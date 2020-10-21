<?php

namespace App\Repository;

use App\Entity\Ville;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Ville|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ville|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ville[]    findAll()
 * @method Ville[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VilleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ville::class);
    }

    public function findVille($value)
    {
        $em = $this->getEntityManager();
        $sql ="Select v.id, v.nom, v.codePostal
        FROM App\Entity\Ville v 
        Where (v.nom like :value or v.codePostal like :value)";
        $query = $em->createQuery($sql);
        $query->setParameter("value",'%'.$value.'%');
        return $query->getResult();
    }

    public function updateVille($nom,$cp,$id)
    {
        $em = $this->getEntityManager();
        $sql ="UPDATE App\Entity\Ville v 
        SET v.nom = :nom, v.codePostal = :cp
        Where v.id = :id";
        $query = $em->createQuery($sql);
        $query->setParameter("nom",$nom);
        $query->setParameter("cp",$cp);
        $query->setParameter("id",$id);
        return $query->getResult();
    }

    // /**
    //  * @return Ville[] Returns an array of Ville objects
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
    public function findOneBySomeField($value): ?Ville
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
