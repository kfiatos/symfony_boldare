<?php

namespace App\Handlers;

use App\Commands\BenchmarkCommand;
use App\Events\Events;
use App\Events\SiteLoadingSpeedTestedEvent;
use App\Events\SiteLoadingSpeedTestedSentNotificationEmailEvent;
use App\Events\SiteLoadingSpeedTestedSentNotificationSmsEvent;
use App\Repository\BenchmarkResultRepository;
use App\Service\Benchmark;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class BenchmarkHandler
{
    /**
     * @var Benchmark
     */
    protected $benchmark;

    /**
     * @var BenchmarkResultRepository
     */
    protected $benchmarkResultRepo;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * BenchmarkHandler constructor.
     * @param Benchmark $benchmark
     * @param BenchmarkResultRepository $benchmarkResultRepo
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        Benchmark $benchmark,
        BenchmarkResultRepository $benchmarkResultRepo,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->benchmark = $benchmark;
        $this->benchmarkResultRepo = $benchmarkResultRepo;
        $this->eventDispatcher = $eventDispatcher;
    }
    /**
     * @param BenchmarkCommand $command
     */
    public function handle(BenchmarkCommand $command) {
        $this->benchmark->performSiteBenchmark($command->getSiteUrlsDto());
        $result = $this->benchmark->getData();
        $this->benchmarkResultRepo->storeBenchmarkResults($result);

        $this->eventDispatcher->dispatch(
            Events::SITE_LOADING_SPEED_TESTED,
            new SiteLoadingSpeedTestedEvent(
                $this->benchmark->getBaseSiteBenchmarkResult(),
                $this->benchmark->getOtherSitesBenchmarkResults(),
                $this->benchmark->getBenchmarkDate()
            )
        );

        if ($this->benchmark->shouldEmailBeSent()) {
            $this->eventDispatcher->dispatch(
                Events::SITE_LOADING_SPEED_TESTED_SENT_NOTIFICATION_EMAIL,
                new SiteLoadingSpeedTestedSentNotificationEmailEvent(
                    $command->getEmail()
                )
            );
        }

        if ($this->benchmark->shouldSmsBeSent()) {
            $this->eventDispatcher->dispatch(
                Events::SITE_LOADING_SPEED_TESTED_SENT_NOTIFICATION_SMS,
                new SiteLoadingSpeedTestedSentNotificationSmsEvent(
                    $command->getMobileNumber()
                )
            );
        }
    }
}