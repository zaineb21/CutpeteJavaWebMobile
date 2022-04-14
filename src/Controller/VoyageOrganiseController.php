<?php

namespace App\Controller;

use App\Entity\VoyageOrganise;
use App\Form\VoyageOrganiseType;
use App\Repository\VoyageOrganiseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/voyage/organise")
 */
class VoyageOrganiseController extends AbstractController
{
    /**
     * @Route("/", name="voyage_organise_index", methods={"GET"})
     */
    public function index(VoyageOrganiseRepository $voyageOrganiseRepository): Response
    {
        return $this->render('voyage_organise/index.html.twig', [
            'voyage_organises' => $voyageOrganiseRepository->findAll(),
        ]);
    }
    /**
     * @Route("/user", name="voyage_organise_index2", methods={"GET"})
     */
    public function index2(VoyageOrganiseRepository $voyageOrganiseRepository): Response
    {
        return $this->render('voyage_organise/index2.html.twig', [
            'voyage_organises' => $voyageOrganiseRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="voyage_organise_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $voyageOrganise = new VoyageOrganise();
        $form = $this->createForm(VoyageOrganiseType::class, $voyageOrganise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($voyageOrganise);
            $entityManager->flush();

            return $this->redirectToRoute('voyage_organise_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('voyage_organise/new.html.twig', [
            'voyage_organise' => $voyageOrganise,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="voyage_organise_show", methods={"GET"})
     */
    public function show(VoyageOrganise $voyageOrganise): Response
    {
        return $this->render('voyage_organise/show.html.twig', [
            'voyage_organise' => $voyageOrganise,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="voyage_organise_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, VoyageOrganise $voyageOrganise): Response
    {
        $form = $this->createForm(VoyageOrganiseType::class, $voyageOrganise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('voyage_organise_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('voyage_organise/edit.html.twig', [
            'voyage_organise' => $voyageOrganise,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="voyage_organise_delete", methods={"POST"})
     */
    public function delete(Request $request, VoyageOrganise $voyageOrganise): Response
    {
        if ($this->isCsrfTokenValid('delete'.$voyageOrganise->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($voyageOrganise);
            $entityManager->flush();
        }

        return $this->redirectToRoute('voyage_organise_index', [], Response::HTTP_SEE_OTHER);
    }
}
