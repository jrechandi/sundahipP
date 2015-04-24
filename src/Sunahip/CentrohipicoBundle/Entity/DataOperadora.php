<?php

namespace Sunahip\CentrohipicoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sunahip\CommonBundle\DBAL\Types\RifType;
use Sunahip\CommonBundle\DBAL\Types\CIType;
use Fresh\Bundle\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;

/**
 * DataOperadora
 * Oficina Principal o Establecimiento de Labor
 * 
 * @ORM\Table(name="data_operadora")
 * @ORM\Entity(repositoryClass="DataOperadoraRepository")
 */
class DataOperadora
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
     * @var string
     *
     * @ORM\Column(name="pers_juridica", type="RifType", nullable=false)
     * @DoctrineAssert\Enum(entity="Sunahip\CommonBundle\DBAL\Types\RifType")
     */
    private $persJuridica;
    
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
     * @var string
     *
     * @ORM\Column(name="tipoci", type="CIType", nullable=false)
     * @DoctrineAssert\Enum(entity="Sunahip\CommonBundle\DBAL\Types\CIType")
     */
    private $tipoci;
    
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
     * @ORM\Column(name="punto_referencia", type="string", length=255, nullable=true)
     */
    private $puntoReferencia;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_postal", type="string", length=4, nullable=false)
     */
    private $codigoPostal;


    /**
     * @var string
     *
     * @ORM\Column(name="cod_fax", type="string", length=4, nullable=true)
     */
    private $codFax;

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
     * @ORM\Column(name="tlf_fijo", type="string", length=16, nullable=true)
     */
    private $tlfFijo;

    /**
     * @var string
     *
     * @ORM\Column(name="cod_tlf_celular", type="string", length=4, nullable=true)
     */
    private $codTlfCelular;

    /**
     * @var string
     *
     * @ORM\Column(name="tlf_celular", type="string", length=16, nullable=true)
     */
    private $tlfCelular;

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
     * @ORM\ManyToOne(targetEntity="\Sunahip\UserBundle\Entity\SysUsuario", inversedBy="operadora")
     * @ORM\JoinColumn(name="idusuario", referencedColumnName="id")
     */
    private $usuario;

    /**
     * @var \Sunahip\CommonBundle\Entity\SysEstado
     *
     * @ORM\ManyToOne(targetEntity="\Sunahip\CommonBundle\Entity\SysEstado")
     * @ORM\JoinColumn(name="idestado", referencedColumnName="id")
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="ciudad", type="string", length=60, nullable=false)
     */
    private $ciudad;
    
    /**
     * @var \Sunahip\CommonBundle\Entity\SysMunicipio
     *
     * @ORM\ManyToOne(targetEntity="\Sunahip\CommonBundle\Entity\SysMunicipio", inversedBy="operadoras")
     * @ORM\JoinColumn(name="idmunicipio", referencedColumnName="id")
     */
    private $municipio;
    
     /**
     * @ORM\ManyToOne(targetEntity="\Sunahip\CommonBundle\Entity\SysParroquia")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parroquia", referencedColumnName="id")
     * })
     */
    private $parroquia;

    /**
     * @var \DataLegal
     *
     * @ORM\ManyToOne(targetEntity="DataLegal", cascade={"persist"})
     * @ORM\JoinColumn(name="idlegal", referencedColumnName="id")
     */
    private $legal;
    
    /**
     * @var boolean 
     * @ORM\Column(name="es_sucursal",type="boolean",nullable=true)
     */
    private $esSucursal=false;

    
    /**
     * 
     * @ORM\OneToMany(targetEntity="DataLicenciasAprob", mappedBy="operadora")
     **/
    private $licenciasaprob;

    /**
     * @ORM\OneToOne(targetEntity="Sunahip\FiscalizacionBundle\Entity\Mercantil")
     * @ORM\JoinColumn(name="registro_id", referencedColumnName="id")
     **/
    private $registro;
    

    public function getIdentificador(){
        return "$this->persJuridica-$this->rif — $this->denominacionComercial";
    }
   
    public function getFullrif()
    {
        return "$this->persJuridica-$this->rif";        
    }
    
    public function __toString() {
        return $this->getDenominacionComercial();
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
     * Set fechaRegistro
     *
     * @param \DateTime $fechaRegistro
     * @return DataOperadora
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
     * @return DataOperadora
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
     * @return DataOperadora
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
     * Set persJuridica
     *
     * @param RifType $persJuridica
     * @return DataOperadora
     */
    public function setPersJuridica($persJuridica)
    {
        $this->persJuridica = $persJuridica;

        return $this;
    }

    /**
     * Get persJuridica
     *
     * @return RifType 
     */
    public function getPersJuridica()
    {
        return $this->persJuridica;
    }

    /**
     * Set rif
     *
     * @param integer $rif
     * @return DataOperadora
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
     * @return DataOperadora
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
     * @return DataOperadora
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
     * @return DataOperadora
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
     * @return DataOperadora
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
     * Set tipoci
     *
     * @param CIType $tipoci
     * @return DataOperadora
     */
    public function setTipoci($tipoci)
    {
        $this->tipoci = $tipoci;

        return $this;
    }

    /**
     * Get tipoci
     *
     * @return CIType 
     */
    public function getTipoci()
    {
        return $this->tipoci;
    }

    /**
     * Set ci
     *
     * @param integer $ci
     * @return DataOperadora
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
     * @return DataOperadora
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
     * @return DataOperadora
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
     * @return DataOperadora
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
     * @return DataOperadora
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
     * @return DataOperadora
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
     * @return DataOperadora
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


    public function getCodFax()
    {
        return $this->codFax;
    }

    public function setCodFax($codFax)
    {
        $this->codFax = $codFax;
    }

    /**
     * Set fax
     *
     * @param string $fax
     * @return DataOperadora
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
     * @return DataOperadora
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
    public function getTlfFijo()
    {
        return $this->tlfFijo;
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
     * @return DataOperadora
     */
    public function setTflFijo($tlfFijo)
    {
        $this->tlfFijo = $tlfFijo;

        return $this;
    }

    /**
     * Get tflFijo
     *
     * @return string 
     */
    public function getTflFijo()
    {
        return $this->tlfFijo;
    }

    /**
     * Set codTlfCelular
     *
     * @param string $codTlfCelular
     * @return DataOperadora
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
     * Get codTlfCelular
     *
     * @return string
     */
    public function getTlfCelular()
    {
        return $this->tlfCelular;
    }

    /**
     * Set tflCelular
     *
     * @param string $tflCelular
     * @return DataOperadora
     */
    public function setTflCelular($tlfCelular)
    {
        $this->tlfCelular = $tlfCelular;

        return $this;
    }

    /**
     * Get tflCelular
     *
     * @return string 
     */
    public function getTflCelular()
    {
        return $this->tlfCelular;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return DataOperadora
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
     * @return DataOperadora
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
     * @return DataOperadora
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
     * @param \Sunahip\CommonBundle\Entity\SysEstado $estado
     * @return DataOperadora
     */
    public function setEstado(\Sunahip\CommonBundle\Entity\SysEstado $estado = null)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return \Sunahip\CommonBundle\Entity\SysEstado 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set ciudad
     *
     * @param string $ciudad
     * @return DataOperadora
     */
    public function setCiudad($ciudad = null)
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    /**
     * Get ciudad
     *
     * @return string
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * Set municipio
     *
     * @param \Sunahip\CommonBundle\Entity\SysMunicipio $municipio
     * @return DataOperadora
     */
    public function setMunicipio(\Sunahip\CommonBundle\Entity\SysMunicipio $municipio = null)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get municipio
     *
     * @return \Sunahip\CommonBundle\Entity\SysMunicipio 
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }
    
    public function setParroquia(\Sunahip\CommonBundle\Entity\SysParroquia $parroquia)
    {
        $this->parroquia = $parroquia;
    }

    public function getParroquia()
    {
        return $this->parroquia;
    }

    /**
     * Set legal
     *
     * @param \Sunahip\CentrohipicoBundle\Entity\DataLegal $legal
     * @return DataOperadora
     */
    public function setLegal(\Sunahip\CentrohipicoBundle\Entity\DataLegal $legal = null)
    {
        $this->legal = $legal;

        return $this;
    }

    /**
     * Get legal
     *
     * @return \Sunahip\CentrohipicoBundle\Entity\DataLegal 
     */
    public function getLegal()
    {
        return $this->legal;
    }

    /**
     * Set tlfFijo
     *
     * @param string $tlfFijo
     * @return DataOperadora
     */
    public function setTlfFijo($tlfFijo)
    {
        $this->tlfFijo = $tlfFijo;

        return $this;
    }

    /**
     * Set tlfCelular
     *
     * @param string $tlfCelular
     * @return DataOperadora
     */
    public function setTlfCelular($tlfCelular)
    {
        $this->tlfCelular = $tlfCelular;

        return $this;
    }

    /**
     * Set esSucursal
     *
     * @param boolean $esSucursal
     * @return DataOperadora
     */
    public function setEsSucursal($esSucursal)
    {
        $this->esSucursal = $esSucursal;

        return $this;
    }

    /**
     * Get esSucursal
     *
     * @return boolean 
     */
    public function getEsSucursal()
    {
        return $this->esSucursal;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->licenciasaprob = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add licenciasaprob
     *
     * @param \Sunahip\CentrohipicoBundle\Entity\DataLicenciasAprob $licenciasaprob
     * @return DataOperadora
     */
    public function addLicenciasaprob(\Sunahip\CentrohipicoBundle\Entity\DataLicenciasAprob $licenciasaprob)
    {
        $this->licenciasaprob[] = $licenciasaprob;

        return $this;
    }

    /**
     * Remove licenciasaprob
     *
     * @param \Sunahip\CentrohipicoBundle\Entity\DataLicenciasAprob $licenciasaprob
     */
    public function removeLicenciasaprob(\Sunahip\CentrohipicoBundle\Entity\DataLicenciasAprob $licenciasaprob)
    {
        $this->licenciasaprob->removeElement($licenciasaprob);
    }

    /**
     * Get licenciasaprob
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLicenciasaprob()
    {
        return $this->licenciasaprob;
    }

    
    /**
     * Set registro
     *
     * @param \Sunahip\FiscalizacionBundle\Entity\Mercantil $registro
     * @return DataCentrohipico
     */
    public function setRegistro(\Sunahip\FiscalizacionBundle\Entity\Mercantil $registro = null)
    {
        $this->registro = $registro;

        return $this;
    }

    /**
     * Get registro
     *
     * @return \Sunahip\FiscalizacionBundle\Entity\Mercantil 
     */
    public function getRegistro()
    {
        return $this->registro;
    }
}