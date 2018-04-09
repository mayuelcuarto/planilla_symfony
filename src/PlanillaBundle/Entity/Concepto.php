<?php

namespace PlanillaBundle\Entity;

/**
 * Concepto
 */
class Concepto
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $concepto;

    /**
     * @var string
     */
    private $abreviatura;

    /**
     * @var string
     */
    private $formaMonto;

    /**
     * @var boolean
     */
    private $estado;

    /**
     * @var boolean
     */
    private $esActivo;

    /**
     * @var boolean
     */
    private $esPension;

    /**
     * @var boolean
     */
    private $esPatronal;

    /**
     * @var boolean
     */
    private $esAsegurada;

    /**
     * @var boolean
     */
    private $esAfp;

    /**
     * @var string
     */
    private $mcppConcepto;

    /**
     * @var \PlanillaBundle\Entity\TipoConcepto
     */
    private $tipoConcepto;


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
     * Set concepto
     *
     * @param string $concepto
     *
     * @return Concepto
     */
    public function setConcepto($concepto)
    {
        $this->concepto = $concepto;

        return $this;
    }

    /**
     * Get concepto
     *
     * @return string
     */
    public function getConcepto()
    {
        return $this->concepto;
    }

    /**
     * Set abreviatura
     *
     * @param string $abreviatura
     *
     * @return Concepto
     */
    public function setAbreviatura($abreviatura)
    {
        $this->abreviatura = $abreviatura;

        return $this;
    }

    /**
     * Get abreviatura
     *
     * @return string
     */
    public function getAbreviatura()
    {
        return $this->abreviatura;
    }

    /**
     * Set formaMonto
     *
     * @param string $formaMonto
     *
     * @return Concepto
     */
    public function setFormaMonto($formaMonto)
    {
        $this->formaMonto = $formaMonto;

        return $this;
    }

    /**
     * Get formaMonto
     *
     * @return string
     */
    public function getFormaMonto()
    {
        return $this->formaMonto;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return Concepto
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
     * Set esActivo
     *
     * @param boolean $esActivo
     *
     * @return Concepto
     */
    public function setEsActivo($esActivo)
    {
        $this->esActivo = $esActivo;

        return $this;
    }

    /**
     * Get esActivo
     *
     * @return boolean
     */
    public function getEsActivo()
    {
        return $this->esActivo;
    }

    /**
     * Set esPension
     *
     * @param boolean $esPension
     *
     * @return Concepto
     */
    public function setEsPension($esPension)
    {
        $this->esPension = $esPension;

        return $this;
    }

    /**
     * Get esPension
     *
     * @return boolean
     */
    public function getEsPension()
    {
        return $this->esPension;
    }

    /**
     * Set esPatronal
     *
     * @param boolean $esPatronal
     *
     * @return Concepto
     */
    public function setEsPatronal($esPatronal)
    {
        $this->esPatronal = $esPatronal;

        return $this;
    }

    /**
     * Get esPatronal
     *
     * @return boolean
     */
    public function getEsPatronal()
    {
        return $this->esPatronal;
    }

    /**
     * Set esAsegurada
     *
     * @param boolean $esAsegurada
     *
     * @return Concepto
     */
    public function setEsAsegurada($esAsegurada)
    {
        $this->esAsegurada = $esAsegurada;

        return $this;
    }

    /**
     * Get esAsegurada
     *
     * @return boolean
     */
    public function getEsAsegurada()
    {
        return $this->esAsegurada;
    }

    /**
     * Set esAfp
     *
     * @param boolean $esAfp
     *
     * @return Concepto
     */
    public function setEsAfp($esAfp)
    {
        $this->esAfp = $esAfp;

        return $this;
    }

    /**
     * Get esAfp
     *
     * @return boolean
     */
    public function getEsAfp()
    {
        return $this->esAfp;
    }

    /**
     * Set mcppConcepto
     *
     * @param string $mcppConcepto
     *
     * @return Concepto
     */
    public function setMcppConcepto($mcppConcepto)
    {
        $this->mcppConcepto = $mcppConcepto;

        return $this;
    }

    /**
     * Get mcppConcepto
     *
     * @return string
     */
    public function getMcppConcepto()
    {
        return $this->mcppConcepto;
    }

    /**
     * Set tipoConcepto
     *
     * @param \PlanillaBundle\Entity\TipoConcepto $tipoConcepto
     *
     * @return Concepto
     */
    public function setTipoConcepto(\PlanillaBundle\Entity\TipoConcepto $tipoConcepto = null)
    {
        $this->tipoConcepto = $tipoConcepto;

        return $this;
    }

    /**
     * Get tipoConcepto
     *
     * @return \PlanillaBundle\Entity\TipoConcepto
     */
    public function getTipoConcepto()
    {
        return $this->tipoConcepto;
    }
}
