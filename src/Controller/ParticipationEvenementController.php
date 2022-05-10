<?php

namespace App\Controller;

use App\Entity\EvenementLocal;
use App\Entity\ParticipationEvenement;
use App\Form\ParticipationEvenementType;
use App\Repository\ParticipationEvenementRepository;

use Doctrine\Persistence\ManagerRegistry;
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
     * @Route("/user", name="participation_evenement_index1", methods={"GET"})
     */
    public function index1(ParticipationEvenementRepository $participationEvenementRepository): Response
    {
        return $this->render('participation_evenement/index1.html.twig', [
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
     * @Route("/{id}/b", name="participation_evenement_show1", methods={"GET"})
     */
    public function show1(ParticipationEvenement $participationEvenement): Response
    {
        return $this->render('participation_evenement/show1.html.twig', [
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

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($participationEvenement);
            $entityManager->flush();



        return $this->redirectToRoute('participation_evenement_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/bjehrabi/{id}", name="participation_evenement_annuler", methods={"GET"})
     */
    public function annuler(Request $request, ParticipationEvenement $participationEvenement,\Swift_Mailer $mailer,ManagerRegistry $doctrine ): Response
    {
        $mailMessage = 'Votre Participation dans l événement '.$participationEvenement->getNomEvent().' est annulé';


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($participationEvenement);
        $entityManager->flush();
        $entityManager = $doctrine->getManager();
        $eve = $entityManager->getRepository(EvenementLocal::class)->find($participationEvenement->getIdEvent());
        $eve->setNbparti($eve->getNbparti()-1);
        $eve->setNbplacerest($eve->getNbplacerest()+1);
        $entityManager->flush();
        $message = (new \Swift_Message('votre participation est annulée avec succés'))
            ->setFrom('medaziz.tebessi@esprit.tn')
            ->setTo('cuutpete@gmail.com')
            ->setBody($mailMessage)
        ;
        $mailer->send($message);




        return $this->redirectToRoute('participation_evenement_index1', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/particiEve/{id}", name="product_search")
     */
    public function recherche(ManagerRegistry $doctrine, int $id): Response
    {
        $ParticipationEvenement = $doctrine->getRepository(ParticipationEvenement::class)->find($id);

        if (!$ParticipationEvenement) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return new Response('Check out this great product: '.$ParticipationEvenement->getName());

        // or render a template
        // in the template, print things with {{ product.name }}
        // return $this->render('product/show.html.twig', ['product' => $product]);
    }






}
