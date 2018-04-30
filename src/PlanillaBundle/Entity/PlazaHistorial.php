<?php

namespace PlanillaBundle\Entity;

/**
 * PlazaHistorial
 */
class PlazaHistorial {

    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $secPersonal;

    /**
     * @var \DateTime
     */
    private $fechaIngreso;

    /**
     * @var \DateTime
     */
    private $fechaCese;

    /**
     * @var string
     */
    private $resolucion;

    /**
     * @var \DateTime
     */
    private $fechaAnulacion;

    /**
     * @var string
     */
    private $cargo;

    /**
     * @var \DateTime
     */
    private $fechaAfp;

    /**
     * @var boolean
     */
    private $estado;

    /**
     * @var string
     */
    private $docAnulacion;

    /**
     * @var boolean
     */
    private $afpMix;

    /**
     * @var \PlanillaBundle\Entity\Afp
     */
    private $afp;

    /**
     * @var \PlanillaBundle\Entity\CondicionLaboral
     */
    private $condicionLaboral;

    /**
     * @var \PlanillaBundle\Entity\ModoIngreso
     */
    private $modoIngreso;

    /**
     * @var \PlanillaBundle\Entity\MotivoAnulacion
     */
    private $motivoAnulacion;

    /**
     * @var \PlanillaBundle\Entity\Personal
     */
    private $codPersonal;

    /**
     * @var \PlanillaBundle\Entity\Plaza
     */
    private $plaza;

    /**
     * @var \PlanillaBundle\Entity\RegimenLaboral
     */
    private $regimenLaboral;

    /**
     * @var \PlanillaBundle\Entity\RegimenPensionario
     */
    private $regimenPensionario;

    /**
     * @var \PlanillaBundle\Entity\SituacionLaboral
     */
    private $situacionLaboral;

    /**
     * @var \PlanillaBundle\Entity\Unidad
     */
    private $unidad;

    /**
     * @var string
     */
    private $cadena;

    /**
     * Get cadena
     *
     * @return string
     */
    public function getCadena() {
        return $this->getCodPersonal()->getCadena();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set secPersonal
     *
     * @param integer $secPersonal
     *
     * @return PlazaHistorial
     */
    public function setSecPersonal($secPersonal) {
        $this->secPersonal = $secPersonal;

        return $this;
    }

    /**
     * Get secPersonal
     *
     * @return integer
     */
    public function getSecPersonal() {
        return $this->secPersonal;
    }

    /**
     * Set fechaIngreso
     *
     * @param \DateTime $fechaIngreso
     *
     * @return PlazaHistorial
     */
    public function setFechaIngreso($fechaIngreso) {
        $this->fechaIngreso = $fechaIngreso;

        return $this;
    }

    /**
     * Get fechaIngreso
     *
     * @return \DateTime
     */
    public function getFechaIngreso() {
        return $this->fechaIngreso;
    }

    /**
     * Set fechaCese
     *
     * @param \DateTime $fechaCese
     *
     * @return PlazaHistorial
     */
    public function setFechaCese($fechaCese) {
        $this->fechaCese = $fechaCese;

        return $this;
    }

    /**
     * Get fechaCese
     *
     * @return \DateTime
     */
    public function getFechaCese() {
        return $this->fechaCese;
    }

    /**
     * Set resolucion
     *
     * @param string $resolucion
     *
     * @return PlazaHistorial
     */
    public function setResolucion($resolucion) {
        $this->resolucion = $resolucion;

        return $this;
    }

    /**
     * Get resolucion
     *
     * @return string
     */
    public function getResolucion() {
        return $this->resolucion;
    }

    /**
     * Set fechaAnulacion
     *
     * @param \DateTime $fechaAnulacion
     *
     * @return PlazaHistorial
     */
    public function setFechaAnulacion($fechaAnulacion) {
        $this->fechaAnulacion = $fechaAnulacion;

        return $this;
    }

    /**
     * Get fechaAnulacion
     *
     * @return \DateTime
     */
    public function getFechaAnulacion() {
        return $this->fechaAnulacion;
    }

    /**
     * Set cargo
     *
     * @param string $cargo
     *
     * @return PlazaHistorial
     */
    public function setCargo($cargo) {
        $this->cargo = $cargo;

        return $this;
    }

    /**
     * Get cargo
     *
     * @return string
     */
    public function getCargo() {
        return $this->cargo;
    }

    /**
     * Set fechaAfp
     *
     * @param \DateTime $fechaAfp
     *
     * @return PlazaHistorial
     */
    public function setFechaAfp($fechaAfp) {
        $this->fechaAfp = $fechaAfp;

        return $this;
    }

    /**
     * Get fechaAfp
     *
     * @return \DateTime
     */
    public function getFechaAfp() {
        return $this->fechaAfp;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return PlazaHistorial
     */
    public function setEstado($estado) {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return boolean
     */
    public function getEstado() {
        return $this->estado;
    }

    /**
     * Set docAnulacion
     *
     * @param string $docAnulacion
     *
     * @return PlazaHistorial
     */
    public function setDocAnulacion($docAnulacion) {
        $this->docAnulacion = $docAnulacion;

        return $this;
    }

    /**
     * Get docAnulacion
     *
     * @return string
     */
    public function getDocAnulacion() {
        return $this->docAnulacion;
    }

    /**
     * Set afpMix
     *
     * @param boolean $afpMix
     *
     * @return PlazaHistorial
     */
    public function setAfpMix($afpMix) {
        $this->afpMix = $afpMix;

        return $this;
    }

    /**
     * Get afpMix
     *
     * @return boolean
     */
    public function getAfpMix() {
        return $this->afpMix;
    }

    /**
     * Set afp
     *
     * @param \PlanillaBundle\Entity\Afp $afp
     *
     * @return PlazaHistorial
     */
    public function setAfp(\PlanillaBundle\Entity\Afp $afp = null) {
        $this->afp = $afp;

        return $this;
    }

    /**
     * Get afp
     *
     * @return \PlanillaBundle\Entity\Afp
     */
    public function getAfp() {
        return $this->afp;
    }

    /**
     * Set condicionLaboral
     *
     * @param \PlanillaBundle\Entity\CondicionLaboral $condicionLaboral
     *
     * @return PlazaHistorial
     */
    public function setCondicionLaboral(\PlanillaBundle\Entity\CondicionLaboral $condicionLaboral = null) {
        $this->condicionLaboral = $condicionLaboral;

        return $this;
    }

    /**
     * Get condicionLaboral
     *
     * @return \PlanillaBundle\Entity\CondicionLaboral
     */
    public function getCondicionLaboral() {
        return $this->condicionLaboral;
    }

    /**
     * Set modoIngreso
     *
     * @param \PlanillaBundle\Entity\ModoIngreso $modoIngreso
     *
     * @return PlazaHistorial
     */
    public function setModoIngreso(\PlanillaBundle\Entity\ModoIngreso $modoIngreso = null) {
        $this->modoIngreso = $modoIngreso;

        return $this;
    }

    /**
     * Get modoIngreso
     *
     * @return \PlanillaBundle\Entity\ModoIngreso
     */
    public function getModoIngreso() {
        return $this->modoIngreso;
    }

    /**
     * Set motivoAnulacion
     *
     * @param \PlanillaBundle\Entity\MotivoAnulacion $motivoAnulacion
     *
     * @return PlazaHistorial
     */
    public function setMotivoAnulacion(\PlanillaBundle\Entity\MotivoAnulacion $motivoAnulacion = null) {
        $this->motivoAnulacion = $motivoAnulacion;

        return $this;
    }

    /**
     * Get motivoAnulacion
     *
     * @return \PlanillaBundle\Entity\MotivoAnulacion
     */
    public function getMotivoAnulacion() {
        return $this->motivoAnulacion;
    }

    /**
     * Set codPersonal
     *
     * @param \PlanillaBundle\Entity\Personal $codPersonal
     *
     * @return PlazaHistorial
     */
    public function setCodPersonal(\PlanillaBundle\Entity\Personal $codPersonal = null) {
        $this->codPersonal = $codPersonal;

        return $this;
    }

    /**
     * Get codPersonal
     *
     * @return \PlanillaBundle\Entity\Personal
     */
    public function getCodPersonal() {
        return $this->codPersonal;
    }

    /**
     * Set plaza
     *
     * @param \PlanillaBundle\Entity\Plaza $plaza
     *
     * @return PlazaHistorial
     */
    public function setPlaza(\PlanillaBundle\Entity\Plaza $plaza = null) {
        $this->plaza = $plaza;

        return $this;
    }

    /**
     * Get plaza
     *
     * @return \PlanillaBundle\Entity\Plaza
     */
    public function getPlaza() {
        return $this->plaza;
    }

    /**
     * Set regimenLaboral
     *
     * @param \PlanillaBundle\Entity\RegimenLaboral $regimenLaboral
     *
     * @return PlazaHistorial
     */
    public function setRegimenLaboral(\PlanillaBundle\Entity\RegimenLaboral $regimenLaboral = null) {
        $this->regimenLaboral = $regimenLaboral;

        return $this;
    }

    /**
     * Get regimenLaboral
     *
     * @return \PlanillaBundle\Entity\RegimenLaboral
     */
    public function getRegimenLaboral() {
        return $this->regimenLaboral;
    }

    /**
     * Set regimenPensionario
     *
     * @param \PlanillaBundle\Entity\RegimenPensionario $regimenPensionario
     *
     * @return PlazaHistorial
     */
    public function setRegimenPensionario(\PlanillaBundle\Entity\RegimenPensionario $regimenPensionario = null) {
        $this->regimenPensionario = $regimenPensionario;

        return $this;
    }

    /**
     * Get regimenPensionario
     *
     * @return \PlanillaBundle\Entity\RegimenPensionario
     */
    public function getRegimenPensionario() {
        return $this->regimenPensionario;
    }

    /**
     * Set situacionLaboral
     *
     * @param \PlanillaBundle\Entity\SituacionLaboral $situacionLaboral
     *
     * @return PlazaHistorial
     */
    public function setSituacionLaboral(\PlanillaBundle\Entity\SituacionLaboral $situacionLaboral = null) {
        $this->situacionLaboral = $situacionLaboral;

        return $this;
    }

    /**
     * Get situacionLaboral
     *
     * @return \PlanillaBundle\Entity\SituacionLaboral
     */
    public function getSituacionLaboral() {
        return $this->situacionLaboral;
    }

    /**
     * Set unidad
     *
     * @param \PlanillaBundle\Entity\Unidad $unidad
     *
     * @return PlazaHistorial
     */
    public function setUnidad(\PlanillaBundle\Entity\Unidad $unidad = null) {
        $this->unidad = $unidad;

        return $this;
    }

    /**
     * Get unidad
     *
     * @return \PlanillaBundle\Entity\Unidad
     */
    public function getUnidad() {
        return $this->unidad;
    }

}
