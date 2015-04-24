<?php

namespace Sunahip\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DataRegistroPagos
 *
 * @ORM\Table(name="data_registro_pagos")
 * @ORM\Entity(repositoryClass="Sunahip\EntityBundle\Entity\DataRegistrosPagosRepository")
 */
class DataRegistroPagos
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
     * @ORM\Column(name="fecha_registro", type="datetime", nullable=false)
     */
    private $fechaRegistro;

    /**
     * @var string
     *
     * @ORM\Column(name="num_licencia_adscrita", type="string", length=45, nullable=false)
     */
    private $numLicenciaAdscrita;

    /**
     * @var string
     *
     * @ORM\Column(name="monto_bs", type="decimal", precision=10, scale=3, nullable=false)
     */
    private $montoBs;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_pago", type="datetime", nullable=false)
     */
    private $fechaPago;

    /**
     * @var string
     *
     * @ORM\Column(name="banco", type="string", length=90, nullable=false)
     */
    private $banco;

    /**
     * @var string
     *
     * @ORM\Column(name="num_transaccion", type="string", length=30, nullable=false)
     */
    private $numTransaccion;

    /**
     * @var string
     *
     * @ORM\Column(name="comprobante", type="string", length=255, nullable=false)
     */
    private $comprobante;

    /**
     * @var \SysUsuario
     *
     * @ORM\ManyToOne(targetEntity="\Sunahip\UserBundle\Entity\SysUsuario")
     * @ORM\JoinColumn(name="idusuario", referencedColumnName="id")
     */
    private $usuario;

    /**
     * @var \AdmAporte
     *
     * @ORM\ManyToOne(targetEntity="AdmAporte")
     * @ORM\JoinColumn(name="idaporte", referencedColumnName="id")
     */
    private $aporte;

    /**
     * @var \DataSolicitudes
     *
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
     * Set status
     *
     * @param string $status
     * @return DataRegistroPagos
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
     * Set fechaRegistro
     *
     * @param \DateTime $fechaRegistro
     * @return DataRegistroPagos
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
     * Set numLicenciaAdscrita
     *
     * @param string $numLicenciaAdscrita
     * @return DataRegistroPagos
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
     * Set montoBs
     *
     * @param string $montoBs
     * @return DataRegistroPagos
     */
    public function setMontoBs($montoBs)
    {
        $this->montoBs = $montoBs;

        return $this;
    }

    /**
     * Get montoBs
     *
     * @return string 
     */
    public function getMontoBs()
    {
        return $this->montoBs;
    }

    /**
     * Set fechaPago
     *
     * @param \DateTime $fechaPago
     * @return DataRegistroPagos
     */
    public function setFechaPago($fechaPago)
    {
        $this->fechaPago = $fechaPago;

        return $this;
    }

    /**
     * Get fechaPago
     *
     * @return \DateTime 
     */
    public function getFechaPago()
    {
        return $this->fechaPago;
    }

    /**
     * Set banco
     *
     * @param string $banco
     * @return DataRegistroPagos
     */
    public function setBanco($banco)
    {
        $this->banco = $banco;

        return $this;
    }

    /**
     * Get banco
     *
     * @return string 
     */
    public function getBanco()
    {
        return $this->banco;
    }

    /**
     * Set numTransaccion
     *
     * @param string $numTransaccion
     * @return DataRegistroPagos
     */
    public function setNumTransaccion($numTransaccion)
    {
        $this->numTransaccion = $numTransaccion;

        return $this;
    }

    /**
     * Get numTransaccion
     *
     * @return string 
     */
    public function getNumTransaccion()
    {
        return $this->numTransaccion;
    }

    /**
     * Set comprobante
     *
     * @param string $comprobante
     * @return DataRegistroPagos
     */
    public function setComprobante($comprobante)
    {
        $this->comprobante = $comprobante;

        return $this;
    }

    /**
     * Get comprobante
     *
     * @return string 
     */
    public function getComprobante()
    {
        return $this->comprobante;
    }

    /**
     * Set usuario
     *
     * @param \Sunahip\UserBundle\Entity\SysUsuario $usuario
     * @return DataRegistroPagos
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
     * Set aporte
     *
     * @param \Sunahip\EntityBundle\Entity\AdmAporte $aporte
     * @return DataRegistroPagos
     */
    public function setAporte(\Sunahip\EntityBundle\Entity\AdmAporte $aporte = null)
    {
        $this->aporte = $aporte;

        return $this;
    }

    /**
     * Get aporte
     *
     * @return \Sunahip\EntityBundle\Entity\AdmAporte 
     */
    public function getAporte()
    {
        return $this->aporte;
    }

    /**
     * Set solicitud
     *
     * @param \Sunahip\EntityBundle\Entity\DataSolicitudes $solicitud
     * @return DataRegistroPagos
     */
    public function setSolicitud(\Sunahip\EntityBundle\Entity\DataSolicitudes $solicitud = null)
    {
        $this->solicitud = $solicitud;

        return $this;
    }

    /**
     * Get solicitud
     *
     * @return \Sunahip\EntityBundle\Entity\DataSolicitudes 
     */
    public function getSolicitud()
    {
        return $this->solicitud;
    }
}
