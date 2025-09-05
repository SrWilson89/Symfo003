<?php

namespace App\Entity;

use App\Repository\VentaDetalleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VentaDetalleRepository::class)]
#[ORM\Table(name: "ventasdetalle")]
class VentaDetalle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id_ventadetalle", type: "integer")]
    private ?int $id_ventadetalle = null;

    #[ORM\ManyToOne(inversedBy: 'ventaDetalles')]
    #[ORM\JoinColumn(name: "venta_id", referencedColumnName: "id_venta", nullable: false)]
    private ?Venta $venta = null;

    #[ORM\ManyToOne(inversedBy: 'ventaDetalles')]
    #[ORM\JoinColumn(name: "producto_id", referencedColumnName: "id_producto", nullable: false)]
    private ?Producto $producto = null;

    #[ORM\Column(name: "ctd")]
    private ?int $cantidad = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $precio = null;

    public function getIdVentadetalle(): ?int
    {
        return $this->id_ventadetalle;
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

    public function getProducto(): ?Producto
    {
        return $this->producto;
    }

    public function setProducto(?Producto $producto): static
    {
        $this->producto = $producto;

        return $this;
    }

    public function getCantidad(): ?int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad): static
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    public function getPrecio(): ?string
    {
        return $this->precio;
    }

    public function setPrecio(string $precio): static
    {
        $this->precio = $precio;

        return $this;
    }
}