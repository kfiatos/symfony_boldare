<?php

namespace App\Service;


use App\Repository\BenchmarkResultRepository;

class BenchmarkQueryService
{
    /**
     * @var BenchmarkResultRepository
     */
    protected $benchmarkResultRepository;

    /**
     * BenchmarkQueryService constructor.
     * @param BenchmarkResultRepository $benchmarkResultRepository
     */
    public function __construct(BenchmarkResultRepository $benchmarkResultRepository)
    {
        $this->benchmarkResultRepository = $benchmarkResultRepository;
    }

    public function findBenchmarkResultsByBaseSiteAndDate(\DateTime $dateTime)
    {
        $benchmarkResults = $this->benchmarkResultRepository->findBy(
            ['benchmarkDate' => $dateTime],
            ['isBaseSite' => 'desc']
        );

        return $benchmarkResults;
    }


}