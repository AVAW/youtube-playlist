<?php

declare(strict_types=1);

namespace App\Repository\Slack;

use App\Entity\Slack\SlackAction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SlackAction|null find($id, $lockMode = null, $lockVersion = null)
 * @method SlackAction|null findOneBy(array $criteria, array $orderBy = null)
 * @method SlackAction[]    findAll()
 * @method SlackAction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SlackActionRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SlackAction::class);
    }

    // /**
    //  * @return SlackAction[] Returns an array of SlackAction objects
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
    public function findOneBySomeField($value): ?SlackAction
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
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function save(SlackAction $action)
    {
        $this->getEntityManager()->persist($action);
        $this->getEntityManager()->flush();
    }

}
