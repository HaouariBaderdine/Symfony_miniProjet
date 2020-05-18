<?php

namespace App\Controller;


use App\Entity\Destination;
use App\Form\DestinationType;
use App\Repository\CircuitRepository;
use App\Repository\DestinationRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DestinationController extends AbstractController
{

    /*
     * @var DestinationRepository
     */
    private $repository;

    /*
     * @var CircuitRepository
     */
    private $repositoryCir;

    /*
     * @var EntityManagerInterface
     */
    private $em;

    public function __Construct(DestinationRepository $repository,CircuitRepository $repository2,EntityManagerInterface $em)
    {
        //destination
        $this->repository = $repository;
        //circuit
        $this->repositoryCir = $repository2;
        //Entity manager
        $this->em = $em;
    }

    /**
     * @Route("/destination", name="destination")
     * @return Response
     */
    public function destination(DestinationRepository $repository)
    {
        $destinations = $repository->findAll();
        return $this->render('home/destination.html.twig', [
            'controller_name' => 'DestinationController',
            'destinations' => $destinations
        ]);
    }


    /**
     * @Route("/detail_destination/{id}", name="destination.show")
     * @return Response
     */

    public function show($id):Response
    {
        $destination = $this->repository->find($id);

        return $this->render('home/showDestination.html.twig',[
            'destination' => $destination
        ]);
    }

    /**
     * @Route("/admin/destination/create", name="admin.destination.new")
     * @param Destination $destination
     * @return Response
     */

    public function new(Request $request):Response
    {
        $destination = new Destination();

        $form = $this->createForm(DestinationType::class,$destination);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($destination);
            $this->em->flush();
            return $this->redirectToRoute('destination');
        }

        return $this->render('admin/newDestination.html.twig',[
            'destination' => $destination,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/admin/destinationDelete/{id}", name="admin.destination.delete")
     * @param Destination $destination
     * @return RedirectResponse;
     */

    public function delete(Destination $destination,Request $request):Response
    {
        if ($this->isCsrfTokenValid('delete'.$destination->getId(),$request->get('_token'))){
            $this->em->remove($destination);
            $this->em->flush();
        }
        return $this->redirectToRoute('destination');
    }




    /**
     * @Route("/admin/destination/{id}", name="admin.destination.edit")
     * @param Destination $destination
     * @return Response
     */

    public function edit(Destination $destination,Request $request):Response
    {
        $form = $this->createForm(DestinationType::class,$destination);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            return $this->redirectToRoute('destination');
        }

        return $this->render('admin/editDestination.html.twig',[
            'destination' => $destination,
            'form' => $form->createView()
        ]);
    }






    /**
     * @Route("/circuit", name="circuit")
     * @return Response
     */
    public function Circuit(CircuitRepository $repository)
    {
        $circuits = $repository->findAll();
        dump($circuits);

        return $this->render('home/Circuits.html.twig', [
            'controller_name' => 'DestinationController',
            'circuits' => $circuits
        ]);
    }

    /**
     * @Route("/detail_circuit/{id}", name="circuit.show")
     * @return Response
     */

    public function showCircuit($id):Response
    {
        $circuit = $this->repository->find($id);

        return $this->render('home/showCircuit.html.twig',[
            'circuit' => $circuit
        ]);
    }



}
