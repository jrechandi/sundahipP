<?php

namespace Sunahip\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DataSolicitudes
 *
 * @ORM\Table(name="data_solicitudes")
 * @ORM\Entity(repositoryClass="DataSolicitudesRepository")
 */
class DataSolicitudes
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
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=45, nullable=false)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_solicitud", type="datetime", nullable=false)
     */
    private $fechaSolicitud;

    /**
     * @var string
     *
     * @ORM\Column(name="aprobacion_tecnica", type="string", length=45, nullable=false)
     */
    private $aprobacionTecnica;

    /**
     * @var string
     *
     * @ORM\Column(name="aprobacion_asesorlegal", type="string", length=45, nullable=false)
     */
    private $aprobacionAsesorlegal;

    /**
     * @var string
     *
     * @ORM\Column(name="num_providencia", type="string", length=45, nullable=false)
     */
    private $numProvidencia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_providencia", type="datetime", nullable=false)
     */
    private $fechaProvidencia;

    /**
     * @var string
     *
     * @ORM\Column(name="aprobacion", type="string", length=45, nullable=false)
     */
    private $aprobacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_aprobacion", type="datetime", nullable=false)
     */
    private $fechaAprobacion;

    /**
     * @var string
     *
     * @ORM\Column(name="num_licencia_adscrita", type="string", length=45, nullable=false)
     */
    private $numLicenciaAdscrita;

    /**
     * @var \DataHipoInter
     * @ORM\ManyToOne(targetEntity="\Sunahip\EntityBundle\Entity\DataHipoInter")
     * @ORM\JoinColumn(name="idhipodromo", referencedColumnName="id")
     */
    private $hipodromo;
    
     /**
     * @var \DataCitas
     *
     * @ORM\ManyToOne(targetEntity="DataCitas")
     * @ORM\JoinColumn(name="idcita", referencedColumnName="id")
     */
    private $cita;

    /**
     * @var \DataOperadora
     * @ORM\ManyToOne(targetEntity="\Sunahip\EntityBundle\Entity\DataOperadora")
     * @ORM\JoinColumn(name="idoperadora", referencedColumnName="id")     
     */
    private $operadora;

   /**
    * Establecimiento
    * @var \DataCentrohipico
    * @ORM\ManyToOne(targetEntity="\Sunahip\EntityBundle\Entity\DataCentrohipico")
    * @ORM\JoinColumn(name="idcentroh", referencedColumnName="id")    * 
    */
    private $centroHipico;

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
     * @var \AdmClasfLicencias
     *
     * @ORM\ManyToOne(targetEntity="\Sunahip\EntityBundle\Entity\AdmClasfLicencias")
     * @ORM\JoinColumn(name="idclasf", referencedColumnName="id")
     */
    private $ClasLicencia;

    /**
     * @var \AdmJuegosExplotados
     *
     * @ORM\ManyToOne(targetEntity="\Sunahip\EntityBundle\Entity\AdmJuegosExplotados")
     * @ORM\JoinColumn(name="idjuegos", referencedColumnName="id")
     */
    private $juegosExplotados;



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

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
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
     * Set aprobacionTecnica
     *
     * @param string $aprobacionTecnica
     * @return DataSolicitudes
     */
    public function setAprobacionTecnica($aprobacionTecnica)
    {
        $this->aprobacionTecnica = $aprobacionTecnica;

        return $this;
    }

    /**
     * Get aprobacionTecnica
     *
     * @return string 
     */
    public function getAprobacionTecnica()
    {
        return $this->aprobacionTecnica;
    }

    /**
     * Set aprobacionAsesorlegal
     *
     * @param string $aprobacionAsesorlegal
     * @return DataSolicitudes
     */
    public function setAprobacionAsesorlegal($aprobacionAsesorlegal)
    {
        $this->aprobacionAsesorlegal = $aprobacionAsesorlegal;

        return $this;
    }

    /**
     * Get aprobacionAsesorlegal
     *
     * @return string 
     */
    public function getAprobacionAsesorlegal()
    {
        return $this->aprobacionAsesorlegal;
    }

    /**
     * Set numProvidencia
     *
     * @param string $numProvidencia
     * @return DataSolicitudes
     */
    public function setNumProvidencia($numProvidencia)
    {
        $this->numProvidencia = $numProvidencia;

        return $this;
    }

    /**
     * Get numProvidencia
     *
     * @return string 
     */
    public function getNumProvidencia()
    {
        return $this->numProvidencia;
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
     * Set aprobacion
     *
     * @param string $aprobacion
     * @return DataSolicitudes
     */
    public function setAprobacion($aprobacion)
    {
        $this->aprobacion = $aprobacion;

        return $this;
    }

    /**
     * Get aprobacion
     *
     * @return string 
     */
    public function getAprobacion()
    {
        return $this->aprobacion;
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
     * Set numLicenciaAdscrita
     *
     * @param string $numLicenciaAdscrita
     * @return DataSolicitudes
     */
    public function setNumLicenciaAdscrita($numLicenciaAdscrita)
    {
        $this->numLicenciaAdscrita = $numLicenciaAdscrita;

        return $this;
    }

    /**
     * Get numLicenciaAdscrita
     *
     * @return string 
     */
    public function getNumLicenciaAdscrita()
    {
        return $this->numLicenciaAdscrita;
    }

    /**
     * Set hipodromo
     *
     * @param \Sunahip\EntityBundle\Entity\DataHipoInter $hipodromo
     * @return DataSolicitudes
     */
    public function setHipodromo(\Sunahip\EntityBundle\Entity\DataHipoInter $hipodromo = null)
    {
        $this->hipodromo = $hipodromo;

        return $this;
    }

    /**
     * Get hipodromo
     *
     * @return \Sunahip\EntityBundle\Entity\DataHipoInter 
     */
    public function getHipodromo()
    {
        return $this->hipodromo;
    }

    /**
     * Set cita
     *
     * @param \Sunahip\EntityBundle\Entity\DataCitas $cita
     * @return DataSolicitudes
     */
    public function setCita(\Sunahip\EntityBundle\Entity\DataCitas $cita = null)
    {
        $this->cita = $cita;

        return $this;
    }

    /**
     * Get cita
     *
     * @return \Sunahip\EntityBundle\Entity\DataCitas 
     */
    public function getCita()
    {
        return $this->cita;
    }

    /**
     * Set citaasignada
     *
     * @param \Sunahip\EntityBundle\Entity\DataCitaAsignada $citaasignada
     * @return DataSolicitudes
     */
    public function setCitaasignada(\Sunahip\EntityBundle\Entity\DataCitaAsignada $citaasignada = null)
    {
        $this->citaasignada = $citaasignada;

        return $this;
    }

    /**
     * Get citaasignada
     *
     * @return \Sunahip\EntityBundle\Entity\DataCitaAsignada 
     */
    public function getCitaasignada()
    {
        return $this->citaasignada;
    }

    /**
     * Set operadora
     *
     * @param \Sunahip\EntityBundle\Entity\DataOperadora $operadora
     * @return DataSolicitudes
     */
    public function setOperadora(\Sunahip\EntityBundle\Entity\DataOperadora $operadora = null)
    {
        $this->operadora = $operadora;

        return $this;
    }

    /**
     * Get operadora
     *
     * @return \Sunahip\EntityBundle\Entity\DataOperadora 
     */
    public function getOperadora()
    {
        return $this->operadora;
    }

    /**
     * Set centroHipico
     *
     * @param \Sunahip\EntityBundle\Entity\DataCentrohipico $centroHipico
     * @return DataSolicitudes
     */
    public function setCentroHipico(\Sunahip\EntityBundle\Entity\DataCentrohipico $centroHipico = null)
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
     * Set ClasLicencia
     *
     * @param \Sunahip\EntityBundle\Entity\AdmClasfLicencias $clasLicencia
     * @return DataSolicitudes
     */
    public function setClasLicencia(\Sunahip\EntityBundle\Entity\AdmClasfLicencias $clasLicencia = null)
    {
        $this->ClasLicencia = $clasLicencia;

        return $this;
    }

    /**
     * Get ClasLicencia
     *
     * @return \Sunahip\EntityBundle\Entity\AdmClasfLicencias 
     */
    public function getClasLicencia()
    {
        return $this->ClasLicencia;
    }

    /**
     * Set juegosExplotados
     *
     * @param \Sunahip\EntityBundle\Entity\AdmJuegosExplotados $juegosExplotados
     * @return DataSolicitudes
     */
    public function setJuegosExplotados(\Sunahip\EntityBundle\Entity\AdmJuegosExplotados $juegosExplotados = null)
    {
        $this->juegosExplotados = $juegosExplotados;

        return $this;
    }

    /**
     * Get juegosExplotados
     *
     * @return \Sunahip\EntityBundle\Entity\AdmJuegosExplotados 
     */
    public function getJuegosExplotados()
    {
        return $this->juegosExplotados;
    }
}
