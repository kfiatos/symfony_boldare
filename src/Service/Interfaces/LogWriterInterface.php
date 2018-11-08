<?php

namespace App\Service\Interfaces;

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
}