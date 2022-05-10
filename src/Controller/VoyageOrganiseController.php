<?php

namespace App\Controller;

use App\Entity\ParticipationVoyage;
use App\Entity\VoyageOrganise;
use App\Form\VoyageOrganiseType;
use App\Repository\VoyageOrganiseRepository;
use App\services\pdfService;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
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
            $now = new DateTime();
            $interval = ($now->diff($voyageOrganise->getDate()));
            $voyageOrganise->setNbjrest($interval->format('%a'));
            $voyageOrganise->setTarif($voyageOrganise->calcultarif($voyageOrganise->getNbjours(),$voyageOrganise->getNbanimal()));
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
     * @Route("/{id}/u/", name="voyage_organise_show1", methods={"GET"})
     */
    public function show1(VoyageOrganise $voyageOrganise): Response
    {
        return $this->render('voyage_organise/show1.html.twig', [
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

    /**
     *
     * @Route("/liste/part/{id}", name="voyage_res", methods={"GET"})
     *
     */
    public function reservationAction(Request $request,VoyageOrganise $voyageOrganise,\Swift_Mailer $mailer, ManagerRegistry $doctrine, pdfService $pdf ,\App\services\qrcode $qrCode ): Response
    {
        $qrcodea = null;
        $participation = new ParticipationVoyage();
        $user=1;

        $mailMessage = 'vous étes participant dans le voyage en '.$voyageOrganise->getPays().'   il vous reste '.$voyageOrganise->getNbjrest().'jours avant la date   '.'auprés de '.$voyageOrganise->getProgramme();
        $parti = $doctrine->getRepository(ParticipationVoyage::class)->findOneBy(['id_voyage'=> $voyageOrganise->getId(),
            'id_user' => 1,
        ]);
        $qrcodea = $qrCode->qrcode($voyageOrganise->getId());
        $html = $this->render('voyage_organise/pdf.html.twig', [
            'voyage_organise' => $voyageOrganise,
            'qrCode' => $qrcodea,

        ]);





        if ($voyageOrganise->getNbjrest()<=1){
            $request->getSession()
                ->getFlashBag()
                ->add('error', "!! Error YOUR ERROR MESSAGE");
        }
        elseif ($parti != null){
            $request->getSession()
                ->getFlashBag()
                ->add('error', "!! Error YOUR ERROR MESSAGE");

        }


        else{
            $participation->setIdVoyage($voyageOrganise->getId());
            $participation->setDateVoyage($voyageOrganise->getDate());
            $participation->setPaysVoyage($voyageOrganise->getPays());
            $participation->setTarifVoyage($voyageOrganise->getTarif());
            $participation->setNbanimalVoyage($voyageOrganise->getNbanimal());
            $participation->setIdUser($user);
            $participation->setNomUser('nader');
            $participation->setPrenomUser('saber');
            $participation->setMailUser('atebessi5@gmail.com');
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($participation);
            $entityManager->flush();


            $message = (new \Swift_Message('votre participation est validée avec succés'))
                ->setFrom('medaziz.tebessi@esprit.tn')
                ->setTo('cuutpete@gmail.com')
                ->setBody($mailMessage)
            ;
            $mailer->send($message);
            $request->getSession()
                ->getFlashBag()
                ->add('error', "!!Bienvenue dans".$voyageOrganise->getPays());


            $pdf->showpdfFile($html);
        }



        return $this->render('voyage_organise/show1.html.twig', [
            'voyage_organise' => $voyageOrganise,
        ]);}
}
