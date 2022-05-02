<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Entity\User;
use App\Form\ReclamationType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Repository\ReclamationRepository;



class ReclamationController extends Controller
{


    /**
     * @Route("/HomeBack", name="HomeBack")
     */
    public function HomeBack(EntityManagerInterface $entityManager)
    {



        $Reclamations=$entityManager->createQuery('SELECT COUNT(u) FROM App\Entity\Reclamation u')->getSingleScalarResult();
        $Dresseur=$entityManager->createQuery('SELECT COUNT(u) FROM App\Entity\Dresseur u')->getSingleScalarResult();
        $Veterinaire=$entityManager->createQuery('SELECT COUNT(u) FROM App\Entity\Veterinaire u')->getSingleScalarResult();
        return $this->render('home/HomeBack.html.twig', [
            'stats' => compact ('Reclamations','Veterinaire','Dresseur')
        ]);
    }










    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/home.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }




    /**
     * @Route("/reclamation", name="reclamationCreate")
     */
    public function create (Request $request ,EntityManagerInterface $entityManager, \Swift_Mailer $mailer)
    {

        $Reclamation = new Reclamation ();

        $form = $this ->createForm(ReclamationType::class,$Reclamation);


        $form->handleRequest($request)  ;
        $myDictionary = array(
            "tue", "merde",
            "gueule",
            "débile",
            "con",
            "abruti",
            "clochard",
            "sang"
        );
        dump($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $myText = $request->get("reclamation")['contenu'];
            $badwords = new PhpBadWordsController();
            $badwords->setDictionaryFromArray($myDictionary)
                ->setText($myText);
            $check = $badwords->check();
            dump($check);
            if ($check) {
                $this->addFlash(
                    'erreur',
                    'Mot inapproprié!'
                );
            } else {

                $entityManager = $this->getdoctrine()->getManager();




                $entityManager->persist($Reclamation);
                $entityManager->flush();
                $this->addFlash(
                    'info',
                    'votre reclamation a bien été envoyé'
                );
            }

            $user = $this->get('security.token_storage')->getToken()->getUser();


            $message= (new \Swift_Message('Confirmation'))

                ->setFrom('mohamedsadok.dorbez@esprit.tn')
                ->setTo($Reclamation->getUser()->getEmail())
                ->setBody(
                    "<p>Bonjour,</p><p>votre reclamation a été effectuée avec succès " ,
                    'text/html' )
            ;

            $mailer->send($message);



        }


        return $this->render('reclamation/index.html.twig', [
            'formReclamation' => $form->createView()

        ]);

    }



    /**
     * @Route("/reclamationadmin", name="reclamationadmin")
     */
    public function reclamations(Request $request ,EntityManagerInterface $entityManager)
    {

        $repo = $this ->getDoctrine()->getRepository(Reclamation::class);
        $Reclamations=$repo->findAll();

        $Reclamations = $this->get('knp_paginator')->paginate(

            $Reclamations,

            $request->query->getInt('page', 1),

            5
        );



        return $this->render('reclamation/reclamationadmin.html.twig', [
            'controller_name' => 'ReclamationController',
            'Reclamations' => $Reclamations

        ]);
    }













    /**
     * @Route("/Reclamation/{id}", name="Reclamation")
     */
    public function reclamation(int $id): Response
    {
        $Reclamation = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);

        return $this->render("reclamation/reclamationadmin.html.twig", [
            "Reclamation" => $Reclamation,
        ]);
    }








    /**
     * @Route("/delete-Reclamation/{id}", name="delete_Reclamation")
     */
    public function deleteReclamation(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $Reclamation = $entityManager->getRepository(Reclamation::class)->find($id);
        $entityManager->remove($Reclamation);
        $entityManager->flush();
        $this->addFlash(
            'info',
            ' la Reclamation a été supprimé avec succès'
        );

        return $this->redirectToRoute("reclamationadmin");
    }

    /**
     * @Route("/pdf", name="pdf")
     */
    public function list(ReclamationRepository $reclamationRepository, Request $request): Response

    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $Reclamation=$reclamationRepository->findAll();

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('reclamation/PDF.html.twig', [
            'Reclamations' => $Reclamation,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A3', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("Reclamation.pdf", [
            "Attachment" => false
        ]);





    }









}
