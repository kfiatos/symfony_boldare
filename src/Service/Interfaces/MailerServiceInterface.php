<?php
namespace App\Service\Interfaces;


interface MailerServiceInterface
{
    /**
     * @param string $email
     * @return void
     */
    public function sendTo(string $email): void;
}