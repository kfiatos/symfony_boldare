<?php
namespace App\Dto;


class SiteUrlsDto
{
    /**
     * @var string
     */
    protected $site1Url;

    /**
     * @var string
     */
    protected $site2Url;

    /**
     * SiteUrlsDto constructor.
     * @param $site1Url
     * @param $site2Url
     */
    public function __construct($site1Url, $site2Url)
    {
        $this->site1Url = $site1Url;
        $this->site2Url = $site2Url;
    }

    /**
     * @return array
     */
    public function getSiteUrls()
    {
        return [
            'site_1' => $this->site1Url,
            'site_2' => $this->site2Url,
        ];
    }

}