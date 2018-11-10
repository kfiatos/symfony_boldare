<?php
namespace App\Events;

use Symfony\Component\EventDispatcher\Event;

class SiteLoadingSpeedTestedSentNotificationSmsEvent extends Event
{
    /**
     * @var string $email
     */
    protected $mobileNumber;

    /**
     * @var string
     */
    protected $message;

    /**
     * SiteLoadingSpeedTestedSentNotificationSmsEvent constructor.
     * @param string $mobileNumber
     * @param string $message
     */
    public function __construct(string $mobileNumber, string $message)
    {
        $this->mobileNumber = $mobileNumber;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getMobileNumber(): string
    {
        return $this->mobileNumber;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}