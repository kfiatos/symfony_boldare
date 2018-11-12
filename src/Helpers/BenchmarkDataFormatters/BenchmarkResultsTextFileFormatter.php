<?php

namespace App\Helpers\BenchmarkDataFormatters;

use App\Dto\BenchmarkResultDto;

class BenchmarkResultsTextFileFormatter
{
    use WhichSiteIsFaster;

    /**
     * @param BenchmarkResultDto $baseSiteTestResult
     * @param BenchmarkResultDto[] $comparedSitesTestsResults
     * @param \DateTime $testDate
     * @return string
     */
    public static function prepareResults(
        BenchmarkResultDto $baseSiteTestResult,
        array $comparedSitesTestsResults,
        \DateTime $testDate
    ): string
    {
        $finalBaseSiteLoadTime = number_format($baseSiteTestResult->getSiteLoadingTime(), 3);
        $firstRow = "Date : {$testDate->format('Y-m-d H:i:s')} | ";
        $firstRow .= "Base comparison site: {$baseSiteTestResult->getSiteUrl()} loading time: {$finalBaseSiteLoadTime}\n";

        $rows = '';
        foreach ($comparedSitesTestsResults as $comparedSiteBenchmarkResult) {
            $finalPageLoadTime = number_format($comparedSiteBenchmarkResult->getSiteLoadingTime(), 3);
            //Add some artificial formatting to text file
            $rows .= str_repeat(' ', 27);

            $formatter = new self();
            list($fasterLoadingSite, $howMuchFaster) =
                $formatter->whichSiteIsLoadingFaster($baseSiteTestResult, $comparedSiteBenchmarkResult);
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