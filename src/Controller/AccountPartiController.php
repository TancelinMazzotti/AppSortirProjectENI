<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\ParticipantType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountPartiController extends AbstractController
{
    /**
     * @Route("/", name="login")
     */
    public function loginAction(AuthenticationUtils $authenticationUtils){

        $error = $authenticationUtils->getLastAuthenticationError();

        if($error !== null){
            $this->addFlash("error", $error);
        }

        $lastName = $authenticationUtils->getLastUsername();

        return $this->render("security/login.html.twig", array(
            'last_username' => $lastName,
        ));
    }

    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, TokenStorageInterface $tokenStorage,
                             SessionInterface $session, EntityManagerInterface $entityManager){

        $participant = new Participant();
        $participant->setAdministrator("ROLE_USER");
        $participant->setActif(true);

        $participantForm = $this->createForm(ParticipantType::class,$participant);
        $participantForm->handleRequest($request);

        if($participantForm->isSubmitted() && $participantForm->isValid()){

            $pass = $passwordEncoder->encodePassword($participant,$participant->getPass());
            $participant->setPass($pass);

            $entityManager->persist($participant);
            $entityManager->flush();

            $token = new UsernamePasswordToken($participant,$pass,'main',$participant->getRoles());
            $tokenStorage->setToken($token);

            $session->set('_security_main',serialize($token));

            $this->addFlash('succes','bien inscirt');

            return $this->redirectToRoute("home");
        }

        return $this->render("account_parti/registerParticipant.html.twig",[
            'title' => 'ce crée un compte',
            'form_ins' => $participantForm->createView(),
        ]);
    }

    /**
     * @Route("/logout" , name="logOut")
     */
    public function logout(){

    }

    /**
     * @Route("/fogot/pass", name="fogotPass")
     */
    public function fogotPassAction(){

        return $this->render('account_parti/fogotPass.html.twig');
    }
}
