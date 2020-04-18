<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Twig\Environment;

class HomeController extends AbstractController
{
    /**
     * @return Response
     * @var Environment
     */
    private $twig;
    public function _construct(Environment $twig){
        $this->twig = $twig;
    }
    public function home():Response
    {
        return new Response($this->render('home/home.html.twig', [
        'controller_name' => 'HomeController',
        'title' => 'Bienvenu'
    ]));
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('home/contact.html.twig', [
            'controller_name' => 'HomeController',
            'title' => 'Contacter'
        ]);
    }
}
