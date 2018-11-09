<?php
namespace App\Dto;


class BenchmarkFullResultsDto
{
    /**
     * @var BenchmarkResultDto
     */
    protected $baseSiteResult;

    /**
     * @var BenchmarkResultDto[]
     */
    protected $otherSitesResults;

    /**
     * @var \DateTime
     */
    protected $benchmarkDate;

    /**
     * BenchmarkFullResultsDto constructor.
     * @param BenchmarkResultDto $baseSiteResult
     * @param BenchmarkResultDto[] $otherSitesResults
     * @param \DateTime $benchmarkDate
     */
    public function __construct(BenchmarkResultDto $baseSiteResult, array $otherSitesResults, \DateTime $benchmarkDate)
    {
        $this->baseSiteResult = $baseSiteResult;
        $this->otherSitesResults = $otherSitesResults;
        $this->benchmarkDate = $benchmarkDate;
    }

    /**
     * @return BenchmarkResultDto
     */
    public function getBaseSiteResult(): BenchmarkResultDto
    {
        return $this->baseSiteResult;
    }

    /**
     * @return BenchmarkResultDto[]
     */
    public function getOtherSitesResults(): array
    {
        return $this->otherSitesResults;
    }

    /**
     * @return \DateTime
     */
    public function getBenchmarkDate(): \DateTime
    {
        return $this->benchmarkDate;
    }






}