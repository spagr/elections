<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Party;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Party>
 *
 * @method Party|null find($id, $lockMode = null, $lockVersion = null)
 * @method Party|null findOneBy(array $criteria, array $orderBy = null)
 * @method Party[]    findAll()
 * @method Party[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Party::class);
    }

    public function add(Party $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Party $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Party[] Returns an array of Party objects
     */
    public function findByName(string $name): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.name LIKE :name')
            ->setParameter('name', '%' . $name . '%')
            ->orderBy('p.id', \Doctrine\Common\Collections\Criteria::ASC)
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Party[] Returns an array of Party objects
     */
    public function findByIds(array $ids): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id IN (:ids)')
            ->setParameter('ids', $ids)
            ->orderBy('p.id', \Doctrine\Common\Collections\Criteria::ASC)
            ->getQuery()
            ->getResult()
        ;
    }
}
