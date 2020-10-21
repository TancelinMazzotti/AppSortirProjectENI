<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Inscription;
use App\Entity\Sortie;
use App\Entity\Ville;
use App\Form\cancelSortieType;
use App\Form\SortieType;
use App\Repository\SortieRepository;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sortie", name="sortie_")
 * Class SortieController
 * @package App\Controller
 */
class SortieController extends AbstractController
{
    /**
     * @Route("/show/{id}", name="sortieShow")
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
     * @Route("/create", name="sortieCreate")
     */
    public function create(Request $request, EntityManagerInterface $entityManager)
    {
        $sortie = new Sortie();

        $villes = $this->getDoctrine()
            ->getRepository(Ville::class)
            ->findAll();

        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $entityManager->persist($sortie);
            $entityManager->flush();
            $createStatus = $form->isValid();

            return $this->render('sortie/create.html.twig', [
                'form' => $form->createView(),
                'villes' => $villes,
                'createStatus' => $createStatus
            ]);

        }

        return $this->render('sortie/create.html.twig', [
            'form' => $form->createView(),
            'villes' => $villes
        ]);
    }

    /**
     * @Route("/update/{id}", name="sortieUpdate")
     */
    public function update(int $id, Request $request, EntityManagerInterface $entityManager)
    {
        $sortie = $this->getDoctrine()
            ->getRepository(Sortie::class)
            ->findOneBy(array('id' => $id));

        $villes = $this->getDoctrine()
            ->getRepository(Ville::class)
            ->findAll();

        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $entityManager->flush();
            $updateStatus = $form->isValid();

            return $this->render('sortie/update.html.twig', [
                'form' => $form->createView(),
                'villes' => $villes,
                'updateStatus' => $updateStatus
            ]);

        }

        return $this->render('sortie/update.html.twig', [
            'form' => $form->createView(),
            'villes' => $villes
        ]);
    }


    /**
     * @Route("/cancel/{id}", name="sortieCancel")
     */
    public function cancelSortie(int $id, Request $request, EntityManagerInterface $entityManager)
    {
        $sortie = $this->getDoctrine()
            ->getRepository(Sortie::class)
            ->findSortie($id);

        $form = $this->createForm(cancelSortieType::class, $sortie[0]);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $sortie[0]->setEtat();
            $entityManager->persist($sortie[0]);
            $entityManager->flush();
            $updateStatus = $form->isValid();

            return $this->render('sortie/cancel.html.twig', [
                'form' => $form->createView(),
                'updateStatus' => $updateStatus
            ]);

        }

        return $this->render('sortie/cancel.html.twig', [
            'form' => $form->createView(),
            'sortie'=> $sortie[0]
        ]);

    }
}
