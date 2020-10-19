<?php


namespace App\Controller\Api;


use App\Entity\Ville;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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
        } catch (\Exception $e) {
            $returnId = null;
            $this->addFlash('error', 'impossible de supprimer la ville : \n'.$e->getCode().'\n'.$e->getMessage());
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

    /**
     * @param EntityManagerInterface $em
     * @param VilleRepository $villeRepository
     * @param Request $rq
     * @return JsonResponse
     * @Route("/AddVille", name="add_ville")
     */
    public function ajouterVilleApi(EntityManagerInterface $em,VilleRepository $villeRepository, Request $rq){
        try {
            $nom = $rq->request->get("nom");
            $cp = $rq->request->get("cp");
            if ($nom != null && $cp != null) {
                $ville = new Ville();
                $ville->setNom($nom);
                $ville->setCodePostal($cp);
                $em->persist($ville);
                $em->flush();
                $id = $ville->getId();
                $insertedVille = $villeRepository->find(array('id' => $id));
            } else {
                throw new \Exception('nom ou/et cp null.');
            }
        } catch (\Exception $e) {
            $this->addFlash('error', 'impossible d\'ajouter la ville : \n'.$e->getCode().'\n'.$e->getMessage());
        }
        return $this->json(['ville' => $insertedVille]);
    }
}