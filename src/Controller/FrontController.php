<?php

namespace App\Controller;

use App\Entity\Commande;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
* @Route("/f")
*/

class FrontController extends AbstractController
{
    /**
     * @Route("/front", name="app_front")
     */
    public function index(): Response
    {
        return $this->render('front/index.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }
    /**
     *
         * @Route("/afficherFront/{idUtulisateur}", name="app_commande_index", methods={"GET"})
     */
    public function afficherFront($idUtulisateur): Response
    {
        $em=$this->getDoctrine()->getManager();
        $commandes = $em
            ->getRepository(Commande::class)
            ->findBy(['idUtulisateur'=>$idUtulisateur]);

        return $this->render('commande/showCommandeFront.html.twig', [
            'commandes' => $commandes
        ]);
    }

}
