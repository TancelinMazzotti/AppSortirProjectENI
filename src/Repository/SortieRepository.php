<?php

namespace App\Repository;

use App\Entity\Campus;
use App\Entity\Inscription;
use App\Entity\Participant;
use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    public function findForHome($participant, $campus, $nom, $debut, $fin, $isOrganisateur, $isInscrit, $notInscrit, $oldSortie)
    {
        $queryBuilder = $this->createQueryBuilder('s');

        if ($campus != null){
            $queryBuilder->andWhere('s.campus = :campus')
                ->setParameter('campus', $campus);
        }

        if($nom != null && strlen($nom) > 1){
            $queryBuilder->andWhere('s.nom LIKE :nomSortie')
                ->setParameter('nomSortie', "%".$nom."%");
        }

        if ($debut != null){
            $queryBuilder->andWhere('s.dateDebut >= :dateDebut')
                ->setParameter('dateDebut', $debut);
        }

        if ($fin != null){
            $queryBuilder->andWhere('s.dateCloture <= :dateCloture')
                ->setParameter('dateCloture', $fin);
        }

        if($participant != null && $isOrganisateur){
            $queryBuilder->andWhere('s.organisateur = :organisateur')
                ->setParameter('organisateur', $participant);
        }

        if($participant != null && $isInscrit && !$notInscrit){
            $queryBuilder->innerJoin('s.inscriptions', 'i')
                ->andWhere('i.participant = :participant')
                ->setParameter('participant', $participant);
        }

        if($participant != null && !$isInscrit && $notInscrit){
            $subQuery = $this->_em->createQueryBuilder()
                ->select("IDENTITY(i.sortie)")
                ->from(Inscription::class, 'i')
                ->andWhere('i.participant = :participant')
                ->setParameter("participant", $participant)
                ->getQuery()->getArrayResult();

            $queryBuilder->andWhere($queryBuilder->expr()->notIn("s.id", ":list"))
                ->setParameter("list", $subQuery);
        }

        if(!$oldSortie){
            $queryBuilder->andWhere('s.dateCloture >= CURRENT_DATE()');
        }


        return $queryBuilder->getQuery()->getResult();
    }

    public function countParticipant(Sortie $sortie){
        $queryBuilder = $this->createQueryBuilder('s')
            ->select('count(i.participant) as inscrip')
            ->join("s.inscriptions", "i")
            ->andWhere("s.id = :id")
                ->setParameter("id", $sortie->getId())
        ;
        return $queryBuilder->getQuery()->getResult();
    }

    // /**
    //  * @return Sortie[] Returns an array of Sortie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Sortie
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getAllSortieEtatParticipant(){

        return $this->createQueryBuilder('s')
            ->leftJoin('s.inscriptions','i')
            ->select('count(i.participant) as inscrip')
            ->join('s.etat','e')
            ->join('s.organisateur','p')
            ->leftJoin('i.participant','pAll')
            ->groupBy('s.id')
            ->getQuery()
            ->getResult();
    }
}
