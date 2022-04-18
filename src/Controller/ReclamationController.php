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
 
class ReclamationController extends Controller
{


    /**
     * @Route("/HomeBack", name="HomeBack")
     */
    public function HomeBack(): Response
    {
        return $this->render('home/HomeBack.html.twig', [
            'controller_name' => 'PostController',
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
    public function create (Request $request ,EntityManagerInterface $entityManager)
    { 
 
        $Reclamation = new Reclamation ();

        $form = $this ->createForm(ReclamationType::class,$Reclamation);
                       
       
                 $form->handleRequest($request)  ;  
                
                if ($form->isSubmitted() && $form->isValid()) {

                    $entityManager=$this->getdoctrine()->getManager();
                    
                  $entityManager->persist($Reclamation);
                  $entityManager->flush();
                  $this->addFlash(
                    'info',
                  ' Votre Réclamation a été envoyer'
              );
    
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








}
