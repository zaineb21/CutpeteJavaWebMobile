<?php

namespace App\Entity;

use App\Repository\ParticipationEvenementRepository;
use Doctrine\DBAL\Types\DateType;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParticipationEvenementRepository::class)
 */
class ParticipationEvenement
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
    private $idUser;

    /**
     * @ORM\ManyToOne(targetEntity=EvenementLocal::class)
     * @ORM\JoinColumn(nullable=false)
     * @ORM\Column(type="integer")
     */
    private $idEvent;

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
     * @ORM\ManyToOne(targetEntity=EvenementLocal::class)
     * @ORM\JoinColumn(nullable=false)
     * @ORM\Column(type="string")
     */
    private $nomEvent;

    /**
     * @ORM\ManyToOne(targetEntity=EvenementLocal::class)
     * @ORM\JoinColumn(nullable=false)
     * @ORM\Column(type="date")
     */
    private $dateEvent;

    /**
     * @ORM\ManyToOne(targetEntity=EvenementLocal::class)
     * @ORM\JoinColumn(nullable=false)
     * @ORM\Column(type="string", length=255)
     */
    private $photoEvent;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class)
     * @ORM\JoinColumn(nullable=false)
     * @ORM\Column(type="string", length=255)
     */
    private $mailUser;





    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser(int $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getIdEvent(): ?int
    {
        return $this->idEvent;
    }

    public function setIdEvent(int $idEvent): self
    {
        $this->idEvent = $idEvent;

        return $this;
    }

    public function getNomUser(): ?string
    {
        return $this->nomUser;
    }

    public function setNomUser(string $nomUser): self
    {
        $this->nomUser = $nomUser;

        return $this;
    }

    public function getPrenomUser(): ?string
    {
        return $this->prenomUser;
    }

    public function setPrenomUser(string $prenomUser): self
    {
        $this->prenomUser = $prenomUser;

        return $this;
    }

    public function getNomEvent(): ?string
    {
        return $this->nomEvent;
    }

    public function setNomEvent(string $nomEvent): self
    {
        $this->nomEvent = $nomEvent;

        return $this;
    }

    public function getDateEvent(): ?\DateTimeInterface
    {
        return $this->dateEvent;
    }

    public function setDateEvent(\DateTimeInterface $dateEvent): self
    {
        $this->dateEvent = $dateEvent;

        return $this;
    }

    public function getPhotoEvent(): ?string
    {
        return $this->photoEvent;
    }

    public function setPhotoEvent(string $photoEvent): self
    {
        $this->photoEvent = $photoEvent;

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
