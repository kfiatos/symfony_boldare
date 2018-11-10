<?php

namespace App\Service\Interfaces;


interface SmsSenderInterface
{
    /**
     * @param string $mobileNumber
     * @param string $message
     */
    public function sendSms(string $mobileNumber, string $message): void;

}