<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecuritAdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function admin(){
        return $this->render('securit_admin/admin.html.twig');
    }

    /**.
     * @Route("/connexion_admin", name="security_login_admin")
     * @param AuthenticationUtils $auth
     * @return Response
     */
    public function login(AuthenticationUtils $auth){

        return $this->render('securit_admin/index.html.twig');
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout(){

    }
}
