<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class NewUserEmailSender
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }


    public function sendEmail(array $user, string $password): void
    {
        $email = (new TemplatedEmail())
                    ->from('idea.admin@sf.com')
                    ->to($user['email'])
                    ->subject('Mot de passe SalesForce Ideation')
                    ->text('
                            Dear' . $user['firstName'] . $user['lastName'] . '
                            Soon you will be able to access your futur favorite ideation platform!
                            
                            Here are your login details.
                            
                            Email :' . $user['email'] . '
                            Password :' . $password . '
                            
                            Please note you will be require to pick a new password upon first login.
                            
                            Kind regards!
                            
                            Admin Team')
                    ->htmlTemplate('emails/newUser.html.twig')
                    ->context([
                                'newUser' => $user,
                                'password' => $password,

                            ]);

                $this->mailer->send($email);
    }
}
