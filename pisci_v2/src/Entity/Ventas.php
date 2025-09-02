<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ventas
 *
 * @ORM\Table(name="ventas")
 * @ORM\Entity
 */
class Ventas
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_venta", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idVenta;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=false, options={"default"="current_timestamp()"})
     */
    private $fecha = 'current_timestamp()';

    /**
     * @var int|null
     *
     * @ORM\Column(name="cliente_id", type="integer", nullable=true, options={"default"="NULL","unsigned"=true})
     */
    private $clienteId = NULL;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="tpv", type="boolean", nullable=true)
     */
    private $tpv = '0';


}
