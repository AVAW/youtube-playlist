<?php

namespace App\Repository\Playlist;

use App\Entity\Playlist\PlaylistVideo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PlaylistVideo|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlaylistVideo|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlaylistVideo[]    findAll()
 * @method PlaylistVideo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlaylistVideoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlaylistVideo::class);
    }

    // /**
    //  * @return Video[] Returns an array of Video objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Video
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
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
    public function save(PlaylistVideo $video)
    {
        $this->getEntityManager()->persist($video);
        $this->getEntityManager()->flush();
    }

}
