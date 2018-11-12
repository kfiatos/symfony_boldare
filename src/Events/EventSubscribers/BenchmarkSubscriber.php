<?php

namespace App\Events\EventSubscribers;

use App\Events\Events;
use App\Events\SiteLoadingSpeedTestedEvent;
use App\Events\SiteLoadingSpeedTestedSentNotificationEmailEvent;
use App\Events\SiteLoadingSpeedTestedSentNotificationSmsEvent;
use App\Service\Interfaces\LogWriterInterface;
use App\Service\Interfaces\NotificationServiceInterface;
use App\Service\Notification;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class BenchmarkSubscriber
 * @package App\Events\EventSubscribers
 */
class BenchmarkSubscriber implements EventSubscriberInterface
{
    /**
     * @var LogWriterInterface
     */
    protected $logWriter;

    /**
     * @var Notification
     */
    protected $notificationService;

    /**
     * BenchmarkSubscriber constructor.
     * @param LogWriterInterface $logWriter
     * @param NotificationServiceInterface $notificationService
     */
    public function __construct(
        LogWriterInterface $logWriter,
        NotificationServiceInterface $notificationService
    ) {
        $this->logWriter = $logWriter;
        $this->notificationService = $notificationService;
    }

    public static function getSubscribedEvents()
    {
        return [
            Events::SITE_LOADING_SPEED_TESTED => [
                ['handleSaveToLogTxtAfterEvent']
            ],
            Events::SITE_LOADING_SPEED_TESTED_SENT_NOTIFICATION_EMAIL => [
                ['handleSendEmailNotificationAfterEvent']
            ],
            Events::SITE_LOADING_SPEED_TESTED_SENT_NOTIFICATION_SMS => [
                ['handleSendSmsNotificationAfterEvent']
            ]
        ];
    }

    /**
     * @param SiteLoadingSpeedTestedEvent $event
     */
    public function handleSaveToLogTxtAfterEvent(SiteLoadingSpeedTestedEvent $event)
    {
        $this->logWriter->writeBenchmarkResultsToFile(
                $event->getBaseSiteTestResult(),
                $event->getComparedSitesTestResults(),
                $event->getBenchmarkDate()
            );
    }

    /**
     * @param SiteLoadingSpeedTestedSentNotificationEmailEvent $event
     */
    public function handleSendEmailNotificationAfterEvent(SiteLoadingSpeedTestedSentNotificationEmailEvent $event)
    {
        $this->notificationService->sendEmail($event->getEmail(), 'You made some benchmarks');
    }

    /**
     * @param SiteLoadingSpeedTestedSentNotificationSmsEvent $event
     */
    public function handleSendSmsNotificationAfterEvent(SiteLoadingSpeedTestedSentNotificationSmsEvent $event)
    {
        $this->notificationService->sendSms($event->getMobileNumber(), 'Sms because you made some benchmarks');
    }
}