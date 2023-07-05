<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class MailerController extends AbstractController
{
    #[Route('/mailer', name: 'app_mailer')]
    public function sendEmail(MailerInterface $mailer): Response
    {

        $email = (new TemplatedEmail())
        ->from('hello@example.com')
        ->to('you@example.com')

        ->subject('Time for Symfony Mailer!')
        ->text('
        Dear foo
        Soon you will be able to access your futur favorite ideation platform!
        Here are your login details, please note you will be require to pick a new password upon first login.
        
        Email :
        Password :
        
        Kind regards!
        
        Admin Team')
        ->htmlTemplate('emails/newUser.html.twig')
        ->context([
            'username' => 'foo',
        ]);

        $mailer->send($email);


        return new Response(
            'Email was sent'
        );
    }
}
