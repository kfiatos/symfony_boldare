<?php

namespace App\Helpers\BenchmarkDataFormatters;

use App\Dto\BenchmarkFullResultsDto;
use App\Dto\BenchmarkResultDto;

class BenchmarkResultsTwigViewFormatter
{
    use WhichSiteIsFaster;

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
     * @param BenchmarkFullResultsDto
     */
    public function __construct(BenchmarkFullResultsDto $benchmarkFullResultsDto)
    {
        $this->baseSiteBenchmarkResult = $benchmarkFullResultsDto->getBaseSiteResult();
        $this->comparedSitesBenchmarkResults = $benchmarkFullResultsDto->getOtherSitesResults();
        $this->benchmarkDate = $benchmarkFullResultsDto->getBenchmarkDate();
    }

    /**
     * @return array
     */
    public function prepareResults(): array
    {
        $result = [];
        $result['base_site']['loading_time'] = number_format($this->baseSiteBenchmarkResult->getSiteLoadingTime(), 3);
        $result['base_site']['test_date'] = $this->benchmarkDate->format('Y-m-d H:i:s');
        $result['base_site']['url'] = $this->baseSiteBenchmarkResult->getSiteUrl();

        $result['compared_sites'] = [];
        foreach ($this->comparedSitesBenchmarkResults as $comparedSiteBenchmarkResult) {
            $row = [];
            $row['loading_time'] = number_format($comparedSiteBenchmarkResult->getSiteLoadingTime(), 3);
            $row['url'] = $comparedSiteBenchmarkResult->getSiteUrl();

            list($fasterLoadingSite, $howMuchFaster) =
                $this->whichSiteIsLoadingFaster($this->baseSiteBenchmarkResult, $comparedSiteBenchmarkResult);
            $howMuchFaster = number_format($howMuchFaster, 3);

            $row['faster_site'] = $fasterLoadingSite;
            $row['how_much_faster'] = $howMuchFaster;
            $result['compared_sites'][] = $row;
        }
        return $result;
    }

}