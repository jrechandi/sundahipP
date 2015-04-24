<?php

namespace Sunahip\SolicitudesCitasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vlabs\MediaBundle\Annotation\Vlabs;

/**
 * DataRecaudosCargados
 *
 * @ORM\Table(name="data_recaudos_cargados")
 * @ORM\Entity(repositoryClass="DataRecaudosCargadosRepository")
 */
class DataRecaudosCargados
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
     * @var \AdmRecaudosLicencias
     * @ORM\ManyToOne(targetEntity="\Sunahip\LicenciaBundle\Entity\AdmRecaudosLicencias")
     * @ORM\JoinColumn(name="idrecaudo_licencia", referencedColumnName="id")
     */
    private $recaudoLicencia;
    
    /**
     * @ORM\OneToOne(targetEntity="\Sunahip\CommonBundle\Entity\Media", cascade={"persist", "remove"}, orphanRemoval=true))
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="meidarecaudo", referencedColumnName="id")
     * })
     * @Vlabs\Media(identifier="file_entity", upload_dir="media/usuario/solicitud/")
     */
    private $mediarecaudo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_vencimiento", type="datetime", nullable=true)
     */
    private $fechaVencimiento;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=45, nullable=false)
     */
    private $status="Solicitada";

    /**
     * @var string
     *
     * @ORM\Column(name="recibo_n", type="string", length=60, nullable=false)
     */
    private $reciboN="000000000";

    /**
     * Tipo de Documento P= pago, D= Documento recaudo
     * @var string
     *
     * @ORM\Column(name="tipodoc", type="string", length=2, nullable=false)
     */
    private $tipodoc="D";

    /**
     * @var \DataSolicitudes
     * @ORM\ManyToOne(targetEntity="DataSolicitudes", inversedBy="recaudoscargados", cascade={"persist", "remove"} )
     * @ORM\JoinColumn(name="idsolicitud", referencedColumnName="id")
     */
    private $solicitud;

    public function __construct() {
        $this->status="Solicitada";
        $this->reciboN="000000000";
        $this->tipodoc="D";
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
     * Set fechaVencimiento
     *
     * @param \DateTime $fechaVencimiento
     * @return DataRecaudosCargados
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
     * Set status
     *
     * @param string $status
     * @return DataRecaudosCargados
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
     * Set recaudoLicencia
     *
     * @param \Sunahip\LicenciaBundle\Entity\AdmRecaudosLicencias $recaudoLicencia
     * @return DataRecaudosCargados
     */
    public function setRecaudoLicencia(\Sunahip\LicenciaBundle\Entity\AdmRecaudosLicencias $recaudoLicencia = null)
    {
        $this->recaudoLicencia = $recaudoLicencia;

        return $this;
    }

    /**
     * Get recaudoLicencia
     *
     * @return \Sunahip\LicenciaBundle\Entity\AdmRecaudosLicencias 
     */
    public function getRecaudoLicencia()
    {
        return $this->recaudoLicencia;
    }

    /**
     * Set mediarecaudo
     *
     * @param \Sunahip\CommonBundle\Entity\Media $mediarecaudo
     * @return DataRecaudosCargados
     */
    public function setMediarecaudo(\Sunahip\CommonBundle\Entity\Media $mediarecaudo = null)
    {
        $this->mediarecaudo = $mediarecaudo;

        return $this;
    }

    /**
     * Get mediarecaudo
     *
     * @return \Sunahip\CommonBundle\Entity\Media 
     */
    public function getMediarecaudo()
    {
        return $this->mediarecaudo;
    }

    /**
     * Set solicitud
     *
     * @param \Sunahip\SolicitudesCitasBundle\Entity\DataSolicitudes $solicitud
     * @return DataRecaudosCargados
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
     * Set reciboN
     *
     * @param string $reciboN
     * @return DataRecaudosCargados
     */
    public function setReciboN($reciboN)
    {
        $this->reciboN = $reciboN;

        return $this;
    }

    /**
     * Get reciboN
     *
     * @return string 
     */
    public function getReciboN()
    {
        return $this->reciboN;
    }

    /**
     * Set tipodoc
     *
     * @param string $tipodoc
     * @return DataRecaudosCargados
     */
    public function setTipodoc($tipodoc)
    {
        $this->tipodoc = $tipodoc;

        return $this;
    }

    /**
     * Get tipodoc
     *
     * @return string 
     */
    public function getTipodoc()
    {
        return $this->tipodoc;
    }
}
