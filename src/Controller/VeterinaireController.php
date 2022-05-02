<?php

namespace App\Controller;

use App\Entity\Urlizer;
use App\Entity\Veterinaire;
use App\Form\VeterinaireType;
use App\Repository\VeterinaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\EntityManagerInterface;



/**
 * @Route("/veterinaire")
 */
class VeterinaireController extends AbstractController
{
    /**
     * @Route("/", name="app_veterinaire_index", methods={"GET"})
     */
    public function veterinaire(PaginatorInterface $paginator, EntityManagerInterface $entityManager,Request $request): Response
    {
        $veterinaire = $entityManager
            ->getRepository(veterinaire::class)
            ->findAll();
        $veterinaire = $paginator->paginate(
            $veterinaire,
            $request->query->getInt('page',1),
            3
        );

        return $this->render('veterinaire/veterinaire.html.twig', [
            'veterinaires' => $veterinaire,
        ]);

    }

    /**
     * @Route("/new", name="app_veterinaire_new", methods={"GET", "POST"})
     */
    public function new(Request $request, VeterinaireRepository $veterinaireRepository): Response
    {
        $veterinaire = new Veterinaire();
        $form = $this->createForm(VeterinaireType::class, $veterinaire);
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
            $veterinaire->setPicture($newFilename);


            $veterinaire->setDate( new \DateTime('now'));
            $veterinaireRepository->add($veterinaire);
            $this->addFlash(
                'info',
                ' Un veterinaire est ajouté avec succsé'
            );
            return $this->redirectToRoute('app_veterinaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('veterinaire/new.html.twig', [
            'veterinaire' => $veterinaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_veterinaire_show", methods={"GET"})
     */
    public function show(Veterinaire $veterinaire): Response
    {
        return $this->render('veterinaire/show.html.twig', [
            'veterinaire' => $veterinaire,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_veterinaire_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Veterinaire $veterinaire, VeterinaireRepository $veterinaireRepository): Response
    {
        $form = $this->createForm(VeterinaireType::class, $veterinaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $veterinaireRepository->add($veterinaire);
            return $this->redirectToRoute('app_veterinaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('veterinaire/edit.html.twig', [
            'veterinaire' => $veterinaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_veterinaire_delete", methods={"POST"})
     */
    public function delete(Request $request, Veterinaire $veterinaire, VeterinaireRepository $veterinaireRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$veterinaire->getId(), $request->request->get('_token'))) {
            $veterinaireRepository->remove($veterinaire);
        }

        return $this->redirectToRoute('app_veterinaire_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/remove/{id}", name="veterinaire_delete")
     */
    public function deletevet(Veterinaire $veterinaire, VeterinaireRepository $veterinaireRepository)
    {
     $em = $this->getDoctrine()->getManager();
     $em->remove($veterinaire);
     $em->flush();
        $em->flush();
        $this->addFlash(
            'info',
            ' le veterinaire a été supprimé avec succès'
        );

        return $this->redirectToRoute('app_veterinaire_index');
    }
    /**
     * @Route("/front/list", name="list_front2", methods={"GET"})
     */
    public function veterianriefrontlist(VeterinaireRepository $veterinaireRepository): Response
    {

        return $this->render('veterinaire/listevetfront.html.twig', [
            'veterinaires' => $veterinaireRepository->findAll(),
        ]);
    }
    /**
     * @Route("/tri/nom", name="tri")
     */
    public function Tri()
    {
        $e= $this->getDoctrine()->getRepository(Veterinaire::class)->TriPardate();
        return $this->render("veterinaire/Tri.html.twig",array('e'=>$e));
    }

}
