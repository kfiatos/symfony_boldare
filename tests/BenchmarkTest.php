<?php
namespace App\Tests;

use App\Dto\BenchmarkFullResultsDto;
use App\Dto\BenchmarkResultDto;
use App\Dto\SiteUrlsDto;
use App\Service\Benchmark;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class BenchmarkTest extends TestCase
{
    /**
     * @var Benchmark
     */
    protected $benchmark;

    protected function setUp()
    {
        /** @var EventDispatcherInterface $dipatcherInterfaceMock */
        $dipatcherInterfaceMock = $this->getMockBuilder(EventDispatcherInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->benchmark = new Benchmark($dipatcherInterfaceMock);
        $siteUrlsDto = new SiteUrlsDto(
            'http://google.pl',
            ['http://microsoft.com', 'http://wp.pl']
        );
        $this->benchmark->performSiteBenchmark($siteUrlsDto);
    }

    public function testPerformSiteBenchmark()
    {
        $siteUrlsDto = new SiteUrlsDto(
            'http://google.pl',
            ['http://microsoft.com', 'http://wp.pl']
        );
        $this->benchmark->performSiteBenchmark($siteUrlsDto);

        $this->assertInstanceOf(BenchmarkResultDto::class, $this->benchmark->getBaseSiteBenchmarkResult());
    }

    public function testGetBaseSiteBenchmarkResult()
    {
        $this->assertInstanceOf(BenchmarkResultDto::class, $this->benchmark->getBaseSiteBenchmarkResult());
        $this->assertObjectHasAttribute('siteLoadingTime', $this->benchmark->getBaseSiteBenchmarkResult());
        $this->assertObjectHasAttribute('siteUrl', $this->benchmark->getBaseSiteBenchmarkResult());
        $this->assertObjectHasAttribute('benchmarkDate', $this->benchmark->getBaseSiteBenchmarkResult());
    }

    public function testGetData()
    {
        $this->assertInstanceOf(BenchmarkFullResultsDto::class, $this->benchmark->getData());
    }

    public function testGetOtherSitesBenchmarkResults()
    {
        $this->assertContainsOnlyInstancesOf(
            BenchmarkResultDto::class,
            $this->benchmark->getOtherSitesBenchmarkResults()
        );
    }

    public function testSendNotificationsAfterBenchmarkWasDone()
    {
        //This method will be tested by testing BenchmarkSubscriber
        $this->markTestSkipped('This method will be tested by testing BenchmarkSubscriber');
    }

    public function test__construct()
    {
        self::assertInstanceOf(Benchmark::class, $this->benchmark);
    }

    public function testGetBenchmarkDate()
    {
        $this->assertInstanceOf(\DateTime::class,$this->benchmark->getBenchmarkDate());
    }
}
