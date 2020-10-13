<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/Ville", name="ville_")
 * Class VilleController
 * @package App\Controller
 */
class VilleController extends AbstractController
{
    /**
     * @Route("/", name="ville")
     */
    public function getVilleList()
    {
        return $this->render('ville/paticipant.html.twig', [
            'title' => 'Ville',
        ]);
    }
}
