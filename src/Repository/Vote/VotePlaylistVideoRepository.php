<?php

namespace App\Repository\Vote;

use App\Entity\Playlist\PlaylistVideo;
use App\Entity\User\User;
use App\Entity\Vote\VotePlaylistVideo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VotePlaylistVideo|null find($id, $lockMode = null, $lockVersion = null)
 * @method VotePlaylistVideo|null findOneBy(array $criteria, array $orderBy = null)
 * @method VotePlaylistVideo[]    findAll()
 * @method VotePlaylistVideo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VotePlaylistVideoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VotePlaylistVideo::class);
    }

    public function findVote(string $action, PlaylistVideo $video, User $user, \DateTimeInterface $from, \DateTimeInterface $to): ?VotePlaylistVideo
    {
        $qb = $this->createQueryBuilder('v');
        return $qb
            ->where('v.action = :action')
            ->setParameter('action', $action)
            ->where('v.video = :video')
            ->setParameter('video', $video)
            ->andWhere('v.user = :user2')
            ->setParameter('user2', $user)
            ->where($qb->expr()->between('v.createdAt', ':from', ':to'))
            ->setParameters([
                'from' => $from,
                'to' => $to,
            ])
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @return VotePlaylistVideo[]
     */
    public function findAllVotes(string $action, PlaylistVideo $video, ?\DateTimeInterface $from, \DateTimeInterface $to): array
    {
        $qb = $this->createQueryBuilder('v');
        return $qb
            ->where('v.action = :action')
            ->setParameter('action', $action)
            ->where('v.video = :video')
            ->setParameter('video', $video)
            ->where($qb->expr()->between('v.createdAt', ':from', ':to'))
            ->setParameters([
                'from' => $from,
                'to' => $to,
            ])
            ->getQuery()
            ->getResult();
    }

}
