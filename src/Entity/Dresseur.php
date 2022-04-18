<?php

namespace App\Entity;

use App\Repository\DresseurRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=DresseurRepository::class)
 */
class Dresseur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length( min = 3, max = 20, minMessage = "Merci de Vérifier Votre champs ")
     * @Assert\NotBlank(message="Ce champs est obligatoire * ")
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length( min = 3, max = 20, minMessage = "Merci de Vérifier Votre champs ")
     * @Assert\NotBlank(message="Ce champs est obligatoire * ")
     */
    private $specialite;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length( min = 3, max = 20, minMessage = "Merci de Vérifier Votre champs ")
     * @Assert\NotBlank(message="Ce champs est obligatoire *")
     * @Assert\Email(
     *     message = "L'email '{{ value }}' n'est pas un email."
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length( min = 3, max = 20, minMessage = "Merci de Vérifier Votre champs ")
     * @Assert\NotBlank(message="Ce champs est obligatoire * ")
     */
    private $address;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="integer")@Assert\Length( min = 3, max = 20, minMessage = "Merci de Vérifier Votre champs ")
     * @Assert\NotBlank(message="Ce champs est obligatoire * ")
     *
     */
    private $num;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length( min = 3, max = 20, minMessage = "Merci de Vérifier Votre champs ")
     * @Assert\NotBlank(message="Ce champs est obligatoire *")
     */
    private $picture;

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

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(string $specialite): self
    {
        $this->specialite = $specialite;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getNum(): ?int
    {
        return $this->num;
    }

    public function setNum(int $num): self
    {
        $this->num = $num;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }
}
