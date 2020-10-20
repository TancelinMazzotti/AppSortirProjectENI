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
    public function index(SortieRepository $sortieRepository)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $sortieAll = $sortieRepository->getAllSortieEtatParticipant();

        //dd($sortieAll);

        return $this->render('home/index.html.twig', [
            'title' => 'Acceuil',
            'listSortie' => $sortieAll,
        ]);
    }
}
