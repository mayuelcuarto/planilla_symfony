<?php

namespace PlanillaBundle\Entity;

/**
 * Usuario
 */
class Usuario
{
    /**
     * @var string
     */
    private $dni;

    /**
     * @var string
     */
    private $apellidos;

    /**
     * @var string
     */
    private $nombres;

    /**
     * @var string
     */
    private $cargo;

    /**
     * @var string
     */
    private $nick;

    /**
     * @var string
     */
    private $clave;

    /**
     * @var boolean
     */
    private $estado = '1';

    /**
     * @var string
     */
    private $claveapi;

    /**
     * @var \PlanillaBundle\Entity\Nivel
     */
    private $nivel;


    /**
     * Get dni
     *
     * @return string
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Set apellidos
     *
     * @param string $apellidos
     *
     * @return Usuario
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set nombres
     *
     * @param string $nombres
     *
     * @return Usuario
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;

        return $this;
    }

    /**
     * Get nombres
     *
     * @return string
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * Set cargo
     *
     * @param string $cargo
     *
     * @return Usuario
     */
    public function setCargo($cargo)
    {
        $this->cargo = $cargo;

        return $this;
    }

    /**
     * Get cargo
     *
     * @return string
     */
    public function getCargo()
    {
        return $this->cargo;
    }

    /**
     * Set nick
     *
     * @param string $nick
     *
     * @return Usuario
     */
    public function setNick($nick)
    {
        $this->nick = $nick;

        return $this;
    }

    /**
     * Get nick
     *
     * @return string
     */
    public function getNick()
    {
        return $this->nick;
    }

    /**
     * Set clave
     *
     * @param string $clave
     *
     * @return Usuario
     */
    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }

    /**
     * Get clave
     *
     * @return string
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return Usuario
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
     * Set claveapi
     *
     * @param string $claveapi
     *
     * @return Usuario
     */
    public function setClaveapi($claveapi)
    {
        $this->claveapi = $claveapi;

        return $this;
    }

    /**
     * Get claveapi
     *
     * @return string
     */
    public function getClaveapi()
    {
        return $this->claveapi;
    }

    /**
     * Set nivel
     *
     * @param \PlanillaBundle\Entity\Nivel $nivel
     *
     * @return Usuario
     */
    public function setNivel(\PlanillaBundle\Entity\Nivel $nivel = null)
    {
        $this->nivel = $nivel;

        return $this;
    }

    /**
     * Get nivel
     *
     * @return \PlanillaBundle\Entity\Nivel
     */
    public function getNivel()
    {
        return $this->nivel;
    }
}
