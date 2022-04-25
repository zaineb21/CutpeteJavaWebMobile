<?php

namespace App\Controller;
use App\Repository\CommandeRepository;
use App\Repository\PanierRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Commande;
use App\Entity\Produit;
use App\Repository\ProduitRepository;
use MercurySeries\FlashyBundle\FlashyNotifier;
use mysql_xdevapi\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Panier;
use App\Entity\CodePromo;
use App\Form\PanierType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/panier")
 */
class PanierController extends AbstractController
{


    /**
     * @Route("/", name="app_panier_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $paniers = $entityManager
            ->getRepository(Panier::class)
            ->findAll();

        return $this->render('panier/index.html.twig', [
            'paniers' => $paniers,
        ]);
    }
    /**
     * @Route("/affichetotal", name="totalPanier")
     */

    public function total(SessionInterface $session, ProduitRepository   $productRepository)
    {
        $panier = $session->get("panier", []);

        // On "fabrique" les données
        $dataPanier = [];
        $total = 0;

        foreach($panier as $idProduit => $quantitePanier){
            $produit = $productRepository->find($idProduit);
            $dataPanier[] = [
                "produit" => $produit,
                "quantite" => $quantitePanier
            ];
            $total += $produit->getPrixProduit() * $quantitePanier;
        }

        return $this->render('panier/index2F.html.twig', compact("dataPanier", "total"));
    }
    /**
     * @Route("/afficherF", name="app_panier_index2F", methods={"GET"})
     */
    public function index2(EntityManagerInterface $entityManager): Response
    {   $codePromos = $entityManager->getRepository(CodePromo::class)->findAll();
        $produits = $entityManager->getRepository(Produit::class)->findAll();
        $paniers = $entityManager
            ->getRepository(Panier::class)
            ->findAll();

        return $this->render('panier/index2F.html.twig', [
            'paniers' => $paniers,'produits'=>$produits,'codePromos'=>$codePromos
        ]);
    }

    /**
     * @Route("/new", name="app_panier_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $panier = new Panier();
        $form = $this->createForm(PanierType::class, $panier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $idUtulisateur=$panier->getIdUtulisateur();

            $entityManager->persist($panier);
            $entityManager->flush();

   $this->addFlash('info','produit ajouté');
            return $this->redirectToRoute('app_panier_index2F', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('panier/new.html.twig', [
            'panier' => $panier,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("afficher/{idPanier}", name="app_panier_show", methods={"GET"})
     */
    public function show(Panier $panier): Response
    {
        return $this->render('panier/show.html.twig', [
            'panier' => $panier,
        ]);
    }

    /**
     * @Route("/{idPanier}/edit", name="app_panier_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Panier $panier, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PanierType::class, $panier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_panier_index2F', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('panier/edit.html.twig', [
            'panier' => $panier,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{idUtulisateur}/{idproduit}/editQuantity/", name="cart_add", methods={"GET", "POST"})
     */
    public function editQuantity(Request $request, EntityManagerInterface $entityManager, $idUtulisateur, $idproduit): Response
    {
        $panier = $entityManager->getRepository(Panier::class)->findOneBy(["idUtulisateur" => $idUtulisateur]);
        //var_dump($panier);
        //$produit = $entityManager->getRepository(Produit::class)->findOneBy(["idproduit" => $panier->getIdProduit()]);


                $panier->setQuantitePanier($panier->getQuantitePanier()+1);
                $entityManager->persist($panier);
                $entityManager->flush();


        return $this->redirectToRoute('app_commande_indexFrontPanier',['idUtulisateur'=>$idUtulisateur]);



    }
    /**
     * @Route("/{idUtulisateur}/{idproduit}/diminuerQuantite/", name="cart_delete", methods={"GET", "POST"})
     */
    public function diminuerQuantite(Request $request, EntityManagerInterface $entityManager, $idUtulisateur, $idproduit): Response
    {
        $panier = $entityManager->getRepository(Panier::class)->findOneBy(["idUtulisateur" => $idUtulisateur]);
        //var_dump($panier);
        //$produit = $entityManager->getRepository(Produit::class)->findOneBy(["idproduit" => $panier->getIdProduit()]);

        $panier->setQuantitePanier($panier->getQuantitePanier()-1);
                $entityManager->persist($panier);
                $entityManager->flush();

        return $this->redirectToRoute('app_commande_indexFrontPanier',['idUtulisateur'=>$idUtulisateur]);



    }
    /**
     * @Route("/{idUtulisateur}/{idPanier}/supp/", name="deleteP", methods={"GET", "POST"})
     */
    public function deletePro(Request $request, EntityManagerInterface $entityManager, $idUtulisateur,$idPanier): Response
    {
        $panier = $entityManager->getRepository(Panier::class)->findOneBy(["idPanier" => $idPanier]);
        //var_dump($panier);
        //$produit = $entityManager->getRepository(Produit::class)->findOneBy(["idproduit" => $panier->getIdProduit()]);

                $entityManager->remove($panier);
                $entityManager->flush();

        return $this->redirectToRoute('app_commande_indexFrontPanier',['idUtulisateur'=>$idUtulisateur]);



    }

    /**
     * @Route("/{idPanier}", name="app_panier_delete", methods={"POST"})
     */
    public function delete(Request $request, Panier $panier, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$panier->getIdPanier(), $request->request->get('_token'))) {
            $entityManager->remove($panier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_panier_index2F', [], Response::HTTP_SEE_OTHER);
    }
    /**
     *
     * @Route("/afficherFrontPanier/{idUtulisateur}", name="app_commande_indexFrontPanier", methods={"GET"})
     */
    public function afficherFront($idUtulisateur,EntityManagerInterface $entityManager): Response
    { $codePromos = $entityManager->getRepository(CodePromo::class)->findAll();
        $produits = $entityManager->getRepository(Produit::class)->findAll();
        $em=$this->getDoctrine()->getManager();
        $paniers = $em
            ->getRepository(panier::class)
            ->findBy(['idUtulisateur'=>$idUtulisateur]);

        return $this->render('panier/index2F.html.twig', [
            'paniers' => $paniers,'produits'=>$produits,'codePromos'=>$codePromos
        ]);
    }


    /**
     * @Route("/vider_panier/{idUtulisateur}", name="app_panier_vider_panier", methods={"GET","POST"})
     */
    public function viderPanier(Request $request, EntityManagerInterface $entityManager, $idUtulisateur): Response
    {
        $paniers = $entityManager->getRepository(Panier::class)->findBy(["idUtulisateur" => $idUtulisateur]);
        var_dump(count($paniers));
        foreach ($paniers as $panier)
        {
            $entityManager->remove($panier);
        }
        $entityManager->flush();

        return $this->redirectToRoute('app_commande_indexFrontPanier',['idUtulisateur'=>$idUtulisateur], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/pdfFacture", name="app_commande_pdfFrontFacture", methods={"GET"})
     */
    public function pdf(EntityManagerInterface $entityManager,PanierRepository $panierRepository): Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $codePromos = $entityManager->getRepository(CodePromo::class)->findAll();
        $produits = $entityManager->getRepository(Produit::class)->findAll();

        $paniers =$panierRepository
            ->findAll();


        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('panier/pdf.html.twig', [
             'paniers' => $paniers,'produits'=>$produits,'codePromos'=>$codePromos,
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
}
