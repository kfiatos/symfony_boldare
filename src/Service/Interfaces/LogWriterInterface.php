<?php

namespace App\Service\Interfaces;

use App\Dto\BenchmarkResultDto;

/**
 * Interface LogWriterInterface
 * @package App\Service\Interfaces
 */
interface LogWriterInterface
{
    /**
     * @param string $filename
     * @param string $content
     * @return void
     */
    public function appendContentToFile(string $filename, string $content);

    /**
     * @param string $content
     * @return void
     */
    public function appendContent(string $content): void;

    /**
     * @param string $filename
     * @return bool
     */
    public function createFile(string $filename): bool;

    /**
     * @param BenchmarkResultDto $benchmarkResultDto
     * @param array $comparedSitesTestResults
     * @param \DateTime $testDate
     * @return mixed
     */
    public function writeBenchmarkResultsToFile(
        BenchmarkResultDto $benchmarkResultDto,
        array $comparedSitesTestResults,
        \DateTime $testDate
    );
}