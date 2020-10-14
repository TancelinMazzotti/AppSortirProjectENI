<?php

namespace App\Controller;

use App\Entity\Lieux;
use App\Entity\Ville;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function getVilleList()
    {
        return $this->render('ville/paticipant.html.twig', [
            'title' => 'Ville',
        ]);
    }

    /**
     * @Route("/{id}/lieux/", name="lieuxByVille")
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
