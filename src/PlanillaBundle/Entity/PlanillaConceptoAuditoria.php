<?php

namespace PlanillaBundle\Entity;

/**
 * PlanillaConceptoAuditoria
 */
class PlanillaConceptoAuditoria
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $planillaConceptoId;

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
     * Set planillaConceptoId
     *
     * @param integer $planillaConceptoId
     *
     * @return PlanillaConceptoAuditoria
     */
    public function setPlanillaConceptoId($planillaConceptoId)
    {
        $this->planillaConceptoId = $planillaConceptoId;

        return $this;
    }

    /**
     * Get planillaConceptoId
     *
     * @return integer
     */
    public function getPlanillaConceptoId()
    {
        return $this->planillaConceptoId;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return PlanillaConceptoAuditoria
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
     * @return PlanillaConceptoAuditoria
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

