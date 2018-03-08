<?php

namespace PlanillaBundle\Entity;

/**
 * Producto
 */
class Producto
{
    /**
     * @var integer
     */
    private $anoEje;

    /**
     * @var string
     */
    private $producto;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $estado;

    /**
     * @var string
     */
    private $ambito;

    /**
     * @var string
     */
    private $esPresupu;


    /**
     * Set anoEje
     *
     * @param integer $anoEje
     *
     * @return Producto
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
     * Set producto
     *
     * @param string $producto
     *
     * @return Producto
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Producto
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
     * @return Producto
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

    /**
     * Set ambito
     *
     * @param string $ambito
     *
     * @return Producto
     */
    public function setAmbito($ambito)
    {
        $this->ambito = $ambito;

        return $this;
    }

    /**
     * Get ambito
     *
     * @return string
     */
    public function getAmbito()
    {
        return $this->ambito;
    }

    /**
     * Set esPresupu
     *
     * @param string $esPresupu
     *
     * @return Producto
     */
    public function setEsPresupu($esPresupu)
    {
        $this->esPresupu = $esPresupu;

        return $this;
    }

    /**
     * Get esPresupu
     *
     * @return string
     */
    public function getEsPresupu()
    {
        return $this->esPresupu;
    }
}
