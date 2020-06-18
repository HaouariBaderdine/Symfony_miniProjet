<?php

namespace App\Controller;


use App\Entity\Destination;
use App\Entity\Ville;
use App\Form\DestinationType;
use App\Form\VilleType;
use App\Repository\DestinationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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
     * @var EntityManagerInterface
     */
    private $em;

    public function __Construct(DestinationRepository $repository,EntityManagerInterface $em)
    {
        //destination
        $this->repository = $repository;
        //Entity manager
        $this->em = $em;
    }

    /*-----------------------------------------Destination-------------------------------------------------*/
    /*---------------------------------------------------------------------------------------------------*/
    /*---------------------------------------------------------------------------------------------------*/


    /**
     * @Route("/destination", name="destination")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @param DestinationRepository $repository
     * @return Response
     */
    public function destination(PaginatorInterface $paginator,Request $request,DestinationRepository $repository):Response
    {
        $destinations = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page',1),
            6
        );
        return $this->render('home/destination.html.twig', [
            'controller_name' => 'DestinationController',
            'destinations' => $destinations
        ]);
    }


    /**
     * @Route("/detail_destination/{id}", name="destination.show")
     * @param $id
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
     * @param Request $request
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
            return $this->redirectToRoute('admin.destination.new');
        }

        return $this->render('admin/newDestination.html.twig',[
            'destination' => $destination,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/admin/destinationDelete/{id}", name="admin.destination.delete")
     * @param Destination $destination
     * @param Request $request
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
     * @param Request $request
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

    /*----------------------------------------Ville-------------------------------------------------------*/
    /*---------------------------------------------------------------------------------------------------*/
    /*---------------------------------------------------------------------------------------------------*/

    /**
     * @Route("/admin/ville/create", name="admin.ville.new")
     * @param Request $request
     * @return Response
     */

    public function newVille(Request $request):Response
    {
        $ville = new Ville();

        $form = $this->createForm(VilleType::class,$ville);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($ville);
            $this->em->flush();
            return $this->redirectToRoute('destination');
        }

        return $this->render('admin/newVille.html.twig',[
            'ville' => $ville,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/villeDelete/{id}", name="admin.ville.delete")
     * @param Ville $ville
     * @param Request $request
     * @return RedirectResponse;
     */

    public function deleteVille(Ville $ville,Request $request):Response
    {
        if ($this->isCsrfTokenValid('delete'.$ville->getId(),$request->get('_token'))){
            $this->em->remove($ville);
            $this->em->flush();
        }
        return $this->redirectToRoute('destination.show');
    }


    /**
     * @Route("/admin/ville/{id}", name="admin.ville.edit")
     * @param Ville $ville
     * @param Request $request
     * @return Response
     */

    public function editVille(Ville $ville,Request $request):Response
    {


        $form = $this->createForm(VilleType::class,$ville);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            return $this->redirectToRoute('destination');
        }

        return $this->render('admin/editVille.html.twig',[
            'ville' => $ville,
            'form' => $form->createView()
        ]);
    }




}
