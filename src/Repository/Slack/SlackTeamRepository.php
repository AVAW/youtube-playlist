<?php

declare(strict_types=1);

namespace App\Repository\Slack;

use App\Entity\Slack\SlackTeam;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SlackTeam|null find($id, $lockMode = null, $lockVersion = null)
 * @method SlackTeam|null findOneBy(array $criteria, array $orderBy = null)
 * @method SlackTeam[]    findAll()
 * @method SlackTeam[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SlackTeamRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SlackTeam::class);
    }

    // /**
    //  * @return SlackTeam[] Returns an array of SlackTeam objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SlackTeam
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
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
    public function save(SlackTeam $team)
    {
        $this->getEntityManager()->persist($team);
        $this->getEntityManager()->flush();
    }

}
