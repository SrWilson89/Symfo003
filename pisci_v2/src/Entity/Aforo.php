<?php

namespace App\Entity;

use App\Repository\AforoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AforoRepository::class)]
#[ORM\Table(name: "aforos")]
class Aforo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id_aforo", type: "integer")]
    private ?int $id_aforo = null;

    #[ORM\Column]
    private ?int $personas = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $fecha = null;

    #[ORM\Column]
    private ?int $capacidad = null;

    public function getIdAforo(): ?int
    {
        return $this->id_aforo;
    }

    public function getPersonas(): ?int
    {
        return $this->personas;
    }

    public function setPersonas(int $personas): static
    {
        $this->personas = $personas;

        return $this;
    }

    public function getFecha(): ?\DateTimeImmutable
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeImmutable $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getCapacidad(): ?int
    {
        return $this->capacidad;
    }

    public function setCapacidad(int $capacidad): static
    {
        $this->capacidad = $capacidad;

        return $this;
    }
}