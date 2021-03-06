<?php
namespace App\Service;

use App\Dto\BenchmarkResultDto;
use App\Helpers\BenchmarkDataFormatters\BenchmarkResultsTextFileFormatter;
use App\Service\Interfaces\LogWriterInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;

class LogWriter implements LogWriterInterface
{
    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var string
     */
    protected $logDir;

    /**
     * @var string
     */
    protected $file;

    /**
     * LogWriter constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->filesystem = new Filesystem();
        $this->logDir = $container->get('kernel')->getLogDir();
    }

    /**
     * @param string $filename
     * @param string $content
     */
    public function appendContentToFile(string $filename,string $content)
    {
        $this->filesystem->appendToFile($filename, $content);
    }

    /**
     * @param string $content
     */
    public function appendContent(string $content): void
    {
        $this->filesystem->appendToFile($this->logDir . DIRECTORY_SEPARATOR .$this->file, $content);
    }

    /**
     * @param string $filename
     * @return bool
     */
    public function createFile(string $filename): bool
    {
        if (empty($this->file)) {
            $this->file = $filename;
        }
        try {
            $path = $this->logDir . DIRECTORY_SEPARATOR . $filename;
            $this->filesystem->touch($path);
        } catch (IOException $exception) {
            return false;
        }
        return true;
    }

    /**
     * @param BenchmarkResultDto $baseSiteTestResult
     * @param array $comparedSitesTestsResults
     * @param \DateTime $testDate
     * @return mixed|void
     */
    public function writeBenchmarkResultsToFile(
        BenchmarkResultDto $baseSiteTestResult,
        array $comparedSitesTestsResults,
        \DateTime $testDate
    ) {
        //hardcoded, should be set from outside
        $filename = 'log.txt';
        if ($this->createFile($filename)) {
            $formattedBenchmarkResults = BenchmarkResultsTextFileFormatter::prepareResults(
                $baseSiteTestResult,
                $comparedSitesTestsResults,
                $testDate
            );

            $this->appendContent($formattedBenchmarkResults);
        } else {
            throw new RuntimeException("{$filename} file could not be created");
        }

    }
}