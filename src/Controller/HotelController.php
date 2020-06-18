<?php

namespace App\Controller;


use App\Entity\Hotel;
use App\Entity\PropretySearch;
use App\Form\HotelType;
use App\Form\PropretySearchType;
use App\Repository\DestinationRepository;
use App\Repository\HotelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HotelController extends AbstractController
{

    /*
     * @var HotelRepository
     */
    private $repository;

    /*
     * @var EntityManagerInterface
     */
    private $em;

    public function __Construct(HotelRepository $repository,EntityManagerInterface $em)
    {
        //destination
        $this->repository = $repository;
        //Entity manager
        $this->em = $em;
    }

    /*----------------------------------------Hotel-------------------------------------------------------*/
    /*---------------------------------------------------------------------------------------------------*/
    /*---------------------------------------------------------------------------------------------------*/

    /**
     * @Route("/hotel", name="hotel")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @param HotelRepository $repository
     * @return Response
     */
    public function hotel(PaginatorInterface $paginator,Request $request,HotelRepository $repository):Response
    {
        $hotels = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page',1),
            6
        );
        return $this->render('home/hotel.html.twig', [
            'hotels' => $hotels
        ]);
    }

    /**
     * @Route("/hotel/search" , name="search_hotel")
     * @param Request $request
     * @return Response
     */
    public function searchHotel(Request $request){

        $propertySearch = new PropretySearch();
        $form = $this->createForm(PropretySearchType::class,$propertySearch);
        $form->handleRequest($request);

        $hotels = [];

        if($form->isSubmitted() && $form->isValid()) {
            //on récupère le nom d'article tapé dans le formulaire
            $nom = $propertySearch->getNom();
            if ($nom!="")
                //si on a fourni un nom d'article on affiche tous les articles ayant ce nom
                $hotels= $this->getDoctrine()->getRepository(Hotel::class)->findBy(['name' => $nom]);
            else
                //si si aucun nom n'est fourni on affiche tous les articles
                $hotels= $this->getDoctrine()->getRepository(Hotel::class)->findAll();
        }

        return $this->render('home/hotelSearch.html.twig',[
            'form' =>$form->createView(),
            'hotels' => $hotels
        ]);
    }

    /**
     * @Route("/detail_hotel/{id}", name="hotel.show")
     * @param $id
     * @return Response
     */

    public function show($id):Response
    {
        $hotel = $this->repository->find($id);

        return $this->render('home/showHotel.html.twig',[
            'hotel' => $hotel
        ]);
    }

    /**
     * @Route("/admin/hotel/create", name="admin.hotel.new")
     * @param Request $request
     * @return Response
     */

    public function newHotel(Request $request):Response
    {
        $hotel = new Hotel();

        $form = $this->createForm(HotelType::class,$hotel);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $hotel->setNote(8);
            $this->em->persist($hotel);
            $this->em->flush();
            return $this->redirectToRoute('hotel');
        }

        return $this->render('admin/newHotel.html.twig',[
            'hotel' => $hotel,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/hotelDelete/{id}", name="admin.hotel.delete")
     * @param Hotel $hotel
     * @param Request $request
     * @return RedirectResponse;
     */

    public function deleteHotel(Hotel $hotel,Request $request):Response
    {
        if ($this->isCsrfTokenValid('delete'.$hotel->getId(),$request->get('_token'))){
            $this->em->remove($hotel);
            $this->em->flush();
        }
        return $this->redirectToRoute('destination.show');
    }


    /**
     * @Route("/admin/hotel/{id}", name="admin.hotel.edit")
     * @param Hotel $hotel
     * @param Request $request
     * @return Response
     */

    public function editHotel(Hotel $hotel,Request $request):Response
    {
        $form = $this->createForm(HotelType::class,$hotel);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            return $this->redirectToRoute('destination');
        }

        return $this->render('admin/editHotel.html.twig',[
            'hotel' => $hotel,
            'hotel' => $form->createView()
        ]);
    }




}
