<?php

namespace App\Entity;

use App\Repository\ParticipationEvenementRepository;
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
     * @ORM\JoinColumn(name="idUser",referencedColumnName="id")
     */
    private $idUser;

    /**
     * @ORM\ManyToOne(targetEntity=EvenementLocal::class)
     * @ORM\JoinColumn(name="idEvent",referencedColumnName="id")
     */
    private $idEvent;

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
}
