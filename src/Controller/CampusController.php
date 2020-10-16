<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Form\CampusType;
use App\Repository\CampusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/Campus", name="campus_")
 * Class CampusController
 * @package App\Controller
 */
class CampusController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function homeCampus(EntityManagerInterface $em,Request $request)
    {
        $campusRepo = $this->getDoctrine()->getRepository(Campus::class);
        $campusAll = $campusRepo->findAll();

        $campus = new Campus();
        $campusForm = $this->createForm(CampusType::class,$campus);

        $campusForm->handleRequest($request);

        if($campusForm-> isSubmitted() && $campusForm->isValid()){

            $em->persist($campus);
            $em->flush();

            $this->addFlash('succes','L\'idée a été sauvgardé');

        }

        return $this->render('campus/campus.html.twig', [
           "campus"=>  $campusAll,
            "campusForm" => $campusForm->createView()
        ]);
    }

    /**
     * @Route("/remove/{id}", name="remove", requirements={"id"="\d+"})
     */
    public function removeCampus($id)
    {
        $campusRepo = $this->getDoctrine()->getRepository(Campus::class);
        $campus = $campusRepo->deleteCampus($id);


        return $this->redirectToRoute("campus", [

        ]);
    }

}
