<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Asociados
 *
 * @ORM\Table(name="asociados")
 * @ORM\Entity
 */
class Asociados
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_asociado", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAsociado;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=30, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", length=30, nullable=false)
     */
    private $apellidos;

    /**
     * @var string|null
     *
     * @ORM\Column(name="dni", type="string", length=10, nullable=true, options={"default"="NULL"})
     */
    private $dni = 'NULL';

    /**
     * @var int|null
     *
     * @ORM\Column(name="cliente_id", type="integer", nullable=true, options={"default"="NULL","unsigned"=true})
     */
    private $clienteId = NULL;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=false, options={"default"="current_timestamp()"})
     */
    private $fecha = 'current_timestamp()';


}
