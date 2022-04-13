<?php

namespace App\Entity;

use App\Repository\FormationsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FormationsRepository::class)
 */
class Formations
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
    private $titres;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $organismes;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Logo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Periode;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitres(): ?string
    {
        return $this->titres;
    }

    public function setTitres(string $titres): self
    {
        $this->titres = $titres;

        return $this;
    }

    public function getOrganismes(): ?string
    {
        return $this->organismes;
    }

    public function setOrganismes(string $organismes): self
    {
        $this->organismes = $organismes;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->Logo;
    }

    public function setLogo(string $Logo): self
    {
        $this->Logo = $Logo;

        return $this;
    }

    public function getPeriode(): ?string
    {
        return $this->Periode;
    }

    public function setPeriode(string $Periode): self
    {
        $this->Periode = $Periode;

        return $this;
    }
}
