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
     * SiteLoadingSpeedTestedSentNotificationSmsEvent constructor.
     * @param string $mobileNumber
     */
    public function __construct(string $mobileNumber)
    {
        $this->mobileNumber = $mobileNumber;
    }

    /**
     * @return string
     */
    public function getMobileNumber(): string
    {
        return $this->mobileNumber;
    }
}