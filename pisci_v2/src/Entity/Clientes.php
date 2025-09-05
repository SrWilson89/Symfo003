<?php

namespace App\Entity;

use App\Repository\ClienteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClienteRepository::class)]
#[ORM\Table(name: "clientes")]
class Cliente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id_cliente", type: "integer")]
    private ?int $id_cliente = null;

    #[ORM\Column(length: 30)]
    private ?string $nombre = null;

    #[ORM\Column(length: 30)]
    private ?string $apellidos = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $dni = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $telefono = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $total_pagos = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $deuda = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $forma_pago = null;

    #[ORM\OneToMany(mappedBy: 'cliente', targetEntity: Asociado::class)]
    private Collection $asociados;

    #[ORM\OneToMany(mappedBy: 'cliente', targetEntity: Venta::class)]
    private Collection $ventas;

    public function __construct()
    {
        $this->asociados = new ArrayCollection();
        $this->ventas = new ArrayCollection();
    }

    public function getIdCliente(): ?int
    {
        return $this->id_cliente;
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

    public function getApellidos(): ?string
    {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos): static
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    public function getDni(): ?string
    {
        return $this->dni;
    }

    public function setDni(?string $dni): static
    {
        $this->dni = $dni;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): static
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getTotalPagos(): ?string
    {
        return $this->total_pagos;
    }

    public function setTotalPagos(?string $total_pagos): static
    {
        $this->total_pagos = $total_pagos;

        return $this;
    }

    public function getDeuda(): ?string
    {
        return $this->deuda;
    }

    public function setDeuda(?string $deuda): static
    {
        $this->deuda = $deuda;

        return $this;
    }

    public function getFormaPago(): ?string
    {
        return $this->forma_pago;
    }

    public function setFormaPago(?string $forma_pago): static
    {
        $this->forma_pago = $forma_pago;

        return $this;
    }

    /**
     * @return Collection<int, Asociado>
     */
    public function getAsociados(): Collection
    {
        return $this->asociados;
    }

    public function addAsociado(Asociado $asociado): static
    {
        if (!$this->asociados->contains($asociado)) {
            $this->asociados->add($asociado);
            $asociado->setCliente($this);
        }

        return $this;
    }

    public function removeAsociado(Asociado $asociado): static
    {
        if ($this->asociados->removeElement($asociado)) {
            // set the owning side to null (unless already changed)
            if ($asociado->getCliente() === $this) {
                $asociado->setCliente(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Venta>
     */
    public function getVentas(): Collection
    {
        return $this->ventas;
    }

    public function addVenta(Venta $venta): static
    {
        if (!$this->ventas->contains($venta)) {
            $this->ventas->add($venta);
            $venta->setCliente($this);
        }

        return $this;
    }

    public function removeVenta(Venta $venta): static
    {
        if ($this->ventas->removeElement($venta)) {
            // set the owning side to null (unless already changed)
            if ($venta->getCliente() === $this) {
                $venta->setCliente(null);
            }
        }

        return $this;
    }
}