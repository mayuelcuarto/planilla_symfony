<?php

namespace PlanillaBundle\Entity;

/**
 * PlanillaAuditoria
 */
class PlanillaAuditoria
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $planillaId;

    /**
     * @var \DateTime
     */
    private $fecha;

    /**
     * @var string
     */
    private $detalle;


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
     * Set planillaId
     *
     * @param integer $planillaId
     *
     * @return PlanillaAuditoria
     */
    public function setPlanillaId($planillaId)
    {
        $this->planillaId = $planillaId;

        return $this;
    }

    /**
     * Get planillaId
     *
     * @return integer
     */
    public function getPlanillaId()
    {
        return $this->planillaId;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return PlanillaAuditoria
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set detalle
     *
     * @param string $detalle
     *
     * @return PlanillaAuditoria
     */
    public function setDetalle($detalle)
    {
        $this->detalle = $detalle;

        return $this;
    }

    /**
     * Get detalle
     *
     * @return string
     */
    public function getDetalle()
    {
        return $this->detalle;
    }
}

