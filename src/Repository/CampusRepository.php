<?php

namespace App\Repository;

use App\Entity\Campus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Campus|null find($id, $lockMode = null, $lockVersion = null)
 * @method Campus|null findOneBy(array $criteria, array $orderBy = null)
 * @method Campus[]    findAll()
 * @method Campus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CampusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Campus::class);
    }
    public function findCampus($value)
    {
        $em = $this->getEntityManager();
        $sql ="Select c.id, c.nomCampus
        FROM App\Entity\Campus c 
        Where c.nomCampus like :value ";
        $query = $em->createQuery($sql);
        $query->setParameter("value",'%'.$value.'%');
        return $query->getResult();
    }
    public function findByidCampus($id)
    {
        $em = $this->getEntityManager();
        $sql ="Select c.id, c.nomCampus
        FROM App\Entity\Campus c 
        Where c.id = :id ";
        $query = $em->createQuery($sql);
        $query->setParameter("id",$id);
        return $query->getResult();
    }

    public function updateCampus($nom,$id)
    {
        $em = $this->getEntityManager();
        $sql ="UPDATE App\Entity\Campus c 
        SET c.nomCampus =  :nom
        Where c.id = :id ";
        $query = $em->createQuery($sql);
        $query->setParameter("nom",$nom);
        $query->setParameter("id",$id);
        return $query->getResult();
    }


    // /**
    //  * @return Campus[] Returns an array of Campus objects
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
    public function findOneBySomeField($value): ?Campus
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
