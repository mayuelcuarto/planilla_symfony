<?php

namespace PlanillaBundle\Entity;

/**
 * Pliego
 */
class Pliego
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $pliego;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $estado;

    /**
     * @var string
     */
    private $regional;

    /**
     * @var \PlanillaBundle\Entity\Sector
     */
    private $anoEje;


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
     * Set pliego
     *
     * @param string $pliego
     *
     * @return Pliego
     */
    public function setPliego($pliego)
    {
        $this->pliego = $pliego;

        return $this;
    }

    /**
     * Get pliego
     *
     * @return string
     */
    public function getPliego()
    {
        return $this->pliego;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Pliego
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
     * @return Pliego
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
     * Set regional
     *
     * @param string $regional
     *
     * @return Pliego
     */
    public function setRegional($regional)
    {
        $this->regional = $regional;

        return $this;
    }

    /**
     * Get regional
     *
     * @return string
     */
    public function getRegional()
    {
        return $this->regional;
    }

    /**
     * Set anoEje
     *
     * @param \PlanillaBundle\Entity\Sector $anoEje
     *
     * @return Pliego
     */
    public function setAnoEje(\PlanillaBundle\Entity\Sector $anoEje = null)
    {
        $this->anoEje = $anoEje;

        return $this;
    }

    /**
     * Get anoEje
     *
     * @return \PlanillaBundle\Entity\Sector
     */
    public function getAnoEje()
    {
        return $this->anoEje;
    }
}

