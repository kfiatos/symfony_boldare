<?php

namespace App\Helpers\BenchmarkDataFormatters;

use App\Entity\BenchmarkResult;

class BenchmarkResultsTwigViewFormatter
{
    use WhichSiteIsFaster;

    /**
     * @param BenchmarkResult[]
     * @return array
     */
    public static function prepareResults(array $benchmarkResults): array
    {
        $result = [];
        $result['compared_sites'] = [];
        $baseSite = null;
        /** @var BenchmarkResult $benchmarkResult */
        foreach ($benchmarkResults as $benchmarkResult) {
            if ($benchmarkResult->isBaseSite()) {
                $result['base_site']['loading_time'] = number_format($benchmarkResult->getLoadingTime(), 3);
                $result['base_site']['test_date'] = $benchmarkResult->getBenchmarkDate()->format('Y-m-d H:i:s');
                $result['base_site']['url'] = $benchmarkResult->getUrl();
                $baseSite = $benchmarkResult;
                continue;
            }

            $row = [];
            $row['loading_time'] = number_format($benchmarkResult->getLoadingTime(), 3);
            $row['url'] = $benchmarkResult->getUrl();

            $formatter = new self();
            list($fasterLoadingSite, $howMuchFaster) =
                $formatter->whichSiteIsLoadingFaster($baseSite, $benchmarkResult);
            $howMuchFaster = number_format($howMuchFaster, 3);

            $row['faster_site'] = $fasterLoadingSite;
            $row['how_much_faster'] = $howMuchFaster;
            $result['compared_sites'][] = $row;

        }

        return $result;
    }

}