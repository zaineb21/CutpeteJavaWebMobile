<?php

namespace App\Entity;

use App\Repository\ParticipationVoyageRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParticipationVoyageRepository::class)
 */
class ParticipationVoyage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class)
     * @ORM\JoinColumn(nullable=false)
     * @ORM\Column(type="integer")
     */
    private $id_user;

    /**
     * @ORM\ManyToOne(targetEntity=VoyageOrganise::class)
     * @ORM\JoinColumn(nullable=false)
     * @ORM\Column(type="integer")
     */
    private $id_voyage;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class)
     * @ORM\JoinColumn(nullable=false)
     * @ORM\Column(type="string")
     */
    private $nomUser;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class)
     * @ORM\JoinColumn(nullable=false)
     * @ORM\Column(type="string")
     */
    private $prenomUser;

    /**
     * @ORM\ManyToOne(targetEntity=VoyageOrganise::class)
     * @ORM\JoinColumn(nullable=false)
     * @ORM\Column(type="date")
     */
    private $dateVoyage;

    /**
     * @ORM\ManyToOne(targetEntity=VoyageOrganise::class)
     * @ORM\JoinColumn(nullable=false)
     * @ORM\Column(type="string")
     */
    private $paysVoyage;

    /**
     * @ORM\ManyToOne(targetEntity=VoyageOrganise::class)
     * @ORM\JoinColumn(nullable=false)
     * @ORM\Column(type="float")
     */
    private $tarifVoyage;

    /**
     * @ORM\ManyToOne(targetEntity=VoyageOrganise::class)
     * @ORM\JoinColumn(nullable=false)
     * @ORM\Column(type="integer")
     */
    private $nbanimalVoyage;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class)
     * @ORM\JoinColumn(nullable=false)
     * @ORM\Column(type="string")
     */
    private $mailUser;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?int
    {
        return $this->id_user;
    }

    public function setIdUser(?int $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getIdVoyage(): ?int
    {
        return $this->id_voyage;
    }

    public function setIdVoyage(?int $id_voyage): self
    {
        $this->id_voyage = $id_voyage;

        return $this;
    }

    public function getNomUser(): ?string
    {
        return $this->nomUser;
    }

    public function setNomUser(?string $nomUser): self
    {
        $this->nomUser = $nomUser;

        return $this;
    }

    public function getPrenomUser(): ?string
    {
        return $this->prenomUser;
    }

    public function setPrenomUser(?string $prenomUser): self
    {
        $this->prenomUser = $prenomUser;

        return $this;
    }

    public function getDateVoyage(): ?\DateTimeInterface
    {
        return $this->dateVoyage;
    }

    public function setDateVoyage(?DateTimeInterface $dateVoyage): self
    {
        $this->dateVoyage = $dateVoyage;

        return $this;
    }

    public function getPaysVoyage(): ?string
    {
        return $this->paysVoyage;
    }

    public function setPaysVoyage(?string $paysVoyage): self
    {
        $this->paysVoyage = $paysVoyage;

        return $this;
    }

    public function getTarifVoyage(): ?float
    {
        return $this->tarifVoyage;
    }

    public function setTarifVoyage(?float $tarifVoyage): self
    {
        $this->tarifVoyage = $tarifVoyage;

        return $this;
    }

    public function getNbanimalVoyage(): ?int
    {
        return $this->nbanimalVoyage;
    }

    public function setNbanimalVoyage(?int $nbanimalVoyage): self
    {
        $this->nbanimalVoyage = $nbanimalVoyage;

        return $this;
    }

    public function getMailUser(): ?string
    {
        return $this->mailUser;
    }

    public function setMailUser(?string $mailUser): self
    {
        $this->mailUser = $mailUser;

        return $this;
    }
}
