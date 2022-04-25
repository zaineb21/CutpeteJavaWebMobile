<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Panier
 *
 * @ORM\Table(name="panier", indexes={@ORM\Index(name="id_produit", columns={"id_produit"}), @ORM\Index(name="code_promo", columns={"code_promo"}), @ORM\Index(name="id_utulisateur", columns={"id_utulisateur"})})
 * @ORM\Entity(repositoryClass="App\Repository\PanierRepository")
 */
class Panier
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_panier", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */


    private $idPanier;

    /**
     * @var \Produit
     *
     * @ORM\ManyToOne(targetEntity="Produit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_produit",referencedColumnName="id_produit")
     * })
     */
    private $idproduit ;

    /**
     * @var int|null
     *@Assert\NotBlank

     * @ORM\Column(name="quantite_panier", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $quantitePanier = NULL;

    /**
     * @var \CodePromo
     *
     * @ORM\ManyToOne(targetEntity="CodePromo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="code_promo", referencedColumnName="id_codepromo")
     * })
     */
    private $codePromo;

    /**
     * @var \Utilisateur
     *

     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_utulisateur", referencedColumnName="id_utilisateur")
     * })
     */
    private $idUtulisateur;

    /**
     * @return int
     */
    public function getIdPanier():? int
    {
        return $this->idPanier;
    }

    /**
     * @param int $idPanier
     */
    public function setIdPanier(int $idPanier): void
    {
        $this->idPanier = $idPanier;
    }


    public function getIdproduit():?Produit
    {
        return $this->idproduit;

    }


    public function setIdproduit(?Produit $idproduit): self
    {
        $this->idproduit = $idproduit;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getQuantitePanier(): ?int
    {
        return $this->quantitePanier;
    }

    /**
     * @param int|null $quantitePanier
     */
    public function setQuantitePanier(?int $quantitePanier): void
    {
        $this->quantitePanier = $quantitePanier;
    }


    public function getCodePromo(): ?CodePromo
    {
        return $this->codePromo;
    }


    public function setCodePromo(?CodePromo $codePromo): self
    {
        $this->codePromo = $codePromo;
        return $this;
    }


    public function getIdUtulisateur(): ?Utilisateur
    {
        return $this->idUtulisateur;
    }


    public function setIdUtulisateur(?Utilisateur $idUtulisateur): self
    {
        $this->idUtulisateur = $idUtulisateur;
        return $this;
    }




}
