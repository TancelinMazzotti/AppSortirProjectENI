<?php


namespace App\Controller\Api;


use App\Entity\Ville;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
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
     * @param EntityManagerInterface $em
     * @param VilleRepository $villeRepository
     * @param Request $rq
     * @return JsonResponse
     * @Route("/AddVille", name="add_ville")
     */
    public function ajouterVilleApi(EntityManagerInterface $em,VilleRepository $villeRepository, Request $rq){
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
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
                throw new Exception('nom ou/et cp null.');
            }
        } catch (Exception $e) {
            $this->addFlash('error', 'impossible d\'ajouter la ville : \n' . $e->getCode() . '\n' . $e->getMessage());
        }
        return $this->json(['ville' => $insertedVille]);
    }

    /**
     * @param VilleRepository $villeRepository
     * @return JsonResponse
     * @Route("/ListVille", name="list_ville")
     */
    public function getListVilleApi(VilleRepository $villeRepository){
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $listVille = $villeRepository->findVille("");

        return $this->json(['list_ville' => $listVille]);
    }

    /**
     * @return JsonResponse
     * @Route("/ListVille/{recherche}", name="recherche_ville")
     */
    public function getListVilleApiRecherche($recherche, VilleRepository $villeRepository){
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $listVille = $villeRepository->findVille($recherche);

        return $this->json(['list_ville' => $listVille]);
    }

    /**
     * @Route("/updateVille", name="update_ville")
     */
    public function updateVille(EntityManagerInterface $em,VilleRepository $villeRepository, Request $rq){
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        try {
            $nom = $rq->request->get("nom");
            $cp = $rq->request->get("cp");
            $id = $rq->request->get("id");
            if ($nom != null && $cp != null && $id != null) {
                $villeRepository->updateVille($nom,$cp,$id);
                $updatedVille = $villeRepository->find(array('id' => $id));
            } else {
                throw new Exception('nom ou/et cp null.');
            }
        } catch (Exception $e) {
            $this->addFlash('error', 'impossible de modifier la ville : \n' . $e->getCode() . '\n' . $e->getMessage());
        }
        return $this->json(['ville' => $updatedVille]);
    }

    /**
     * @Route("/Supprimer/{id}", name="supprimer")
     */
    public function supprimerVilleApi($id, EntityManagerInterface $em, VilleRepository $villeRepository){
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $returnId = $id;
        try {
            $supprimerVille = $villeRepository->find(array('id' => $id));

            $em->remove($supprimerVille);
            $em->flush();
        } catch (Exception $e) {
            $returnId = null;
            $this->addFlash('error', 'impossible de supprimer la ville : \n'.$e->getCode().'\n'.$e->getMessage());
        }
        return $this->json(['id' => $returnId]);
    }

    /**
     * @return JsonResponse
     * @Route("/{id}/lieux/", name="apiVilleLieux")
     */
    public function getLieuxByVille(int $id){
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $ville =  $this->getDoctrine()
            ->getRepository(Ville::class)
            ->findOneBy(array('id' => $id));

        $result = array();
        foreach ($ville->getLieux() as $lieux){
            array_push($result, [
                'id' => $lieux->getId(),
                'nom' => $lieux->getNom()
            ]);
        }
        return  $this->json($result);
    }
}