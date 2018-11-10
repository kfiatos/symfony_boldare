<?php
namespace App\Service\Interfaces;

/**
 * Interface NotificationServiceInterface
 * @package App\Service\Interfaces
 */
interface NotificationServiceInterface
{
    /**
     * @param string $mobileNumber
     * @param string $message
     */
    public function sendSms(string $mobileNumber, string $message): void;

    /**
     * @param string $email
     * @param $content
     */
    public function sendEmail(string $email, $content): void;
}