<?php

namespace App\Controller;

use App\Entity\Ville;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/ville", name="api_ville_")
 * Class ApiVilleController
 * @package App\Controller
 */
class ApiVilleController extends AbstractController
{
    /**
     * @Route("/{id}/lieux/", name="apiVilleLieux")
     */
    public function getLieuxByVille(int $id)
    {
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
