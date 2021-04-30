<?php

namespace App\Repository\Google;

use App\Entity\Google\GoogleUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GoogleUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method GoogleUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method GoogleUser[]    findAll()
 * @method GoogleUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GoogleUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GoogleUser::class);
    }

    // /**
    //  * @return GoogleUser[] Returns an array of GoogleUser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GoogleUser
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(GoogleUser $googleProfile)
    {
        $this->getEntityManager()->persist($googleProfile);
        $this->getEntityManager()->flush();
    }

}
