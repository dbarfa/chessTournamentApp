<?php

namespace App\Repository;

use App\Entity\Tournament;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tournament|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tournament|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tournament[]    findAll()
 * @method Tournament[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TournamentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tournament::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Tournament $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Tournament $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Tournament[] Returns an array of Tournament objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tournament
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function countBySearch($keyword)
    {
        $qb = $this->_getQbWithSearch($keyword);

        $qb->select('count(t.id)');
        // permet de recuperer une valeur unique et une un objet ou une collection
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function findBySearch($search)
    {

        //keyword
        $qb = $this->_getQbWithSearch($search[2]);
        //offset
        if ($search[0]) {
            $qb->setFirstResult($search[0]);
        }
        //limit
        if ($search[1]) {
            $qb->setMaxResults($search[1]);
        }
        $qb->orderBy('t.id');
        return $qb->getQuery()->getResult();
    }



    private function _getQbWithSearch($keyword)
    {
        $qb = $this->createQueryBuilder('t');
        $qb->where('t.deleted = 0');
        if ($keyword) {
            $qb->andWhere('t.name LIKE :p3');
            $qb->setParameter('p3', '%'.$keyword . '%');
        }
        return $qb;
    }






}
