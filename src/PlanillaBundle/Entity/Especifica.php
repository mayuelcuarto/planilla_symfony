<?php

namespace PlanillaBundle\Entity;

/**
 * Especifica
 */
class Especifica
{
    /**
     * @var integer
     */
    private $anoEje;

    /**
     * @var string
     */
    private $especifica;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $estado;


    /**
     * Set anoEje
     *
     * @param integer $anoEje
     *
     * @return Especifica
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
     * Set especifica
     *
     * @param string $especifica
     *
     * @return Especifica
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Especifica
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
     * @param string $estado
     *
     * @return Especifica
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
}
