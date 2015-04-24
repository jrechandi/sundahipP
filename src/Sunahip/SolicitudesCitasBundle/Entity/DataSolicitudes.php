<?php

namespace Sunahip\SolicitudesCitasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @ORM\Column(name="fecha_solicitud", type="datetime", nullable=true)
     */
    private $fechaSolicitud;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_aprobada", type="datetime", nullable=true)
     */
    private $fechaAprobada;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_rechazada", type="datetime", nullable=true)
     */
    private $fechaRechazada;

    /**
     * @var string
     *
     * @ORM\Column(name="num_licencia_adscrita", type="string", length=45, nullable=true)
     */
    private $numLicenciaAdscrita;

    /**
     * @var string
     * @ORM\Column(name="hipodromo_inter", type="string", length=2048, nullable=true)
     */
    private $hipodromoInter;
    
    /**
     * @var string
     *
     * @ORM\Column(name="cod_solicitud", type="string", length=20, nullable=true)
     */
    private $codsolicitud;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_solicitud", type="string", length=20, nullable=true)
     */
    private $tipoSolicitud;
    
     /**
     * @var \DataCitas
     *
     * @ORM\ManyToOne(targetEntity="DataCitas")
     * @ORM\JoinColumn(name="idcita", referencedColumnName="id")
     */
    private $cita;

    /**
     * @var \DataOperadora
     * @ORM\ManyToOne(targetEntity="\Sunahip\CentrohipicoBundle\Entity\DataOperadora")
     * @ORM\JoinColumn(name="idoperadora", referencedColumnName="id", nullable=true)     
     */
    private $operadora;

   /**
    * Establecimiento
    * @var \DataCentrohipico
    * @ORM\ManyToOne(targetEntity="\Sunahip\CentrohipicoBundle\Entity\DataCentrohipico")
    * @ORM\JoinColumn(name="idcentroh", referencedColumnName="id", nullable=true)    
    *  
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
     * @ORM\ManyToOne(targetEntity="\Sunahip\LicenciaBundle\Entity\AdmClasfLicencias")
     * @ORM\JoinColumn(name="idclasf", referencedColumnName="id")
     */
    private $ClasLicencia;
   
    /**
     * @var \Pagos
     *
     * @ORM\ManyToOne(targetEntity="\Sunahip\PagosBundle\Entity\Pagos",cascade={"persist","remove"})
     * @ORM\JoinColumn(name="idpago", referencedColumnName="id")
     */
    private $pago;

     /**
     * @var ArrayCollection $juegosExplotados
     *
     * @ORM\ManyToMany(targetEntity="\Sunahip\LicenciaBundle\Entity\AdmJuegosExplotados")
     * @ORM\JoinTable(name="data_solicitud_juegose",
     *      joinColumns={@ORM\JoinColumn(name="idsolicitud", referencedColumnName="id", nullable=true)},
     *      inverseJoinColumns={@ORM\JoinColumn(name="idjuegoe", referencedColumnName="id")}
     *      )
     **/
    private $juegosExplotados;
    
    /**
     * @var ArrayCollection $recaudoscargados
     *
     * @ORM\OneToMany(targetEntity="DataRecaudosCargados",cascade={"persist", "remove"}, mappedBy="solicitud" )
     *
     */
    private $recaudoscargados;
    
    /**
     * @var \DataOperadora
     * @ORM\ManyToOne(targetEntity="Sunahip\CentrohipicoBundle\Entity\DataOperadoraEstablecimiento")
     * @ORM\JoinColumn(name="id_operadora_establecimiento", referencedColumnName="id", nullable=true)     
     */
    private $dataOperadora;

    public function __construct()
    {
        $now = new \DateTime();
        $this->recaudoscargados = new ArrayCollection();
        $this->juegosExplotados = new ArrayCollection();
        $this->status="Solicitada";
        $this->fechaSolicitud=$now;
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
     * Set hipodromoInter
     *
     * @param string $hipodromoInter
     * @return DataSolicitudes
     */
    public function setHipodromoInter($hipodromoInter)
    {
        $this->hipodromoInter = $hipodromoInter;

        return $this;
    }

    /**
     * Get hipodromoInter
     *
     * @return string 
     */
    public function getHipodromoInter()
    {
        return $this->hipodromoInter;
    }

    /**
     * Set codsolicitud
     *
     * @param string $codsolicitud
     * @return DataSolicitudes
     */
    public function setCodsolicitud($codsolicitud)
    {
        $this->codsolicitud = $codsolicitud;

        return $this;
    }

    /**
     * Get codsolicitud
     *
     * @return string 
     */
    public function getCodsolicitud()
    {
        return $this->codsolicitud;
    }

    /**
     * Set cita
     *
     * @param \Sunahip\SolicitudesCitasBundle\Entity\DataCitas $cita
     * @return DataSolicitudes
     */
    public function setCita(\Sunahip\SolicitudesCitasBundle\Entity\DataCitas $cita = null)
    {
        $this->cita = $cita;

        return $this;
    }

    /**
     * Get cita
     *
     * @return \Sunahip\SolicitudesCitasBundle\Entity\DataCitas 
     */
    public function getCita()
    {
        return $this->cita;
    }

    /**
     * Set operadora
     *
     * @param \Sunahip\CentrohipicoBundle\Entity\DataOperadora $operadora
     * @return DataSolicitudes
     */
    public function setOperadora(\Sunahip\CentrohipicoBundle\Entity\DataOperadora $operadora = null)
    {
        $this->operadora = $operadora;

        return $this;
    }

    /**
     * Get operadora
     *
     * @return \Sunahip\CentrohipicoBundle\Entity\DataOperadora 
     */
    public function getOperadora()
    {
        return $this->operadora;
    }

    /**
     * Set centroHipico
     *
     * @param \Sunahip\CentrohipicoBundle\Entity\DataCentrohipico $centroHipico
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
     * @return \Sunahip\CentrohipicoBundle\Entity\DataCentrohipico 
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
     * @param \Sunahip\LicenciaBundle\Entity\AdmClasfLicencias $clasLicencia
     * @return DataSolicitudes
     */
    public function setClasLicencia(\Sunahip\LicenciaBundle\Entity\AdmClasfLicencias $clasLicencia = null)
    {
        $this->ClasLicencia = $clasLicencia;

        return $this;
    }

    /**
     * Get ClasLicencia
     *
     * @return \Sunahip\LicenciaBundle\Entity\AdmClasfLicencias 
     */
    public function getClasLicencia()
    {
        return $this->ClasLicencia;
    }

    /**
     * Add juegosExplotados
     *
     * @param \Sunahip\LicenciaBundle\Entity\AdmJuegosExplotados $juegosExplotados
     * @return DataSolicitudes
     */
    public function addJuegosExplotado(\Sunahip\LicenciaBundle\Entity\AdmJuegosExplotados $juegosExplotados)
    {
        $this->juegosExplotados[] = $juegosExplotados;

        return $this;
    }

    /**
     * Remove juegosExplotados
     *
     * @param \Sunahip\LicenciaBundle\Entity\AdmJuegosExplotados $juegosExplotados
     */
    public function removeJuegosExplotado(\Sunahip\LicenciaBundle\Entity\AdmJuegosExplotados $juegosExplotados)
    {
        $this->juegosExplotados->removeElement($juegosExplotados);
    }

    /**
     * Get juegosExplotados
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getJuegosExplotados()
    {
        return $this->juegosExplotados;
    }

    /**
     * Add recaudoscargados
     *
     * @param \Sunahip\SolicitudesCitasBundle\Entity\DataRecaudosCargados $recaudoscargados
     * @return DataSolicitudes
     */
    public function addRecaudoscargado(\Sunahip\SolicitudesCitasBundle\Entity\DataRecaudosCargados $recaudoscargados)
    {
        $this->recaudoscargados[] = $recaudoscargados;

        return $this;
    }

    /**
     * Remove recaudoscargados
     *
     * @param \Sunahip\SolicitudesCitasBundle\Entity\DataRecaudosCargados $recaudoscargados
     */
    public function removeRecaudoscargado(\Sunahip\SolicitudesCitasBundle\Entity\DataRecaudosCargados $recaudoscargados)
    {
        $this->recaudoscargados->removeElement($recaudoscargados);
    }

    /**
     * Get recaudoscargados
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRecaudoscargados()
    {
        return $this->recaudoscargados;
    }

    /**
     * Set tipoSolicitud
     *
     * @param string $tipoSolicitud
     * @return DataSolicitudes
     */
    public function setTipoSolicitud($tipoSolicitud)
    {
        $this->tipoSolicitud = $tipoSolicitud;

        return $this;
    }

    /**
     * Get tipoSolicitud
     *
     * @return string 
     */
    public function getTipoSolicitud()
    {
        return $this->tipoSolicitud;
    }

    /**
     * Set pago
     *
     * @param \Sunahip\PagosBundle\Entity\Pagos $pago
     * @return DataSolicitudes
     */
    public function setPago(\Sunahip\PagosBundle\Entity\Pagos $pago = null)
    {
        $this->pago = $pago;

        return $this;
    }

    /**
     * Get Pago
     *
     * @return \Sunahip\PagosBundle\Entity\Pagos 
     */
    public function getPago()
    {
        return $this->pago;
    }
    
    /**
     * Set dataOperadora
     *
     * @param \Sunahip\CentrohipicoBundle\Entity\DataOperadoraEstablecimiento $dataOperadora
     * @return DataSolicitudes
     */
    public function setDataOperadora(\Sunahip\CentrohipicoBundle\Entity\DataOperadoraEstablecimiento $dataOperadora = null)
    {
        $this->dataOperadora = $dataOperadora;
        return $this;
    }

    /**
     * Get Pago
     *
     * @return \Sunahip\CentrohipicoBundle\Entity\DataOperadoraEstablecimiento 
     */
    public function getDataOperadora()
    {
        return $this->dataOperadora;
    }

    /**
     * Set fechaAprobada
     *
     * @param \DateTime $fechaAprobada
     * @return DataSolicitudes
     */
    public function setFechaAprobada($fechaAprobada)
    {
        $this->fechaAprobada = $fechaAprobada;

        return $this;
    }

    /**
     * Get fechaAprobada
     *
     * @return \DateTime 
     */
    public function getFechaAprobada()
    {
        return $this->fechaAprobada;
    }

    /**
     * Set fechaRechazada
     *
     * @param \DateTime $fechaRechazada
     * @return DataSolicitudes
     */
    public function setFechaRechazada($fechaRechazada)
    {
        $this->fechaRechazada = $fechaRechazada;

        return $this;
    }

    /**
     * Get fechaRechazada
     *
     * @return \DateTime 
     */
    public function getFechaRechazada()
    {
        return $this->fechaRechazada;
    }
}
