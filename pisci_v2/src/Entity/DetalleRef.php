<?php

namespace App\Entity;

use App\Repository\DetalleRefRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetalleRefRepository::class)]
#[ORM\Table(name: "detalle_ref")]
class DetalleRef
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id_detalleref", type: "integer")]
    private ?int $id_detalleref = null;

    #[ORM\ManyToOne(inversedBy: 'detalleRefs')]
    #[ORM\JoinColumn(name: "referencia_id", referencedColumnName: "id_referencia", nullable: false)]
    private ?Referencia $referencia = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: "producto_id", referencedColumnName: "id_producto", nullable: false)]
    private ?Producto $producto = null;

    #[ORM\Column]
    private ?int $cantidad = null;

    public function getIdDetalleref(): ?int
    {
        return $this->id_detalleref;
    }

    public function getReferencia(): ?Referencia
    {
        return $this->referencia;
    }

    public function setReferencia(?Referencia $referencia): static
    {
        $this->referencia = $referencia;

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
}
