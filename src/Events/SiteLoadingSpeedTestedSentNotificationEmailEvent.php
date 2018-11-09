<?php
namespace App\Events;

use Symfony\Component\EventDispatcher\Event;

class SiteLoadingSpeedTestedSentNotificationEmailEvent extends Event
{
    /**
     * @var string $email
     */
    protected $email;

    /**
     * SiteLoadingSpeedTestedSentNotficationEmailEvent constructor.
     * @param string $email
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}