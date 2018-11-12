<?php
namespace App\Helpers\BenchmarkDataFormatters;

use App\Entity\Interfaces\BenchmarkResultInterface;

trait WhichSiteIsFaster
{
    /**
     * @param BenchmarkResultInterface $site1
     * @param BenchmarkResultInterface $site2
     * @return array
     */
    protected function whichSiteIsLoadingFaster(BenchmarkResultInterface $site1, BenchmarkResultInterface $site2) {
        if ($site1->getLoadingTime() > $site2->getLoadingTime()) {
            $site =  $site2;
        } else {
            $site = $site1;
        }
        $howMuchFasterLoading = abs($site1->getLoadingTime() - $site2->getLoadingTime());

        return [
            $site,
            $howMuchFasterLoading
        ];
    }
}