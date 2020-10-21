<?php

namespace App\Controller;

use App\Entity\Inscription;
use App\Repository\InscriptionRepository;
use App\Repository\ParticipantRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class InscriptionController
 * @package App\Controller
 * @Route("/inscription", name="inscription_")
 */
class InscriptionController extends AbstractController
{
    /**
     * @Route("/", name="view")
     */
    public function index()
    {
        return $this->render('inscription/inscription.html.twig', [
            'controller_name' => 'InscriptionController',
        ]);
    }

    /**
     * @param $idSortie
     * @param $idUser
     * @param EntityManagerInterface $entityManager
     * @param SortieRepository $sortieRepository
     * @param ParticipantRepository $participantRepository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/sinscrir/{idSortie}/{idUser}", name="sinscrir")
     */
    public function getSortieInscrip($idSortie, $idUser, EntityManagerInterface $entityManager, SortieRepository $sortieRepository, ParticipantRepository $participantRepository){

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $sortie = $sortieRepository->find(array('id' => $idSortie));

        $participant = $participantRepository->find(array('id' => $idUser));

        $inscription = new Inscription();

        $inscription->setDateInscription(new \DateTime());

        $inscription->setParticipant($participant);

        $inscription->setSortie($sortie);

        $entityManager->persist($inscription);
        $entityManager->flush();

        $this->addFlash("success","Vous être bien incrit !");

        return $this->redirectToRoute("home");
    }

    /**
     * @param $idSortie
     * @param $idUser
     * @param EntityManagerInterface $entityManager
     * @param SortieRepository $sortieRepository
     * @param ParticipantRepository $participantRepository
     * @param InscriptionRepository $inscriptionRepository
     * @Route("/deinscrir/{idSortie}/{idUser}", name="deinscrir")
     */
    public function getRemouveInscription($idSortie,$idUser,EntityManagerInterface $entityManager,SortieRepository $sortieRepository,ParticipantRepository $participantRepository,
                                            InscriptionRepository $inscriptionRepository){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $sortie = $sortieRepository->find(array('id' => $idSortie));

        $participant = $participantRepository->find(array('id' => $idUser));

        $inscription = $inscriptionRepository->getInscriptionBySortieIdAndParticipantId($sortie->getId(), $participant->getId());

        //dd($inscription[0]);

        $entityManager->remove($inscription[0]);
        $entityManager->flush();

        $this->addFlash("success","Vous être bien déinscrie !");

        return $this->redirectToRoute("home");
    }
}
