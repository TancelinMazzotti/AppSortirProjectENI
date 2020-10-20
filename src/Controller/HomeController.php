<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Sortie;
use App\Form\SortieFilterType;
use App\Repository\InscriptionRepository;
use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(Request $request, InscriptionRepository $inscriptionRepository, SortieRepository $sortieRepository)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $listSortie = array();

        $sortieAll = $sortieRepository->getAllSortieEtatParticipant();

        //dd($sortieAll);

        $form = $this->createForm(SortieFilterType::class);
        $form->handleRequest($request);

        $username = $this->getUser()->getUsername();
        $utilisateur = $this->getDoctrine()->getRepository(Participant::class)
            ->findOneBy(array('pseudo' => $username));

        if($form->isSubmitted()) {
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

            $nbinscrit = $sortieRepository->getAllSortieEtatParticipant();

            foreach ($sorties as $sortie => $val){
                array_push($listSortie, [
                    'sortie' => $val,
                    'nbInscrits' => $nbinscrit[$sortie],
                ]);
            }
            //dd($listSortie);
        }

        return $this->render('home/index.html.twig', [
            'title' => 'Acceuil',
            'formFilter' => $form->createView(),
            'listSortie' => $listSortie,
        ]);
    }
}
