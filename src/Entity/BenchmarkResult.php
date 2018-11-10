<?php

namespace App\Entity;

use App\Entity\Interfaces\BenchmarkResultInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BenchmarkResultRepository")
 */
class BenchmarkResult implements BenchmarkResultInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="decimal", precision=6, scale=6)
     */
    private $loadingTime;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isBaseSite = false;

    /**
     * @ORM\Column(type="datetime")
     */
    private $benchmarkDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return float
     */
    public function getLoadingTime(): float
    {
        return $this->loadingTime;
    }

    /**
     * @param float $loadingTime
     */
    public function setLoadingTime(float $loadingTime): void
    {
        $this->loadingTime = $loadingTime;
    }

    /**
     * @return \DateTime
     */
    public function getBenchmarkDate(): \DateTime
    {
        return $this->benchmarkDate;
    }

    /**
     * @param \DateTime $benchmarkDate
     */
    public function setBenchmarkDate($benchmarkDate): void
    {
        $this->benchmarkDate = $benchmarkDate;
    }

    /**
     * @return boolean
     */
    public function isBaseSite(): bool
    {
        return $this->isBaseSite;
    }

    /**
     * @param bool $isBaseSite
     */
    public function setIsBaseSite(bool $isBaseSite): void
    {
        $this->isBaseSite = $isBaseSite;
    }


}
