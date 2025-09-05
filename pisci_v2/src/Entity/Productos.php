<?php

namespace App\Entity;

use App\Repository\ProductoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductoRepository::class)]
#[ORM\Table(name: "productos")]
class Producto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id_producto", type: "integer")]
    private ?int $id_producto = null;

    #[ORM\Column(length: 30)]
    private ?string $nombre = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $precio = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $seccion = null;

    #[ORM\OneToMany(mappedBy: 'producto', targetEntity: VentaDetalle::class)]
    private Collection $ventaDetalles;

    public function __construct()
    {
        $this->ventaDetalles = new ArrayCollection();
    }

    public function getIdProducto(): ?int
    {
        return $this->id_producto;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

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

    public function getSeccion(): ?string
    {
        return $this->seccion;
    }

    public function setSeccion(?string $seccion): static
    {
        $this->seccion = $seccion;

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
            $ventaDetalle->setProducto($this);
        }

        return $this;
    }

    public function removeVentaDetalle(VentaDetalle $ventaDetalle): static
    {
        if ($this->ventaDetalles->removeElement($ventaDetalle)) {
            // set the owning side to null (unless already changed)
            if ($ventaDetalle->getProducto() === $this) {
                $ventaDetalle->setProducto(null);
            }
        }

        return $this;
    }
}