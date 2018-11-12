<?php
namespace App\Dto;


class SiteUrlsDto
{
    /**
     * @var string
     */
    protected $baseSiteUrl;

    /**
     * @var array
     */
    protected $comparedSites;

    /**
     * @var \DateTime
     */
    protected $benchmarkDate;

    /**
     * SiteUrlsDto constructor.
     * @param $baseSiteUrl
     * @param array $comparedSites
     * @param \DateTime $benchmarkDate
     */
    public function __construct(string $baseSiteUrl, array $comparedSites, \DateTime $benchmarkDate)
    {
        $this->baseSiteUrl = $baseSiteUrl;
        $this->comparedSites = $comparedSites;
        $this->benchmarkDate = $benchmarkDate;
    }

    /**
     * @return string
     */
    public function getBaseSiteUrl(): string
    {
        return $this->baseSiteUrl;
    }

    /**
     * @return array
     */
    public function getComparedSitesUrls(): array
    {
        return $this->comparedSites;

    }

    /**
     * @return \DateTime
     */
    public function getBenchmarkDate(): \DateTime
    {
        return $this->benchmarkDate;
    }
}