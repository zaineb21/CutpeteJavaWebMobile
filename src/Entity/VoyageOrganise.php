<?php

namespace App\Entity;

use App\Repository\VoyageOrganiseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="le champs est vide")
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     */
    private $pays;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThan("+24 hours")
     */
    private $date;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="le champs est vide")
     */
    private $nbjours;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="le champs est vide")
     */
    private $programme;

    /**
     * @ORM\Column(type="float")
     *
     */
    private $tarif;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="le champs est vide")
     */
    private $nbanimal;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbjrest;











    public function getId(): ?int
    {
        return $this->id;
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
    public function calcultarif(int $nbj , int $nbanim):float{
         $jour = 20;
        $animal = 50;
        $tarif = ($nbj*$jour) + ($nbanim*$animal);

        return $tarif;}

    public function getNbjrest(): ?int
    {
        return $this->nbjrest;
    }

    public function setNbjrest(int $nbjrest): self
    {
        $this->nbjrest = $nbjrest;

        return $this;
    }








}
