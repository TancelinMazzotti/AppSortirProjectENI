<?php

namespace App\Controller;

use App\Entity\Campus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CampusController extends AbstractController
{
    /**
     * @Route("/campus", name="campus")
     */
    public function homeCampus()
    {
        $campusRepo = $this->getDoctrine()->getRepository(Campus::class);
        $campus = $campusRepo->findAll();


        return $this->render('campus/campus.html.twig', [
           "campus"=>  $campus,
        ]);
    }

    /**
     * @Route("/campus_remove/{id}", name="campus_remove", requirements={"id"="\d+"})
     */
    public function removeCampus($id)
    {
        $campusRepo = $this->getDoctrine()->getRepository(Campus::class);
        $campus = $campusRepo->deleteCampus($id);


        return $this->redirectToRoute("campus", [

        ]);
    }



}
