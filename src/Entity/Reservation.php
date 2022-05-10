<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


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
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="le champs est vide")
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="le champs est vide")
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     */
    private $prenom;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThan("+24 hours")
     */
    private $date_arrive;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThan("+50 hours")
     */
    private $date_sortie;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="le champs est vide")

     */
    private $nbanimal;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="le champs est vide")
     */
    private $pension;

    /**
     * @ORM\Column(type="string")
     */
    private $dresseur;

    /**
     * @ORM\Column(type="string")
     */
    private $veterinaire;

    /**
     * @ORM\Column(type="float")
     */
    private $tarif;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="le champs est vide")
     */
    private $numtel;

    /**
     * @ORM\Column(type="integer")
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class)
     * @ORM\JoinColumn(nullable=false)
     * @ORM\Column(type="integer")
     */
    private $iduser;


    protected $captchaCode;
    
    public function getCaptchaCode()
    {
      return $this->captchaCode;
    }

    public function setCaptchaCode($captchaCode)
    {
      $this->captchaCode = $captchaCode;
    }



    




    public function getId(): ?int
    {
        return $this->id;
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

    public function getPension(): ?string
    {
        return $this->pension;
    }

    public function setPension(string $pension): self
    {
        $this->pension = $pension;

        return $this;
    }

    public function getDresseur(): ?string
    {
        return $this->dresseur;
    }

    public function setDresseur(string $dresseur): self
    {
        $this->dresseur = $dresseur;

        return $this;
    }

    public function getVeterinaire(): ?string
    {
        return $this->veterinaire;
    }

    public function setVeterinaire(string $veterinaire): self
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
    public function calculTarif(int $pens,int $nbjou, int $nbanim, string $vet, string $dress):float
    {
        $prixjour = 20;
        $prixvet =5;
        $prixdress =7;
        $pensnormal= 5;
        $penscomplete =10;
        $pensroyal =15;
        $total = $nbjou * $prixjour;

        if ($dress==1){$total=$total + $prixdress; }
        if ($vet==1){$total=$total + $prixvet; }
        if ($pens==1){$total=$total + $pensnormal; }elseif ($pens==2){$total=$total + $penscomplete; }else {$total=$total + $pensroyal;}
    return $total;}

    public function getIduser(): ?int
    {
        return $this->iduser;
    }

    public function setIduser(?int $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }



}
