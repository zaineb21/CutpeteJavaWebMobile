<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Panier;
use App\Entity\Produit;
use App\Entity\Utilisateur;
use App\Repository\CommandeRepository;
use App\Repository\PanierRepository;
use App\Repository\ProduitRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class JsonController extends AbstractController
{
    /**
     * @Route("/commande/update/{id}", name="update-commande")
     */
    public function updateCommande(int $id,Request $request,UserRepository $destinationRepository,CommandeRepository $repository): Response
    {
        $em = $this->getDoctrine()->getManager();
        $commandeId = $request->request->get("commande");
        $etat = $request->request->get("etat");
        $commande = $repository->find($commandeId);
        $commande->setEtatCommande($etat);
        $em->persist($commande);
        $em->flush();
        return $this->json("Done");

    }


    /**
     * @Route("/produit/show-all", name="show-all-produit")
     */
    public function showProduitAll(ProduitRepository $repository): Response
    {
        $cats = $repository->findAll();
        $json = [];
        foreach ($cats as $cat){
            $json[] = [
                'id' => $cat->getIdProduit(),
                'lib'=>$cat->getLibelleProduit(),
                'desc'=>$cat->getDescription(),
                'prix'=>$cat->getPrix(),
                'quant' => $cat->getQuantite(),
                'cat'=> $cat->getCategorie(),
                'img' => $cat->getImage()
            ];
        }
        return $this->json($json);
    }
    /**
     * @Route("/produit/add", name="add-produit")
     */
    public function addProduit(Request $request): Response
    {
        $product = new Produit();
        $lib = $request->request->get("lib");
        $cat = $request->request->get("cat");
        $prix = $request->request->get("prix");
        $quant = $request->request->get("quant");
        $desc = $request->request->get("desc");

        $em = $this->getDoctrine()->getManager();
        $product->setLibelleProduit($lib);
        $product->setDescription($desc);
        $product->setDateExpiration(new \DateTime());
        $product->setQuantite(intval($quant));
        $product->setPrix(floatval($prix));
        $product->setCategorie($cat);
        $product->setImage("none");
        $em->persist($product);
        $em->flush();
        return $this->json("Done");
    }
    /**
     * @Route("/produit/delete/{id}", name="delete-prod")
     */
    public function deleteProduit(int $id,ProduitRepository $repository): Response
    {
        $em = $this->getDoctrine()->getManager();
        $dest = $repository->find($id);
        if($dest == null){
            return $this->json("Dosn't Exist");
        }
        $em->remove($dest);
        $em->flush();
        return $this->json("Done");
    }
    /**
     * @Route("/produit/update/{id}", name="update-produit")
     */
    public function updateDest(int $id,Request $request,ProduitRepository $destinationRepository): Response
    {

        $product = $destinationRepository->find($id);
        $lib = $request->request->get("lib");
        $cat = $request->request->get("cat");
        $prix = $request->request->get("prix");
        $quant = $request->request->get("quant");
        $desc = $request->request->get("desc");
        $image = $request->files->get("image");
        if(!$image)
        {
            $product->setLibelleProduit($lib);
            $product->setDescription($desc);
            $product->setDateExpiration(new \DateTime());
            $product->setQuantite(intval($quant));
            $product->setPrix(floatval($prix));
            $product->setCategorie($cat);}
        else
        {
            $file = new File($image);
            $fileName= md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('images_directory'),$fileName);
            $product->setImage($fileName);
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();
        return $this->json("Done");
    }
    /**
     * @Route("/commande/add", name="add-commande")
     */
    public function addCommande(Request $request): Response
    {
        $panier = new Commande();
        $products = $request->request->get("adresse");
        $userid = $request->request->get("user");
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(Utilisateur::class)->find(intval($userid));
        $panier->setIdUtulisateur($user);
        $panier->setAdresseCommande($products);
        $panier->setEtatCommande(1);
        $em->persist($panier);
        $em->flush();
        return $this->json("Done");
    }
    /**
     * @Route("/commande/show/{id}", name="show-all-commande")
     */
    public function showCommande(CommandeRepository $repository,int $id): Response
    {
        $user = $this->getDoctrine()->getRepository(Utilisateur::class)->find($id);
        $cats = $repository->findBy(['idUtulisateur' => $user]);
        $json = [];
        foreach ($cats as $cat){
            $json[] = [
                'id' => $cat->getIdCommande(),
                'adresse'=>$cat->getAdresseCommande(),
                'etat'=>$cat->getEtatCommande()            ];

        }
        return $this->json($json);
    }
    /**
     * @Route("/commande/show-all", name="show-all-commande-admin")
     */
    public function showCommandeAll(CommandeRepository $repository): Response
    {
        $cats = $repository->findAll();
        $json = [];
        foreach ($cats as $cat){
            $json[] = [
                'id' => $cat->getIdCommande(),
                'adresse'=>$cat->getAdresseCommande(),
                'etat'=>$cat->getEtatCommande()];
        }
        return $this->json($json);
    }
    /**
     * @Route("/panier/add", name="add-panier")
     */
    public function addPanier(Request $request): Response
    {
            $panier = new Panier();
            $products = $request->request->get("product");
            $userid = $request->request->get("user");
            $quantity = $request->request->get("quantity");
            $em = $this->getDoctrine()->getManager();
            $product = $em->getRepository(Produit::class)->find(intval($products));
            $user = $em->getRepository(Utilisateur::class)->find(intval($userid));
            $panier->setIdproduit($product);
            $panier->setIdUtulisateur($user);
            $panier->setQuantitePanier(intval($quantity));
            $panier->setCodePromo(null);
            $em->persist($panier);
            $em->flush();
        return $this->json("Done");

    }
    /**
     * @Route("/panier/show-all/{id}", name="show-all-panier")
     */
    public function showPanier(PanierRepository $repository,int $id): Response
    {
        $user = $this->getDoctrine()->getRepository(Utilisateur::class)->find($id);
        $cats = $repository->findBy(['idUtulisateur' => $user]);
        $json = [];
        foreach ($cats as $cat){
            $json[] = [
                'id' => $cat->getIdPanier(),
                'idProduit'=>$cat->getIdproduit()->getPrixProduit(),
                'quant'=>$cat->getQuantitePanier()            ];

        }
        return $this->json($json);
    }

    /**
     * @Route("/panier/update/{id}", name="update-panier")
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function updatePanier(int $id,Request $request,ProduitRepository $destinationRepository, PanierRepository $repository): Response
    {
        $em = $this->getDoctrine()->getManager();
        $product = $destinationRepository->findBy(["idProduit" => $id]);
        $query = $repository->createQueryBuilder('p')
            ->where('p.idproduit = :produit')
            ->setParameter("produit",$product)
            ->orderBy("p.idPanier","DESC");
        $cart = $query->getQuery()->setMaxResults(1)->getOneOrNullResult();
        $quantity = $request->request->get("quantity");
        $cart->setQuantitePanier(intval($quantity));
        $em->persist($cart);
        $em->flush();
        return $this->json("Done");
    }


    /**
     * @Route("/panier/delete/{id}", name="delete-dest")
     */
    public function deletePanier(int $id,PanierRepository $repository): Response
    {
        $em = $this->getDoctrine()->getManager();
        $dest = $repository->find($id);
        if($dest == null){
            return $this->json("Dosn't Exist");
        }
        $em->remove($dest);
        $em->flush();
        return $this->json("Done");
    }

    /**
     * @Route("/panier/delete-all/{id}", name="clear-panier")
     */
    public function clearPanier(int $id,PanierRepository $repository): Response
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository(Utilisateur::class)->find($id);
        $cats = $repository->findBy(['idUtulisateur' => $user]);
        if($cats == null){
            return $this->json("Dosn't Exist");
        }
        foreach ($cats as $cat){
        $em->remove($cat);}
        $em->flush();
        return $this->json("Done");
    }



}
