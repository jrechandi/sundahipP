<?php

namespace Sunahip\PagosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vlabs\MediaBundle\Annotation\Vlabs;
use Sunahip\CommonBundle\DBAL\Types\PaymentType;
use Fresh\Bundle\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;

/**
 * @ORM\Entity(repositoryClass="Sunahip\PagosBundle\Entity\Repository\PagoRepository")
 * @ORM\Table(name="data_pagos")
 * 
 */
class Pagos
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
     * Banco
     * @var \DataCentrohipico
     * @ORM\ManyToOne(targetEntity="\Sunahip\PagosBundle\Entity\Banco")
     * @ORM\JoinColumn(name="idbanco", referencedColumnName="id", nullable=true)
     *
     */
    private $banco;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_pago", type="PaymentType", nullable=false)
     * @DoctrineAssert\Enum(entity="Sunahip\CommonBundle\DBAL\Types\PaymentType")
     */
    private $tipoPago;

    /**
     * @var string
     *
     * @ORM\Column(name="num_referencia", type="string", length=45, nullable=true)
     */
    private $numReferencia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_solicitud", type="date", nullable=true)
     */
    private $fechaDeposito;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=2)
     *
     */
    protected $monto;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_creacion", type="datetime", nullable=false)
     */
    private $fechaCreacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_proceso", type="datetime", nullable=false)
     */
    private $fechaProceso;

    /**
     * @var \SysUsuario
     *
     * @ORM\ManyToOne(targetEntity="\Sunahip\UserBundle\Entity\SysUsuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idusuario_creacion", referencedColumnName="id", nullable=true)
     * })
     */
    private $usuarioCreacion;

    /**
     * @var \SysUsuario
     *
     * @ORM\ManyToOne(targetEntity="\Sunahip\UserBundle\Entity\SysUsuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idusuario_paga", referencedColumnName="id", nullable=true)
     * })
     */
    private $usuarioPaga;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=45, nullable=false)
     */
    private $status;


    /**
     * @ORM\OneToOne(targetEntity="\Sunahip\CommonBundle\Entity\Media", cascade={"persist", "remove"}, orphanRemoval=true))
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="archivo_adjunto", referencedColumnName="id")
     * })
     *
     * @Vlabs\Media(identifier="file_entity", upload_dir="media/pagos/")
     */
    private $archivoAdjunto;
    
    /**
     * @var \DataSolicitudes
     *
     * @ORM\ManyToOne(targetEntity="\Sunahip\SolicitudesCitasBundle\Entity\DataSolicitudes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_solicitud", referencedColumnName="id", nullable=true)
     * })
     */
    private $solicitud;

    
    public function __construct() {
        $now = new \DateTime();
        $this->status="CREADO";
        $this->fechaProceso=$now;
        $this->fechaCreacion=$now;
        $this->numReferencia="";
    }
    /**
     * Set tipopago
     *
     * @param PaymentType $tipo
     */
    public function setTipoPago($tipo)
    {
        $this->tipoPago = $tipo;

        return $this;
    }

    /**
     * Get tipoPago
     *
     * @return PaymentType
     */
    public function getTipoPago()
    {
        return $this->tipoPago;
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
     * Set numReferencia
     *
     * @param string $numReferencia
     * @return Pago
     */
    public function setNumReferencia($numReferencia)
    {
        $this->numReferencia = $numReferencia;

        return $this;
    }

    /**
     * Get numReferencia
     *
     * @return string 
     */
    public function getNumReferencia()
    {
        return $this->numReferencia;
    }

    /**
     * Set fechaDeposito
     *
     * @param \DateTime $fechaDeposito
     * @return Pago
     */
    public function setFechaDeposito($fechaDeposito)
    {
        $this->fechaDeposito = $fechaDeposito;

        return $this;
    }

    /**
     * Get fechaDeposito
     *
     * @return \DateTime 
     */
    public function getFechaDeposito()
    {
        return $this->fechaDeposito;
    }

    /**
     * Set monto
     *
     * @param integer $monto
     * @return Pago
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;

        return $this;
    }

    /**
     * Get monto
     *
     * @return integer 
     */
    public function getMonto()
    {
        return $this->monto;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     * @return Pago
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return \DateTime 
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * Set fechaProceso
     *
     * @param \DateTime $fechaProceso
     * @return Pago
     */
    public function setFechaProceso($fechaProceso)
    {
        $this->fechaProceso = $fechaProceso;

        return $this;
    }

    /**
     * Get fechaProceso
     *
     * @return \DateTime 
     */
    public function getFechaProceso()
    {
        return $this->fechaProceso;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Pago
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
     * Set operadora
     *
     * @param \Sunahip\CentrohipicoBundle\Entity\DataOperadora $operadora
     * @return Pago
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
     * @return Pago
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
     * Set banco
     *
     * @param \Sunahip\PagosBundle\Entity\Banco $banco
     * @return Pago
     */
    public function setBanco(\Sunahip\PagosBundle\Entity\Banco $banco = null)
    {
        $this->banco = $banco;

        return $this;
    }

    /**
     * Get banco
     *
     * @return \Sunahip\PagosBundle\Entity\Banco 
     */
    public function getBanco()
    {
        return $this->banco;
    }

    /**
     * Set usuarioCreacion
     *
     * @param \Sunahip\UserBundle\Entity\SysUsuario $usuarioCreacion
     * @return Pago
     */
    public function setUsuarioCreacion(\Sunahip\UserBundle\Entity\SysUsuario $usuarioCreacion = null)
    {
        $this->usuarioCreacion = $usuarioCreacion;

        return $this;
    }

    /**
     * Get usuarioCreacion
     *
     * @return \Sunahip\UserBundle\Entity\SysUsuario 
     */
    public function getUsuarioCreacion()
    {
        return $this->usuarioCreacion;
    }

    /**
     * Set usuarioPaga
     *
     * @param \Sunahip\UserBundle\Entity\SysUsuario $usuarioPaga
     * @return Pago
     */
    public function setUsuarioPaga(\Sunahip\UserBundle\Entity\SysUsuario $usuarioPaga = null)
    {
        $this->usuarioPaga = $usuarioPaga;

        return $this;
    }

    /**
     * Get usuarioPaga
     *
     * @return \Sunahip\UserBundle\Entity\SysUsuario 
     */
    public function getUsuarioPaga()
    {
        return $this->usuarioPaga;
    }

    /**
     * Set archivoAdjunto
     *
     * @param \Sunahip\CommonBundle\Entity\Media $archivoAdjunto
     * @return Pago
     */
    public function setArchivoAdjunto(\Sunahip\CommonBundle\Entity\Media $archivoAdjunto = null)
    {
        $this->archivoAdjunto = $archivoAdjunto;

        return $this;
    }

    /**
     * Get archivoAdjunto
     *
     * @return \Sunahip\CommonBundle\Entity\Media 
     */
    public function getArchivoAdjunto()
    {
        return $this->archivoAdjunto;
    }
    
    public function getSolicitud() {
        return $this->solicitud;
    }
    
    public function setSolicitud(\Sunahip\SolicitudesCitasBundle\Entity\DataSolicitudes $solicitud) {
        $this->solicitud = $solicitud;
        return $this;
    }
}