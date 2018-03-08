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
    private $grupoOcupacional;

    /**
     * @var string
     */
    private $categoriaOcupacional;

    /**
     * @var string
     */
    private $secFunc;

    /**
     * @var string
     */
    private $estado = 'A';

    /**
     * @var string
     */
    private $especifica;


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
     * Set grupoOcupacional
     *
     * @param string $grupoOcupacional
     *
     * @return Plaza
     */
    public function setGrupoOcupacional($grupoOcupacional)
    {
        $this->grupoOcupacional = $grupoOcupacional;

        return $this;
    }

    /**
     * Get grupoOcupacional
     *
     * @return string
     */
    public function getGrupoOcupacional()
    {
        return $this->grupoOcupacional;
    }

    /**
     * Set categoriaOcupacional
     *
     * @param string $categoriaOcupacional
     *
     * @return Plaza
     */
    public function setCategoriaOcupacional($categoriaOcupacional)
    {
        $this->categoriaOcupacional = $categoriaOcupacional;

        return $this;
    }

    /**
     * Get categoriaOcupacional
     *
     * @return string
     */
    public function getCategoriaOcupacional()
    {
        return $this->categoriaOcupacional;
    }

    /**
     * Set secFunc
     *
     * @param string $secFunc
     *
     * @return Plaza
     */
    public function setSecFunc($secFunc)
    {
        $this->secFunc = $secFunc;

        return $this;
    }

    /**
     * Get secFunc
     *
     * @return string
     */
    public function getSecFunc()
    {
        return $this->secFunc;
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
}
