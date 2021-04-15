<?php

namespace App\Repository\Slack;

use App\Entity\Slack\Conversation;
use App\Entity\Slack\ConversationPlaylistVideo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query\Expr;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

/**
 * @method ConversationPlaylistVideo|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConversationPlaylistVideo|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConversationPlaylistVideo[]    findAll()
 * @method ConversationPlaylistVideo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConversationPlaylistVideoRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConversationPlaylistVideo::class);
    }

    public function findLastConversationPlaylistVideo(Conversation $conversation): ConversationPlaylistVideo
    {

        $res = $this->createQueryBuilder('cpv')
            ->addSelect('authors')
            ->addSelect('video')
            ->leftJoin('cpv.conversationPlaylist', 'cp')
            ->leftJoin('cpv.currentVideo', 'video')
            ->leftJoin('video.authors', 'authors')
            ->andWhere('cp.conversation = :conversation')
            ->setParameter('conversation', $conversation)
            ->getQuery()
            ->getResult();

        return array_pop($res);
    }

    // /**
    //  * @return ConversationPlaylistVideo[] Returns an array of ConversationPlaylistVideo objects
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
    public function findOneBySomeField($value): ?ConversationPlaylistVideo
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
    public function save(ConversationPlaylistVideo $conversationPlaylist)
    {
        $this->getEntityManager()->persist($conversationPlaylist);
        $this->getEntityManager()->flush();
    }

}
