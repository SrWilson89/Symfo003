<?php

namespace App\Entity;

use App\Repository\ArqueoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArqueoRepository::class)]
#[ORM\Table(name: "arqueos")]
class Arqueo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id_arqueo", type: "integer")]
    private ?int $id_arqueo = null;

    #[ORM\ManyToOne(inversedBy: 'arqueos')]
    #[ORM\JoinColumn(name: "empleado_id", referencedColumnName: "id_empleado", nullable: false)]
    private ?Empleado $empleado = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $fondo = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $ventas = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $descuadre = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $fecha_inicio = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $fecha_fin = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $cto1 = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $cto2 = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $cto5 = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $cto10 = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $cto20 = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $cto50 = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $euro1 = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $euro2 = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $euro5 = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $euro10 = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $euro20 = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $euro50 = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $euro100 = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $euro200 = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $euro500 = null;

    public function getIdArqueo(): ?int
    {
        return $this->id_arqueo;
    }

    public function getEmpleado(): ?Empleado
    {
        return $this->empleado;
    }

    public function setEmpleado(?Empleado $empleado): static
    {
        $this->empleado = $empleado;

        return $this;
    }

    public function getFondo(): ?string
    {
        return $this->fondo;
    }

    public function setFondo(?string $fondo): static
    {
        $this->fondo = $fondo;

        return $this;
    }

    public function getVentas(): ?string
    {
        return $this->ventas;
    }

    public function setVentas(?string $ventas): static
    {
        $this->ventas = $ventas;

        return $this;
    }

    public function getDescuadre(): ?string
    {
        return $this->descuadre;
    }

    public function setDescuadre(?string $descuadre): static
    {
        $this->descuadre = $descuadre;

        return $this;
    }

    public function getFechaInicio(): ?\DateTimeImmutable
    {
        return $this->fecha_inicio;
    }

    public function setFechaInicio(\DateTimeImmutable $fecha_inicio): static
    {
        $this->fecha_inicio = $fecha_inicio;

        return $this;
    }

    public function getFechaFin(): ?\DateTimeImmutable
    {
        return $this->fecha_fin;
    }

    public function setFechaFin(?\DateTimeImmutable $fecha_fin): static
    {
        $this->fecha_fin = $fecha_fin;

        return $this;
    }

    public function getCto1(): ?int
    {
        return $this->cto1;
    }

    public function setCto1(?int $cto1): static
    {
        $this->cto1 = $cto1;

        return $this;
    }

    public function getCto2(): ?int
    {
        return $this->cto2;
    }

    public function setCto2(?int $cto2): static
    {
        $this->cto2 = $cto2;

        return $this;
    }

    public function getCto5(): ?int
    {
        return $this->cto5;
    }

    public function setCto5(?int $cto5): static
    {
        $this->cto5 = $cto5;

        return $this;
    }

    public function getCto10(): ?int
    {
        return $this->cto10;
    }

    public function setCto10(?int $cto10): static
    {
        $this->cto10 = $cto10;

        return $this;
    }

    public function getCto20(): ?int
    {
        return $this->cto20;
    }

    public function setCto20(?int $cto20): static
    {
        $this->cto20 = $cto20;

        return $this;
    }

    public function getCto50(): ?int
    {
        return $this->cto50;
    }

    public function setCto50(?int $cto50): static
    {
        $this->cto50 = $cto50;

        return $this;
    }

    public function getEuro1(): ?int
    {
        return $this->euro1;
    }

    public function setEuro1(?int $euro1): static
    {
        $this->euro1 = $euro1;

        return $this;
    }

    public function getEuro2(): ?int
    {
        return $this->euro2;
    }

    public function setEuro2(?int $euro2): static
    {
        $this->euro2 = $euro2;

        return $this;
    }

    public function getEuro5(): ?int
    {
        return $this->euro5;
    }

    public function setEuro5(?int $euro5): static
    {
        $this->euro5 = $euro5;

        return $this;
    }

    public function getEuro10(): ?int
    {
        return $this->euro10;
    }

    public function setEuro10(?int $euro10): static
    {
        $this->euro10 = $euro10;

        return $this;
    }

    public function getEuro20(): ?int
    {
        return $this->euro20;
    }

    public function setEuro20(?int $euro20): static
    {
        $this->euro20 = $euro20;

        return $this;
    }

    public function getEuro50(): ?int
    {
        return $this->euro50;
    }

    public function setEuro50(?int $euro50): static
    {
        $this->euro50 = $euro50;

        return $this;
    }

    public function getEuro100(): ?int
    {
        return $this->euro100;
    }

    public function setEuro100(?int $euro100): static
    {
        $this->euro100 = $euro100;

        return $this;
    }

    public function getEuro200(): ?int
    {
        return $this->euro200;
    }

    public function setEuro200(?int $euro200): static
    {
        $this->euro200 = $euro200;

        return $this;
    }

    public function getEuro500(): ?int
    {
        return $this->euro500;
    }

    public function setEuro500(?int $euro500): static
    {
        $this->euro500 = $euro500;

        return $this;
    }
}