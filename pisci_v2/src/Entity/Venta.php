<?php

namespace App\Entity;

use App\Repository\VentaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VentaRepository::class)]
#[ORM\Table(name: "ventas")]
class Venta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id_venta", type: "integer")]
    private ?int $id_venta = null;

    #[ORM\ManyToOne(inversedBy: 'ventas')]
    #[ORM\JoinColumn(name: "cliente_id", referencedColumnName: "id_cliente", nullable: true)]
    private ?Cliente $cliente = null;

    #[ORM\ManyToOne(inversedBy: 'ventas')]
    #[ORM\JoinColumn(name: "arqueo_id", referencedColumnName: "id_arqueo", nullable: false)]
    private ?Arqueo $arqueo = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $total = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $fecha_venta = null;

    #[ORM\OneToMany(mappedBy: 'venta', targetEntity: VentaDetalle::class, orphanRemoval: true)]
    private Collection $ventaDetalles;

    public function __construct()
    {
        $this->ventaDetalles = new ArrayCollection();
    }

    public function getIdVenta(): ?int
    {
        return $this->id_venta;
    }

    public function getCliente(): ?Cliente
    {
        return $this->cliente;
    }

    public function setCliente(?Cliente $cliente): static
    {
        $this->cliente = $cliente;

        return $this;
    }

    public function getArqueo(): ?Arqueo
    {
        return $this->arqueo;
    }

    public function setArqueo(?Arqueo $arqueo): static
    {
        $this->arqueo = $arqueo;

        return $this;
    }

    public function getTotal(): ?string
    {
        return $this->total;
    }

    public function setTotal(string $total): static
    {
        $this->total = $total;

        return $this;
    }

    public function getFechaVenta(): ?\DateTimeImmutable
    {
        return $this->fecha_venta;
    }

    public function setFechaVenta(\DateTimeImmutable $fecha_venta): static
    {
        $this->fecha_venta = $fecha_venta;

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
            // set the owning side to null (unless already changed)
            if ($ventaDetalle->getVenta() === $this) {
                $ventaDetalle->setVenta(null);
            }
        }

        return $this;
    }
}