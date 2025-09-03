<?php
// src/Entity/VentaDetalle.php

namespace App\Entity;

use App\Repository\VentaDetalleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VentaDetalleRepository::class)]
class VentaDetalle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ventaDetalles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Venta $venta = null;

    // Esta es la propiedad que faltaba o estaba mal definida.
    #[ORM\Column]
    private ?float $cantidad = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVenta(): ?Venta
    {
        return $this->venta;
    }

    public function setVenta(?Venta $venta): static
    {
        $this->venta = $venta;

        return $this;
    }

    public function getCantidad(): ?float
    {
        return $this->cantidad;
    }

    public function setCantidad(float $cantidad): static
    {
        $this->cantidad = $cantidad;

        return $this;
    }
}