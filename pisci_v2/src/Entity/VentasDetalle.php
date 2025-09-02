<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VentasDetalle
 *
 * @ORM\Table(name="ventas_detalle")
 * @ORM\Entity
 */
class VentasDetalle
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_venta_detalle", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idVentaDetalle;

    /**
     * @var int|null
     *
     * @ORM\Column(name="venta_id", type="integer", nullable=true, options={"default"="NULL","unsigned"=true})
     */
    private $ventaId = NULL;

    /**
     * @var int|null
     *
     * @ORM\Column(name="producto_id", type="integer", nullable=true, options={"default"="NULL","unsigned"=true})
     */
    private $productoId = NULL;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ctd", type="integer", nullable=true, options={"default"="NULL","unsigned"=true})
     */
    private $ctd = NULL;

    /**
     * @var float|null
     *
     * @ORM\Column(name="precio", type="float", precision=10, scale=0, nullable=true, options={"default"="NULL"})
     */
    private $precio = NULL;


}
