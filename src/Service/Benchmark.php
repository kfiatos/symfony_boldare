<?php

namespace App\Service;

use App\Dto\BenchmarkResultDto;
use App\Dto\SiteUrlsDto;
use App\Events\Events;
use App\Events\SiteLoadingSpeedTestedEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Benchmark
{
    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var array
     */
    protected $benchmarkResults = [];

    /**
     * Benchmark constructor.
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param SiteUrlsDto $siteUrlsDto
     */
    public function performSiteBenchmark(SiteUrlsDto $siteUrlsDto)
    {
        // Not perfect time of execution but close enough in this case
        $benchmarkDate = new \DateTime('now');
        foreach ($siteUrlsDto->getSiteUrls() as $siteUrl) {
            $siteLoadingTime = $this->getWebsiteLoadingTime($siteUrl);
            $benchmarkResult = new BenchmarkResultDto($siteUrl, $siteLoadingTime, $benchmarkDate);
            $this->addBenchmarkResult($benchmarkResult);
        }

        $this->eventDispatcher->dispatch(
            Events::SITE_LOADING_SPEED_TESTED_EVENT,
            new SiteLoadingSpeedTestedEvent(
                $this->getBenchmarkResults()
            )
        );
    }

    /**
     * @param string $url
     * @return float
     */
    protected function getWebsiteLoadingTime(string $url) : float
    {
        $curl = curl_init($url);
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1
        ]);
        curl_exec($curl);
        $info = curl_getinfo($curl);
        curl_close($curl);
        $requestLength = (float)$info['total_time'];
        return $requestLength;
    }

    /**
     * @param BenchmarkResultDto $result
     */
    public function addBenchmarkResult(BenchmarkResultDto $result): void
    {
        $this->benchmarkResults[] = $result;
    }

    /**
     * @return string
     */
    public function getBenchmarkResultsForView(): string
    {
        $result = '';
        /** @var BenchmarkResultDto $benchmarkResult */
        foreach ($this->benchmarkResults as $benchmarkResult) {
            $requestLengthInSeconds = intval($benchmarkResult->getSiteLoadingTime());
            $requestLengthMicro = $benchmarkResult->getSiteLoadingTime() - $requestLengthInSeconds;
            $final = strftime('%T', mktime(0, 0, $requestLengthInSeconds)) . str_replace('0.', '.', sprintf('%.3f', $requestLengthMicro));
            $result .= $final . '<br>';
        }
        return $result;
    }

    /**
     * @return array
     */
    public function getBenchmarkResults(): array
    {
        return $this->benchmarkResults;
    }
}