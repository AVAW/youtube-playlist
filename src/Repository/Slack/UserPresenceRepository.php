<?php

namespace App\Repository\Slack;

use App\Entity\Slack\UserPresence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserPresence|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserPresence|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserPresence[]    findAll()
 * @method UserPresence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserPresenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserPresence::class);
    }

    // /**
    //  * @return UserPresence[] Returns an array of UserPresence objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserPresence
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
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
    public function save(UserPresence $userPresence)
    {
        $this->getEntityManager()->persist($userPresence);
        $this->getEntityManager()->flush();
    }

}
