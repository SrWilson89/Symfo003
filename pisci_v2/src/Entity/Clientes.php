<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Clientes
 *
 * @ORM\Table(name="clientes")
 * @ORM\Entity
 */
class Clientes
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_cliente", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCliente;

    /**
     * @var string|null
     *
     * @ORM\Column(name="notas", type="string", length=500, nullable=true, options={"default"="''"})
     */
    private $notas = '\'\'';

    /**
     * @var int|null
     *
     * @ORM\Column(name="asociado_id", type="integer", nullable=true, options={"default"="NULL","unsigned"=true})
     */
    private $asociadoId = NULL;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=false, options={"default"="current_timestamp()"})
     */
    private $fecha = 'current_timestamp()';


}
