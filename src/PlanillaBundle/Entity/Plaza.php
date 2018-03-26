<?php

namespace PlanillaBundle\Entity;

/**
 * Plaza
 */
class Plaza
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $numPlaza;

    /**
     * @var boolean
     */
    private $estado;

    /**
     * @var \PlanillaBundle\Entity\CategoriaOcupacional
     */
    private $categoria;

    /**
     * @var \PlanillaBundle\Entity\Especifica
     */
    private $especifica;

    /**
     * @var \PlanillaBundle\Entity\Meta
     */
    private $secFunc;

    /**
     * @var \PlanillaBundle\Entity\TipoPlanilla
     */
    private $tipoPlanilla;


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
     * @param boolean $estado
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
     * @return boolean
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set categoria
     *
     * @param \PlanillaBundle\Entity\CategoriaOcupacional $categoria
     *
     * @return Plaza
     */
    public function setCategoria(\PlanillaBundle\Entity\CategoriaOcupacional $categoria = null)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return \PlanillaBundle\Entity\CategoriaOcupacional
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set especifica
     *
     * @param \PlanillaBundle\Entity\Especifica $especifica
     *
     * @return Plaza
     */
    public function setEspecifica(\PlanillaBundle\Entity\Especifica $especifica = null)
    {
        $this->especifica = $especifica;

        return $this;
    }

    /**
     * Get especifica
     *
     * @return \PlanillaBundle\Entity\Especifica
     */
    public function getEspecifica()
    {
        return $this->especifica;
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

    /**
     * Set tipoPlanilla
     *
     * @param \PlanillaBundle\Entity\TipoPlanilla $tipoPlanilla
     *
     * @return Plaza
     */
    public function setTipoPlanilla(\PlanillaBundle\Entity\TipoPlanilla $tipoPlanilla = null)
    {
        $this->tipoPlanilla = $tipoPlanilla;

        return $this;
    }

    /**
     * Get tipoPlanilla
     *
     * @return \PlanillaBundle\Entity\TipoPlanilla
     */
    public function getTipoPlanilla()
    {
        return $this->tipoPlanilla;
    }
}

