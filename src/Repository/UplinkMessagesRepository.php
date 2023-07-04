<?php

namespace App\Repository;

use App\Entity\UplinkMessages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UplinkMessages>
 *
 * @method UplinkMessages|null find($id, $lockMode = null, $lockVersion = null)
 * @method UplinkMessages|null findOneBy(array $criteria, array $orderBy = null)
 * @method UplinkMessages[]    findAll()
 * @method UplinkMessages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UplinkMessagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UplinkMessages::class);
    }

    public function save(UplinkMessages $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UplinkMessages $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return UplinkMessages[] Returns an array of UplinkMessages objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UplinkMessages
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
