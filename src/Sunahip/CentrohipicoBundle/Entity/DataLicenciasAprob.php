<?php

namespace Sunahip\CentrohipicoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DataLicenciasAprob
 * Entidad para Almacenar las Licencias Aprobadas de las Solicitudes...
 *
 * @ORM\Table(name="data_licencias_aprob")
 * @ORM\Entity
 */
class DataLicenciasAprob
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
     * @ORM\Column(name="num_licencia", type="string", length=45, nullable=true)
     */
    private $numLicencia;

    /**
     * @var datetime
     *
     * @ORM\Column(name="fecha_registro", type="datetime", nullable=true)
     */
    private $fechaRegistro;

    /**
     * @var datetime
     *
     * @ORM\Column(name="fecha_vencimiento", type="datetime", nullable=true)
     */
    private $fechaVencimiento;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="vigente", type="boolean", nullable=true)
     */
    private $vigente;

    /**
     * @var \AdmClasfLicencias
     *
     * @ORM\ManyToOne(targetEntity="\Sunahip\LicenciaBundle\Entity\AdmClasfLicencias")
     * @ORM\JoinColumn(name="id_clasf_licencia", referencedColumnName="id")
     */
    private $clasfLicencia;
    
      
    /**
     * @var \SysUsuario
     *
     * @ORM\ManyToOne(targetEntity="\Sunahip\UserBundle\Entity\SysUsuario")
     * @ORM\JoinColumn(name="idusuario", referencedColumnName="id")
     */
    private $usuario;

    /**
     * @var \DataOperadora
     *
     * @ORM\ManyToOne(targetEntity="DataOperadora", inversedBy="licenciasaprob")
     * @ORM\JoinColumn(name="idoperadora", referencedColumnName="id",  nullable=true)
     */
    private $operadora;    

    /**
     * @var \DataCentrohipico
     *
     * @ORM\ManyToOne(targetEntity="DataCentrohipico", inversedBy="licenciasaprob")
     * @ORM\JoinColumn(name="idcentroh", referencedColumnName="id",  nullable=true)
     */
    private $centrohipico;    
    

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
     * Set clasfLicencia
     *
     * @param \Sunahip\LicenciaBundle\Entity\AdmClasfLicencias $clasfLicencia
     * @return DataLicenciasAprob
     */
    public function setClasfLicencia(\Sunahip\LicenciaBundle\Entity\AdmClasfLicencias $clasfLicencia = null)
    {
        $this->clasfLicencia = $clasfLicencia;

        return $this;
    }

    /**
     * Get clasfLicencia
     *
     * @return \Sunahip\LicenciaBundle\Entity\AdmClasfLicencias 
     */
    public function getClasfLicencia()
    {
        return $this->clasfLicencia;
    }

    /**
     * Set usuario
     *
     * @param \Sunahip\UserBundle\Entity\SysUsuario $usuario
     * @return DataLicenciasAprob
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
     * Set operadora
     *
     * @param \Sunahip\CentrohipicoBundle\Entity\DataOperadora $operadora
     * @return DataLicenciasAprob
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
     * Set centrohipico
     *
     * @param \Sunahip\CentrohipicoBundle\Entity\DataCentrohipico $centrohipico
     * @return DataLicenciasAprob
     */
    public function setCentrohipico(\Sunahip\CentrohipicoBundle\Entity\DataCentrohipico $centrohipico = null)
    {
        $this->centrohipico = $centrohipico;

        return $this;
    }

    /**
     * Get centrohipico
     *
     * @return \Sunahip\CentrohipicoBundle\Entity\DataCentrohipico 
     */
    public function getCentrohipico()
    {
        return $this->centrohipico;
    }

    /**
     * Set numLicencia
     *
     * @param string $numLicencia
     * @return DataLicenciasAprob
     */
    public function setNumLicencia($numLicencia)
    {
        $this->numLicencia = $numLicencia;

        return $this;
    }

    /**
     * Get numLicencia
     *
     * @return string 
     */
    public function getNumLicencia()
    {
        return $this->numLicencia;
    }

    /**
     * Set fechaRegistro
     *
     * @param \DateTime $fechaRegistro
     * @return DataLicenciasAprob
     */
    public function setFechaRegistro($fechaRegistro)
    {
        $this->fechaRegistro = $fechaRegistro;

        return $this;
    }

    /**
     * Get fechaRegistro
     *
     * @return \DateTime 
     */
    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }

    /**
     * Set fechaVencimiento
     *
     * @param \DateTime $fechaVencimiento
     * @return DataLicenciasAprob
     */
    public function setFechaVencimiento($fechaVencimiento)
    {
        $this->fechaVencimiento = $fechaVencimiento;

        return $this;
    }

    /**
     * Get fechaVencimiento
     *
     * @return \DateTime 
     */
    public function getFechaVencimiento()
    {
        return $this->fechaVencimiento;
    }

    /**
     * Set vigente
     *
     * @param boolean $vigente
     * @return DataLicenciasAprob
     */
    public function setVigente($vigente)
    {
        $this->vigente = $vigente;

        return $this;
    }

    /**
     * Get vigente
     *
     * @return boolean 
     */
    public function getVigente()
    {
        return $this->vigente;
    }
}
