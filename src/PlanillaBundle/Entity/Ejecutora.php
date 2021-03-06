<?php

namespace PlanillaBundle\Entity;

/**
 * Ejecutora
 */
class Ejecutora
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $secEjec;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $direccion;

    /**
     * @var string
     */
    private $ruc;

    /**
     * @var boolean
     */
    private $estado;

    /**
     * @var \PlanillaBundle\Entity\Pliego
     */
    private $pliego;

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
        return $this->getPliego()->getSector()->getAnoEje() ." - ".$this->secEjec." - ".$this->nombre;
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
     * Set secEjec
     *
     * @param string $secEjec
     *
     * @return Ejecutora
     */
    public function setSecEjec($secEjec)
    {
        $this->secEjec = $secEjec;

        return $this;
    }

    /**
     * Get secEjec
     *
     * @return string
     */
    public function getSecEjec()
    {
        return $this->secEjec;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Ejecutora
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
     * Set direccion
     *
     * @param string $direccion
     *
     * @return Ejecutora
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set ruc
     *
     * @param string $ruc
     *
     * @return Ejecutora
     */
    public function setRuc($ruc)
    {
        $this->ruc = $ruc;

        return $this;
    }

    /**
     * Get ruc
     *
     * @return string
     */
    public function getRuc()
    {
        return $this->ruc;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return Ejecutora
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
     * Set pliego
     *
     * @param \PlanillaBundle\Entity\Pliego $pliego
     *
     * @return Ejecutora
     */
    public function setPliego(\PlanillaBundle\Entity\Pliego $pliego = null)
    {
        $this->pliego = $pliego;

        return $this;
    }

    /**
     * Get pliego
     *
     * @return \PlanillaBundle\Entity\Pliego
     */
    public function getPliego()
    {
        return $this->pliego;
    }
}
