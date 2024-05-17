<?php
namespace App\Service;


use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class SendMailService
{
    protected $mailer;
    protected $security;


    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(
        string $from,
        string $name,
        string $to,
        string $subject,
        string $template,
        array $context
    )
    {
        //On crée le mail
        $email = (new TemplatedEmail());
        $email->from(new Address($from, $name))
            ->to($to)
            ->subject($subject)
            ->htmlTemplate("emails/$template.html.twig")
            ->context($context);

        // On envoie le mail
        $this->mailer->send($email);
    }
}
