<?php

namespace App\Events\EventSubscribers;

use App\Events\Events;
use App\Events\SiteLoadingSpeedTestedEvent;
use App\Service\Interfaces\LogWriterInterface;
use \RuntimeException;
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
     * BenchmarkSubscriber constructor.
     * @param LogWriterInterface $logWriter
     */
    public function __construct(LogWriterInterface $logWriter)
    {
        $this->logWriter = $logWriter;
    }


    public static function getSubscribedEvents()
    {
        return [
            Events::SITE_LOADING_SPEED_TESTED_EVENT => [
                [
                    'handleSaveToLogTxtAfterEvent',
                ]
            ],
        ];
    }

    /**
     * @param SiteLoadingSpeedTestedEvent $event
     */
    public function handleSaveToLogTxtAfterEvent(SiteLoadingSpeedTestedEvent $event)
    {
        //Create text file log.txt if it does not exits and append content
        if ($this->logWriter->createFile('log.txt')) {
            $this->logWriter->appendContent('content');
        } else {
            throw new RuntimeException('Log.txt file could not be created');
        }
    }

}