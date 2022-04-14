<?php

namespace App\Controller;

use App\Entity\EvenementLocal;
use App\Form\EvenementLocalType;
use App\Repository\EvenementLocalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/evenement/local")
 */
class EvenementLocalController extends AbstractController
{
    /**
     * @Route("/", name="evenement_local_index", methods={"GET"})
     */
    public function index(EvenementLocalRepository $evenementLocalRepository): Response
    {
        return $this->render('evenement_local/index.html.twig', [
            'evenement_locals' => $evenementLocalRepository->findAll(),
        ]);
    }

    /**
     * @Route("/user", name="evenement_local_index1", methods={"GET"})
     */
    public function index1(EvenementLocalRepository $evenementLocalRepository): Response
    {
        return $this->render('evenement_local/index1.html.twig', [
            'evenement_locals' => $evenementLocalRepository->findAll(),
        ]);
    }




    /**
     * @Route("/new", name="evenement_local_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $evenementLocal = new EvenementLocal();
        $form = $this->createForm(EvenementLocalType::class, $evenementLocal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($evenementLocal);
            $entityManager->flush();

            return $this->redirectToRoute('evenement_local_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('evenement_local/new.html.twig', [
            'evenement_local' => $evenementLocal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evenement_local_show", methods={"GET"})
     */
    public function show(EvenementLocal $evenementLocal): Response
    {
        return $this->render('evenement_local/show.html.twig', [
            'evenement_local' => $evenementLocal,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="evenement_local_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EvenementLocal $evenementLocal): Response
    {
        $form = $this->createForm(EvenementLocalType::class, $evenementLocal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evenement_local_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('evenement_local/edit.html.twig', [
            'evenement_local' => $evenementLocal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evenement_local_delete", methods={"POST"})
     */
    public function delete(Request $request, EvenementLocal $evenementLocal): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenementLocal->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($evenementLocal);
            $entityManager->flush();
        }

        return $this->redirectToRoute('evenement_local_index', [], Response::HTTP_SEE_OTHER);
    }
}
