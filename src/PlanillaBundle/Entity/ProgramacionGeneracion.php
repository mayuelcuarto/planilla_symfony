<?php

namespace PlanillaBundle\Entity;

/**
 * ProgramacionGeneracion
 */
class ProgramacionGeneracion
{
    /**
     * @var integer
     */
    private $anoEje;

    /**
     * @var integer
     */
    private $mesEje;

    /**
     * @var string
     */
    private $secEjec;

    /**
     * @var \DateTime
     */
    private $fechaPension;

    /**
     * @var string
     */
    private $fechaActivo;


    /**
     * Set anoEje
     *
     * @param integer $anoEje
     *
     * @return ProgramacionGeneracion
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
     * Set mesEje
     *
     * @param integer $mesEje
     *
     * @return ProgramacionGeneracion
     */
    public function setMesEje($mesEje)
    {
        $this->mesEje = $mesEje;

        return $this;
    }

    /**
     * Get mesEje
     *
     * @return integer
     */
    public function getMesEje()
    {
        return $this->mesEje;
    }

    /**
     * Set secEjec
     *
     * @param string $secEjec
     *
     * @return ProgramacionGeneracion
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
     * Set fechaPension
     *
     * @param \DateTime $fechaPension
     *
     * @return ProgramacionGeneracion
     */
    public function setFechaPension($fechaPension)
    {
        $this->fechaPension = $fechaPension;

        return $this;
    }

    /**
     * Get fechaPension
     *
     * @return \DateTime
     */
    public function getFechaPension()
    {
        return $this->fechaPension;
    }

    /**
     * Set fechaActivo
     *
     * @param string $fechaActivo
     *
     * @return ProgramacionGeneracion
     */
    public function setFechaActivo($fechaActivo)
    {
        $this->fechaActivo = $fechaActivo;

        return $this;
    }

    /**
     * Get fechaActivo
     *
     * @return string
     */
    public function getFechaActivo()
    {
        return $this->fechaActivo;
    }
}
