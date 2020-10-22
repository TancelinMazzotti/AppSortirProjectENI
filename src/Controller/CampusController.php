<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Form\CampusType;
use App\Repository\CampusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/campus", name="campus_")
 * Class CampusController
 * @package App\Controller
 */
class CampusController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function homeCampus(EntityManagerInterface $em,Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('campus/campus.html.twig', [
            'title' => 'Campus',
        ]);
    }

}
