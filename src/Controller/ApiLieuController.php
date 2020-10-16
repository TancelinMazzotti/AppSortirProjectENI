<?php

namespace App\Controller;

use App\Entity\Lieux;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/lieu", name="api_lieu_")
 * Class ApiLieuController
 * @package App\Controller
 */
class ApiLieuController extends AbstractController
{
    /**
     * @Route("/{id}", name="get_lieu")
     */
    public function getLieu(int $id)
    {
        $lieu =  $this->getDoctrine()
            ->getRepository(Lieux::class)
            ->findOneBy(array('id' => $id));

        $result = array(
            'id' => $lieu->getId(),
            'nom' => $lieu->getNom(),
            'rue' => $lieu->getRue(),
            'codePostal' => $lieu->getVille()->getCodePostal(),
            'latitude' => $lieu->getLatitude(),
            'longitude' => $lieu->getLongitude(),
        );

        return $this->json($result);
    }
}
