<?php

namespace PlanillaBundle\Entity;

/**
 * Funcion
 */
class Funcion
{
    /**
     * @var integer
     */
    private $anoEje;

    /**
     * @var string
     */
    private $funcion;

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
     * @return Funcion
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
     * Set funcion
     *
     * @param string $funcion
     *
     * @return Funcion
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Funcion
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
     * @return Funcion
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
     * @return Funcion
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
     * @return Funcion
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
