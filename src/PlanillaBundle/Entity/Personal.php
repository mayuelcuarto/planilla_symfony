<?php

namespace PlanillaBundle\Entity;

/**
 * Personal
 */
class Personal
{
    /**
     * @var integer
     */
    private $codPersonal;

    /**
     * @var string
     */
    private $apellidoPaterno;

    /**
     * @var string
     */
    private $apellidoMaterno;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $anexo;

    /**
     * @var \DateTime
     */
    private $fechaNacimiento;

    /**
     * @var string
     */
    private $tipoDoc;

    /**
     * @var string
     */
    private $numeroDocumento;

    /**
     * @var string
     */
    private $sexo;

    /**
     * @var string
     */
    private $cuspp;

    /**
     * @var string
     */
    private $numAutogenerado;

    /**
     * @var boolean
     */
    private $estado;


    /**
     * Get codPersonal
     *
     * @return integer
     */
    public function getCodPersonal()
    {
        return $this->codPersonal;
    }

    /**
     * Set apellidoPaterno
     *
     * @param string $apellidoPaterno
     *
     * @return Personal
     */
    public function setApellidoPaterno($apellidoPaterno)
    {
        $this->apellidoPaterno = $apellidoPaterno;

        return $this;
    }

    /**
     * Get apellidoPaterno
     *
     * @return string
     */
    public function getApellidoPaterno()
    {
        return $this->apellidoPaterno;
    }

    /**
     * Set apellidoMaterno
     *
     * @param string $apellidoMaterno
     *
     * @return Personal
     */
    public function setApellidoMaterno($apellidoMaterno)
    {
        $this->apellidoMaterno = $apellidoMaterno;

        return $this;
    }

    /**
     * Get apellidoMaterno
     *
     * @return string
     */
    public function getApellidoMaterno()
    {
        return $this->apellidoMaterno;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Personal
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
     * Set anexo
     *
     * @param string $anexo
     *
     * @return Personal
     */
    public function setAnexo($anexo)
    {
        $this->anexo = $anexo;

        return $this;
    }

    /**
     * Get anexo
     *
     * @return string
     */
    public function getAnexo()
    {
        return $this->anexo;
    }

    /**
     * Set fechaNacimiento
     *
     * @param \DateTime $fechaNacimiento
     *
     * @return Personal
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    /**
     * Get fechaNacimiento
     *
     * @return \DateTime
     */
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    /**
     * Set tipoDoc
     *
     * @param string $tipoDoc
     *
     * @return Personal
     */
    public function setTipoDoc($tipoDoc)
    {
        $this->tipoDoc = $tipoDoc;

        return $this;
    }

    /**
     * Get tipoDoc
     *
     * @return string
     */
    public function getTipoDoc()
    {
        return $this->tipoDoc;
    }

    /**
     * Set numeroDocumento
     *
     * @param string $numeroDocumento
     *
     * @return Personal
     */
    public function setNumeroDocumento($numeroDocumento)
    {
        $this->numeroDocumento = $numeroDocumento;

        return $this;
    }

    /**
     * Get numeroDocumento
     *
     * @return string
     */
    public function getNumeroDocumento()
    {
        return $this->numeroDocumento;
    }

    /**
     * Set sexo
     *
     * @param string $sexo
     *
     * @return Personal
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;

        return $this;
    }

    /**
     * Get sexo
     *
     * @return string
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * Set cuspp
     *
     * @param string $cuspp
     *
     * @return Personal
     */
    public function setCuspp($cuspp)
    {
        $this->cuspp = $cuspp;

        return $this;
    }

    /**
     * Get cuspp
     *
     * @return string
     */
    public function getCuspp()
    {
        return $this->cuspp;
    }

    /**
     * Set numAutogenerado
     *
     * @param string $numAutogenerado
     *
     * @return Personal
     */
    public function setNumAutogenerado($numAutogenerado)
    {
        $this->numAutogenerado = $numAutogenerado;

        return $this;
    }

    /**
     * Get numAutogenerado
     *
     * @return string
     */
    public function getNumAutogenerado()
    {
        return $this->numAutogenerado;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return Personal
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
}

