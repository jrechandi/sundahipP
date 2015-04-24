<?php

namespace Sunahip\SolicitudesCitasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DataSolicitudes
 *
 * @ORM\Table(name="data_solicitudes_aprob")
 * @ORM\Entity(repositoryClass="DataSolicitudesAprobRepository")
 */
class DataSolicitudesAprob
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
     * @ORM\Column(name="num_providencia", type="string", length=45, nullable=true)
     */
    private $numProvidencia;

     /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_aprobada", type="datetime", nullable=true)
     */
    private $fechaAprobada;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_inicio", type="date", nullable=true)
     */
    private $fechaInicio;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_fin", type="date", nullable=true)
     */
    private $fechaFin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_providencia", type="date", nullable=true)
     */
    private $fechaProvidencia;

    /**
     * @var
     *
     * @ORM\OneToOne(targetEntity="\Sunahip\CentrohipicoBundle\Entity\DataOperadoraEstablecimiento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="operadora_establecimiento", referencedColumnName="id", nullable=true)
     * })
     */
    private $operadoraEstablecimiento;

    /**
     * @var \SysUsuario
     *
     * @ORM\ManyToOne(targetEntity="\Sunahip\UserBundle\Entity\SysUsuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idfiscal", referencedColumnName="id", nullable=true)
     * })
     */
    private $fiscal;
    
    /**
     * @var string
     *
     * @ORM\Column(name="revision_fiscal", type="boolean", nullable=true)
     */
    private $revisionFiscal;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_revision_fiscal", type="datetime", nullable=true)
     */
    private $fecharevisionFiscal;
  
    /**
     * @var \SysUsuario
     *
     * @ORM\ManyToOne(targetEntity="\Sunahip\UserBundle\Entity\SysUsuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idasesor", referencedColumnName="id", nullable=true)
     * })
     */
    private $asesorLegal;
    
    /**
     * @var string
     *
     * @ORM\Column(name="revision_asesor", type="boolean", nullable=true)
     */
    private $revisionAsesor;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_revision_asesor", type="datetime", nullable=true)
     */
    private $fecharevisionAsesor;

    /**
     * @var \SysUsuario
     *
     * @ORM\ManyToOne(targetEntity="\Sunahip\UserBundle\Entity\SysUsuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idgerente", referencedColumnName="id", nullable=true)
     * })
     */
    private $gerente;
    
    /**
     * @var string
     *
     * @ORM\Column(name="revision_gerente", type="boolean", nullable=true)
     */
    private $revisionGerente;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_revision_gerente", type="datetime", nullable=true)
     */
    private $fecharevisionGerente;
    
    /**
     * @var \DataSolicitudes
     * @ORM\ManyToOne(targetEntity="DataSolicitudes")
     * @ORM\JoinColumn(name="idsolicitud", referencedColumnName="id")
     */
    private $solicitud;


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
     * Set numProvidencia
     *
     * @param string $numProvidencia
     * @return DataSolicitudesAprob
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
     * Set fechaInicio
     *
     * @param string $fechaInicio
     * @return DataSolicitudesAprob
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    /**
     * Get fechaInicio
     *
     * @return string 
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    /**
     * Set fechaFin
     *
     * @param string $fechaFin
     * @return DataSolicitudesAprob
     */
    public function setFechaFin($fechaFin)
    {
        $this->fechaFin = $fechaFin;

        return $this;
    }

    /**
     * Get fechaFin
     *
     * @return string 
     */
    public function getFechaFin()
    {
        return $this->fechaFin;
    }

    /**
     * Set fechaProvidencia
     *
     * @param string $fechaProvidencia
     * @return DataSolicitudesAprob
     */
    public function setFechaProvidencia($fechaProvidencia)
    {
        $this->fechaProvidencia = $fechaProvidencia;

        return $this;
    }

    /**
     * Get fechaProvidencia
     *
     * @return string 
     */
    public function getFechaProvidencia()
    {
        return $this->fechaProvidencia;
    }

    /**
     * Set revisionFiscal
     *
     * @param boolean $revisionFiscal
     * @return DataSolicitudesAprob
     */
    public function setRevisionFiscal($revisionFiscal)
    {
        $this->revisionFiscal = $revisionFiscal;

        return $this;
    }

    /**
     * Get revisionFiscal
     *
     * @return boolean 
     */
    public function getRevisionFiscal()
    {
        return $this->revisionFiscal;
    }

    /**
     * Set fecharevisionFiscal
     *
     * @param \DateTime $fecharevisionFiscal
     * @return DataSolicitudesAprob
     */
    public function setFecharevisionFiscal($fecharevisionFiscal)
    {
        $this->fecharevisionFiscal = $fecharevisionFiscal;

        return $this;
    }

    /**
     * Get fecharevisionFiscal
     *
     * @return \DateTime 
     */
    public function getFecharevisionFiscal()
    {
        return $this->fecharevisionFiscal;
    }

    /**
     * Set revisionAsesor
     *
     * @param boolean $revisionAsesor
     * @return DataSolicitudesAprob
     */
    public function setRevisionAsesor($revisionAsesor)
    {
        $this->revisionAsesor = $revisionAsesor;

        return $this;
    }

    /**
     * Get revisionAsesor
     *
     * @return boolean 
     */
    public function getRevisionAsesor()
    {
        return $this->revisionAsesor;
    }

    /**
     * Set fecharevisionAsesor
     *
     * @param \DateTime $fecharevisionAsesor
     * @return DataSolicitudesAprob
     */
    public function setFecharevisionAsesor($fecharevisionAsesor)
    {
        $this->fecharevisionAsesor = $fecharevisionAsesor;

        return $this;
    }

    /**
     * Get fecharevisionAsesor
     *
     * @return \DateTime 
     */
    public function getFecharevisionAsesor()
    {
        return $this->fecharevisionAsesor;
    }

    /**
     * Set revisionGerente
     *
     * @param boolean $revisionGerente
     * @return DataSolicitudesAprob
     */
    public function setRevisionGerente($revisionGerente)
    {
        $this->revisionGerente = $revisionGerente;

        return $this;
    }

    /**
     * Get revisionGerente
     *
     * @return boolean 
     */
    public function getRevisionGerente()
    {
        return $this->revisionGerente;
    }

    /**
     * Set fecharevisionGerente
     *
     * @param \DateTime $fecharevisionGerente
     * @return DataSolicitudesAprob
     */
    public function setFecharevisionGerente($fecharevisionGerente)
    {
        $this->fecharevisionGerente = $fecharevisionGerente;

        return $this;
    }

    /**
     * Get fecharevisionGerente
     *
     * @return \DateTime 
     */
    public function getFecharevisionGerente()
    {
        return $this->fecharevisionGerente;
    }

    /**
     * Set operadoraEstablecimiento
     *
     * @param \Sunahip\CentrohipicoBundle\Entity\DataOperadoraEstablecimiento $operadoraEstablecimiento
     * @return DataSolicitudesAprob
     */
    public function setOperadoraEstablecimiento(\Sunahip\CentrohipicoBundle\Entity\DataOperadoraEstablecimiento $operadoraEstablecimiento = null)
    {
        $this->operadoraEstablecimiento = $operadoraEstablecimiento;

        return $this;
    }

    /**
     * Get operadoraEstablecimiento
     *
     * @return \Sunahip\CentrohipicoBundle\Entity\DataOperadoraEstablecimiento 
     */
    public function getOperadoraEstablecimiento()
    {
        return $this->operadoraEstablecimiento;
    }

    /**
     * Set fiscal
     *
     * @param \Sunahip\UserBundle\Entity\SysUsuario $fiscal
     * @return DataSolicitudesAprob
     */
    public function setFiscal(\Sunahip\UserBundle\Entity\SysUsuario $fiscal = null)
    {
        $this->fiscal = $fiscal;

        return $this;
    }

    /**
     * Get fiscal
     *
     * @return \Sunahip\UserBundle\Entity\SysUsuario 
     */
    public function getFiscal()
    {
        return $this->fiscal;
    }

    /**
     * Set asesorLegal
     *
     * @param \Sunahip\UserBundle\Entity\SysUsuario $asesorLegal
     * @return DataSolicitudesAprob
     */
    public function setAsesorLegal(\Sunahip\UserBundle\Entity\SysUsuario $asesorLegal = null)
    {
        $this->asesorLegal = $asesorLegal;

        return $this;
    }

    /**
     * Get asesorLegal
     *
     * @return \Sunahip\UserBundle\Entity\SysUsuario 
     */
    public function getAsesorLegal()
    {
        return $this->asesorLegal;
    }

    /**
     * Set gerente
     *
     * @param \Sunahip\UserBundle\Entity\SysUsuario $gerente
     * @return DataSolicitudesAprob
     */
    public function setGerente(\Sunahip\UserBundle\Entity\SysUsuario $gerente = null)
    {
        $this->gerente = $gerente;

        return $this;
    }

    /**
     * Get gerente
     *
     * @return \Sunahip\UserBundle\Entity\SysUsuario 
     */
    public function getGerente()
    {
        return $this->gerente;
    }

    /**
     * Set solicitud
     *
     * @param \Sunahip\SolicitudesCitasBundle\Entity\DataSolicitudes $solicitud
     * @return DataSolicitudesAprob
     */
    public function setSolicitud(\Sunahip\SolicitudesCitasBundle\Entity\DataSolicitudes $solicitud = null)
    {
        $this->solicitud = $solicitud;

        return $this;
    }

    /**
     * Get solicitud
     *
     * @return \Sunahip\SolicitudesCitasBundle\Entity\DataSolicitudes 
     */
    public function getSolicitud()
    {
        return $this->solicitud;
    }

    /**
     * Set fechaAprobada
     *
     * @param \DateTime $fechaAprobada
     * @return DataSolicitudesAprob
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
}
