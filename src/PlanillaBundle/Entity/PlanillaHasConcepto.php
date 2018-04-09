<?php

namespace PlanillaBundle\Entity;

/**
 * PlanillaHasConcepto
 */
class PlanillaHasConcepto
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var float
     */
    private $monto;

    /**
     * @var \DateTime
     */
    private $fechaIng;

    /**
     * @var \PlanillaBundle\Entity\Planilla
     */
    private $planilla;

    /**
     * @var \PlanillaBundle\Entity\Concepto
     */
    private $concepto;

    /**
     * @var \PlanillaBundle\Entity\Usuario
     */
    private $usuario;


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
     * Set monto
     *
     * @param float $monto
     *
     * @return PlanillaHasConcepto
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;

        return $this;
    }

    /**
     * Get monto
     *
     * @return float
     */
    public function getMonto()
    {
        return $this->monto;
    }

    /**
     * Set fechaIng
     *
     * @param \DateTime $fechaIng
     *
     * @return PlanillaHasConcepto
     */
    public function setFechaIng($fechaIng)
    {
        $this->fechaIng = $fechaIng;

        return $this;
    }

    /**
     * Get fechaIng
     *
     * @return \DateTime
     */
    public function getFechaIng()
    {
        return $this->fechaIng;
    }

    /**
     * Set planilla
     *
     * @param \PlanillaBundle\Entity\Planilla $planilla
     *
     * @return PlanillaHasConcepto
     */
    public function setPlanilla(\PlanillaBundle\Entity\Planilla $planilla = null)
    {
        $this->planilla = $planilla;

        return $this;
    }

    /**
     * Get planilla
     *
     * @return \PlanillaBundle\Entity\Planilla
     */
    public function getPlanilla()
    {
        return $this->planilla;
    }

    /**
     * Set concepto
     *
     * @param \PlanillaBundle\Entity\Concepto $concepto
     *
     * @return PlanillaHasConcepto
     */
    public function setConcepto(\PlanillaBundle\Entity\Concepto $concepto = null)
    {
        $this->concepto = $concepto;

        return $this;
    }

    /**
     * Get concepto
     *
     * @return \PlanillaBundle\Entity\Concepto
     */
    public function getConcepto()
    {
        return $this->concepto;
    }

    /**
     * Set usuario
     *
     * @param \PlanillaBundle\Entity\Usuario $usuario
     *
     * @return PlanillaHasConcepto
     */
    public function setUsuario(\PlanillaBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \PlanillaBundle\Entity\Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}

