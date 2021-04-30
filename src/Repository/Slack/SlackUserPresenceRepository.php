<?php

namespace App\Repository\Slack;

use App\Entity\Slack\SlackUserPresence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SlackUserPresence|null find($id, $lockMode = null, $lockVersion = null)
 * @method SlackUserPresence|null findOneBy(array $criteria, array $orderBy = null)
 * @method SlackUserPresence[]    findAll()
 * @method SlackUserPresence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SlackUserPresenceRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SlackUserPresence::class);
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
    public function save(SlackUserPresence $userPresence)
    {
        $this->getEntityManager()->persist($userPresence);
        $this->getEntityManager()->flush();
    }

}
