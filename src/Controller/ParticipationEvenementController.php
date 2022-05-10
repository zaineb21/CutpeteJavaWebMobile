<?php

namespace App\Controller;

use App\Entity\ParticipationEvenement;
use App\Form\ParticipationEvenementType;
use App\Repository\ParticipationEvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/participation/evenement")
 */
class ParticipationEvenementController extends AbstractController
{
    /**
     * @Route("/", name="participation_evenement_index", methods={"GET"})
     */
    public function index(ParticipationEvenementRepository $participationEvenementRepository): Response
    {
        return $this->render('participation_evenement/index.html.twig', [
            'participation_evenements' => $participationEvenementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="participation_evenement_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $participationEvenement = new ParticipationEvenement();
        $form = $this->createForm(ParticipationEvenementType::class, $participationEvenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($participationEvenement);
            $entityManager->flush();

            return $this->redirectToRoute('participation_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('participation_evenement/new.html.twig', [
            'participation_evenement' => $participationEvenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="participation_evenement_show", methods={"GET"})
     */
    public function show(ParticipationEvenement $participationEvenement): Response
    {
        return $this->render('participation_evenement/show.html.twig', [
            'participation_evenement' => $participationEvenement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="participation_evenement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ParticipationEvenement $participationEvenement): Response
    {
        $form = $this->createForm(ParticipationEvenementType::class, $participationEvenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('participation_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('participation_evenement/edit.html.twig', [
            'participation_evenement' => $participationEvenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="participation_evenement_delete", methods={"POST"})
     */
    public function delete(Request $request, ParticipationEvenement $participationEvenement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$participationEvenement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($participationEvenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('participation_evenement_index', [], Response::HTTP_SEE_OTHER);
    }
}
