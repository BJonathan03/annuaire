<?php

namespace App\Controller;



use App\Entity\Register;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\service\mailer;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController {
    /**
     *
     * Permet de s'inscrire sur le site, envoie un email de confirmation avant inscription finale
     *
     * @Route("/inscription", name="security_register")
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function register(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder, mailer $email)
    {

        $registration = new Register();
        $form = $this->createForm(RegisterType::class, $registration);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $mdp = $registration->getPassword();
            $registration->getType();
            $password = $encoder->encodePassword($registration, $mdp);
            $registration->setPassword($password);

            $registration->setToken(bin2hex(openssl_random_pseudo_bytes(20)));

            $email->sendConfirmationMail($registration);

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
}


