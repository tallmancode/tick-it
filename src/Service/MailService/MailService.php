<?php


namespace App\Service\MailService;


use App\Service\Mail\ErrorMailer;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Message;

class MailService
{
    private Address $from;
    private MailerInterface $mailer;
    private LoggerInterface $logger;

    public function __construct(MailerInterface $mailer, LoggerInterface $logger){

        $this->from = new Address('hello@tickit.com');
        $this->mailer = $mailer;
        $this->logger = $logger;
    }

    /**
     * @param Address $from
     * @param string $to
     * @param string $subject
     * @param string $template
     * @param array $templateParams
     * @return object|TemplatedEmail
     */
    protected function createMail(Address $from, string $to,string $subject,string $template,array $templateParams)
    {
        $email = (new TemplatedEmail())
            ->from($from)
            ->subject($subject)
            ->htmlTemplate($template)
            ->context($templateParams)
            ->addTo($to);

        return $email;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendEmail(string $to, string $subject, string $template, array $templateParams)
    {
        $email = $this->createMail($this->from,$to,$subject,$template,$templateParams);
        $this->send($email);
    }

    private function send($email): void
    {
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            $this->logger->critical("Email Down",$e->getTrace());
            throw $e;
        }
    }
}