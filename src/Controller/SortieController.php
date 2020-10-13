<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\SortieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
    /**
     * @Route("/sortie/create", name="sortieCreate")
     */
    public function create(Request $request, EntityManagerInterface $entityManager)
    {
        $sortie = new Sortie();

        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $entityManager->persist($sortie);
            $entityManager->flush();
        }

        return $this->render('sortie/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
