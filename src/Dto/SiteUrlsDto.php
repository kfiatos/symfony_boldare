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
     * SiteUrlsDto constructor.
     * @param $baseSiteUrl
     * @param array $comparedSites
     */
    public function __construct(string $baseSiteUrl, array $comparedSites)
    {
        $this->baseSiteUrl = $baseSiteUrl;
        $this->comparedSites = $comparedSites;
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

}