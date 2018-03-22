<?php

namespace PlanillaBundle\Entity;

/**
 * Meta
 */
class Meta
{
    /**
     * @var string
     */
    private $secFunc;

    /**
     * @var string
     */
    private $programa;

    /**
     * @var string
     */
    private $producto;

    /**
     * @var string
     */
    private $actProy;

    /**
     * @var string
     */
    private $funcion;

    /**
     * @var string
     */
    private $divfunc;

    /**
     * @var string
     */
    private $grpf;

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
     * @var string
     */
    private $direccion;

    /**
     * @var boolean
     */
    private $estado = '1';

    /**
     * @var \PlanillaBundle\Entity\Ejecutora
     */
    private $ejecutora;

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
        return $this->meta ." - ".$this->nombre;
    }    

    /**
     * Get secFunc
     *
     * @return string
     */
    public function getSecFunc()
    {
        return $this->secFunc;
    }

    /**
     * Set programa
     *
     * @param string $programa
     *
     * @return Meta
     */
    public function setPrograma($programa)
    {
        $this->programa = $programa;

        return $this;
    }

    /**
     * Get programa
     *
     * @return string
     */
    public function getPrograma()
    {
        return $this->programa;
    }

    /**
     * Set producto
     *
     * @param string $producto
     *
     * @return Meta
     */
    public function setProducto($producto)
    {
        $this->producto = $producto;

        return $this;
    }

    /**
     * Get producto
     *
     * @return string
     */
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * Set actProy
     *
     * @param string $actProy
     *
     * @return Meta
     */
    public function setActProy($actProy)
    {
        $this->actProy = $actProy;

        return $this;
    }

    /**
     * Get actProy
     *
     * @return string
     */
    public function getActProy()
    {
        return $this->actProy;
    }

    /**
     * Set funcion
     *
     * @param string $funcion
     *
     * @return Meta
     */
    public function setFuncion($funcion)
    {
        $this->funcion = $funcion;

        return $this;
    }

    /**
     * Get funcion
     *
     * @return string
     */
    public function getFuncion()
    {
        return $this->funcion;
    }

    /**
     * Set divfunc
     *
     * @param string $divfunc
     *
     * @return Meta
     */
    public function setDivfunc($divfunc)
    {
        $this->divfunc = $divfunc;

        return $this;
    }

    /**
     * Get divfunc
     *
     * @return string
     */
    public function getDivfunc()
    {
        return $this->divfunc;
    }

    /**
     * Set grpf
     *
     * @param string $grpf
     *
     * @return Meta
     */
    public function setGrpf($grpf)
    {
        $this->grpf = $grpf;

        return $this;
    }

    /**
     * Get grpf
     *
     * @return string
     */
    public function getGrpf()
    {
        return $this->grpf;
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
     * Set direccion
     *
     * @param string $direccion
     *
     * @return Meta
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
}
