<?php


namespace App\Controller\Api;


use App\Entity\Campus;
use App\Repository\CampusRepository;
use Doctrine\ORM\EntityManagerInterface;
use http\Exception;
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
    public function getListCampusApi(){

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
//api/Campus/ListCampusRecherche/

    /**
     * @return JsonResponse
     * @Route("/ListCampus/{recherche}", name="recherche_campus")
     */
    public function getListCampusApiRecherche($recherche){

        $campusRepo = $this->getDoctrine()->getRepository(Campus::class);

        $listCampus = $campusRepo->findCampus($recherche);

        return $this->json(['list_Campus' => $listCampus]);
    }

    /**
     * @Route("/updateCampus/{nom}/{id}", name="update_campus")
     */
    public function updateCampus($nom,$id){

        $returnId = $id;

        try {

            $campusRepo = $this->getDoctrine()->getRepository(Campus::class);
            $campusRepo->updateCampus($nom,$id);


        } catch (Exception $e) {
            $returnId = null;
            $this->addFlash('error', 'impossible d\'update le Campus');
        }
        return $this->json(['id' => $returnId]);

    }


}