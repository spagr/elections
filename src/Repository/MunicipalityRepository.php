<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Municipality;
use App\Entity\Party;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Municipality>
 *
 * @method Municipality|null find($id, $lockMode = null, $lockVersion = null)
 * @method Municipality|null findOneBy(array $criteria, array $orderBy = null)
 * @method Municipality[]    findAll()
 * @method Municipality[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MunicipalityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Municipality::class);
    }

    public function add(Municipality $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Municipality $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Municipality[] Returns an array of Party objects
     */
    public function findByName(string $value, int $limit = 10): array
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.name LIKE :name')
            ->setParameter('name', '%' . $value . '%')
            ->orderBy('m.name', \Doctrine\Common\Collections\Criteria::ASC)
            ->setFirstResult(0)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
            ;
    }
}
