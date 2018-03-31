<?php

namespace PlanillaBundle\Entity;

/**
 * Meta
 */
class Meta
{
    /**
     * @var integer
     */
    private $secFunc;

    /**
     * @var string
     */
    private $meta;

    /**
     * @var string
     */
    private $finalidad;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var boolean
     */
    private $estado;

    /**
     * @var \PlanillaBundle\Entity\ActProy
     */
    private $actProy;

    /**
     * @var \PlanillaBundle\Entity\Divfunc
     */
    private $divfunc;

    /**
     * @var \PlanillaBundle\Entity\Ejecutora
     */
    private $ejecutora;

    /**
     * @var \PlanillaBundle\Entity\Funcion
     */
    private $funcion;

    /**
     * @var \PlanillaBundle\Entity\Grpf
     */
    private $grpf;

    /**
     * @var \PlanillaBundle\Entity\Producto
     */
    private $producto;

    /**
     * @var \PlanillaBundle\Entity\Programa
     */
    private $programa;

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
        return $this->getEjecutora()->getPliego()->getSector()->getAnoEje()." - ".$this->meta." ".$this->nombre;
    } 

    /**
     * Get secFunc
     *
     * @return integer
     */
    public function getSecFunc()
    {
        return $this->secFunc;
    }

    /**
     * Set meta
     *
     * @param string $meta
     *
     * @return Meta
     */
    public function setMeta($meta)
    {
        $this->meta = $meta;

        return $this;
    }

    /**
     * Get meta
     *
     * @return string
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * Set finalidad
     *
     * @param string $finalidad
     *
     * @return Meta
     */
    public function setFinalidad($finalidad)
    {
        $this->finalidad = $finalidad;

        return $this;
    }

    /**
     * Get finalidad
     *
     * @return string
     */
    public function getFinalidad()
    {
        return $this->finalidad;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Meta
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
     * @return Meta
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
     * Set actProy
     *
     * @param \PlanillaBundle\Entity\ActProy $actProy
     *
     * @return Meta
     */
    public function setActProy(\PlanillaBundle\Entity\ActProy $actProy = null)
    {
        $this->actProy = $actProy;

        return $this;
    }

    /**
     * Get actProy
     *
     * @return \PlanillaBundle\Entity\ActProy
     */
    public function getActProy()
    {
        return $this->actProy;
    }

    /**
     * Set divfunc
     *
     * @param \PlanillaBundle\Entity\Divfunc $divfunc
     *
     * @return Meta
     */
    public function setDivfunc(\PlanillaBundle\Entity\Divfunc $divfunc = null)
    {
        $this->divfunc = $divfunc;

        return $this;
    }

    /**
     * Get divfunc
     *
     * @return \PlanillaBundle\Entity\Divfunc
     */
    public function getDivfunc()
    {
        return $this->divfunc;
    }

    /**
     * Set ejecutora
     *
     * @param \PlanillaBundle\Entity\Ejecutora $ejecutora
     *
     * @return Meta
     */
    public function setEjecutora(\PlanillaBundle\Entity\Ejecutora $ejecutora = null)
    {
        $this->ejecutora = $ejecutora;

        return $this;
    }

    /**
     * Get ejecutora
     *
     * @return \PlanillaBundle\Entity\Ejecutora
     */
    public function getEjecutora()
    {
        return $this->ejecutora;
    }

    /**
     * Set funcion
     *
     * @param \PlanillaBundle\Entity\Funcion $funcion
     *
     * @return Meta
     */
    public function setFuncion(\PlanillaBundle\Entity\Funcion $funcion = null)
    {
        $this->funcion = $funcion;

        return $this;
    }

    /**
     * Get funcion
     *
     * @return \PlanillaBundle\Entity\Funcion
     */
    public function getFuncion()
    {
        return $this->funcion;
    }

    /**
     * Set grpf
     *
     * @param \PlanillaBundle\Entity\Grpf $grpf
     *
     * @return Meta
     */
    public function setGrpf(\PlanillaBundle\Entity\Grpf $grpf = null)
    {
        $this->grpf = $grpf;

        return $this;
    }

    /**
     * Get grpf
     *
     * @return \PlanillaBundle\Entity\Grpf
     */
    public function getGrpf()
    {
        return $this->grpf;
    }

    /**
     * Set producto
     *
     * @param \PlanillaBundle\Entity\Producto $producto
     *
     * @return Meta
     */
    public function setProducto(\PlanillaBundle\Entity\Producto $producto = null)
    {
        $this->producto = $producto;

        return $this;
    }

    /**
     * Get producto
     *
     * @return \PlanillaBundle\Entity\Producto
     */
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * Set programa
     *
     * @param \PlanillaBundle\Entity\Programa $programa
     *
     * @return Meta
     */
    public function setPrograma(\PlanillaBundle\Entity\Programa $programa = null)
    {
        $this->programa = $programa;

        return $this;
    }

    /**
     * Get programa
     *
     * @return \PlanillaBundle\Entity\Programa
     */
    public function getPrograma()
    {
        return $this->programa;
    }
}
