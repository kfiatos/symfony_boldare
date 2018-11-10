<?php

namespace App\Events\EventSubscribers;

use App\Events\Events;
use App\Events\SiteLoadingSpeedTestedEvent;
use App\Events\SiteLoadingSpeedTestedSentNotificationEmailEvent;
use App\Events\SiteLoadingSpeedTestedSentNotificationSmsEvent;
use App\Helpers\BenchmarkDataFormatters\BenchmarkResultsTextFileFormatter;
use App\Service\Interfaces\LogWriterInterface;
use App\Service\Interfaces\MailerServiceInterface;
use App\Service\Interfaces\SmsSenderInterface;
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
     * @var MailerServiceInterface
     */
    protected $mailer;

    /**
     * @var SmsSenderInterface
     */
    protected $smsService;

    /**
     * BenchmarkSubscriber constructor.
     * @param LogWriterInterface $logWriter
     * @param MailerServiceInterface $mailer
     * @param SmsSenderInterface $smsService
     */
    public function __construct(
        LogWriterInterface $logWriter,
        MailerServiceInterface $mailer,
        SmsSenderInterface $smsService
    ) {
        $this->logWriter = $logWriter;
        $this->mailer = $mailer;
        $this->smsService = $smsService;
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
        //Create text file log.txt if it does not exits and append content (hardcoded for now, can be later easily changed)
        $filename = 'log.txt';
        if ($this->logWriter->createFile($filename)) {
            $benchmarkFormatter = new BenchmarkResultsTextFileFormatter(
                $event->getBaseSiteTestResult(),
                $event->getComparedSitesTestResults(),
                $event->getBenchmarkDate()
            );
            $formattedBenchmarkResults = $benchmarkFormatter->prepareResults();

            $this->logWriter->appendContent($formattedBenchmarkResults);
        } else {
            throw new RuntimeException("{$filename} file could not be created");
        }
    }

    /**
     * @param SiteLoadingSpeedTestedSentNotificationEmailEvent $event
     */
    public function handleSendEmailNotificationAfterEvent(SiteLoadingSpeedTestedSentNotificationEmailEvent $event)
    {
        $this->mailer->sendTo($event->getEmail());
    }

    /**
     * @param SiteLoadingSpeedTestedSentNotificationSmsEvent $event
     */
    public function handleSendSmsNotificationAfterEvent(SiteLoadingSpeedTestedSentNotificationSmsEvent $event)
    {
        $this->smsService->sendSms($event->getMobileNumber(), $event->getMessage());
    }
}