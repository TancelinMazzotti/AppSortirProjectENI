<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Sortie;
use App\Form\SortieFilterType;
use App\Repository\EtatRepository;
use App\Repository\InscriptionRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(Request $request, InscriptionRepository $inscriptionRepository, SortieRepository $sortieRepository,EtatRepository $etatRepository,
                          EntityManagerInterface $entityManager)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $listSortie = array();

        $form = $this->createForm(SortieFilterType::class);
        $form->handleRequest($request);

        $username = $this->getUser()->getUsername();
        $utilisateur = $this->getDoctrine()->getRepository(Participant::class)
            ->findOneBy(array('pseudo' => $username));

        $campus = $form['campus']->getData();
        $nom = $form['nom']->getData();
        $dateDebut = $form['dateDebut']->getData();
        $dateCloture = $form['dateCloture']->getData();
        $isOrganisateur = $form['isOrganisateur']->getData();
        $isInscrit = $form['isInscrit']->getData();
        $notInscrit = $form['notInscrit']->getData();
        $isOnlyOld = $form['isOnlyOld']->getData();

        $sorties = $this->getDoctrine()->getRepository(Sortie::class)
            ->findForHome($utilisateur, $campus, $nom, $dateDebut, $dateCloture, $isOrganisateur, $isInscrit, $notInscrit, $isOnlyOld);

        foreach ($sorties as $sortie){
            $nbInscrit = $this->getDoctrine()->getRepository(Sortie::class)
                ->countParticipant($sortie);

            array_push($listSortie, [
                'sortie' => $sortie,
                'nbInscrits' => $nbInscrit[0]
            ]);
        }

        // TODO::APO faire pour chaque ville regarder la date ??
        $listSortie = $this->loadAllSortie($listSortie,$sortieRepository,$etatRepository,$entityManager);

        return $this->render('home/index.html.twig', [
            'title' => 'Acceuil',
            'formFilter' => $form->createView(),
            'listSortie' => $listSortie,
        ]);
    }

    public function loadAllSortie($listeSortie, $sortieRepository, EtatRepository $etatRepository,$entityManager){

        $dateJ = new \DateTime();

        foreach ($listeSortie as $sortie => $keys){
            if ($keys["sortie"]->getDateDebut() <= $dateJ && $keys["sortie"]->getDateCloture() > $dateJ){
                $etatEnCour = $etatRepository->findby(array('libelle' => 'Activité en cours'));

                $keys["sortie"]->setEtat($etatEnCour[0]);

                $entityManager->persist($keys["sortie"]);
                $entityManager->flush();
            }
            if($keys["sortie"]->getDateCloture() < $dateJ){
                $etatEnCour = $etatRepository->findby(array('libelle' => 'Passée'));

                $keys["sortie"]->setEtat($etatEnCour[0]);

                $entityManager->persist($keys["sortie"]);
                $entityManager->flush();
            }
        }
        return $listeSortie;
    }
}
