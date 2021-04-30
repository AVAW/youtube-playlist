<?php

namespace App\Repository\Slack;

use App\Entity\Slack\SlackConversation;
use App\Entity\Slack\SlackConversationPlaylist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SlackConversationPlaylist|null find($id, $lockMode = null, $lockVersion = null)
 * @method SlackConversationPlaylist|null findOneBy(array $criteria, array $orderBy = null)
 * @method SlackConversationPlaylist[]    findAll()
 * @method SlackConversationPlaylist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SlackConversationPlaylistRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SlackConversationPlaylist::class);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findLastConversationPlaylist(SlackConversation $conversation)
    {
        return $this->createQueryBuilder('cp')
            ->addSelect('playlist')
            ->leftJoin('cp.playlist', 'playlist')
            ->andWhere('cp.conversation = :conversation')
            ->setParameter('conversation', $conversation)
            ->orderBy('cp.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
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
    public function save(SlackConversationPlaylist $conversationPlaylist)
    {
        $this->getEntityManager()->persist($conversationPlaylist);
        $this->getEntityManager()->flush();
    }

}
