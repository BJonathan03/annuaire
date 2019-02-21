<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\PasswordUpdate;
use App\Entity\Register;
use App\Entity\Vendor;
use App\Entity\Visitor;
use App\Form\ClientType;
use App\Form\ClientUpdateType;
use App\Form\PasswordUpdateType;
use App\Form\VendorType;
use App\Form\VendorUpdateType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class SecurityVendorController extends AbstractController
{


    /**
     * @route("/connexion", name="security_login")
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();
        return $this->render('security_vendor/login.html.twig', [
            'hasError' => $error !== null,
            'username' => $username
        ]);
    }

    /**
     * Fonction permettant de se déconnecter
     *
     * @Route("/deconnexion", name="security_logout")
     */

    public function logout()
    {
    }

    /**
     * Cette fonction permet à un utilisateur de s'inscrire en complétant son profil, elle n'est accessible que grâce au token et le formulaire dépend du type d'utilisateur
     *
     * @route("/user/new/{token}", name="new_vendor")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */

    public function form(Register $register, Request $request, UserPasswordEncoderInterface $encoder ,ObjectManager $manager)
    {
        if($register->getType() === 'vendor') {

            $vendor = new Vendor();

            $form = $this->createForm(VendorType::class, $vendor);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                if (!password_verify($vendor->getPassword(), $register->getPassword())) {
                    $form->get('password')->addError(new FormError("Le mot de passe que vous avez tapé n'est pas votre mot de passe !" . $vendor->getPassword() . ' ' . $register->getPassword()));

                } else {
                    $mdp = $vendor->getPassword();
                    $password = $encoder->encodePassword($vendor, $mdp);
                    $vendor->setPassword($password);

                    $vendor->setEmail($register->getEmail());
                    $vendor->setBanni(0);
                    $vendor->setDate(new \DateTime('now'));
                    $vendor->setInscription(1);
                    $vendor->setTry(0);

                    $manager->persist($vendor);
                    $manager->remove($register);
                    $manager->flush();

                    $this->addFlash(
                        'success',
                        "Votre inscription/modification a bien été enregistrée ! Merci de votre confiance {$vendor->getName()}"
                    );
                 /*   return $guardHandler->authenticateUserAndHandleSuccess(
                        $vendor,          // the User object you just created
                        $request,
                        $authenticator, // authenticator whose onAuthenticationSuccess you want to use
                        'main'   // the name of your firewall in security.yaml
                    ); */
                    return $this->redirectToRoute('security_login');
                }
            }

            return $this->render('security_vendor/new_vendor.html.twig', [
                'form' => $form->createView(),   //createView : methode de Form qui retourne la 'partie affichage de l'objet)
                'editMode' => $vendor->getId() !== null,
                'register' => $register
            ]);
        } elseif ($register->getType() === 'user'){
            $user = new Client();
            $form = $this->createForm(ClientType::class, $user);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                if (!password_verify($user->getPassword(), $register->getPassword())) {
                    $form->get('password')->addError(new FormError("Le mot de passe que vous avez tapé n'est pas votre mot de passe !" . $user->getPassword() . ' ' . $register->getPassword()));
                } else {
                    $mdp = $user->getPassword();
                    $password = $encoder->encodePassword($user, $mdp);
                    $user->setPassword($password);

                    $user->setEmail($register->getEmail());
                    $user->setBanni(0);
                    $user->setDate(new \DateTime('now'));
                    $user->setInscription(1);
                    $user->setTry(0);

                    $manager->persist($user);
                    $manager->remove($register);
                    $manager->flush();

                    $this->addFlash(
                        'success',
                        "Votre inscription/modification a bien été enregistrée ! Merci de votre confiance {$user->getName()}, vous pouvez maintenant vous connecter"
                    );

                    return $this->redirectToRoute('security_login');
                }
            }
            return $this->render('security_vendor/new_client.html.twig', [
                'form' => $form->createView(),   //createView : methode de Form qui retourne la 'partie affichage de l'objet)
                'editMode' => $user->getId() !== null,
                'register' => $register
            ]);
        }
    }


    /**
     * Permet de modifier le mot de passe
     *
     * @Route("/security/vendor/password-update", name="vendor_password")
     * @Route("/security/user/password-update", name="user_password")
     *
     *
     */
    public function updateVendorPassword(Request $request, UserPasswordEncoderInterface $encoder, ObjectManager $manager)
    {

        $passwordUpdate = new PasswordUpdate();
        $user = $this->getUser();

        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if (!password_verify($passwordUpdate->getOldPassword(), $user->getPassword())) {
                $form->get('oldPassword')->addError(new FormError("Le mot de passe que vous avez tapé n'est pas votre mot de passe actuel"));

            } else {
                $newPassword = $passwordUpdate->getNewPassword();
                $password = $encoder->encodePassword($user, $newPassword);
                $user->setPassword($password);
                $manager->persist($user);
                $manager->flush();

                $this->addFlash(
                    'success',
                    "Votre mot de passe a bien été modifié..."
                );
                return $this->redirectToRoute('home');
            }
        }
        return $this->render('security_vendor/password.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * Permet d'afficher et de traiter le formulaire de modification de profil
     *
     * @Route("/account/profile", name="vendor_profile")
     *
     */
    public function profile(Request $request, ObjectManager $manager, AuthenticationUtils $utils)
    {
        $user = $this->getUser();

        // $object instance of surfer
        if($user instanceof Vendor){
            $form = $this->createForm(VendorUpdateType::class, $user);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                //persist n'est pas obligatoire car l'entité existe déjà
                $manager->persist($user);
                $manager->flush();

                $this->addFlash(
                    'success',
                    "Les données du profile ont été enregistrées avec succès !"
                );
            }

            return $this->render('security_vendor/update_vendor.html.twig', [
                'form' => $form->createView()
            ]);

        } elseif ($user instanceof Client){
            $form = $this->createForm(ClientUpdateType::class, $user);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                //persist n'est pas obligatoire car l'entité existe déjà
                $manager->persist($user);
                $manager->flush();

                $this->addFlash(
                    'success',
                    "Les données du profile ont été enregistrées avec succès !"
                );
            }
            return $this->render('security_vendor/update_client.html.twig', [
                'form' => $form->createView()
            ]);
        } else {
            return $this->redirectToRoute('security_login');
        }
    }

    /**
     * @Route("/vendor/inscription", name="validation_inscription")
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function email_validation()
    {
        return $this->render('security_vendor/index.html.twig');
    }

}
