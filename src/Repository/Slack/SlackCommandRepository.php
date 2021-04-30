<?php

declare(strict_types=1);

namespace App\Repository\Slack;

use App\Entity\Slack\SlackCommand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SlackCommand|null find($id, $lockMode = null, $lockVersion = null)
 * @method SlackCommand|null findOneBy(array $criteria, array $orderBy = null)
 * @method SlackCommand[]    findAll()
 * @method SlackCommand[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SlackCommandRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SlackCommand::class);
    }

    // /**
    //  * @return Command[] Returns an array of Command objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Command
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
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
    public function save(SlackCommand $command)
    {
        $this->getEntityManager()->persist($command);
        $this->getEntityManager()->flush();
    }

}
