<?php

namespace App\Helpers\BenchmarkDataFormatters;

use App\Dto\BenchmarkResultDto;

class BenchmarkResultsTextFileFormatter
{
    /**
     * @var BenchmarkResultDto
     */
    protected $baseSiteBenchmarkResult;

    /**
     * @var BenchmarkResultDto[]
     */
    protected $comparedSitesBenchmarkResults;

    /**
     * @var \DateTime
     */
    protected $benchmarkDate;

    /**
     * BenchmarkResultsTextFileFormatter constructor.
     * @param BenchmarkResultDto $baseSiteBenchmarkResult
     * @param array $comparedSitesBenchmarkResults
     * @param \DateTime $benchmarkDate
     */
    public function __construct(
        BenchmarkResultDto $baseSiteBenchmarkResult,
        array $comparedSitesBenchmarkResults,
        \DateTime $benchmarkDate
    ) {
        $this->baseSiteBenchmarkResult = $baseSiteBenchmarkResult;
        $this->comparedSitesBenchmarkResults = $comparedSitesBenchmarkResults;
        $this->benchmarkDate = $benchmarkDate;
    }

    /**
     * @return string
     */
    public function prepareResults(): string
    {
        $finalBaseSiteLoadTime = number_format($this->baseSiteBenchmarkResult->getSiteLoadingTime(), 3);
        $firstRow = "Date : {$this->benchmarkDate->format('Y-m-d H:i:s')} | ";
        $firstRow .= "Base comparison site: {$this->baseSiteBenchmarkResult->getSiteUrl()} loading time: {$finalBaseSiteLoadTime}\n";

        $rows = '';
        foreach ($this->comparedSitesBenchmarkResults as $comparedSiteBenchmarkResult) {
            $finalPageLoadTime = number_format($comparedSiteBenchmarkResult->getSiteLoadingTime(), 3);
            //Add some artificial formatting to text file
            $rows .= str_repeat(' ', 27);
            list($fasterLoadingSite, $howMuchFaster) =
                $this->whichSiteIsLoadingFaster($this->baseSiteBenchmarkResult, $comparedSiteBenchmarkResult);
            $howMuchFaster = number_format($howMuchFaster, 3);
            $rows .= "Site: {$comparedSiteBenchmarkResult->getSiteUrl()} loading time: {$finalPageLoadTime} | ";
            $rows .= "Faster loading site is {$fasterLoadingSite->getSiteUrl()} by {$howMuchFaster}\n";
        }
        return $firstRow . $rows;
    }

    /**
     * @param BenchmarkResultDto $site1
     * @param BenchmarkResultDto $site2
     * @return array
     */
    protected function whichSiteIsLoadingFaster(BenchmarkResultDto $site1, BenchmarkResultDto $site2) {
        if ($site1->getSiteLoadingTime() > $site2->getSiteLoadingTime()) {
           $site =  $site2;
        } else {
          $site = $site1;
        }
        $howMuchFasterLoading = abs($site1->getSiteLoadingTime() - $site2->getSiteLoadingTime());

        return [
            $site,
            $howMuchFasterLoading
        ];
    }
}