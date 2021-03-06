<?php

namespace PlanillaBundle\Entity;

/**
 * Afp
 */
class Afp
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var boolean
     */
    private $estado;

    /**
     * @var float
     */
    private $snp;

    /**
     * @var float
     */
    private $jubilacion;

    /**
     * @var float
     */
    private $seguros;

    /**
     * @var float
     */
    private $ra;

    /**
     * @var float
     */
    private $pension;

    /**
     * @var float
     */
    private $raMixta;

    /**
     * @var \PlanillaBundle\Entity\RegimenPensionario
     */
    private $regimenPensionario;
    
    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Afp
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
    
    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Afp
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
     * @param boolean $estado
     *
     * @return Afp
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
     * Set snp
     *
     * @param float $snp
     *
     * @return Afp
     */
    public function setSnp($snp)
    {
        $this->snp = $snp;

        return $this;
    }

    /**
     * Get snp
     *
     * @return float
     */
    public function getSnp()
    {
        return $this->snp;
    }

    /**
     * Set jubilacion
     *
     * @param float $jubilacion
     *
     * @return Afp
     */
    public function setJubilacion($jubilacion)
    {
        $this->jubilacion = $jubilacion;

        return $this;
    }

    /**
     * Get jubilacion
     *
     * @return float
     */
    public function getJubilacion()
    {
        return $this->jubilacion;
    }

    /**
     * Set seguros
     *
     * @param float $seguros
     *
     * @return Afp
     */
    public function setSeguros($seguros)
    {
        $this->seguros = $seguros;

        return $this;
    }

    /**
     * Get seguros
     *
     * @return float
     */
    public function getSeguros()
    {
        return $this->seguros;
    }

    /**
     * Set ra
     *
     * @param float $ra
     *
     * @return Afp
     */
    public function setRa($ra)
    {
        $this->ra = $ra;

        return $this;
    }

    /**
     * Get ra
     *
     * @return float
     */
    public function getRa()
    {
        return $this->ra;
    }

    /**
     * Set pension
     *
     * @param float $pension
     *
     * @return Afp
     */
    public function setPension($pension)
    {
        $this->pension = $pension;

        return $this;
    }

    /**
     * Get pension
     *
     * @return float
     */
    public function getPension()
    {
        return $this->pension;
    }

    /**
     * Set raMixta
     *
     * @param float $raMixta
     *
     * @return Afp
     */
    public function setRaMixta($raMixta)
    {
        $this->raMixta = $raMixta;

        return $this;
    }

    /**
     * Get raMixta
     *
     * @return float
     */
    public function getRaMixta()
    {
        return $this->raMixta;
    }

    /**
     * Set regimenPensionario
     *
     * @param \PlanillaBundle\Entity\RegimenPensionario $regimenPensionario
     *
     * @return Afp
     */
    public function setRegimenPensionario(\PlanillaBundle\Entity\RegimenPensionario $regimenPensionario = null)
    {
        $this->regimenPensionario = $regimenPensionario;

        return $this;
    }

    /**
     * Get regimenPensionario
     *
     * @return \PlanillaBundle\Entity\RegimenPensionario
     */
    public function getRegimenPensionario()
    {
        return $this->regimenPensionario;
    }
}
