<?php

namespace App\Repository;

use App\Entity\Medal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Medal>
 *
 * @method Medal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Medal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Medal[]    findAll()
 * @method Medal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MedalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Medal::class);
    }

    public function findTop3MedalNation(): array
    {
        return $this->createQueryBuilder('m')
            ->select('n.id as nation_id, SUM(m.point) as total')
            ->join('m.nation', 'n')
            ->groupBy('n.id')
            ->orderBy('total', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }
}
