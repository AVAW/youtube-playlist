<?php

declare(strict_types=1);

namespace App\Repository\Playlist;

use App\Entity\Playlist\Playlist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Playlist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Playlist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Playlist[]    findAll()
 * @method Playlist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlaylistRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Playlist::class);
    }

    public function findOneByIdentifierWithVideos(string $identifier)
    {
        $qb = $this->createQueryBuilder('p');

        return $qb
            ->addSelect('videos')
            ->where('p.identifier = :identifier')
            ->setParameter('identifier', $identifier, 'uuid')
//            ->andWhere($qb->expr()->notIn('p.status', [Playlist::STATUS_REMOVED]))
            ->leftJoin('p.videos', 'videos')
            ->getQuery()
            ->getOneOrNullResult();
    }

    // /**
    //  * @return Playlist[] Returns an array of Playlist objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Playlist
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
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
    public function save(Playlist $playlist): void
    {
        $this->getEntityManager()->persist($playlist);
        $this->getEntityManager()->flush();
    }

    public function findOneByIdentifierWithVideosAndPlay(string $identifier): ?Playlist
    {
        $qb = $this->createQueryBuilder('p');

        return $qb
            ->addSelect('play')
            ->addSelect('video')
            ->addSelect('authors')
            ->where('p.identifier = :identifier')
            ->setParameter('identifier', $identifier, 'uuid')
            ->leftJoin('p.play', 'play')
            ->leftJoin('play.video', 'video')
            ->leftJoin('video.authors', 'authors')
            ->getQuery()
            ->getOneOrNullResult();
    }

}
