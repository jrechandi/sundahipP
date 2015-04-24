<?php

namespace Sunahip\SolicitudesCitasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DataRecaudosAprobados
 * Entidad de Recaudos que han sido aprobados y resaltados.
 *
 * @ORM\Table(name="data_recaudos_aprob")
 * @ORM\Entity(repositoryClass="DataRecaudosAprobRepository")
 */
class DataRecaudosAprob
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
     * @var \DataRecaudosCargados
     *
     * @ORM\ManyToOne(targetEntity="\Sunahip\SolicitudesCitasBundle\Entity\DataRecaudosCargados")
     * @ORM\JoinColumn(name="idrecaudo", referencedColumnName="id")
     */
    private $recaudo;   
    
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
     * @ORM\Column(name="apobacion_fiscal", type="boolean", nullable=true)
     */
    private $apobacionFiscal;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_aprob_fiscal", type="datetime", nullable=true)
     */
    private $fechaAprobFiscal;

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
     * @ORM\Column(name="aprob_gerente", type="boolean", nullable=true)
     */
    private $aprobGerente;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_aprob_gerente", type="datetime", nullable=true)
     */
    private $fechaAprobGerente;

    /**
     * @var \SysUsuario
     *
     * @ORM\ManyToOne(targetEntity="\Sunahip\UserBundle\Entity\SysUsuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idasesorlegal", referencedColumnName="id", nullable=true)
     * })
     */
    private $asesorLegal;

    /**
     * @var string
     *
     * @ORM\Column(name="aprob_asesorlegal", type="boolean", nullable=true)
     */
    private $aprobAsesorlegal;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_aprob_asesorlegal", type="datetime", nullable=true)
     */
    private $fechaAprobAsesorlegal;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="string", length=255, nullable=true)
     */
    private $observacion;

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
     * Set apobacionFiscal
     *
     * @param boolean $apobacionFiscal
     * @return DataRecaudosAprob
     */
    public function setApobacionFiscal($apobacionFiscal)
    {
        $this->apobacionFiscal = $apobacionFiscal;

        return $this;
    }

    /**
     * Get apobacionFiscal
     *
     * @return boolean
     */
    public function getApobacionFiscal()
    {
        return $this->apobacionFiscal;
    }

    /**
     * Set fechaAprobFiscal
     *
     * @param \DateTime $fechaAprobFiscal
     * @return DataRecaudosAprob
     */
    public function setFechaAprobFiscal($fechaAprobFiscal)
    {
        $this->fechaAprobFiscal = $fechaAprobFiscal;

        return $this;
    }

    /**
     * Get fechaAprobFiscal
     *
     * @return \DateTime
     */
    public function getFechaAprobFiscal()
    {
        return $this->fechaAprobFiscal;
    }

    /**
     * Set aprobGerente
     *
     * @param boolean $aprobGerente
     * @return DataRecaudosAprob
     */
    public function setAprobGerente($aprobGerente)
    {
        $this->aprobGerente = $aprobGerente;

        return $this;
    }

    /**
     * Get aprobGerente
     *
     * @return boolean
     */
    public function getAprobGerente()
    {
        return $this->aprobGerente;
    }

    /**
     * Set fechaAprobGerente
     *
     * @param \DateTime $fechaAprobGerente
     * @return DataRecaudosAprob
     */
    public function setFechaAprobGerente($fechaAprobGerente)
    {
        $this->fechaAprobGerente = $fechaAprobGerente;

        return $this;
    }

    /**
     * Get fechaAprobGerente
     *
     * @return \DateTime
     */
    public function getFechaAprobGerente()
    {
        return $this->fechaAprobGerente;
    }

    /**
     * Set aprobAsesorlegal
     *
     * @param boolean $aprobAsesorlegal
     * @return DataRecaudosAprob
     */
    public function setAprobAsesorlegal($aprobAsesorlegal)
    {
        $this->aprobAsesorlegal = $aprobAsesorlegal;

        return $this;
    }

    /**
     * Get aprobAsesorlegal
     *
     * @return boolean
     */
    public function getAprobAsesorlegal()
    {
        return $this->aprobAsesorlegal;
    }

    /**
     * Set fechaAprobAsesorlegal
     *
     * @param \DateTime $fechaAprobAsesorlegal
     * @return DataRecaudosAprob
     */
    public function setFechaAprobAsesorlegal($fechaAprobAsesorlegal)
    {
        $this->fechaAprobAsesorlegal = $fechaAprobAsesorlegal;

        return $this;
    }

    /**
     * Get fechaAprobAsesorlegal
     *
     * @return \DateTime
     */
    public function getFechaAprobAsesorlegal()
    {
        return $this->fechaAprobAsesorlegal;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     * @return DataRecaudosAprob
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * Get observacion
     *
     * @return string 
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * Set recaudo
     *
     * @param \Sunahip\SolicitudesCitasBundle\Entity\DataRecaudosCargados $recaudo
     * @return DataRecaudosAprob
     */
    public function setRecaudo(\Sunahip\SolicitudesCitasBundle\Entity\DataRecaudosCargados $recaudo = null)
    {
        $this->recaudo = $recaudo;

        return $this;
    }

    /**
     * Get recaudo
     *
     * @return \Sunahip\SolicitudesCitasBundle\Entity\DataRecaudosCargados 
     */
    public function getRecaudo()
    {
        return $this->recaudo;
    }

    /**
     * Set fiscal
     *
     * @param \Sunahip\UserBundle\Entity\SysUsuario $fiscal
     * @return DataRecaudosAprob
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
     * Set gerente
     *
     * @param \Sunahip\UserBundle\Entity\SysUsuario $gerente
     * @return DataRecaudosAprob
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
     * Set asesorLegal
     *
     * @param \Sunahip\UserBundle\Entity\SysUsuario $asesorLegal
     * @return DataRecaudosAprob
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
}
