<?php

namespace PlanillaBundle\Entity;

/**
 * ActProy
 */
class ActProy
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $anoEje;

    /**
     * @var string
     */
    private $actProy;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var boolean
     */
    private $estado;

    /**
     * @var boolean
     */
    private $esPresupu;

    /**
     * @var string
     */
    private $cadena;
    
    /**
     * Get cadena
     *
     * @return string
     */
    public function getCadena()
    {
        return $this->getAnoEje() ." - ".$this->nombre;
    } 

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
     * @return ActProy
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
     * Set actProy
     *
     * @param string $actProy
     *
     * @return ActProy
     */
    public function setActProy($actProy)
    {
        $this->actProy = $actProy;

        return $this;
    }

    /**
     * Get actProy
     *
     * @return string
     */
    public function getActProy()
    {
        return $this->actProy;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return ActProy
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
     * @return ActProy
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
     * Set esPresupu
     *
     * @param boolean $esPresupu
     *
     * @return ActProy
     */
    public function setEsPresupu($esPresupu)
    {
        $this->esPresupu = $esPresupu;

        return $this;
    }

    /**
     * Get esPresupu
     *
     * @return boolean
     */
    public function getEsPresupu()
    {
        return $this->esPresupu;
    }
}
