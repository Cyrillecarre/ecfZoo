<?php

namespace App\Repository;

use App\Entity\Monitoring;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Monitoring>
 */
class MonitoringRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Monitoring::class);
    }

    public function countByAreaAndState(string $area, string $state): int
    {
    return $this->createQueryBuilder('m')
        ->select('count(m.id)')
        ->join('m.animal', 'a')
        ->join('a.area', 'ar')
        ->where('ar.name = :area')
        ->andWhere('m.state = :state')
        ->setParameter('area', $area)
        ->setParameter('state', $state)
        ->getQuery()
        ->getSingleScalarResult();
    }
}
