<?php

namespace PlanillaBundle\Entity;

/**
 * Plaza
 */
class Plaza
{
    /**
     * @var string
     */
    private $tipoPlanilla;

    /**
     * @var string
     */
    private $numPlaza;

    /**
     * @var string
     */
    private $estado = 'A';

    /**
     * @var string
     */
    private $especifica;

    /**
     * @var \PlanillaBundle\Entity\CategoriaOcupacional
     */
    private $grupoOcupacional;

    /**
     * @var \PlanillaBundle\Entity\Meta
     */
    private $secFunc;


    /**
     * Set tipoPlanilla
     *
     * @param string $tipoPlanilla
     *
     * @return Plaza
     */
    public function setTipoPlanilla($tipoPlanilla)
    {
        $this->tipoPlanilla = $tipoPlanilla;

        return $this;
    }

    /**
     * Get tipoPlanilla
     *
     * @return string
     */
    public function getTipoPlanilla()
    {
        return $this->tipoPlanilla;
    }

    /**
     * Set numPlaza
     *
     * @param string $numPlaza
     *
     * @return Plaza
     */
    public function setNumPlaza($numPlaza)
    {
        $this->numPlaza = $numPlaza;

        return $this;
    }

    /**
     * Get numPlaza
     *
     * @return string
     */
    public function getNumPlaza()
    {
        return $this->numPlaza;
    }

    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return Plaza
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
     * Set especifica
     *
     * @param string $especifica
     *
     * @return Plaza
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
     * Set grupoOcupacional
     *
     * @param \PlanillaBundle\Entity\CategoriaOcupacional $grupoOcupacional
     *
     * @return Plaza
     */
    public function setGrupoOcupacional(\PlanillaBundle\Entity\CategoriaOcupacional $grupoOcupacional = null)
    {
        $this->grupoOcupacional = $grupoOcupacional;

        return $this;
    }

    /**
     * Get grupoOcupacional
     *
     * @return \PlanillaBundle\Entity\CategoriaOcupacional
     */
    public function getGrupoOcupacional()
    {
        return $this->grupoOcupacional;
    }

    /**
     * Set secFunc
     *
     * @param \PlanillaBundle\Entity\Meta $secFunc
     *
     * @return Plaza
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
}

