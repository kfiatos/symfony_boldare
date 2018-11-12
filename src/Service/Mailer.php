<?php
namespace App\Service;


use App\Service\Interfaces\MailerServiceInterface;

class Mailer implements MailerServiceInterface
{
    /**
     * @var \Swift_Mailer
     */
    protected $swiftMailer;

    /**
     * Mailer constructor.
     * @param \Swift_Mailer $swift_Mailer
     */
    public function __construct(\Swift_Mailer $swift_Mailer)
    {
        $this->swiftMailer = $swift_Mailer;
    }

    /**
     * @param \Swift_Message $message
     * @return mixed|void
     */
    protected function send(\Swift_Message $message): void
    {
        $this->swiftMailer->send($message);
    }

    /**
     * @param string $email
     * @param string $content
     */
    public function sendEmail(string $email, string $content): void
    {
        // This value should be injected from outside, config maybe
        $from = 'test@test.com';
        $message = (new \Swift_Message($content))
            ->setFrom($from)
            ->setTo($email)
            ->setBody(
                'Some web sites were benchmarked',
                'text/plain'
            );
        $this->swiftMailer->send($message);
    }

}