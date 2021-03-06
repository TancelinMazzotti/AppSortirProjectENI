<?php

namespace App\Controller;

use App\Entity\Lieux;
use App\Entity\Ville;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use mysql_xdevapi\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
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
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('ville/ville.html.twig', [
            'title' => 'Ville',
        ]);
    }
}
