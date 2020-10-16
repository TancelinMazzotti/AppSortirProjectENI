<?php


namespace App\Controller\Api;


use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use mysql_xdevapi\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/Ville", name="api_ville_")
 * Class ApiVilleController
 * @package App\Controller\Api
 */
class ApiVilleController extends AbstractController
{
    /**
     * @Route("/Supprimer/{id}", name="supprimer")
     */
    public function supprimerVilleApi($id, EntityManagerInterface $em, VilleRepository $villeRepository)
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
        return $this->json(['id' => $returnId]);
    }

    /**
     * @param VilleRepository $villeRepository
     * @return JsonResponse
     * @Route("/ListVille", name="list_ville")
     */
    public function getListVilleApi(VilleRepository $villeRepository){
        $listVille = $villeRepository->findAll();

        return $this->json(['list_ville' => $listVille]);
    }
}