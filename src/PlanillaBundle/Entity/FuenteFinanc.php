<?php

namespace PlanillaBundle\Entity;

/**
 * FuenteFinanc
 */
class FuenteFinanc
{
    /**
     * @var integer
     */
    private $anoEje;

    /**
     * @var string
     */
    private $fuenteFinanc;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $origen;

    /**
     * @var string
     */
    private $estado;


    /**
     * Set anoEje
     *
     * @param integer $anoEje
     *
     * @return FuenteFinanc
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
     * Set fuenteFinanc
     *
     * @param string $fuenteFinanc
     *
     * @return FuenteFinanc
     */
    public function setFuenteFinanc($fuenteFinanc)
    {
        $this->fuenteFinanc = $fuenteFinanc;

        return $this;
    }

    /**
     * Get fuenteFinanc
     *
     * @return string
     */
    public function getFuenteFinanc()
    {
        return $this->fuenteFinanc;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return FuenteFinanc
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
     * Set origen
     *
     * @param string $origen
     *
     * @return FuenteFinanc
     */
    public function setOrigen($origen)
    {
        $this->origen = $origen;

        return $this;
    }

    /**
     * Get origen
     *
     * @return string
     */
    public function getOrigen()
    {
        return $this->origen;
    }

    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return FuenteFinanc
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

