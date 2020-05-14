<?php

namespace App\Controller;


use App\Entity\Circuit;
use App\Entity\Destination;
use App\Entity\Etape;
use App\Entity\Ville;
use App\Repository\EtapeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DestinationController extends AbstractController
{
    private $rep_dest;
    public function __construct(EtapeRepository $rep_dest_parm)
    {
        $this->rep_dest = $rep_dest_parm;
    }

    /**
     * @Route("/destination", name="destination")
     * @return Response
     */
    public function destination()
    {
        return $this->render('home/destination.html.twig', [
            'controller_name' => 'DestinationController',
            'title' => 'Destination'
        ]);
    }

    /**
     * @Route("/MAJ", name="MAJ_destination")
     * @return Response
     */
    public function MAJ()
    {

        return $this->render('home/MAJ.html.twig', [
            'controller_name' => 'DestinationController'
        ]);
    }



}
