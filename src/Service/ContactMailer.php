<?php


namespace App\Service;


use App\Model\Contact;
use Twig\Environment;

class ContactMailer
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * ContactMailer constructor.
     * @param \Swift_Mailer $mailer
     * @param Environment $twig
     */
    public function __construct(\Swift_Mailer $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function send (Contact $contact)
    {
        $message = new \Swift_Message();

        $message
            ->setFrom("meagane.takacs@le-campus-numerique.fr", "meagtak")
            ->setTo("meagane.takacs@le-campus-numerique.fr", "meagtak")
            ->setReplyTo([$contact->getEmail()])
            ->setSubject($contact->getTitle())
            ->setBody(
                $this->twig->render("quack_entity/email.html.twig", ["contact" => $contact]),
                "text/html"
            );
        $this->mailer->send($message);
    }

}