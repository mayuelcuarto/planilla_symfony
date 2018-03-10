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
    private $tipoConcepto;

    /**
     * @var integer
     */
    private $secConcepto;

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
     * @var string
     */
    private $estado;

    /**
     * @var string
     */
    private $esActivo;

    /**
     * @var string
     */
    private $esPension;

    /**
     * @var string
     */
    private $esPatronal;

    /**
     * @var string
     */
    private $esAsegurada;

    /**
     * @var string
     */
    private $esAfp;

    /**
     * @var string
     */
    private $mcppConcepto;


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
     * Set tipoConcepto
     *
     * @param string $tipoConcepto
     *
     * @return Concepto
     */
    public function setTipoConcepto($tipoConcepto)
    {
        $this->tipoConcepto = $tipoConcepto;

        return $this;
    }

    /**
     * Get tipoConcepto
     *
     * @return string
     */
    public function getTipoConcepto()
    {
        return $this->tipoConcepto;
    }

    /**
     * Set secConcepto
     *
     * @param integer $secConcepto
     *
     * @return Concepto
     */
    public function setSecConcepto($secConcepto)
    {
        $this->secConcepto = $secConcepto;

        return $this;
    }

    /**
     * Get secConcepto
     *
     * @return integer
     */
    public function getSecConcepto()
    {
        return $this->secConcepto;
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
     * @param string $estado
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
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set esActivo
     *
     * @param string $esActivo
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
     * @return string
     */
    public function getEsActivo()
    {
        return $this->esActivo;
    }

    /**
     * Set esPension
     *
     * @param string $esPension
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
     * @return string
     */
    public function getEsPension()
    {
        return $this->esPension;
    }

    /**
     * Set esPatronal
     *
     * @param string $esPatronal
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
     * @return string
     */
    public function getEsPatronal()
    {
        return $this->esPatronal;
    }

    /**
     * Set esAsegurada
     *
     * @param string $esAsegurada
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
     * @return string
     */
    public function getEsAsegurada()
    {
        return $this->esAsegurada;
    }

    /**
     * Set esAfp
     *
     * @param string $esAfp
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
     * @return string
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
}

