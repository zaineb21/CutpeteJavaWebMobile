<?php

namespace App\Controller;

use App\Entity\EvenementLocal;
use App\Entity\ParticipationEvenement;
use App\Entity\Utilisateur;
use App\Form\EvenementLocalType;
use App\Repository\EvenementLocalRepository;
use App\services\MailerService;
use App\services\pdfService;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Endroid\QrCode\QrCode;


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
    public function index1(EvenementLocalRepository $evenementLocalRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $alleve =$evenementLocalRepository->findAll();
        $evenement_locals = $paginator->paginate(
        // Doctrine Query, not results
            $alleve,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            2
        );
        return $this->render('evenement_local/index1.html.twig', [
            'evenement_locals' => $evenement_locals,
        ]);
    }


    /**
     * @Route("/new", name="evenement_local_new", methods={"GET","POST"})
     * @param Request $request
     * @param $slugger
     * @return Response
     */
    public function new(Request $request): Response
    {
        $evenementLocal = new EvenementLocal();
        $form = $this->createForm(EvenementLocalType::class, $evenementLocal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename =$originalFilename;
                $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $image->move(
                        $this->getParameter('evenement-directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $evenementLocal->setPhoto($newFilename);
            }

            $now = new DateTime();
            $evenementLocal->setNbplacerest($evenementLocal->getNbplace()-$evenementLocal->getNbparti());
            $interval = ($now->diff($evenementLocal->getDate()));
            $evenementLocal->setNbjoursrestant($interval->format('%a'));
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
     * @Route("/{id}/a", name="evenement_local_show1", methods={"GET"})
     */
    public function show1(EvenementLocal $evenementLocal): Response
    {
        return $this->render('evenement_local/show1.html.twig', [
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

            $now = new DateTime();
            $evenementLocal->setNbplacerest($evenementLocal->getNbplace()-$evenementLocal->getNbparti());
            $interval = ($now->diff($evenementLocal->getDate()));
            $evenementLocal->setNbjoursrestant($interval->format('%a'));
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

    /**
     *
     * @Route("/liste/res/{id}", name="event_res", methods={"GET"})
     *
     */
    public function reservationAction(Request $request,EvenementLocal $event,\Swift_Mailer $mailer, ManagerRegistry $doctrine, pdfService $pdf ,\App\services\qrcode $qrCode ): Response
    {

        $qrcodea = null;
        $participation = new ParticipationEvenement();
        $user=1;

        $mailMessage = 'vous étes participant dans l événement '.$event->getNom().'   il vous reste '.$event->getNbjoursrestant().'jours avant la date   '.'auprés de '.$event->getLieu();
        $parti = $doctrine->getRepository(ParticipationEvenement::class)->findOneBy(['idEvent'=> $event->getId(),
            'idUser' => 1,
        ]);
        $qrcodea = $qrCode->qrcode($event->getId());
        $html = $this->render('evenement_local/pdf.html.twig', [
            'evenement_local' => $event,
            'qrCode' => $qrcodea,


        ]);




        if ($event->getNbplacerest()==0) {
            $request->getSession()
                ->getFlashBag()
                ->add('error', "!! Error YOUR ERROR MESSAGE");}
        elseif ($event->getNbjoursrestant()<=1){
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
        $participation->setIdEvent($event->getId());
        $participation->setNomEvent($event->getNom());
        $participation->setDateEvent($event->getDate());
        $participation->setPhotoEvent($event->getPhoto());
        $participation->setIdUser($user);
        $participation->setNomUser('nader');
        $participation->setPrenomUser('saber');
        $participation->setMailUser('atebessi5@gmail.com');
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($participation);
        $entityManager->flush();
        $event->setNbparti($event->getNbparti()+1);
        $event->setNbplacerest($event->getNbplacerest()-1);
        $this->getDoctrine()->getManager()->flush();
        $message = (new \Swift_Message('votre participation est validée avec succés'))
            ->setFrom('medaziz.tebessi@esprit.tn')
            ->setTo('cuutpete@gmail.com')
            ->setBody($mailMessage)
        ;
        $mailer->send($message);
            $request->getSession()
                ->getFlashBag()
                ->add('error', "!!Bienvenue dans".$event->getNom());


            $pdf->showpdfFile($html);




        }



        return $this->render('evenement_local/show1.html.twig', [
            'evenement_local' => $event,
        ]);}





}
