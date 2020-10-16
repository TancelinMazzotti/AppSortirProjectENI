<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\AddParticipantProfilType;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class ParticipantController
 * @package App\Controller
 * @Route("/participant", name="participant_")
 */
class ParticipantController extends AbstractController
{

    /**
     * @Route("/", name="list")
     */
    public function getListParticipantAction(ParticipantRepository $participantRepository){

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $partiAll = $participantRepository->getAllPaticipantandCampus();

        //dd($partiAll);

        return $this->render('participant/listParticipant.html.twig',[
            'title' => 'List des profil',
            'listPart' => $partiAll,
        ]);
    }

    /**
     * @Route("/{id}", name="view")
     */
    public function getPaticipantAction(ParticipantRepository $participantRepository, $id)
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $participant = $participantRepository->findBy(array('id' => $id));

        $user = $this->getUser();

        if($participant[0]->getPass() === $user->getPassword() && $participant[0]->getPseudo() ===  $user->getUsername()) {
            return $this->redirectToRoute("participant_edit", array('id' => $participant[0]->getId()));
        }
        //dd($participant);

        return $this->render('participant/paticipant.html.twig', [
            'title' => 'Le profil',
            'participant' => $participant,
        ]);
        //dd($user);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function getUpdateParticipantAction(Request $request, EntityManagerInterface $entityManager, ParticipantRepository $participantRepository, $id,
                    UserPasswordEncoderInterface $passwordEncoder){

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $participantSel  = $participantRepository->find(array('id' => $id));

        $user = $this->getUser();

        if( $user->getRoles()[0] === "ROLE_ADMIN" || $participantSel->getPass() === $user->getPassword() && $participantSel->getPseudo() ===  $user->getUsername()) {

            $participantForm = $this->createForm(AddParticipantProfilType::class, $participantSel);

            $participantForm->handleRequest($request);

            if ($participantForm->isSubmitted() && $participantForm->isValid()) {

                $pass = $passwordEncoder->encodePassword($participantSel, $participantSel->getPass());
                $participantSel->setPass($pass);

                /** @var UploadedFile $picture */
                $picture = $participantForm->get('picture')->getData();

                $newFileName = sha1(uniqid()) . "." . $picture->guessExtension();

                try {
                    $picture->move($this->getParameter('uplode_dir'), $newFileName);
                } catch (FileException $fileException) {
                    die($fileException);
                }

                $participantSel->setUrlPhoto($newFileName);

                $entityManager->persist($participantSel);
                $entityManager->flush();

                $this->addFlash("success", "le profil à été modifier");

                return $this->redirectToRoute("participant_view", array('id' => $participantSel->getId()));
            }

            return $this->render('participant/modifProfilParticipant.html.twig', [
                'title' => 'Mon Profil',
                'formMonProfil' => $participantForm->createView(),
                'participant' => $participantSel,
            ]);
        }else{
            $this->addFlash("error","Vous ne passerez pas ...");
            return $this->render('home/index.html.twig', [
                'controller_name' => 'HomeController',
            ]);
        }
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function deleteParticipantAction($id, ParticipantRepository $participantRepository, EntityManagerInterface $entityManager){

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $deletePart = $participantRepository->find(array('id' => $id));

        $entityManager->remove($deletePart);
        $entityManager->flush();

        $this->addFlash("success",'le profil à été supprimer !');

        return $this->redirectToRoute("participant_list");
    }

    /**
     * @Route("/insert/new", name="new")
     */
    public function insertParticipantAction(EntityManagerInterface $entityManager, Request $request, UserPasswordEncoderInterface $passwordEncoder){

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $participant = new Participant();

        $participantForm = $this->createForm(AddParticipantProfilType::class,$participant);
        $participantForm->handleRequest($request);

        if($participantForm->isSubmitted() && $participantForm->isValid()){

            $participant->setAdministrator("ROLE_USER");
            $participant->setActif(true);

            $pass = $passwordEncoder->encodePassword($participant,$participant->getPass());
            $participant->setPass($pass);

            /** var UploadedFile $picture */
            $picture = $participantForm->get('picture')->getData();

            $newFileName = sha1(uniqid()) . "." . $picture->guessExtension();

            try {
                $picture->move($this->getParameter('uplode_dir'), $newFileName);
            }catch (FileException $fileException){
                die($fileException);
            }

            $participant->setUrlPhoto($newFileName);

            $entityManager->persist($participant);
            $entityManager->flush();

            $this->addFlash("success",'le profil à bien été crée !');

            return $this->redirectToRoute("participant_list");
        }

        return $this->render('participant/addParticipant.html.twig',[
            'title' => 'ajouter un participant',
            'form_int' => $participantForm->createView(),
        ]);
    }
}
