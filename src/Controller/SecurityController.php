<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     * @param Request $req
     * @param EntityManagerInterface $manager
     * @param UserPasswordEncoderInterface $encoder
     * @return RedirectResponse|Response
     */
    public function registration(Request $req,EntityManagerInterface $manager,UserPasswordEncoderInterface $encoder)
    {
        $user = new User();

        $form = $this->createForm(RegistrationType::class,$user);

        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isvalid()){

            $hash=$encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/registration.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/connexion", name="security_login")
     * @param AuthenticationUtils $auth
     * @return Response
     */
    public function login(AuthenticationUtils $auth){
        $error = $auth->getLastAuthenticationError();
        $lastUsername = $auth->getLastUsername();
        return $this->render('security/login.html.twig',[
            'last_username'=>$lastUsername,
            'error'=>$error
        ]);
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout()
    {}
}
