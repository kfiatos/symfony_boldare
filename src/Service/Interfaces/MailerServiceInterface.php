<?php
namespace App\Service\Interfaces;


interface MailerServiceInterface
{
    /**
     * @param string $email
     * @param string $content
     * @return void
     */
    public function sendEmail(string $email, string $content): void;
}