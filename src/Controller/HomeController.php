<?php

namespace App\Controller;

use App\Repository\InscriptionRepository;
use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(InscriptionRepository $inscriptionRepository, SortieRepository $sortieRepository)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        //$sortieAll = $sortieRepository->getAllSortieEtatParticipant();

        $incripAll = $inscriptionRepository->getInscriptionAll();

        //dd($incripAll);

        return $this->render('home/index.html.twig', [
            'title' => 'Acceuil',
            'listSortie' => $incripAll,
        ]);
    }
}
