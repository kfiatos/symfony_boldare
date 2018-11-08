<?php
namespace App\Events;

use Symfony\Component\EventDispatcher\Event;

class SiteLoadingSpeedTestedEvent extends Event
{
    /**
     * @var array
     */
    protected $testResults = [];

    /**
     * SiteLoadingSpeedTestedEvent constructor.
     * @param array $testResults
     */
    public function __construct(array $testResults)
    {
        $this->testResults = $testResults;
    }

    /**
     * @return array
     */
    public function getTestResults(): array
    {
        return $this->testResults;
    }

    /**
     * @return \DateTime|null
     */
    public function getTestDate(): ?\DateTime
    {
        return $this->testDate;
    }
}