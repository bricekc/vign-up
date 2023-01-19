<?php

namespace App\Repository;

use App\Entity\Questionnaire;
use App\Entity\ResultatQuestionnaire;
use App\Entity\Viticulteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ResultatQuestionnaire>
 *
 * @method ResultatQuestionnaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResultatQuestionnaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResultatQuestionnaire[]    findAll()
 * @method ResultatQuestionnaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResultatQuestionnaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResultatQuestionnaire::class);
    }

    public function save(ResultatQuestionnaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ResultatQuestionnaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findOneByUserAndQuestionnaire(Viticulteur $user, Questionnaire $questionnaire): ?ResultatQuestionnaire
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.viticulteur = :user')
            ->andWhere('r.questionnaire = :questionnaire')
            ->setParameter('user', $user)
            ->setParameter('questionnaire', $questionnaire)
            ->getQuery()
            ->getOneOrNullResult();
    }

//    /**
//     * @return ResultatQuestionnaire[] Returns an array of ResultatQuestionnaire objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ResultatQuestionnaire
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
