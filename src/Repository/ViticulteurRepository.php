<?php

namespace App\Repository;

use App\Entity\Viticulteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Viticulteur>
 *
 * @method Viticulteur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Viticulteur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Viticulteur[]    findAll()
 * @method Viticulteur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ViticulteurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Viticulteur::class);
    }

    public function save(Viticulteur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Viticulteur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function searchNonVerif(): array
    {
        return $this->createQueryBuilder('v')
            ->select('v')
            ->where('v.verif = :bool')
            ->setParameter('bool', '0')
            ->orderBy('v.lastname', 'DESC')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Customer[] Returns an array of Customer objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Customer
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
