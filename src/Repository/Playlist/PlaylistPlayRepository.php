<?php

namespace App\Repository\Playlist;

use App\Entity\Playlist\PlaylistPlay;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PlaylistPlay|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlaylistPlay|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlaylistPlay[]    findAll()
 * @method PlaylistPlay[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlaylistPlayRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlaylistPlay::class);
    }

    // /**
    //  * @return PlaylistPlay[] Returns an array of PlaylistPlay objects
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
    public function findOneBySomeField($value): ?PlaylistPlay
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
    public function save(PlaylistPlay $play)
    {
        $this->getEntityManager()->persist($play);
        $this->getEntityManager()->flush();
    }

}
