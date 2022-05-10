<?php

namespace App\Entity;

use App\Repository\EvenementLocalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EvenementLocalRepository::class)
 */
class EvenementLocal
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
     * @ORM\Column(type="date")
     * @Assert\GreaterThan("+24 hours")
     */
    private $date;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbparti;

    /**
     * @ORM\Column(type="float")
     */
    private $tarif;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="le champs est vide")
     */
    private $lieu;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="le champs est vide")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbplace;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photo;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbjoursrestant;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbplacerest;






    public function getImagePath()
    {
        return '/public/uploads/evenement/'.$this->getPhoto();
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getNbparti(): ?int
    {
        return $this->nbparti;
    }

    public function setNbparti(int $nbparti): self
    {
        $this->nbparti = $nbparti;

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

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNbplace(): ?int
    {
        return $this->nbplace;
    }

    public function setNbplace(int $nbplace): self
    {
        $this->nbplace = $nbplace;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getNbjoursrestant(): ?int
    {
        return $this->nbjoursrestant;
    }

    public function setNbjoursrestant(int $nbjoursrestant): self
    {
        $this->nbjoursrestant = $nbjoursrestant;

        return $this;
    }

    public function getNbplacerest(): ?int
    {
        return $this->nbplacerest;
    }

    public function setNbplacerest(int $nbplacerest): self
    {
        $this->nbplacerest = $nbplacerest;

        return $this;
    }



}
