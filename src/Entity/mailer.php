<?php
/**
 * Created by PhpStorm.
 * User: busti
 * Date: 21-01-19
 * Time: 21:13
 */

namespace App\Entity;

use App\Entity\Register;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface as Generator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class mailer
{
    /**
     *
     * CODE MR BERGER A TRAVAILLER 
     *
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var Generator
     */
    private $urlGenerator;

    public function __construct(\Swift_Mailer $mailer, Generator $urlGenerator) {
        $this->mailer = $mailer;
        $this->urlGenerator = $urlGenerator;
    }
    public function sendConfirmationMail(Register $user){
        $message = new \Swift_Message('Confirmation');
        $message->setFrom('info@bienetre.com')
            ->setTo($user->getEmail())
            ->setBody(
                sprintf('hello this is your confirmation token <a href="%s">Token</a>',
                    $this->urlGenerator->generate(
                        'confirm_inscription', ['token'=>$user->getToken()], UrlGeneratorInterface::ABSOLUTE_URL
                    )
                ), 'text/html'
            );
        $this->mailer->send($message);
    }
}