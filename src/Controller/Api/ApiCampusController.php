<?php


namespace App\Controller\Api;


use App\Entity\Campus;
use App\Repository\CampusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api/campus", name="api_campus_")
 * Class ApiCampusController
 * @package App\Controller\Api
 */
class ApiCampusController extends AbstractController
{

    /**
     * @return JsonResponse
     * @Route("/ListCampus", name="list_campus")
     */
    public function getListCampusApi()
    {

        $campusRepo = $this->getDoctrine()->getRepository(Campus::class);
        $listCampus = $campusRepo->findCampus("");

        return $this->json(['list_Campus' => $listCampus]);
    }

    /**
     * @Route("/Supprimer/{id}", name="supprimer")
     */
    public function supprimerCampus($id, EntityManagerInterface $em, CampusRepository $campusRepository)
    {
        $returnId = $id;
        try {
            $supprimerCampus = $campusRepository->find(array('id' => $id));

            $em->remove($supprimerCampus);
            $em->flush();
        } catch (Exception $e) {
            $returnId = null;
            $this->addFlash('error', 'impossible de supprimer le Campus');
        }
        return $this->json(['id' => $returnId]);
    }

    /**
     * @return JsonResponse
     * @Route("/ListCampus/{recherche}", name="recherche_campus")
     */
    public function getListCampusApiRecherche($recherche)
    {

        $campusRepo = $this->getDoctrine()->getRepository(Campus::class);

        $listCampus = $campusRepo->findCampus($recherche);

        return $this->json(['list_Campus' => $listCampus]);
    }

    /**
     * @param EntityManagerInterface $em
     * @param CampusRepository $campusRepository
     * @param Request $request
     * @return JsonResponse
     * @Route("/AddCampus", name="add_campus")
     */
    public function AddCampus(EntityManagerInterface $em, CampusRepository $campusRepository, Request $request)
    {
        try {
            $nom = $request->request->get("nomCampus");

            if ($nom != null) {
                $campus = new Campus();
                $campus->setNomCampus($nom);
                $em->persist($campus);
                $em->flush();

                $id = $campus->getId();
                $insertedCampus = $campusRepository->findByidCampus($id);
            } else {
                throw new Exception('nom est null.');
            }
        } catch (Exception $e) {
            $this->addFlash('error', 'impossible d\'ajouter le campus : \n' . $e->getCode() . '\n' . $e->getMessage());
        }

        return $this->json(['campus' => $insertedCampus[0]]);
    }

    /**
     * @Route("/updateCampus", name="update_campus")
     * @param EntityManagerInterface $em
     * @param CampusRepository $campusRepository
     * @param Request $request
     * @return JsonResponse
     */
    public function updateCampus(EntityManagerInterface $em,CampusRepository $campusRepository, Request $request){

        try {
            $nom = $request->request->get("nomCampus");
            $id = $request->request->get("id");
            if ($nom != null  && $id != null) {
                $campusRepository->updateCampus($nom,$id);
                $updatedCampus = $campusRepository->findByidCampus($id);
            } else {
                throw new Exception('nom  null.');
            }
        } catch (Exception $e) {
            $this->addFlash('error', 'impossible de modifier le campus : \n' . $e->getCode() . '\n' . $e->getMessage());
        }
        return $this->json(['campus' => $updatedCampus[0]]);
    }

}