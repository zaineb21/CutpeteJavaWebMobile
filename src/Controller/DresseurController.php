<?php

namespace App\Controller;

use App\Entity\Dresseur;
use App\Form\DresseurType;
use App\Repository\DresseurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer ;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use App\Entity\Urlizer;

/**
 * @Route("/dresseur")
 */
class DresseurController extends AbstractController
{
    /**
     * @Route("/", name="app_dresseur_index", methods={"GET"})
     */
    public function dresseur(DresseurRepository $dresseurRepository): Response
    {
        return $this->render('dresseur/dresseur.html.twig', [
            'dresseurs' => $dresseurRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_dresseur_new", methods={"GET", "POST"})
     */
    public function new(Request $request, DresseurRepository $dresseurRepository): Response
    {
        $dresseur = new Dresseur();
        $form = $this->createForm(DresseurType::class, $dresseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['picture']->getData();
            $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = Urlizer::urlize($originalFilename).'-'.uniqid().'.'.$uploadedFile->guessExtension();
            $uploadedFile->move(
                $destination,
                $newFilename

            );
            $dresseur->setPicture($newFilename);



            $dresseur->setDate( new \DateTime('now'));
            $dresseurRepository->add($dresseur);
            $this->addFlash(
                'info',
                ' Un dresseur est ajouté avec succsé'
              );
            return $this->redirectToRoute('app_dresseur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dresseur/new.html.twig', [
            'dresseur' => $dresseur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_dresseur_show", methods={"GET"})
     */
    public function show(Dresseur $dresseur): Response
    {
        return $this->render('dresseur/show.html.twig', [
            'dresseur' => $dresseur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_dresseur_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Dresseur $dresseur, DresseurRepository $dresseurRepository): Response
    {
        $form = $this->createForm(DresseurType::class, $dresseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dresseurRepository->add($dresseur);
            return $this->redirectToRoute('app_dresseur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dresseur/edit.html.twig', [
            'dresseur' => $dresseur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_dresseur_delete", methods={"POST"})
     */
    public function delete(Request $request, Dresseur $dresseur, DresseurRepository $dresseurRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dresseur->getId(), $request->request->get('_token'))) {
            $dresseurRepository->remove($dresseur);
        }

        return $this->redirectToRoute('app_dresseur_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/remove/{id}", name="dresseur_delete")
     */
    public function deletevet(Dresseur $dresseur, DresseurRepository $dresseurRepository)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($dresseur);
        $em->flush();
        $em->flush();
        $this->addFlash(
            'info',
            'le Dresseur a été supprimé avec succès'
        );

        return $this->redirectToRoute('app_dresseur_index');
    }
    /**
     * @Route("/front/list", name="list_front", methods={"GET"})
     */
    public function dresseurfrontlist(DresseurRepository $dresseurRepository): Response
    {

        return $this->render('dresseur/listedresseurfront.html.twig', [
            'dresseurs' => $dresseurRepository->findAll(),
        ]);
    }
}
