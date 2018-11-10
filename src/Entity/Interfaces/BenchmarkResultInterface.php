<?php

namespace App\Entity\Interfaces;


interface BenchmarkResultInterface
{
    /**
     * @return string
     */
    public function getUrl(): ?string;

    /**
     * @return float
     */
    public function getLoadingTime(): float;

    /**
     * @return \DateTime
     */
    public function getBenchmarkDate(): \DateTime;

    /**
     * @return bool
     */
    public function isBaseSite(): bool;
}