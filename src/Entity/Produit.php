<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity(repositoryClass="App\Repository\ProduitRepository")
 */
class Produit
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_produit", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idProduit;

    /**
     * @ORM\Column(type="integer")
     */
    public $prix_produit;

    /**
     * @return int
     */
    public function getIdProduit(): int
    {
        return $this->idProduit;
    }

    /**
     * @param int $idProduit
     */
    public function setIdProduit(int $idProduit): void
    {
        $this->idProduit = $idProduit;
    }

    public function getPrixProduit(): ?int
    {
        return $this->prix_produit;
    }

    public function setPrixProduit(int $prix_produit): self
    {
        $this->prix_produit = $prix_produit;

        return $this;
    }


}
