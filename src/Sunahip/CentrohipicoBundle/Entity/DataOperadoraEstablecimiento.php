<?php

namespace Sunahip\CentrohipicoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vlabs\MediaBundle\Annotation\Vlabs;

/**
 * DataOperadoraEstablecimiento
 *
 * @ORM\Table(name="data_operadora_establecimiento")
 * @ORM\Entity(repositoryClass="DataOperadoraEstablecimientoRepository")
 */
class DataOperadoraEstablecimiento
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


    /**
     * @var \SysUsuario
     *
     * @ORM\ManyToOne(targetEntity="\Sunahip\UserBundle\Entity\SysUsuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idusuario", referencedColumnName="id")
     * })
     */
    private $usuario;

    /**
     * @var \SysUsuario
     *
     * @ORM\ManyToOne(targetEntity="\Sunahip\UserBundle\Entity\SysUsuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idgerente", referencedColumnName="id")
     * })
     */
    private $gerente;

    /**
     * @var
     *
     * @ORM\Column(name="notas", type="string", nullable=true)
     */
    private $notas;


    /**
     * Establecimiento
     * @var \DataCentrohipico
     * @ORM\ManyToOne(targetEntity="\Sunahip\CentrohipicoBundle\Entity\DataCentrohipico")
     * @ORM\JoinColumn(name="idcentrohipico", referencedColumnName="id")    *
     */
    private $centroHipico;

    /**
     * Operadora
     * @var \
     * @ORM\ManyToOne(targetEntity="\Sunahip\CentrohipicoBundle\Entity\DataOperadora")
     * @ORM\JoinColumn(name="idoperadora", referencedColumnName="id")    *
     */
    private $operadora;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=45, nullable=false)
     */
    private $status;

    /**
     * @ORM\OneToOne(targetEntity="\Sunahip\CommonBundle\Entity\Media", cascade={"persist", "remove"}, orphanRemoval=true))
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="contrato_firmado", referencedColumnName="id")
     * })
     *
     * @Vlabs\Media(identifier="file_entity", upload_dir="media/operadora-establecimiento/solicitudes/")
     */
    private $contratoFirmado;

    /**
     * @ORM\OneToOne(targetEntity="\Sunahip\CommonBundle\Entity\Media", cascade={"persist", "remove"}, orphanRemoval=true))
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="buena_pro", referencedColumnName="id")
     * })
     * @Vlabs\Media(identifier="file_entity", upload_dir="media/operadora-establecimiento/solicitudes/")
     */
    private $buenaPro;
    
    /**
     * @var \AdmClasfLicencias
     *
     * @ORM\ManyToOne(targetEntity="\Sunahip\LicenciaBundle\Entity\AdmClasfLicencias")
     * @ORM\JoinColumn(name="idclasf", referencedColumnName="id")
     */
    private $clasLicencia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_solicitud", type="datetime", nullable=false)
     */
    private $fechaSolicitud;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_aprobacion", type="datetime", nullable=true)
     */
    private $fechaAprobacion;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_cancelacion", type="datetime", nullable=true)
     */
    private $fechaCancelacion;
    
    /**
     * @var string
     *
     * @ORM\Column(name="has_solicitud", type="boolean", nullable=true)
     */
    private $hasSolicitud = 0;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_actualizacion", type="datetime", nullable=true)
     */
    private $fechaActualizacion;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_desafiliacion", type="datetime", nullable=true)
     */
    private $fechaDesafiliacion;
    
    /**
     * @var \SysUsuario
     *
     * @ORM\ManyToOne(targetEntity="\Sunahip\UserBundle\Entity\SysUsuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idgerente_desafiliacion", referencedColumnName="id", nullable=true)
     * })
     */
    private $gerenteDesafiliacion;


    public function getFullrif() 
     {
        return "$this->persJuridica-$this->rif";
    }
    
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
     * Set status
     *
     * @param string $status
     * @return DataSolicitudes
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    function setOperadora(\Sunahip\CentrohipicoBundle\Entity\DataOperadora $operadora)
    {
        $this->operadora = $operadora;
    }

    function getOperadora()
    {
        return $this->operadora;
    }


    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }


    public function setContratoFirmado(\Sunahip\CommonBundle\Entity\Media $contrato = null)
    {
        $this->contratoFirmado = $contrato;
    }

    public function getContratoFirmado()
    {
        return $this->contratoFirmado;
    }

    public function setBuenaPro(\Sunahip\CommonBundle\Entity\Media $buenaPro = null)
    {
        $this->buenaPro = $buenaPro;
    }

    public function getBuenaPro()
    {
        return $this->buenaPro;
    }

    /**
     * Set fechaSolicitud
     *
     * @param \DateTime $fechaSolicitud
     * @return DataSolicitudes
     */
    public function setFechaSolicitud($fechaSolicitud)
    {
        $this->fechaSolicitud = $fechaSolicitud;

        return $this;
    }

    /**
     * Get fechaSolicitud
     *
     * @return \DateTime
     */
    public function getFechaSolicitud()
    {
        return $this->fechaSolicitud;
    }

    /**
     * Set fechaProvidencia
     *
     * @param \DateTime $fechaProvidencia
     * @return DataSolicitudes
     */
    public function setFechaProvidencia($fechaProvidencia)
    {
        $this->fechaProvidencia = $fechaProvidencia;

        return $this;
    }

    /**
     * Get fechaProvidencia
     *
     * @return \DateTime
     */
    public function getFechaProvidencia()
    {
        return $this->fechaProvidencia;
    }


    /**
     * Set fechaAprobacion
     *
     * @param \DateTime $fechaAprobacion
     * @return DataSolicitudes
     */
    public function setFechaAprobacion($fechaAprobacion)
    {
        $this->fechaAprobacion = $fechaAprobacion;

        return $this;
    }

    /**
     * Get fechaAprobacion
     *
     * @return \DateTime
     */
    public function getFechaAprobacion()
    {
        return $this->fechaAprobacion;
    }

    /**
     * Set fechaCancelacion
     * @param \DateTime $fechaCancelacion
     * @return \DateTime
     */
    public function setFechaCancelacion($fechaCancelacion)
    {
        $this->fechaCancelacion = $fechaCancelacion;

        return $this;
    }

    /**
     * Get fechaCancelacion
     *
     * @return \DateTime
     * @return \DateTime
     */
    public function getFechaCancelacion()
    {
        return $this->fechaCancelacion;
    }

    /**
     * Set usuario
     *
     * @param \Sunahip\UserBundle\Entity\SysUsuario $usuario
     * @return DataSolicitudes
     */
    public function setUsuario(\Sunahip\UserBundle\Entity\SysUsuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \Sunahip\UserBundle\Entity\SysUsuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Get Gerente
     *
     * @return \Sunahip\UserBundle\Entity\SysUsuario
     */
    public function getGerente()
    {
        return $this->gerente;
    }

    /**
     * Set usuario
     *
     * @param \Sunahip\UserBundle\Entity\SysUsuario $usuario
     * @return DataSolicitudes
     */
    public function setGerente(\Sunahip\UserBundle\Entity\SysUsuario $usuario = null)
    {
        $this->gerente = $usuario;

        return $this;
    }

    public function setNotas($notas)
    {
        $this->notas = $notas;
    }

    public function getNotas()
    {
        return $this->notas;
    }

    /**
     * Set centroHipico
     *
     * @param \Sunahip\EntityBundle\Entity\DataCentrohipico $centroHipico
     * @return DataSolicitudes
     */
    public function setCentroHipico(\Sunahip\CentrohipicoBundle\Entity\DataCentrohipico $centroHipico = null)
    {
        $this->centroHipico = $centroHipico;

        return $this;
    }

    /**
     * Get centroHipico
     *
     * @return \Sunahip\EntityBundle\Entity\DataCentrohipico
     */
    public function getCentroHipico()
    {
        return $this->centroHipico;
    }
    
    /**
     * Set clasLicencia
     *
     * @param \Sunahip\LicenciaBundle\Entity\AdmClasfLicencias $clasLicencia
     * @return DataSolicitudes
     */
    public function setClasLicencia(\Sunahip\LicenciaBundle\Entity\AdmClasfLicencias $clasLicencia = null)
    {
        $this->clasLicencia = $clasLicencia;

        return $this;
    }

    /**
     * Get clasLicencia
     *
     * @return \Sunahip\LicenciaBundle\Entity\AdmClasfLicencias 
     */
    public function getClasLicencia()
    {
        return $this->clasLicencia;
    }
    
    public function setHasSolicitud($hasSolicitud)
    {
        $this->hasSolicitud = $hasSolicitud;
        return $this;
    }
    
    public function getHasSolicitud()
    {
        return $this->hasSolicitud;
    }     
    
    public function setFechaActualizacion($fechaActualizacion=null)
    {
        $this->fechaActualizacion = $fechaActualizacion;
        return $this;
        
    }
    
    public function getFechaActualizacion()
    {
        return $this->fechaActualizacion;        
    }
    
    public function setFechaDesafiliacion($fechaDesafiliacion=null)
    {
        $this->fechaDesafiliacion = $fechaDesafiliacion;
        return $this;
    }
    
    public function getFechaDesafiliacion()
    {
        return $this->fechaDesafiliacion;
    }
    
    public function setGerenteDesafiliacion(\Sunahip\UserBundle\Entity\SysUsuario $gerenteDesafiliacion=null)
    {
        $this->gerenteDesafiliacion = $gerenteDesafiliacion;
        return $this;
    }
    
    public function getGerenteDesafiliacion()
    {
        return $this->gerenteDesafiliacion;
    }
}
