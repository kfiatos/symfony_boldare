<?php

namespace App\Events\EventSubscribers;

use App\Events\Events;
use App\Events\SiteLoadingSpeedTestedEvent;
use App\Events\SiteLoadingSpeedTestedSentNotificationEmailEvent;
use App\Helpers\BenchmarkDataFormatters\BenchmarkResultsTextFileFormatter;
use App\Service\Interfaces\LogWriterInterface;
use App\Service\Interfaces\MailerServiceInterface;
use RuntimeException;
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
     * BenchmarkSubscriber constructor.
     * @param LogWriterInterface $logWriter
     * @param MailerServiceInterface $mailer
     */
    public function __construct(LogWriterInterface $logWriter, MailerServiceInterface $mailer)
    {
        $this->logWriter = $logWriter;
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return [
            Events::SITE_LOADING_SPEED_TESTED_EVENT => [
                [
                    'handleSaveToLogTxtAfterEvent',
                ]
            ],
            Events::SITE_LOADING_SPEED_TESTED_SENT_NOTIFICATION_EMAIL_EVENT => [
                [
                    'handleSendEmailNotificationAfterEvent'
                ]
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
}