<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\CodePromo;
use App\Entity\Commande;
use App\Entity\Produit;
use App\Entity\Panier;
use App\Entity\Utilisateur;
use App\Form\CommandeType;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commande")
 */
class CommandeController extends AbstractController
{
    /**
     * @Route("/afficherBack", name="app_commande_indexCommandeBack", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    { $Utilisateurs = $entityManager->getRepository(CodePromo::class)->findAll();
        $commandes = $entityManager
            ->getRepository(Commande::class)
            ->findAll();

        return $this->render('commande/index.html.twig', [
            'commandes' => $commandes, 'Utilisateurs' => $Utilisateurs,
        ]);
    }
    /**
     * @Route("/pdf", name="app_commande_pdfFront", methods={"GET"})
     */
    public function pdf(EntityManagerInterface $entityManager,CommandeRepository $commandeRepository): Response
       {
           // Configure Dompdf according to your needs
           $pdfOptions = new Options();
           $pdfOptions->set('defaultFont', 'Arial');

           // Instantiate Dompdf with our options
           $dompdf = new Dompdf($pdfOptions);
           $codePromos = $entityManager->getRepository(CodePromo::class)->findAll();
           $produits = $entityManager->getRepository(Produit::class)->findAll();
           $paniers =$entityManager->getRepository(Panier::class)->findAll();
           $commandes =$commandeRepository
               ->findAll();


           // Retrieve the HTML generated in our twig file
           $html = $this->renderView('commande/pdf.html.twig', [
               'commandes' => $commandes, 'paniers' => $paniers,'produits'=>$produits,'codePromos'=>$codePromos,
           ]);

           // Load HTML to Dompdf
           $dompdf->loadHtml($html);

           // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
           $dompdf->setPaper('A4', 'portrait');

           // Render the HTML as PDF
           $dompdf->render();

           // Output the generated PDF to Browser (force download)
           $dompdf->stream("mypdf.pdf", [
               "Attachment" => true
           ]);

    }
    /**
     * @Route("/Front", name="app_commande_indexFront", methods={"GET"})
     */
    public function indexFront(EntityManagerInterface $entityManager): Response
    {
        $commandes = $entityManager
            ->getRepository(Commande::class)
            ->findAll();

        return $this->render('commande/indexFront.html.twig', [
            'commandes' => $commandes,
        ]);
    }

    /**
     * @Route("/new", name="app_commande_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $commande = new Commande();
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $idUtulisateur=$commande->getIdUtulisateur();
            $etatCommande=$commande->setEtatCommande(1);
            $entityManager->persist($commande);
            $entityManager->flush();

            return $this->redirectToRoute('app_commande_indexFront', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commande/new.html.twig', [
            'commande' => $commande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idCommande}", name="app_commande_show", methods={"GET"})
     */
    public function show(Commande $commande): Response
    {
        return $this->render('commande/show.html.twig', [
            'commande' => $commande,
        ]);
    }


    /**
     * @Route("/{idCommande}/edit", name="app_commande_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commande_indexFront', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commande/edit.html.twig', [
            'commande' => $commande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idCommande}", name="app_commande_delete", methods={"POST"})
     */
    public function delete(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commande->getIdCommande(), $request->request->get('_token'))) {
            $entityManager->remove($commande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     *
     * @Route("/afficherFront/{idUtulisateur}", name="app_commande_index2", methods={"GET"})
     */
    public function afficherFront($idUtulisateur,EntityManagerInterface $entityManager): Response
    { $codePromos = $entityManager->getRepository(CodePromo::class)->findAll();
        $produits = $entityManager->getRepository(Produit::class)->findAll();
        $paniers =$entityManager->getRepository(Panier::class)->findAll();
        $em=$this->getDoctrine()->getManager();
        $commandes = $em
            ->getRepository(Commande::class)
            ->findBy(['idUtulisateur'=>$idUtulisateur]);

        return $this->render('commande/showCommandeFront.html.twig', [
            'commandes' => $commandes,
            'paniers' => $paniers,'produits'=>$produits,'codePromos'=>$codePromos
        ]);
    }

    /**
     * @Route("/{idCommande}/editQuantity/", name="updateEtat", methods={"GET", "POST"})
     */
    public function UpdateEtat(Request $request, EntityManagerInterface $entityManager, $idCommande): Response
    {
        $commande = $entityManager->getRepository(Commande::class)->findOneBy(["idCommande" => $idCommande]);
        //var_dump($panier);
        //$produit = $entityManager->getRepository(Produit::class)->findOneBy(["idproduit" => $panier->getIdProduit()]);


        $panier->setQuantitePanier($panier->getQuantitePanier()+1);
        $entityManager->persist($panier);
        $entityManager->flush();


        return $this->redirectToRoute('app_commande_indexFrontPanier',['idUtulisateur'=>$idUtulisateur]);



    }
}
