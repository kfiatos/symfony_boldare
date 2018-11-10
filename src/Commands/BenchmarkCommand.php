<?php

namespace App\Commands;


use App\Dto\SiteUrlsDto;

class BenchmarkCommand
{
    /**
     * @var SiteUrlsDto
     */
    protected $siteUrlsDto;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $mobileNumber;

    /**
     * BenchmarkCommand constructor.
     * @param SiteUrlsDto $siteUrlsDto
     * @param string $email
     * @param string $mobileNumber
     */
    public function __construct(SiteUrlsDto $siteUrlsDto, string $email, string $mobileNumber)
    {
        $this->siteUrlsDto = $siteUrlsDto;
        $this->email = $email;
        $this->mobileNumber = $mobileNumber;
    }

    /**
     * @return SiteUrlsDto
     */
    public function getSiteUrlsDto(): SiteUrlsDto
    {
        return $this->siteUrlsDto;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getMobileNumber(): string
    {
        return $this->mobileNumber;
    }
}