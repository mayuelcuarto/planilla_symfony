<?php

namespace PlanillaBundle\Entity;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Usuario
 */
class Usuario implements UserInterface
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
    
    protected $planilla;
    
    public function __construct() {
        $this->planilla = new ArrayCollection() ;
    }

    /**
     * Set dni
     *
     * @param string $dni
     *
     * @return Usuario
     */
    public function setDni($dni)
    {
        $this->dni = $dni;

        return $this;
    }
    
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
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $role;


    /**
     * Set password
     *
     * @param string $password
     *
     * @return Usuario
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set role
     *
     * @param string $role
     *
     * @return Usuario
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    public function eraseCredentials() {
        
    }

    public function getRoles() {
        return array($this->getRole());
    }

    public function getSalt() {
        return null;
    }

    public function getUsername() {
        return $this->nick;
    }

    /**
     * @var integer
     */
    private $id;


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
     * Add planilla
     *
     * @param \PlanillaBundle\Entity\Planilla $planilla
     *
     * @return Usuario
     */
    public function addPlanilla(\PlanillaBundle\Entity\Planilla $planilla)
    {
        $this->planilla[] = $planilla;

        return $this;
    }

    /**
     * Remove planilla
     *
     * @param \PlanillaBundle\Entity\Planilla $planilla
     */
    public function removePlanilla(\PlanillaBundle\Entity\Planilla $planilla)
    {
        $this->planilla->removeElement($planilla);
    }

    /**
     * Get planilla
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlanilla()
    {
        return $this->planilla;
    }
}
