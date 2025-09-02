<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Aforo
 *
 * @ORM\Table(name="aforo")
 * @ORM\Entity
 */
class Aforo
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_aforo", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAforo;

    /**
     * @var int
     *
     * @ORM\Column(name="ctd", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $ctd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=false, options={"default"="current_timestamp()"})
     */
    private $fecha = 'current_timestamp()';


}
