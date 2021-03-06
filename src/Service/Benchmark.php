<?php
namespace App\Service;

use App\Dto\BenchmarkFullResultsDto;
use App\Dto\BenchmarkResultDto;
use App\Dto\SiteUrlsDto;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class Benchmark
 * @package App\Service
 */
class Benchmark
{

    /**
     * @var BenchmarkResultDto
     */
    protected $baseSiteBenchmarkResult;

    /**
     * @var BenchmarkResultDto[]
     */
    protected $otherSitesBenchmarkResults = [];

    /**
     * @var \DateTime
     */
    protected $benchmarkDate;

    /**
     * @param SiteUrlsDto $siteUrlsDto
     * @return void
     */
    public function performSiteBenchmark(SiteUrlsDto $siteUrlsDto): void
    {
        // Not perfect time of execution but close enough in this case
        $this->benchmarkDate = $siteUrlsDto->getBenchmarkDate();
        $siteLoadingTime = $this->getWebsiteLoadingTime($siteUrlsDto->getBaseSiteUrl());
        $benchmarkResult = new BenchmarkResultDto($siteUrlsDto->getBaseSiteUrl(), $siteLoadingTime, $this->benchmarkDate);
        $this->setBaseSiteBenchmarkResult($benchmarkResult);

        foreach ($siteUrlsDto->getComparedSitesUrls() as $siteUrl) {
            $siteLoadingTime = $this->getWebsiteLoadingTime($siteUrl);
            $benchmarkResult = new BenchmarkResultDto($siteUrl, $siteLoadingTime, $this->getBenchmarkDate());
            $this->addOtherSiteBenchmarkResult($benchmarkResult);
        }
        $this->sortBenchmarkResultsByLoadingTime($this->otherSitesBenchmarkResults);
    }

    /**
     * @return BenchmarkFullResultsDto
     */
    public function getData(): BenchmarkFullResultsDto
    {
        return new BenchmarkFullResultsDto(
            $this->getBaseSiteBenchmarkResult(),
            $this->getOtherSitesBenchmarkResults(),
            $this->getBenchmarkDate()
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
    protected function addOtherSiteBenchmarkResult(BenchmarkResultDto $result): void
    {
        $this->otherSitesBenchmarkResults[] = $result;
    }

    /**
     * @param BenchmarkResultDto $baseSiteBenchmarkResult
     */
    protected function setBaseSiteBenchmarkResult(BenchmarkResultDto $baseSiteBenchmarkResult): void
    {
        $this->baseSiteBenchmarkResult = $baseSiteBenchmarkResult;
    }

    /**
     * @return BenchmarkResultDto
     */
    public function getBaseSiteBenchmarkResult(): BenchmarkResultDto
    {
        return $this->baseSiteBenchmarkResult;
    }

    /**
     * @return BenchmarkResultDto[]
     */
    public function getOtherSitesBenchmarkResults(): array
    {
        return $this->otherSitesBenchmarkResults;
    }

    /**
     * @param array $benchmarkResults
     */
    protected function sortBenchmarkResultsByLoadingTime(array &$benchmarkResults) {
        usort($benchmarkResults, function ($site1, $site2) {
            /**@var BenchmarkResultDto $site1 */
            /**@var BenchmarkResultDto $site2 */
            return $site1->getSiteLoadingTime() > $site2->getSiteLoadingTime();
        });
    }

    /**
     * @return \DateTime
     */
    public function getBenchmarkDate(): \DateTime
    {
        return $this->benchmarkDate;
    }

    /**
     * @param BenchmarkResultDto $baseSite
     * @param BenchmarkResultDto[] $comparedSites
     * @return bool
     */
    protected function shouldSmsNotificationBeSent($baseSite, $comparedSites): bool
    {
        $sendNotificationSms = false;
        $baseSiteLoadingTimeDoubled = (float)bcmul((string)$baseSite->getSiteLoadingTime(), '2');
        foreach ($comparedSites as $comparedSite) {
            if ($baseSiteLoadingTimeDoubled > $comparedSite->getSiteLoadingTime()) {
                $sendNotificationSms = true;
                break;
            }
        }
        return $sendNotificationSms;
    }
    /**
     * @param BenchmarkResultDto $baseSite
     * @param BenchmarkResultDto[] $comparedSites
     * @return bool
     */
    protected function shouldEmailNotificationBeSent($baseSite, $comparedSites): bool
    {
        $sendNotificationEmail = false;
        foreach ($comparedSites as $comparedSite) {
            if ($baseSite->getSiteLoadingTime() > $comparedSite->getSiteLoadingTime()) {
                $sendNotificationEmail = true;
                break;
            }
        }
        return $sendNotificationEmail;
    }

    /**
     * @return bool
     */
    public function shouldSmsBeSent(): bool
    {
        //check if sms sending is nescessary
        $shouldSmsNotificationBeSent = $this->shouldSmsNotificationBeSent(
            $this->getBaseSiteBenchmarkResult(),
            $this->getOtherSitesBenchmarkResults()
        );
        return $shouldSmsNotificationBeSent;
    }

    /**
     * @return bool
     */
    public function shouldEmailBeSent(): bool
    {
        //Check if email sending is nescessary
        $shouldEmailNotificationBeSent = $this->shouldEmailNotificationBeSent(
            $this->getBaseSiteBenchmarkResult(),
            $this->getOtherSitesBenchmarkResults()
        );
        return $shouldEmailNotificationBeSent;
    }
}