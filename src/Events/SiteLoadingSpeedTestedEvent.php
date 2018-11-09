<?php
namespace App\Events;

use App\Dto\BenchmarkResultDto;
use Symfony\Component\EventDispatcher\Event;

class SiteLoadingSpeedTestedEvent extends Event
{
    /** @var BenchmarkResultDto */
    protected $baseSiteTestResult;

    /**
     * @var array
     */
    protected $comparedSitesTestResults = [];

    /**
     * @var \DateTime
     */
    protected $benchmarkDate;

    /**
     * SiteLoadingSpeedTestedEvent constructor.
     * @param array $comparedSitesTestResults
     * @param \DateTime $benchmarkDate
     */
    public function __construct(
        BenchmarkResultDto $baseSiteTestResult,
        array $comparedSitesTestResults,
        \DateTime $benchmarkDate)
    {
        $this->baseSiteTestResult = $baseSiteTestResult;
        $this->comparedSitesTestResults = $comparedSitesTestResults;
        $this->benchmarkDate = $benchmarkDate;
    }

    /**
     * @return BenchmarkResultDto
     */
    public function getBaseSiteTestResult(): BenchmarkResultDto
    {
        return $this->baseSiteTestResult;
    }

    /**
     * @return array
     */
    public function getComparedSitesTestResults(): array
    {
        return $this->comparedSitesTestResults;
    }

    /**
     * @return \DateTime|null
     */
    public function getBenchmarkDate(): ?\DateTime
    {
        return $this->benchmarkDate;
    }
}