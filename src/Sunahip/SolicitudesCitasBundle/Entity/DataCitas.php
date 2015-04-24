<?php

namespace Sunahip\SolicitudesCitasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DataCitas
 *
 * @ORM\Table(name="data_citas")
 * @ORM\Entity(repositoryClass="Sunahip\SolicitudesCitasBundle\Entity\DataCitasRepository")
 */
class DataCitas
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
     * @ORM\Column(name="cod_solicitud", type="string", length=20, nullable=true)
     */
    private $codsolicitud;

    /**
     * @var integer
     *
     * @ORM\Column(name="idsolicitud", type="integer", nullable=true)
     */
    private $solicitud;
    
    /**
     * @var \SysUsuario
     *
     * @ORM\ManyToOne(targetEntity="\Sunahip\UserBundle\Entity\SysUsuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idusuario", referencedColumnName="id")
     * })
     */
    private $usuario;

    public function __construct() {
        $this->status="Asignada";
    }
    
    function __toString() {
        return $this->getId();
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
     * @return DataCitas
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
     * @return DataCitas
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
     * Set solicitud
     *
     * @param integer $solicitud
     * @return DataCitas
     */
    public function setSolicitud($solicitud)
    {
        $this->solicitud = $solicitud;

        return $this;
    }

    /**
     * Get solicitud
     *
     * @return integer 
     */
    public function getSolicitud()
    {
        return $this->solicitud;
    }

    /**
     * Set usuario
     *
     * @param \Sunahip\UserBundle\Entity\SysUsuario $usuario
     * @return DataCitas
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
     * Set codsolicitud
     *
     * @param string $codsolicitud
     * @return DataCitas
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
}
