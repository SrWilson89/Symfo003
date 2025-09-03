<?php

namespace App\Entity;

use App\Repository\VentaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VentaRepository::class)]
class Venta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ventas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Empleado $empleado = null;

    // Se cambió 'cantidad' a 'total' para que coincida con la base de datos
    #[ORM\Column]
    private ?float $total = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $fecha = null;

    /**
     * @var Collection<int, VentaDetalle>
     */
    #[ORM\OneToMany(targetEntity: VentaDetalle::class, mappedBy: 'venta', orphanRemoval: true)]
    private Collection $ventaDetalles;

    public function __construct()
    {
        $this->ventaDetalles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    // Se cambió 'getCantidad' a 'getTotal'
    public function getTotal(): ?float
    {
        return $this->total;
    }

    // Se cambió 'setCantidad' a 'setTotal'
    public function setTotal(float $total): static
    {
        $this->total = $total;

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

    /**
     * @return Collection<int, VentaDetalle>
     */
    public function getVentaDetalles(): Collection
    {
        return $this->ventaDetalles;
    }

    public function addVentaDetalle(VentaDetalle $ventaDetalle): static
    {
        if (!$this->ventaDetalles->contains($ventaDetalle)) {
            $this->ventaDetalles->add($ventaDetalle);
            $ventaDetalle->setVenta($this);
        }

        return $this;
    }

    public function removeVentaDetalle(VentaDetalle $ventaDetalle): static
    {
        if ($this->ventaDetalles->removeElement($ventaDetalle)) {
            if ($ventaDetalle->getVenta() === $this) {
                $ventaDetalle->setVenta(null);
            }
        }

        return $this;
    }
}