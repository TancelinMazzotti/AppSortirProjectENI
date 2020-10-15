<?php

namespace App\Controller;

use App\Entity\Inscription;
use App\Entity\Sortie;
use App\Form\SortieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
    /**
     * @Route("/sortie/show/{id}", name="sortieShow")
     */
    public function show(int $id)
    {
        $sortie =  $this->getDoctrine()
            ->getRepository(Sortie::class)
            ->findOneBy(array('id' => $id));

        return $this->render('sortie/sortie.html.twig', [
            'sortie' => $sortie
        ]);
    }

    /**
     * @Route("/sortie/create", name="sortieCreate")
     */
    public function create(Request $request, EntityManagerInterface $entityManager)
    {
        $sortie = new Sortie();

        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $createStatus = true;

            try{
                $entityManager->persist($sortie);
                $entityManager->flush();
                $createStatus = $form->isValid();
            }
            catch(DBALException $e) {
                $createStatus = false;
            }

            return $this->render('sortie/create.html.twig', [
                'form' => $form->createView(),
                'createStatus' => $createStatus
            ]);

        }

        return $this->render('sortie/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}