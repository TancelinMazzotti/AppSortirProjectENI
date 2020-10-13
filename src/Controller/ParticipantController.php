<?php

namespace App\Controller;

use App\Form\AddParticipantProfilType;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use function Symfony\Component\String\u;

/**
 * Class ParticipantController
 * @package App\Controller
 * @Route("/participant", name="participant_")
 */
class ParticipantController extends AbstractController
{
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

        return $this->render('participant/paticipant.html.twig', [
            'title' => 'Mon profil',
            'participant' => $participant,
        ]);
        //dd($user);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function getUpdateParticipantAction(Request $request, EntityManagerInterface $entityManager, ParticipantRepository $participantRepository, $id,
                    UserPasswordEncoderInterface $passwordEncoder){

        $participantSel  = $participantRepository->find(array('id' => $id));

        $participantForm = $this->createForm(AddParticipantProfilType::class,$participantSel);

        $participantForm->handleRequest($request);

        if($participantForm->isSubmitted() && $participantForm->isValid()){

            $pass = $passwordEncoder->encodePassword($participantSel,$participantSel->getPass());
            $participantSel->setPass($pass);

            $entityManager->persist($participantSel);
            $entityManager->flush();

            $this->addFlash("success","le profil à été modifier");

            return $this->redirectToRoute("participant_view", array('id' => $participantSel->getId()));
        }

        return $this->render('participant/modifProfilParticipant.html.twig',[
            'title' => 'Mon Profil',
            'formMonProfil' => $participantForm->createView(),
        ]);
    }
}
