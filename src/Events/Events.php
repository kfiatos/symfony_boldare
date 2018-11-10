<?php
namespace App\Events;


final class Events
{
    public const SITE_LOADING_SPEED_TESTED = 'SiteLoadingSpeedTestedEvent';
    public const SITE_LOADING_SPEED_TESTED_SENT_NOTIFICATION_EMAIL = 'SiteLoadingSpeedTestedSentNotificationEmailEvent';
    public const SITE_LOADING_SPEED_TESTED_SENT_NOTIFICATION_SMS = 'SiteLoadingSpeedTestedSentNotificationSmsEvent';
}