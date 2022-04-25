<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * CodePromo
 *
 * @ORM\Table(name="code_promo")
 * @ORM\Entity(repositoryClass="App\Repository\CodePromoRepository")
 */
class CodePromo
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_codepromo", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCodepromo;

    /**
     * @var int|null
     * * * @Assert\Range(
     *      min = 0,
     *      max = 100,
     *      notInRangeMessage = "You must be between {{ min }}% and {{ max }}%  to enter",
     * )
     *@Assert\NotBlank
     * @ORM\Column(name="pourcentage", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $pourcentage = NULL;

    /**
     * @var string
     *@Assert\NotBlank
     * @ORM\Column(name="nomBlogeuse", type="string", length=255, nullable=false)
     */
    private $nomblogeuse;

    /**
     * @var int
     * @Assert\PositiveOrZero
     * @ORM\Column(name="nb", type="integer", nullable=false)
     */
    private $nb;

    /**
     * @return int
     */
    public function getIdCodepromo(): int
    {
        return $this->idCodepromo;
    }

    /**
     * @param int $idCodepromo
     */
    public function setIdCodepromo(int $idCodepromo): void
    {
        $this->idCodepromo = $idCodepromo;
    }

    /**

     * @return int|null
     */
    public function getPourcentage(): ?int
    {
        return $this->pourcentage;
    }

    /**
     * @param int|null $pourcentage
     */
    public function setPourcentage(?int $pourcentage): void
    {
        $this->pourcentage = $pourcentage;
    }

    /**
     * @return string
     */
    public function getNomblogeuse(): ?string
    {
        return $this->nomblogeuse;
    }

    /**
     * @param string $nomblogeuse
     */
    public function setNomblogeuse(string $nomblogeuse): void
    {
        $this->nomblogeuse = $nomblogeuse;
    }

    /**
     * @return int
     */
    public function getNb(): ?int
    {
        return $this->nb;
    }

    /**
     * @param int $nb
     */
    public function setNb(int $nb): void
    {
        $this->nb = $nb;
    }


}
