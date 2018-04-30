<?php

namespace PlanillaBundle\Entity;

/**
 * GrupoOcupacional
 */
class GrupoOcupacional
{
    /**
     * @var string
     */
    private $grupoOcupacional;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var boolean
     */
    private $estado;

    /**
     * Set grupoOcupacional
     *
     * @param integer $grupoOcupacional
     *
     * @return GrupoOcupacional
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return GrupoOcupacional
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
     * @return GrupoOcupacional
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
