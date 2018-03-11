<?php

namespace PlanillaBundle\Entity;

/**
 * Sector
 */
class Sector
{
    /**
     * @var integer
     */
    private $anoEje;

    /**
     * @var string
     */
    private $sector;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $estado;


    /**
     * Set anoEje
     *
     * @param integer $anoEje
     *
     * @return Sector
     */
    public function setAnoEje($anoEje)
    {
        $this->anoEje = $anoEje;

        return $this;
    }

    /**
     * Get anoEje
     *
     * @return integer
     */
    public function getAnoEje()
    {
        return $this->anoEje;
    }

    /**
     * Set sector
     *
     * @param string $sector
     *
     * @return Sector
     */
    public function setSector($sector)
    {
        $this->sector = $sector;

        return $this;
    }

    /**
     * Get sector
     *
     * @return string
     */
    public function getSector()
    {
        return $this->sector;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Sector
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

    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return Sector
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }
}
