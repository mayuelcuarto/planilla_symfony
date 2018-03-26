<?php

namespace PlanillaBundle\Entity;

/**
 * Pliego
 */
class Pliego
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $pliego;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var boolean
     */
    private $estado;

    /**
     * @var \PlanillaBundle\Entity\Sector
     */
    private $sector;

    /**
     * @var string
     */
    private $cadena;
    
    /**
     * Get cadena
     *
     * @return string
     */
    public function getCadena()
    {
        return $this->getSector()->getAnoEje() ." - ".$this->pliego." ".$this->nombre;
    } 

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set pliego
     *
     * @param string $pliego
     *
     * @return Pliego
     */
    public function setPliego($pliego)
    {
        $this->pliego = $pliego;

        return $this;
    }

    /**
     * Get pliego
     *
     * @return string
     */
    public function getPliego()
    {
        return $this->pliego;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Pliego
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
     * @param boolean $estado
     *
     * @return Pliego
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return boolean
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set sector
     *
     * @param \PlanillaBundle\Entity\Sector $sector
     *
     * @return Pliego
     */
    public function setSector(\PlanillaBundle\Entity\Sector $sector = null)
    {
        $this->sector = $sector;

        return $this;
    }

    /**
     * Get sector
     *
     * @return \PlanillaBundle\Entity\Sector
     */
    public function getSector()
    {
        return $this->sector;
    }
}

