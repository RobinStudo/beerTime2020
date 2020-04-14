<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function countIncomingEvent(){
        $stmt = $this->createQueryBuilder( 'e' );
        $stmt->select( 'count(e.id)' );
        $stmt->where( 'e.startAt > :now' );
        $stmt->setParameter( 'now', new \DateTime() );

        return $stmt->getQuery()->getSingleScalarResult();
    }

    public function searchByName( $query ){
        $stmt = $this->createQueryBuilder( 'e' );
        $stmt->where( 'e.name LIKE :query' );
        $stmt->setParameter( 'query', '%' . $query . '%' );

        return $stmt->getQuery()->getResult();
    }

    public function getRandom(){
        $stmt = $this->createQueryBuilder( 'e' );
        $stmt->select('e.id');

        $stmt->where( 'e.endAt > NOW()' );
        $stmt->orderBy( 'RAND()' );
        $stmt->setMaxResults( 1 );

        return $stmt->getQuery()->getSingleScalarResult();
    }

    // /**
    //  * @return Event[] Returns an array of Event objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Event
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
