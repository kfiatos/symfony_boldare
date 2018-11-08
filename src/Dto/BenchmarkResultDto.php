<?php
namespace App\Dto;

class BenchmarkResultDto
{
    /**
     * @var string
     */
    protected $siteUrl;

    /**
     * @var float
     */
    protected $siteLoadingTime;

    /**
     * @var \DateTime
     */
    protected $benchmarkDate;

    /**
     * BenchmarkResultDto constructor.
     * @param string $siteUrl
     * @param $siteLoadingTime
     */
    public function __construct(string $siteUrl, $siteLoadingTime, \DateTime $benchmarkDate)
    {
        $this->siteUrl = $siteUrl;
        $this->siteLoadingTime = $siteLoadingTime;
        $this->benchmarkDate = $benchmarkDate;
    }

    /**
     * @return string
     */
    public function getSiteUrl(): string
    {
        return $this->siteUrl;
    }

    /**
     * @return float
     */
    public function getSiteLoadingTime(): float
    {
        return $this->siteLoadingTime;
    }

    /**
     * @return \DateTime
     */
    public function getBenchmarkDate(): \DateTime
    {
        return $this->benchmarkDate;
    }
}