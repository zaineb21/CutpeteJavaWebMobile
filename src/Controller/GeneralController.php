<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class GeneralController extends AbstractController
 {

    
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('post/home.html.twig', [
            'controller_name' => 'GeneralController',
        ]);
    }
     
    /**
     * @Route("/admin", name="General")
     */
    public function General(EntityManagerInterface $entityManager)
    {


        $users=$entityManager->createQuery('SELECT COUNT(u) FROM App\Entity\User u')->getSingleScalarResult();
        return $this->render('admin/general.html.twig', [
                   'stats' => compact ('users')
        ]);
    }    
      
}
