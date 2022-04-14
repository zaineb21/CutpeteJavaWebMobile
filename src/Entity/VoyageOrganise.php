<?php

namespace App\Entity;

use App\Repository\VoyageOrganiseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VoyageOrganiseRepository::class)
 */
class VoyageOrganise
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
    private $idvoy;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pays;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbjours;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $programme;

    /**
     * @ORM\Column(type="float")
     */
    private $tarif;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbanimal;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdvoy(): ?int
    {
        return $this->idvoy;
    }

    public function setIdvoy(int $idvoy): self
    {
        $this->idvoy = $idvoy;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getNbjours(): ?int
    {
        return $this->nbjours;
    }

    public function setNbjours(int $nbjours): self
    {
        $this->nbjours = $nbjours;

        return $this;
    }

    public function getProgramme(): ?string
    {
        return $this->programme;
    }

    public function setProgramme(string $programme): self
    {
        $this->programme = $programme;

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

    public function getNbanimal(): ?int
    {
        return $this->nbanimal;
    }

    public function setNbanimal(int $nbanimal): self
    {
        $this->nbanimal = $nbanimal;

        return $this;
    }
}
