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
     * @Route("/api/lieu/{id}", name="get_lieu")
     */
    public function getLieu(int $id)
    {
        $lieu =  $this->getDoctrine()
            ->getRepository(Lieux::class)
            ->findOneBy(array('id' => $id));

        return $this->json($lieu);
    }
}
