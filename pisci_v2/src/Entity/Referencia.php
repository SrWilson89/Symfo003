<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Referencia
 *
 * @ORM\Table(name="referencia")
 * @ORM\Entity
 */
class Referencia
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_referencia", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idReferencia;

    /**
     * @var string|null
     *
     * @ORM\Column(name="referencia", type="string", length=20, nullable=true, options={"default"="NULL"})
     */
    private $referencia = 'NULL';

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean", nullable=false, options={"default"="1"})
     */
    private $activo = true;

    /**
     * @var int|null
     *
     * @ORM\Column(name="venta_detalle_id", type="integer", nullable=true, options={"default"="NULL","unsigned"=true})
     */
    private $ventaDetalleId = NULL;


}
