<?php
namespace App\Service;

use App\Service\Interfaces\MailerServiceInterface;
use App\Service\Interfaces\NotificationServiceInterface;
use App\Service\Interfaces\SmsSenderInterface;

/**
 * Class Notification
 * @package App\Service
 */
class Notification implements NotificationServiceInterface
{
    /**
     * @var MailerServiceInterface
     */
    protected $mailer;

    /**
     * @var SmsSenderInterface
     */
    protected $smsService;

    /**
     * Notification constructor.
     * @param MailerServiceInterface $mailer
     * @param SmsSenderInterface $smsService
     */
    public function __construct(MailerServiceInterface $mailer, SmsSenderInterface $smsService)
    {
        $this->mailer = $mailer;
        $this->smsService = $smsService;
    }

    /**
     * @param string $mobileNumber
     * @param string $message
     */
    public function sendSms(string $mobileNumber, string $message): void
    {
        $this->smsService->sendSms($mobileNumber, $message);
    }

    /**
     * @param string $email
     * @param $content
     */
    public function sendEmail(string $email, $content): void
    {
        $this->mailer->sendEmail($email, $content);
    }


}