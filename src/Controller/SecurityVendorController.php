<?php

namespace App\Controller;

use App\Entity\PasswordUpdate;
use App\Entity\Register;
use App\Entity\Vendor;
use App\Entity\Visitor;
use App\Form\PasswordUpdateType;
use App\Form\RegisterType;
use App\Form\VendorType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class SecurityVendorController extends AbstractController
{
    /**
     * @Route("/security/vendor", name="security_vendor")
     */
    public function index()
    {
        return $this->render('security_vendor/index.html.twig', [
            'controller_name' => 'SecurityVendorController',
        ]);
    }

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
     *
     * Permet de s'inscrire sur le site, envoie un email de confirmation avant inscription finale
     *
     * @Route("/inscription", name="security_register")
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function register(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {

        $registration = new Register();
        $form = $this->createForm(RegisterType::class, $registration);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $mdp = $registration->getPassword();
            $password = $encoder->encodePassword($registration, $mdp);
            $registration->setPassword($password);

            $registration->setToken(bin2hex(openssl_random_pseudo_bytes(20)));
            $registration->setType('vendor');
            $link = "http://localhost:8000/vendor/new/" . $registration->getToken();
            $transport = (new \Swift_SmtpTransport('smtp.mailtrap.io', 25))
                ->setUsername('658f04574378bc')
                ->setPassword('48a5526794aa0a');
            $mailer = new \Swift_Mailer($transport);

            $message = (new \Swift_Message('Bienvenue'))
                ->setFrom(['test@symfony.com' => 'annuaire.fr'])
                ->setTo($registration->getEmail())
                ->setBody('<p>Bonjour, vous venez de vous inscrire sur le site annuaire.be. </p>
<p>Afin de finaliser votre inscription, veuillez cliquer sur le lien suivant et complètez votre profil : </p><a href=".$link.">' . $link .
                    '</a><p>Si vous n\'êtes pas à l\'origine de cette inscription, veuillez ne pas tenir compte de cet email. </p>
<p>Nous vous remercions pour votre confiane et à bientôt sur annuaire.be</p>
<p>En cas de problème, n\'hésitez pas à nous contacter à <a href="mailto:annuaire@email.be">annuaire@email.be</a></p>', 'text/html');

            $result = $mailer->send($message);
            $manager->persist($registration);
            $manager->flush();

            $this->addFlash(
                'success',
                "Vous allez recevoir un mail de confirmation..."
            );
            return $this->redirectToRoute('home');
        }
        return $this->render('security_vendor/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Cette fonction permet à un prestataire de s'inscrire en complétant son profil, elle n'est accessible que grâce au token
     *
     * @route("/vendor/new/{token}", name="new_vendor")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */

    public function form(Register $register, Request $request, UserPasswordEncoderInterface $encoder ,ObjectManager $manager)
    {
        $vendor = new Vendor();

        $form = $this->createForm(VendorType::class, $vendor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!password_verify($vendor->getPassword(), $register->getPassword())) {
                $form->get('password')->addError(new FormError("Le mot de passe que vous avez tapé n'est pas votre mot de passe !".$vendor->getPassword().' '.$register->getPassword()));

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

                return $this->redirectToRoute('vendor_show', ['id' => $vendor->getId()]);
                    }
        }

        return $this->render('security_vendor/new_vendor.html.twig', [
            'formVendor' => $form->createView(),   //createView : methode de Form qui retourne la 'partie affichage de l'objet)
            'editMode' => $vendor->getId() !== null,
            'register' => $register
        ]);
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
    public function profile(Request $request, ObjectManager $manager)
    {
        $user = $this->getUser();
        $form = $this->createForm(VendorType::class, $user);

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
            'formVendor' => $form->createView()
        ]);

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
