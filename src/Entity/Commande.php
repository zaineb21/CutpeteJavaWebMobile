<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Commande
 *
 * @ORM\Table(name="commande", indexes={@ORM\Index(name="id_utilisateur", columns={"id_utilisateur"})})
 * @ORM\Entity(repositoryClass="App\Repository\CommandeRepository")
 */
class Commande
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_commande", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCommande;

    /**
     * @var string|null
     * @Assert\NotBlank
     * @ORM\Column(name="adresse_commande", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $adresseCommande ;

    /**
     * @var int|null
     * * * @Assert\Range(
     *      min = 0,
     *      max = 1,
     *      notInRangeMessage = "You must be between {{ min }} etat non validé and {{ max }} etat validé to enter",
     * )

     * @ORM\Column(name="etat_commande", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $etatCommande = NULL;

    /**
     * @var \Utilisateur
     *

     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_utilisateur", referencedColumnName="id_utilisateur")
     * })
     */
    private $idUtulisateur;

    /**
     * @return int
     */
    public function getIdCommande(): int
    {
        return $this->idCommande;
    }

    /**
     * @param int $idCommande
     */
    public function setIdCommande(int $idCommande): void
    {
        $this->idCommande = $idCommande;
    }

    /**
     * @return string|null
     */
    public function getAdresseCommande(): ?string
    {
        return $this->adresseCommande;
    }

    /**
     * @param string|null $adresseCommande
     */
    public function setAdresseCommande(?string $adresseCommande): void
    {
        $this->adresseCommande = $adresseCommande;
    }

    /**
     * @return int|null
     */
    public function getEtatCommande(): ?int
    {
        return $this->etatCommande;
    }

    /**
     * @param int|null $etatCommande
     */
    public function setEtatCommande(?int $etatCommande): void
    {
        $this->etatCommande = $etatCommande;
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
