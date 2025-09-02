<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Arqueo
 *
 * @ORM\Table(name="arqueo")
 * @ORM\Entity
 */
class Arqueo
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_arqueo", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idArqueo;

    /**
     * @var int|null
     *
     * @ORM\Column(name="empleado_id", type="integer", nullable=true, options={"default"="NULL","unsigned"=true})
     */
    private $empleadoId = NULL;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_ini", type="datetime", nullable=false, options={"default"="current_timestamp()"})
     */
    private $fechaIni = 'current_timestamp()';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_fin", type="datetime", nullable=true, options={"default"="NULL"})
     */
    private $fechaFin = 'NULL';

    /**
     * @var float
     *
     * @ORM\Column(name="fondo", type="float", precision=10, scale=0, nullable=false)
     */
    private $fondo;

    /**
     * @var float|null
     *
     * @ORM\Column(name="ventas", type="float", precision=10, scale=0, nullable=true, options={"default"="NULL"})
     */
    private $ventas = NULL;

    /**
     * @var float|null
     *
     * @ORM\Column(name="ventas_efectivo", type="float", precision=10, scale=0, nullable=true, options={"default"="NULL"})
     */
    private $ventasEfectivo = NULL;

    /**
     * @var int|null
     *
     * @ORM\Column(name="billetes_500", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $billetes500 = NULL;

    /**
     * @var int|null
     *
     * @ORM\Column(name="billetes_200", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $billetes200 = NULL;

    /**
     * @var int|null
     *
     * @ORM\Column(name="billetes_100", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $billetes100 = NULL;

    /**
     * @var int|null
     *
     * @ORM\Column(name="billetes_50", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $billetes50 = NULL;

    /**
     * @var int|null
     *
     * @ORM\Column(name="billetes_20", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $billetes20 = NULL;

    /**
     * @var int|null
     *
     * @ORM\Column(name="billetes_10", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $billetes10 = NULL;

    /**
     * @var int|null
     *
     * @ORM\Column(name="billetes_5", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $billetes5 = NULL;

    /**
     * @var int|null
     *
     * @ORM\Column(name="monedas_2", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $monedas2 = NULL;

    /**
     * @var int|null
     *
     * @ORM\Column(name="monedas_1", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $monedas1 = NULL;

    /**
     * @var int|null
     *
     * @ORM\Column(name="monedas_05", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $monedas05 = NULL;

    /**
     * @var int|null
     *
     * @ORM\Column(name="monedas_02", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $monedas02 = NULL;

    /**
     * @var int|null
     *
     * @ORM\Column(name="monedas_01", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $monedas01 = NULL;

    /**
     * @var int|null
     *
     * @ORM\Column(name="monedas_005", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $monedas005 = NULL;

    /**
     * @var int|null
     *
     * @ORM\Column(name="monedas_002", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $monedas002 = NULL;

    /**
     * @var int|null
     *
     * @ORM\Column(name="monedas_001", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $monedas001 = NULL;


}
