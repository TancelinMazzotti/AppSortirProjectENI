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
    public function getVilleList(VilleRepository $villeRepository)
    {
        return $this->render('ville/paticipant.html.twig', [
            'title' => 'Ville',
        ]);
    }

    /**
     * @Route("/Supprimer/{id}", name="supprimer")
     */
    public function supprimerVille($id, EntityManagerInterface $em, VilleRepository $villeRepository)
    {
        $returnId = $id;
        try {
            $supprimerVille = $villeRepository->find(array('id' => $id));

            $em->remove($supprimerVille);
            $em->flush();
        } catch (Exception $e) {
            $returnId = null;
            $this->addFlash('error', 'impossible de supprimer la ville');
        }
        return new Response($id);
    }

    /**
     * @param VilleRepository $villeRepository
     * @return JsonResponse
     * @Route("/apiListVille", name="api_list_ville")
     */
    public function getListVilleApi(VilleRepository $villeRepository){
        $listVille = $villeRepository->findAll();

        return $this->json(['list_ville' => $listVille]);
    }
}
