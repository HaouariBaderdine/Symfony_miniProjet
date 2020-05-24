<?php

namespace App\Controller;


use App\Entity\Circuit;
use App\Entity\Etape;
use App\Form\CircuitType;
use App\Form\EtapeType;
use App\Repository\CircuitRepository;
use App\Repository\EtapeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CircuitController extends AbstractController{

    /*
     * @var CircuitRepository
     */
    private $repositoryCir;

    /*
     * @var EtapeRepository
     */
    private $repositoryEtape;

    /*
     * @var EntityManagerInterface
     */
    private $em;

    public function __Construct(CircuitRepository $repository2,EtapeRepository $repositoryEtape,EntityManagerInterface $em)
    {
        //circuit
        $this->repositoryCir = $repository2;
        //etape
        $this->repositoryEtape = $repositoryEtape;
        //Entity manager
        $this->em = $em;
    }

    /**
     * @Route("/circuit", name="circuit")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @param CircuitRepository $repository
     * @return Response
     */
    public function Circuit(PaginatorInterface $paginator,Request $request,CircuitRepository $repository)
    {
        $circuits = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page',1),
            6
        );

        return $this->render('home/Circuits.html.twig', [
            'controller_name' => 'CircuitController',
            'circuits' => $circuits
        ]);
    }

    /**
     * @Route("/detail_circuit/{id}", name="circuit.show")
     * @param $id
     * @return Response
     */

    public function showCircuit($id):Response
    {
        $circuit = $this->repositoryCir->find($id);

        return $this->render('home/showCircuit.html.twig',[
            'controller_name' => 'CircuitController',
            'circuit' => $circuit
        ]);
    }

    /**
     * @Route("/admin/circuit/create", name="admin.circuit.new")
     * @param Request $request
     * @return Response
     */

    public function new(Request $request):Response
    {
        $circuit = new Circuit();

        $form = $this->createForm(CircuitType::class,$circuit);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($circuit);
            $this->em->flush();
            return $this->redirectToRoute('admin.circuit.new');
        }

        return $this->render('admin/newCircuit.html.twig',[
            'circuit' => $circuit,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/circuitDelete/{id}", name="admin.circuit.delete")
     * @param Circuit $circuit
     * @param Request $request
     * @return RedirectResponse;
     */

    public function delete(Circuit $circuit,Request $request):Response
    {
        if ($this->isCsrfTokenValid('delete'.$circuit->getId(),$request->get('_token'))){
            $this->em->remove($circuit);
            $this->em->flush();
        }
        return $this->redirectToRoute('circuit');
    }


    /**
     * @Route("/admin/circuit/{id}", name="admin.circuit.edit")
     * @param Circuit $circuit
     * @param Request $request
     * @return Response
     */

    public function edit(Circuit $circuit,Request $request):Response
    {
        $form = $this->createForm(CircuitType::class,$circuit);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            return $this->redirectToRoute('circuit');
        }

        return $this->render('admin/editCircuit.html.twig',[
            'circuit' => $circuit,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/admin/etape/create", name="admin.etape.new")
     * @param Request $request
     * @return Response
     */

    public function newEtape(Request $request):Response
    {
        $etape = new Etape();

        $form = $this->createForm(EtapeType::class,$etape);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($etape);
            $this->em->flush();
            return $this->redirectToRoute('circuit');
        }

        return $this->render('admin/newEtape.html.twig',[
            'etape' => $etape,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/etape/{id}", name="admin.etape.edit")
     * @param Etape $etape
     * @param Request $request
     * @return Response
     */

    public function editEtape(Etape $etape,Request $request):Response
    {
        $form = $this->createForm(EtapeType::class,$etape);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            return $this->redirectToRoute('circuit.show');
        }

        return $this->render('admin/editEtapee.html.twig',[
            'etape' => $etape,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/etapeDelete/{id}", name="admin.etape.delete")
     * @param Etape $etape
     * @param Request $request
     * @return RedirectResponse;
     */

    public function deleteEtape(Etape $etape,Request $request):Response
    {
        if ($this->isCsrfTokenValid('delete'.$etape->getId(),$request->get('_token'))){
            $this->em->remove($etape);
            $this->em->flush();
        }
        return $this->redirectToRoute('circuit.show');
    }


}