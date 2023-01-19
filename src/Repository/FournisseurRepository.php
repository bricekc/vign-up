<?php

namespace App\Repository;

use App\Entity\Fournisseur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Fournisseur>
 *
 * @method Fournisseur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fournisseur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fournisseur[]    findAll()
 * @method Fournisseur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FournisseurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fournisseur::class);
    }

    public function save(Fournisseur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Fournisseur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllFournisseur(): array
    {
        return $this->createQueryBuilder('u')
            ->select('u')
            ->orderBy('u.lastname')
            ->getQuery()
            ->getResult();
    }

    public function searchWithNomPrenom(string $text = ''): array
    {
        if ('' == $text) {
            $query = $this->createQueryBuilder('f')
                ->orderBy('f.lastname', 'DESC');
        } else {
            $query = $this->createQueryBuilder('f')
                ->where('f.firstname LIKE :text OR f.lastname LIKE :text')
                ->setParameter('text', '%'.$text.'%')
                ->orderBy('f.lastname', 'DESC');
        }

        return $query->getQuery()->execute();
    }

    public function searchNonVerif(): array
    {
        return $this->createQueryBuilder('f')
            ->select('f')
            ->where('f.verif = :bool')
            ->setParameter('bool', 'false')
            ->orderBy('f.lastname', 'DESC')
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
