<?php

namespace App\Entity;

use App\Repository\ReferenciaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReferenciaRepository::class)]
#[ORM\Table(name: "referencias")]
class Referencia
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id_referencia", type: "integer")]
    private ?int $id_referencia = null;

    #[ORM\Column(length: 30)]
    private ?string $nombre = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $precio = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $seccion = null;

    #[ORM\OneToMany(mappedBy: 'referencia', targetEntity: DetalleRef::class)]
    private Collection $detalleRefs;

    public function __construct()
    {
        $this->detalleRefs = new ArrayCollection();
    }

    public function getIdReferencia(): ?int
    {
        return $this->id_referencia;
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
     * @return Collection<int, DetalleRef>
     */
    public function getDetalleRefs(): Collection
    {
        return $this->detalleRefs;
    }

    public function addDetalleRef(DetalleRef $detalleRef): static
    {
        if (!$this->detalleRefs->contains($detalleRef)) {
            $this->detalleRefs->add($detalleRef);
            $detalleRef->setReferencia($this);
        }

        return $this;
    }

    public function removeDetalleRef(DetalleRef $detalleRef): static
    {
        if ($this->detalleRefs->removeElement($detalleRef)) {
            // set the owning side to null (unless already changed)
            if ($detalleRef->getReferencia() === $this) {
                $detalleRef->setReferencia(null);
            }
        }

        return $this;
    }
}