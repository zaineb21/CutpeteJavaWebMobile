<?php

namespace App\Entity;

use App\Repository\ParticipationVoyageRepository;
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
     * @ORM\ManyToOne(targetEntity=utilisateur::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_user;

    /**
     * @ORM\ManyToOne(targetEntity=VoyageOrganise::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_voyage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?utilisateur
    {
        return $this->id_user;
    }

    public function setIdUser(?utilisateur $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getIdVoyage(): ?VoyageOrganise
    {
        return $this->id_voyage;
    }

    public function setIdVoyage(?VoyageOrganise $id_voyage): self
    {
        $this->id_voyage = $id_voyage;

        return $this;
    }
}
