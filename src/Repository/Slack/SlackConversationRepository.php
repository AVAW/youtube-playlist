<?php

declare(strict_types=1);

namespace App\Repository\Slack;

use App\Entity\Slack\SlackConversation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SlackConversation|null find($id, $lockMode = null, $lockVersion = null)
 * @method SlackConversation|null findOneBy(array $criteria, array $orderBy = null)
 * @method SlackConversation[]    findAll()
 * @method SlackConversation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SlackConversationRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SlackConversation::class);
    }

    // /**
    //  * @return SlackChannel[] Returns an array of SlackChannel objects
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
    public function findOneBySomeField($value): ?SlackChannel
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
    public function save(SlackConversation $conversation)
    {
        $this->getEntityManager()->persist($conversation);
        $this->getEntityManager()->flush();
    }

}
