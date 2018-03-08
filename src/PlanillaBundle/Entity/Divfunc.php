<?php

namespace PlanillaBundle\Entity;

/**
 * Divfunc
 */
class Divfunc
{
    /**
     * @var integer
     */
    private $anoEje;

    /**
     * @var string
     */
    private $divfunc;

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
     * @return Divfunc
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
     * Set divfunc
     *
     * @param string $divfunc
     *
     * @return Divfunc
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Divfunc
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
     * @return Divfunc
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
     * @return Divfunc
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
     * @return Divfunc
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
