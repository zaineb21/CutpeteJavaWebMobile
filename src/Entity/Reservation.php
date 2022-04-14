<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $idreser;

    /**
     * @ORM\Column(type="integer")
     */
    private $iduser;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="date")
     */
    private $date_arrive;

    /**
     * @ORM\Column(type="date")
     */
    private $date_sortie;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbanimal;

    /**
     * @ORM\Column(type="integer")
     */
    private $pension;

    /**
     * @ORM\Column(type="integer")
     */
    private $dresseur;

    /**
     * @ORM\Column(type="integer")
     */
    private $veterinaire;

    /**
     * @ORM\Column(type="float")
     */
    private $tarif;

    /**
     * @ORM\Column(type="integer")
     */
    private $numtel;

    /**
     * @ORM\Column(type="integer")
     */
    private $etat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdreser(): ?int
    {
        return $this->idreser;
    }

    public function setIdreser(int $idreser): self
    {
        $this->idreser = $idreser;

        return $this;
    }

    public function getIduser(): ?int
    {
        return $this->iduser;
    }

    public function setIduser(int $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateArrive(): ?\DateTimeInterface
    {
        return $this->date_arrive;
    }

    public function setDateArrive(\DateTimeInterface $date_arrive): self
    {
        $this->date_arrive = $date_arrive;

        return $this;
    }

    public function getDateSortie(): ?\DateTimeInterface
    {
        return $this->date_sortie;
    }

    public function setDateSortie(\DateTimeInterface $date_sortie): self
    {
        $this->date_sortie = $date_sortie;

        return $this;
    }

    public function getNbanimal(): ?int
    {
        return $this->nbanimal;
    }

    public function setNbanimal(int $nbanimal): self
    {
        $this->nbanimal = $nbanimal;

        return $this;
    }

    public function getPension(): ?int
    {
        return $this->pension;
    }

    public function setPension(int $pension): self
    {
        $this->pension = $pension;

        return $this;
    }

    public function getDresseur(): ?int
    {
        return $this->dresseur;
    }

    public function setDresseur(int $dresseur): self
    {
        $this->dresseur = $dresseur;

        return $this;
    }

    public function getVeterinaire(): ?int
    {
        return $this->veterinaire;
    }

    public function setVeterinaire(int $veterinaire): self
    {
        $this->veterinaire = $veterinaire;

        return $this;
    }

    public function getTarif(): ?float
    {
        return $this->tarif;
    }

    public function setTarif(float $tarif): self
    {
        $this->tarif = $tarif;

        return $this;
    }

    public function getNumtel(): ?int
    {
        return $this->numtel;
    }

    public function setNumtel(int $numtel): self
    {
        $this->numtel = $numtel;

        return $this;
    }

    public function getEtat(): ?int
    {
        return $this->etat;
    }

    public function setEtat(int $etat): self
    {
        $this->etat = $etat;

        return $this;
    }
}
