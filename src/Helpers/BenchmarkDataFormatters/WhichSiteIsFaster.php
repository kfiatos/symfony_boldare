<?php
namespace App\Helpers\BenchmarkDataFormatters;

use App\Dto\BenchmarkResultDto;

trait WhichSiteIsFaster
{
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