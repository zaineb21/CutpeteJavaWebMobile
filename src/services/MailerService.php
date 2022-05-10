<?php

namespace App\services;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Response;

class MailerService
{







    public function sendEmail(MailerInterface $mailer,
        $to ,
        $content ,
        $subject = 'BIENVENUE CHEZ CUTPETE'
    ): void
    {
        $email = (new Email())
            ->from('cuutpete@gmail.com')
            ->to($to)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo($this->replyTo)
            //->priority(Email::PRIORITY_HIGH)
            ->subject($subject)
//            ->text('Sending emails is fun again!')
            ->html($content);
        $mailer->send($email);
        // ...
    }

}