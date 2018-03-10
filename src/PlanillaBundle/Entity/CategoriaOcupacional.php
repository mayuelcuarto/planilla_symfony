<?php

namespace PlanillaBundle\Entity;

/**
 * CategoriaOcupacional
 */
class CategoriaOcupacional
{
    /**
     * @var string
     */
    private $categoriaOcupacional;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $sinCatego;

    /**
     * @var string
     */
    private $estado;

    /**
     * @var string
     */
    private $abreviatura;

    /**
     * @var \PlanillaBundle\Entity\GrupoOcupacional
     */
    private $grupoOcupacional;


    /**
     * Set categoriaOcupacional
     *
     * @param string $categoriaOcupacional
     *
     * @return CategoriaOcupacional
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CategoriaOcupacional
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
     * Set sinCatego
     *
     * @param string $sinCatego
     *
     * @return CategoriaOcupacional
     */
    public function setSinCatego($sinCatego)
    {
        $this->sinCatego = $sinCatego;

        return $this;
    }

    /**
     * Get sinCatego
     *
     * @return string
     */
    public function getSinCatego()
    {
        return $this->sinCatego;
    }

    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return CategoriaOcupacional
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
     * Set abreviatura
     *
     * @param string $abreviatura
     *
     * @return CategoriaOcupacional
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
     * Set grupoOcupacional
     *
     * @param \PlanillaBundle\Entity\GrupoOcupacional $grupoOcupacional
     *
     * @return CategoriaOcupacional
     */
    public function setGrupoOcupacional(\PlanillaBundle\Entity\GrupoOcupacional $grupoOcupacional = null)
    {
        $this->grupoOcupacional = $grupoOcupacional;

        return $this;
    }

    /**
     * Get grupoOcupacional
     *
     * @return \PlanillaBundle\Entity\GrupoOcupacional
     */
    public function getGrupoOcupacional()
    {
        return $this->grupoOcupacional;
    }
}

