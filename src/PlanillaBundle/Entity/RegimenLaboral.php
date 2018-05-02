<?php

namespace PlanillaBundle\Entity;

/**
 * RegimenLaboral
 */
class RegimenLaboral
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var boolean
     */
    private $estado;

    /**
     * @var string
     */
    private $descripcion;
    
    /**
     * @var float
     */
    private $sueldoMinimo;

    /**
     * Set if
     *
     * @param integer $id
     *
     * @return RegimenLaboral
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return RegimenLaboral
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
     * @return RegimenLaboral
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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return RegimenLaboral
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    
    /**
     * Set sueldoMinimo
     *
     * @param float $sueldoMinimo
     *
     * @return RegimenLaboral
     */
    public function setSueldoMinimo($sueldoMinimo)
    {
        $this->sueldoMinimo = $sueldoMinimo;

        return $this;
    }

    /**
     * Get sueldoMinimo
     *
     * @return float
     */
    public function getSueldoMinimo()
    {
        return $this->sueldoMinimo;
    }
}
