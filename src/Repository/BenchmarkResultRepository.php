<?php

namespace App\Repository;

use App\Dto\BenchmarkFullResultsDto;
use App\Entity\BenchmarkResult;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BenchmarkResult|null find($id, $lockMode = null, $lockVersion = null)
 * @method BenchmarkResult|null findOneBy(array $criteria, array $orderBy = null)
 * @method BenchmarkResult[]    findAll()
 * @method BenchmarkResult[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BenchmarkResultRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BenchmarkResult::class);
    }

    /**
     * @param BenchmarkFullResultsDto $benchmarkFullResultsDto
     */
    public function storeBenchmarkResults(BenchmarkFullResultsDto $benchmarkFullResultsDto)
    {
        $benchmarkResult = new BenchmarkResult();
        $benchmarkResult->setBenchmarkDate($benchmarkFullResultsDto->getBenchmarkDate());
        $benchmarkResult->setLoadingTime($benchmarkFullResultsDto->getBaseSiteResult()->getSiteLoadingTime());
        $benchmarkResult->setUrl($benchmarkFullResultsDto->getBaseSiteResult()->getSiteUrl());
        $benchmarkResult->setIsBaseSite(true);

        $this->getEntityManager()->persist($benchmarkResult);
        $otherSites = $benchmarkFullResultsDto->getOtherSitesResults();
        foreach ($otherSites as $otherSite) {
            $benchmarkResult = new BenchmarkResult();
            $benchmarkResult->setBenchmarkDate($otherSite->getBenchmarkDate());
            $benchmarkResult->setUrl($otherSite->getSiteUrl());
            $benchmarkResult->setLoadingTime($otherSite->getSiteLoadingTime());
            $this->getEntityManager()->persist($benchmarkResult);
        }
        $this->getEntityManager()->flush();

    }
}
