<?php

namespace App\Controller;

use App\Entity\ParticipationVoyage;
use App\Entity\VoyageOrganise;
use App\Form\ParticipationVoyageType;
use App\Repository\ParticipationVoyageRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/participation/voyage")
 */
class ParticipationVoyageController extends AbstractController
{
    /**
     * @Route("/", name="participation_voyage_index", methods={"GET"})
     */
    public function index(ParticipationVoyageRepository $participationVoyageRepository): Response
    {
        return $this->render('participation_voyage/index.html.twig', [
            'participation_voyages' => $participationVoyageRepository->findAll(),
        ]);
    }
    /**
     * @Route("/user", name="participation_voyage_index1", methods={"GET"})
     */
    public function index1(ParticipationVoyageRepository $participationVoyageRepository): Response
    {
        return $this->render('participation_voyage/index1.html.twig', [
            'participation_voyages' => $participationVoyageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="participation_voyage_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $participationVoyage = new ParticipationVoyage();
        $form = $this->createForm(ParticipationVoyageType::class, $participationVoyage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($participationVoyage);
            $entityManager->flush();

            return $this->redirectToRoute('participation_voyage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('participation_voyage/new.html.twig', [
            'participation_voyage' => $participationVoyage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="participation_voyage_show", methods={"GET"})
     */
    public function show(ParticipationVoyage $participationVoyage): Response
    {
        return $this->render('participation_voyage/show.html.twig', [
            'participation_voyage' => $participationVoyage,
        ]);
    }
    /**
     * @Route("/user/{id}", name="participation_voyage_show1", methods={"GET"})
     */
    public function show1(ParticipationVoyage $participationVoyage): Response
    {
        return $this->render('participation_voyage/show1.html.twig', [
            'participation_voyage' => $participationVoyage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="participation_voyage_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ParticipationVoyage $participationVoyage): Response
    {
        $form = $this->createForm(ParticipationVoyageType::class, $participationVoyage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('participation_voyage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('participation_voyage/edit.html.twig', [
            'participation_voyage' => $participationVoyage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="participation_voyage_delete", methods={"POST"})
     */
    public function delete(Request $request, ParticipationVoyage $participationVoyage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$participationVoyage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($participationVoyage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('participation_voyage_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/bjehrabi1/{id}", name="participation_voyage_annuler", methods={"GET"})
     */
    public function annulerVoy(Request $request, ParticipationVoyage $participationVoyage,\Swift_Mailer $mailer,ManagerRegistry $doctrine ): Response
    {
        $mailMessage = 'Votre Participation dans le voyage de '.$participationVoyage->getPaysVoyage().' est annulé';


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($participationVoyage);
        $entityManager->flush();
        $entityManager = $doctrine->getManager();
        $eve = $entityManager->getRepository(VoyageOrganise::class)->find($participationVoyage->getIdVoyage());


        $message = (new \Swift_Message('votre participation est annulée avec succés'))
            ->setFrom('medaziz.tebessi@esprit.tn')
            ->setTo('cuutpete@gmail.com')
            ->setBody($mailMessage)
        ;
        $mailer->send($message);




        return $this->redirectToRoute('participation_voyage_index1', [], Response::HTTP_SEE_OTHER);
    }
}
