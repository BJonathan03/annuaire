<?php
/**
 * Created by PhpStorm.
 * User: busti
 * Date: 21-01-19
 * Time: 21:13
 */

namespace App\service;

use App\Entity\Register;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface as Generator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class mailer
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;


    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendConfirmationMail(Register $user)
    {

        $link = "http://localhost:8000/user/new/" . $user->getToken();
        $message = new \Swift_Message('Bienvenue');
        $message->setFrom(['test@symfony.com' => 'annuaire.fr'])
            ->setTo($user->getEmail())
            ->setBody(
                '<p>Bonjour, vous venez de vous inscrire sur le site annuaire.be. </p>
<p>Afin de finaliser votre inscription, veuillez cliquer sur le lien suivant et complètez votre profil : </p><a href=".$link.">' . $link .
                '</a><p>Si vous n\'êtes pas à l\'origine de cette inscription, veuillez ne pas tenir compte de cet email. </p>
<p>Nous vous remercions pour votre confiane et à bientôt sur annuaire.be</p>
<p>En cas de problème, n\'hésitez pas à nous contacter à <a href="mailto:annuaire@email.be">annuaire@email.be</a></p>', 'text/html'
            );

        $this->mailer->send($message);
    }
}