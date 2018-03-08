<?php

namespace PlanillaBundle\Entity;

/**
 * Mes
 */
class Mes
{
    /**
     * @var integer
     */
    private $mesEje;

    /**
     * @var string
     */
    private $nombre;


    /**
     * Get mesEje
     *
     * @return integer
     */
    public function getMesEje()
    {
        return $this->mesEje;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Mes
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }
}
