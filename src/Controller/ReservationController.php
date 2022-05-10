<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use DateTime;
use App\services\pdfService;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;











/**
 * @Route("/reservation")
 */
class ReservationController extends AbstractController
{
    /**
     * @Route("/", name="reservation_index", methods={"GET"})
     */
    public function index(ReservationRepository $reservationRepository): Response
    {
        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/mes", name="reservation_index1", methods={"GET"})
     */
    public function index1(ReservationRepository $reservationRepository, ManagerRegistry $doctrine,Request $request, PaginatorInterface $paginator, PaginatorInterface $paginator12,Request $request12): Response
    {
        $res = $reservationRepository->findBy(['etat'=> 1,'iduser'=>1, ]);
        $res1 = $reservationRepository->findBy(['etat'=> 0,'iduser'=>1, ]);
        $reservation = $paginator->paginate(
            // Doctrine Query, not results
                $res,
                // Define the page parameter
                $request->query->getInt('page', 1),
                // Items per page
                5
            );
            $reservation1 = $paginator12->paginate(
                // Doctrine Query, not results
                    $res1,
                    // Define the page parameter
                    $request12->query->getInt('page', 1),
                    // Items per page
                    5
                );





        return $this->render('reservation/MesRes.html.twig', [
            'reservations' =>$reservation,
            'reservations1' => $reservation1,
        ]);
    }





    /**
     * @Route("/new", name="reservation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/new/user", name="reservation_new1", methods={"GET","POST"})
     */
    public function new1(Request $request,MailerInterface $mailer,pdfService $pdf): Response
    {
        $reservation = new Reservation();
       

        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);
        


        if ($form->isSubmitted() && $form->isValid()) {

            $interval = ($reservation->getDateSortie()->diff($reservation->getDateArrive()));
            $att = $interval->format('%a');
            $reservation->setEtat(1);
            $reservation->setIduser(1);
            $writer = new PngWriter();
            $reservation->setTarif($reservation->calculTarif($reservation->getPension(),$att,$reservation->getNbanimal(),$reservation->getVeterinaire(),$reservation->getDresseur()));
            $mailMessage = 'votre reservation est validée chez CUTPETE au nom de '.$reservation->getNom().''.$reservation->getPrenom().' pour le '.$reservation->getDateArrive()->format('Y-m-d').' jusqu a '.$reservation->getDateSortie()->format('Y-m-d').'pour '.$reservation->getNbanimal().'\n animals  votre tarif est : '.$reservation->getTarif();
            $html = $this->render('reservation/pdf.html.twig', [
                'reservation' => $reservation,
                
            ]);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reservation);
            $entityManager->flush();

          


        $qrCode = QrCode::create($mailMessage);
        $label = Label::create('Reservation Details')
            ->setTextColor(new Color(255, 0, 0));
        $result = $writer->write($qrCode, null,$label);
        $result->saveToFile('../public/qr/reservation'.$reservation->getId().'.png');
        $url = '../public/qr/reservation'.$reservation->getId().'png';
        
        $message = (new Email())
                ->from('medaziz.tebessi@esprit.tn')
                ->subject('reservation est validée chez CUTPETE')
                ->text($mailMessage)
                ->to('cuutpete@gmail.com')
                ->embed(fopen('../public/qr/reservation'.$reservation->getId().'.png', 'r'), '.png')
               
                
            ;
            $mailer->send($message);   
            $pdf->showpdfFile($html);
            
            }
            

       return $this->render('reservation/new1.html.twig', [
            'form' => $form->createView(),
        ]);
    }





    /**
     * @Route("/{id}", name="reservation_show", methods={"GET"})
     */
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

       /**
     * @Route("/annuler/{id}", name="reservation_annuler", methods={"GET"})
     */
    public function annuler(Reservation $reservation,ReservationRepository $reservationRepository,Request $request,PaginatorInterface $paginator, PaginatorInterface $paginator12,Request $request12): Response
    {
        $date = new \DateTime('@'.strtotime('now'));
        $now= new DateTime();
        $interval = ($reservation->getDateArrive()->diff($date));
        $att = $interval->format('%a');
        var_dump($att);
        if($att<1){
            $request->getSession()
                ->getFlashBag()
                ->add('error', "!! Error YOUR ERROR MESSAGE");
        }
        else {
        $reservation->setEtat(0);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        }
        $res = $reservationRepository->findBy(['etat'=> 1,'iduser'=>1, ]);
        $res1 = $reservationRepository->findBy(['etat'=> 0,'iduser'=>1, ]);
        $reservation = $paginator->paginate(
            // Doctrine Query, not results
                $res,
                // Define the page parameter
                $request->query->getInt('page', 1),
                // Items per page
                5
            );
            $reservation1 = $paginator12->paginate(
                // Doctrine Query, not results
                    $res1,
                    // Define the page parameter
                    $request12->query->getInt('page', 1),
                    // Items per page
                    5
                );
        return $this->render('reservation/MesRes.html.twig', [
            'reservations' =>$reservation,
            'reservations1' => $reservation1,
        ]);
        
    }






    /**
     * @Route("/{id}/edit", name="reservation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Reservation $reservation): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reservation_delete", methods={"POST"})
     */
    public function delete(Request $request, Reservation $reservation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reservation_index', [], Response::HTTP_SEE_OTHER);
    }
}
