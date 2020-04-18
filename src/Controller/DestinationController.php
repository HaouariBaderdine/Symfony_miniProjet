<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DestinationController extends AbstractController
{
    /**
     * @Route("/destination", name="destination")
     */
    public function index()
    {
        return $this->render('home/destination.html.twig', [
            'controller_name' => 'DestinationController',
            'title' => 'Destination'
        ]);
    }

}
