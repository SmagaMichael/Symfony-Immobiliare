<?php

namespace App\Repository;

use App\Entity\RealEstate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RealEstate|null find($id, $lockMode = null, $lockVersion = null)
 * @method RealEstate|null findOneBy(array $criteria, array $orderBy = null)
 * @method RealEstate[]    findAll()
 * @method RealEstate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RealEstateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RealEstate::class);
    }

    public function findAllWithSurface($surface, $price, $rooms){
        $qb = $this->createQueryBuilder('r')
            //->where('r.surface > :surface')
            //->andWhere('r.price < :price')
            //->andWhere('r.rooms = :rooms')
            ->setParameters([
               // 'surface' => empty($surface) ? 0: $surface,
               // 'price' => empty($price) ? 999999999999999 : $price,
               // 'rooms' => $rooms,
                ]);
           // ->getQuery();

        if(!empty($surface)){
            $qb->andWhere('r.surface > :surface')->setParameter('surface', $surface);
        }

        if(!empty($price)){
            $qb->andWhere('r.price < :price')->setParameter('price', $price);
        }

        if(!empty($rooms)){
            $qb->andWhere('r.rooms = :rooms')->setParameter('rooms', $rooms);
        }

        return $qb->getQuery()->getResult();
    }

    public function search($query){
        $qb = $this->createQueryBuilder('r')
        ->where('r.title LIKE :query')
            ->setParameter('query', '%'.$query.'%');

        return $qb->getQuery()->getResult();
    }


    // /**
    //  * @return RealEstate[] Returns an array of RealEstate objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RealEstate
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
