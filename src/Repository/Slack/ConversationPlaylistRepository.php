<?php

namespace App\Repository\Slack;

use App\Entity\Slack\ConversationPlaylist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ConversationPlaylist|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConversationPlaylist|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConversationPlaylist[]    findAll()
 * @method ConversationPlaylist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConversationPlaylistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConversationPlaylist::class);
    }

    // /**
    //  * @return ConversationPlaylist[] Returns an array of ConversationPlaylist objects
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
    public function findOneBySomeField($value): ?ConversationPlaylist
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
    public function save(ConversationPlaylist $conversationPlaylist)
    {
        $this->getEntityManager()->persist($conversationPlaylist);
        $this->getEntityManager()->flush();
    }

}
