<?php

namespace Sunahip\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DataSucursal
 * Sucursales de Centros hipicos Adicionales
 *
 * @ORM\Table(name="data_sucursal")
 * @ORM\Entity(repositoryClass="Sunahip\EntityBundle\Entity\DataSucursalRepository")
 */
class DataSucursal
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_registro", type="datetime", nullable=false)
     */
    private $fechaRegistro;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=45, nullable=false)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="denominacion_comercial", type="string", length=255, nullable=false)
     */
    private $denominacionComercial;

    /**
     * @var integer
     *
     * @ORM\Column(name="rif", type="integer", nullable=false)
     */
    private $rif;

    /**
     * @var string
     *
     * @ORM\Column(name="estatus_local", type="string", length=45, nullable=false)
     */
    private $estatusLocal;

    /**
     * @var string
     *
     * @ORM\Column(name="propietario_local", type="string", length=255, nullable=false)
     */
    private $propietarioLocal;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=120, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=45, nullable=false)
     */
    private $apellido;

    /**
     * @var integer
     *
     * @ORM\Column(name="ci", type="integer", nullable=false)
     */
    private $ci;

    /**
     * @var string
     *
     * @ORM\Column(name="urban_sector", type="string", length=255, nullable=false)
     */
    private $urbanSector;

    /**
     * @var string
     *
     * @ORM\Column(name="av_calle_carrera", type="string", length=255, nullable=false)
     */
    private $avCalleCarrera;

    /**
     * @var string
     *
     * @ORM\Column(name="edif_casa", type="string", length=255, nullable=false)
     */
    private $edifCasa;

    /**
     * @var string
     *
     * @ORM\Column(name="ofc_apto_num", type="string", length=255, nullable=false)
     */
    private $ofcAptoNum;

    /**
     * @var string
     *
     * @ORM\Column(name="punto_referencia", type="string", length=255, nullable=false)
     */
    private $puntoReferencia;

    /**
     * @var boolean
     *
     * @ORM\Column(name="codigo_postal", type="boolean", nullable=false)
     */
    private $codigoPostal;

    /**
     * @var string
     *
     * @ORM\Column(name="fax", type="string", length=16, nullable=true)
     */
    private $fax;

    /**
     * @var string
     *
     * @ORM\Column(name="cod_tlf_fijo", type="string", length=4, nullable=true)
     */
    private $codTlfFijo;

    /**
     * @var string
     *
     * @ORM\Column(name="tfl_fijo", type="string", length=16, nullable=true)
     */
    private $tflFijo;

    /**
     * @var string
     *
     * @ORM\Column(name="cod_tlf_celular", type="string", length=4, nullable=true)
     */
    private $codTlfCelular;

    /**
     * @var string
     *
     * @ORM\Column(name="tfl_celular", type="string", length=16, nullable=true)
     */
    private $tflCelular;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=120, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="pag_web", type="string", length=255, nullable=true)
     */
    private $pagWeb;

    /**
     * @var \SysUsuario
     *
     * @ORM\ManyToOne(targetEntity="\Sunahip\UserBundle\Entity\SysUsuario")
     * @ORM\JoinColumn(name="idusuario", referencedColumnName="id")
     */
    private $usuario;

    /**
     * @var \SysEstado
     *
     * @ORM\ManyToOne(targetEntity="SysEstado")
     * @ORM\JoinColumn(name="idestado", referencedColumnName="id")
     */
    private $estado;

    /**
     * @var \SysCiudad
     *
     * @ORM\ManyToOne(targetEntity="SysCiudad")
     * @ORM\JoinColumn(name="idciudad", referencedColumnName="id")
     */
    private $ciudad;

    /**
     * @var \SysMunicipio
     *
     * @ORM\ManyToOne(targetEntity="SysMunicipio")
     * @ORM\JoinColumn(name="idmunicipio", referencedColumnName="id")
     */
    private $municipio;



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
     * Set fechaRegistro
     *
     * @param \DateTime $fechaRegistro
     * @return DataSucursal
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
     * Set status
     *
     * @param string $status
     * @return DataSucursal
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
     * Set denominacionComercial
     *
     * @param string $denominacionComercial
     * @return DataSucursal
     */
    public function setDenominacionComercial($denominacionComercial)
    {
        $this->denominacionComercial = $denominacionComercial;

        return $this;
    }

    /**
     * Get denominacionComercial
     *
     * @return string 
     */
    public function getDenominacionComercial()
    {
        return $this->denominacionComercial;
    }

    /**
     * Set rif
     *
     * @param integer $rif
     * @return DataSucursal
     */
    public function setRif($rif)
    {
        $this->rif = $rif;

        return $this;
    }

    /**
     * Get rif
     *
     * @return integer 
     */
    public function getRif()
    {
        return $this->rif;
    }

    /**
     * Set estatusLocal
     *
     * @param string $estatusLocal
     * @return DataSucursal
     */
    public function setEstatusLocal($estatusLocal)
    {
        $this->estatusLocal = $estatusLocal;

        return $this;
    }

    /**
     * Get estatusLocal
     *
     * @return string 
     */
    public function getEstatusLocal()
    {
        return $this->estatusLocal;
    }

    /**
     * Set propietarioLocal
     *
     * @param string $propietarioLocal
     * @return DataSucursal
     */
    public function setPropietarioLocal($propietarioLocal)
    {
        $this->propietarioLocal = $propietarioLocal;

        return $this;
    }

    /**
     * Get propietarioLocal
     *
     * @return string 
     */
    public function getPropietarioLocal()
    {
        return $this->propietarioLocal;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return DataSucursal
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellido
     *
     * @param string $apellido
     * @return DataSucursal
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set ci
     *
     * @param integer $ci
     * @return DataSucursal
     */
    public function setCi($ci)
    {
        $this->ci = $ci;

        return $this;
    }

    /**
     * Get ci
     *
     * @return integer 
     */
    public function getCi()
    {
        return $this->ci;
    }

    /**
     * Set urbanSector
     *
     * @param string $urbanSector
     * @return DataSucursal
     */
    public function setUrbanSector($urbanSector)
    {
        $this->urbanSector = $urbanSector;

        return $this;
    }

    /**
     * Get urbanSector
     *
     * @return string 
     */
    public function getUrbanSector()
    {
        return $this->urbanSector;
    }

    /**
     * Set avCalleCarrera
     *
     * @param string $avCalleCarrera
     * @return DataSucursal
     */
    public function setAvCalleCarrera($avCalleCarrera)
    {
        $this->avCalleCarrera = $avCalleCarrera;

        return $this;
    }

    /**
     * Get avCalleCarrera
     *
     * @return string 
     */
    public function getAvCalleCarrera()
    {
        return $this->avCalleCarrera;
    }

    /**
     * Set edifCasa
     *
     * @param string $edifCasa
     * @return DataSucursal
     */
    public function setEdifCasa($edifCasa)
    {
        $this->edifCasa = $edifCasa;

        return $this;
    }

    /**
     * Get edifCasa
     *
     * @return string 
     */
    public function getEdifCasa()
    {
        return $this->edifCasa;
    }

    /**
     * Set ofcAptoNum
     *
     * @param string $ofcAptoNum
     * @return DataSucursal
     */
    public function setOfcAptoNum($ofcAptoNum)
    {
        $this->ofcAptoNum = $ofcAptoNum;

        return $this;
    }

    /**
     * Get ofcAptoNum
     *
     * @return string 
     */
    public function getOfcAptoNum()
    {
        return $this->ofcAptoNum;
    }

    /**
     * Set puntoReferencia
     *
     * @param string $puntoReferencia
     * @return DataSucursal
     */
    public function setPuntoReferencia($puntoReferencia)
    {
        $this->puntoReferencia = $puntoReferencia;

        return $this;
    }

    /**
     * Get puntoReferencia
     *
     * @return string 
     */
    public function getPuntoReferencia()
    {
        return $this->puntoReferencia;
    }

    /**
     * Set codigoPostal
     *
     * @param boolean $codigoPostal
     * @return DataSucursal
     */
    public function setCodigoPostal($codigoPostal)
    {
        $this->codigoPostal = $codigoPostal;

        return $this;
    }

    /**
     * Get codigoPostal
     *
     * @return boolean 
     */
    public function getCodigoPostal()
    {
        return $this->codigoPostal;
    }

    /**
     * Set fax
     *
     * @param string $fax
     * @return DataSucursal
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string 
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set codTlfFijo
     *
     * @param string $codTlfFijo
     * @return DataSucursal
     */
    public function setCodTlfFijo($codTlfFijo)
    {
        $this->codTlfFijo = $codTlfFijo;

        return $this;
    }

    /**
     * Get codTlfFijo
     *
     * @return string 
     */
    public function getCodTlfFijo()
    {
        return $this->codTlfFijo;
    }

    /**
     * Set tflFijo
     *
     * @param string $tflFijo
     * @return DataSucursal
     */
    public function setTflFijo($tflFijo)
    {
        $this->tflFijo = $tflFijo;

        return $this;
    }

    /**
     * Get tflFijo
     *
     * @return string 
     */
    public function getTflFijo()
    {
        return $this->tflFijo;
    }

    /**
     * Set codTlfCelular
     *
     * @param string $codTlfCelular
     * @return DataSucursal
     */
    public function setCodTlfCelular($codTlfCelular)
    {
        $this->codTlfCelular = $codTlfCelular;

        return $this;
    }

    /**
     * Get codTlfCelular
     *
     * @return string 
     */
    public function getCodTlfCelular()
    {
        return $this->codTlfCelular;
    }

    /**
     * Set tflCelular
     *
     * @param string $tflCelular
     * @return DataSucursal
     */
    public function setTflCelular($tflCelular)
    {
        $this->tflCelular = $tflCelular;

        return $this;
    }

    /**
     * Get tflCelular
     *
     * @return string 
     */
    public function getTflCelular()
    {
        return $this->tflCelular;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return DataSucursal
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set pagWeb
     *
     * @param string $pagWeb
     * @return DataSucursal
     */
    public function setPagWeb($pagWeb)
    {
        $this->pagWeb = $pagWeb;

        return $this;
    }

    /**
     * Get pagWeb
     *
     * @return string 
     */
    public function getPagWeb()
    {
        return $this->pagWeb;
    }

    /**
     * Set usuario
     *
     * @param \Sunahip\UserBundle\Entity\SysUsuario $usuario
     * @return DataSucursal
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
     * Set estado
     *
     * @param \Sunahip\EntityBundle\Entity\SysEstado $estado
     * @return DataSucursal
     */
    public function setEstado(\Sunahip\EntityBundle\Entity\SysEstado $estado = null)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return \Sunahip\EntityBundle\Entity\SysEstado 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set ciudad
     *
     * @param \Sunahip\EntityBundle\Entity\SysCiudad $ciudad
     * @return DataSucursal
     */
    public function setCiudad(\Sunahip\EntityBundle\Entity\SysCiudad $ciudad = null)
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    /**
     * Get ciudad
     *
     * @return \Sunahip\EntityBundle\Entity\SysCiudad 
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * Set municipio
     *
     * @param \Sunahip\EntityBundle\Entity\SysMunicipio $municipio
     * @return DataSucursal
     */
    public function setMunicipio(\Sunahip\EntityBundle\Entity\SysMunicipio $municipio = null)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get municipio
     *
     * @return \Sunahip\EntityBundle\Entity\SysMunicipio 
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }
}
