<?php

namespace PlanillaBundle\Entity;

/**
 * Planilla
 */
class Planilla
{
    /**
     * @var integer
     */
    private $id = '0';

    /**
     * @var integer
     */
    private $anoEje;

    /**
     * @var integer
     */
    private $mesEje;

    /**
     * @var \DateTime
     */
    private $fechaPago;

    /**
     * @var \DateTime
     */
    private $fechaGeneracion;

    /**
     * @var string
     */
    private $nota;

    /**
     * @var float
     */
    private $remAseg;

    /**
     * @var float
     */
    private $remNoaseg;

    /**
     * @var float
     */
    private $totalEgreso;

    /**
     * @var string
     */
    private $estado;

    /**
     * @var string
     */
    private $fuenteFinanc;

    /**
     * @var string
     */
    private $especifica;

    /**
     * @var float
     */
    private $patronal = '0';

    /**
     * @var \DateTime
     */
    private $fechaIng;

    /**
     * @var integer
     */
    private $tardanzas;

    /**
     * @var integer
     */
    private $particulares;

    /**
     * @var integer
     */
    private $lsgh;

    /**
     * @var integer
     */
    private $faltas;

    /**
     * @var \PlanillaBundle\Entity\Meta
     */
    private $secFunc;

    /**
     * @var \PlanillaBundle\Entity\PlazaHistorial
     */
    private $plazaHistorial;

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
     * Set anoEje
     *
     * @param integer $anoEje
     *
     * @return Planilla
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
     * @return Planilla
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
     * Set fechaPago
     *
     * @param \DateTime $fechaPago
     *
     * @return Planilla
     */
    public function setFechaPago($fechaPago)
    {
        $this->fechaPago = $fechaPago;

        return $this;
    }

    /**
     * Get fechaPago
     *
     * @return \DateTime
     */
    public function getFechaPago()
    {
        return $this->fechaPago;
    }

    /**
     * Set fechaGeneracion
     *
     * @param \DateTime $fechaGeneracion
     *
     * @return Planilla
     */
    public function setFechaGeneracion($fechaGeneracion)
    {
        $this->fechaGeneracion = $fechaGeneracion;

        return $this;
    }

    /**
     * Get fechaGeneracion
     *
     * @return \DateTime
     */
    public function getFechaGeneracion()
    {
        return $this->fechaGeneracion;
    }

    /**
     * Set nota
     *
     * @param string $nota
     *
     * @return Planilla
     */
    public function setNota($nota)
    {
        $this->nota = $nota;

        return $this;
    }

    /**
     * Get nota
     *
     * @return string
     */
    public function getNota()
    {
        return $this->nota;
    }

    /**
     * Set remAseg
     *
     * @param float $remAseg
     *
     * @return Planilla
     */
    public function setRemAseg($remAseg)
    {
        $this->remAseg = $remAseg;

        return $this;
    }

    /**
     * Get remAseg
     *
     * @return float
     */
    public function getRemAseg()
    {
        return $this->remAseg;
    }

    /**
     * Set remNoaseg
     *
     * @param float $remNoaseg
     *
     * @return Planilla
     */
    public function setRemNoaseg($remNoaseg)
    {
        $this->remNoaseg = $remNoaseg;

        return $this;
    }

    /**
     * Get remNoaseg
     *
     * @return float
     */
    public function getRemNoaseg()
    {
        return $this->remNoaseg;
    }

    /**
     * Set totalEgreso
     *
     * @param float $totalEgreso
     *
     * @return Planilla
     */
    public function setTotalEgreso($totalEgreso)
    {
        $this->totalEgreso = $totalEgreso;

        return $this;
    }

    /**
     * Get totalEgreso
     *
     * @return float
     */
    public function getTotalEgreso()
    {
        return $this->totalEgreso;
    }

    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return Planilla
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
     * Set fuenteFinanc
     *
     * @param string $fuenteFinanc
     *
     * @return Planilla
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
     * Set especifica
     *
     * @param string $especifica
     *
     * @return Planilla
     */
    public function setEspecifica($especifica)
    {
        $this->especifica = $especifica;

        return $this;
    }

    /**
     * Get especifica
     *
     * @return string
     */
    public function getEspecifica()
    {
        return $this->especifica;
    }

    /**
     * Set patronal
     *
     * @param float $patronal
     *
     * @return Planilla
     */
    public function setPatronal($patronal)
    {
        $this->patronal = $patronal;

        return $this;
    }

    /**
     * Get patronal
     *
     * @return float
     */
    public function getPatronal()
    {
        return $this->patronal;
    }

    /**
     * Set fechaIng
     *
     * @param \DateTime $fechaIng
     *
     * @return Planilla
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
     * Set tardanzas
     *
     * @param integer $tardanzas
     *
     * @return Planilla
     */
    public function setTardanzas($tardanzas)
    {
        $this->tardanzas = $tardanzas;

        return $this;
    }

    /**
     * Get tardanzas
     *
     * @return integer
     */
    public function getTardanzas()
    {
        return $this->tardanzas;
    }

    /**
     * Set particulares
     *
     * @param integer $particulares
     *
     * @return Planilla
     */
    public function setParticulares($particulares)
    {
        $this->particulares = $particulares;

        return $this;
    }

    /**
     * Get particulares
     *
     * @return integer
     */
    public function getParticulares()
    {
        return $this->particulares;
    }

    /**
     * Set lsgh
     *
     * @param integer $lsgh
     *
     * @return Planilla
     */
    public function setLsgh($lsgh)
    {
        $this->lsgh = $lsgh;

        return $this;
    }

    /**
     * Get lsgh
     *
     * @return integer
     */
    public function getLsgh()
    {
        return $this->lsgh;
    }

    /**
     * Set faltas
     *
     * @param integer $faltas
     *
     * @return Planilla
     */
    public function setFaltas($faltas)
    {
        $this->faltas = $faltas;

        return $this;
    }

    /**
     * Get faltas
     *
     * @return integer
     */
    public function getFaltas()
    {
        return $this->faltas;
    }

    /**
     * Set secFunc
     *
     * @param \PlanillaBundle\Entity\Meta $secFunc
     *
     * @return Planilla
     */
    public function setSecFunc(\PlanillaBundle\Entity\Meta $secFunc = null)
    {
        $this->secFunc = $secFunc;

        return $this;
    }

    /**
     * Get secFunc
     *
     * @return \PlanillaBundle\Entity\Meta
     */
    public function getSecFunc()
    {
        return $this->secFunc;
    }

    /**
     * Set plazaHistorial
     *
     * @param \PlanillaBundle\Entity\PlazaHistorial $plazaHistorial
     *
     * @return Planilla
     */
    public function setPlazaHistorial(\PlanillaBundle\Entity\PlazaHistorial $plazaHistorial = null)
    {
        $this->plazaHistorial = $plazaHistorial;

        return $this;
    }

    /**
     * Get plazaHistorial
     *
     * @return \PlanillaBundle\Entity\PlazaHistorial
     */
    public function getPlazaHistorial()
    {
        return $this->plazaHistorial;
    }

    /**
     * Set usuario
     *
     * @param \PlanillaBundle\Entity\Usuario $usuario
     *
     * @return Planilla
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

