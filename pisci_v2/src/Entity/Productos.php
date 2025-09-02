<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Productos
 *
 * @ORM\Table(name="productos")
 * @ORM\Entity
 */
class Productos
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_producto", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idProducto;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50, nullable=false)
     */
    private $nombre;

    /**
     * @var float
     *
     * @ORM\Column(name="precio", type="float", precision=10, scale=0, nullable=false)
     */
    private $precio;

    /**
     * @var bool
     *
     * @ORM\Column(name="tipo", type="boolean", nullable=false)
     */
    private $tipo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="notas", type="string", length=500, nullable=true, options={"default"="''"})
     */
    private $notas = '\'\'';

    /**
     * @var int|null
     *
     * @ORM\Column(name="ref_ini", type="integer", nullable=true, options={"default"="NULL","unsigned"=true})
     */
    private $refIni = NULL;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ref_fin", type="integer", nullable=true, options={"default"="NULL","unsigned"=true})
     */
    private $refFin = NULL;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_ini", type="date", nullable=true, options={"default"="NULL"})
     */
    private $fechaIni = 'NULL';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_fin", type="date", nullable=true, options={"default"="NULL"})
     */
    private $fechaFin = 'NULL';


}
