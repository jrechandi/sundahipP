<?php

namespace Sunahip\CentrohipicoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sunahip\CommonBundle\DBAL\Types\RifType;
use Sunahip\CommonBundle\DBAL\Types\CIType;
use Fresh\Bundle\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * DataCentrohipico
 * Establecimiento Local de Operacion 
 *
 * @ORM\Table(name="data_centrohipico")
 * @ORM\Entity(repositoryClass="DataCentrohipicoRepository")
 */
class DataCentrohipico
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
     * @ORM\Column(name="estatus_local", type="string", length=45, nullable=true)
     */
    private $estatusLocal;

    /**
     * @var string
     *
     * @ORM\Column(name="propietario_local", type="string", length=255, nullable=true)
     */
    private $propietarioLocal;

    /**
     * @var \AdmClasfEstab
     *
     * @ORM\ManyToOne(targetEntity="\Sunahip\LicenciaBundle\Entity\AdmClasfEstab")
     * @ORM\JoinColumn(name="clasificacion_local", referencedColumnName="id")
     */
    private $clasificacionLocal;

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
     * @ORM\Column(name="pers_juridica_dueno", type="RifType", nullable=true)
     * @DoctrineAssert\Enum(entity="Sunahip\CommonBundle\DBAL\Types\RifType")
     */
    private $persJuridicaDueno;

    /**
     * @var integer
     *
     * @ORM\Column(name="rif_dueno", type="integer", nullable=true)
     */
    private $rifDueno;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=120, nullable=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=45, nullable=true)
     */
    private $apellido;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoci", type="CIType", nullable=true)
     * @DoctrineAssert\Enum(entity="Sunahip\CommonBundle\DBAL\Types\CIType")
     */
    private $tipoci;

    /**
     * @var integer
     *
     * @ORM\Column(name="ci", type="integer", nullable=true)
     */
    private $ci;

    /**
     * @var string
     *
     * @ORM\Column(name="urban_sector", type="string", length=255, nullable=true)
     */
    private $urbanSector;

    /**
     * @var string
     *
     * @ORM\Column(name="av_calle_carrera", type="string", length=255, nullable=true)
     */
    private $avCalleCarrera;

    /**
     * @var string
     *
     * @ORM\Column(name="edif_casa", type="string", length=255, nullable=true)
     */
    private $edifCasa;

    /**
     * @var string
     *
     * @ORM\Column(name="ofc_apto_num", type="string", length=255, nullable=true)
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
     * @ORM\Column(name="codigo_postal", type="string", length=5, nullable=true)
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
     * @ORM\JoinColumn(name="usuario", referencedColumnName="id")
     */
    private $usuario;

    /**
     * @var \SysEstado
     *
     * @ORM\ManyToOne(targetEntity="\Sunahip\CommonBundle\Entity\SysEstado")
     * @ORM\JoinColumn(name="estado", referencedColumnName="id", nullable=true)
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="ciudad", type="string", length=60)
     */
    private $ciudad;

    /**
     * @var \SysMunicipio
     *
     * @ORM\ManyToOne(targetEntity="\Sunahip\CommonBundle\Entity\SysMunicipio", inversedBy="centros")
     * @ORM\JoinColumn(name="municipio", referencedColumnName="id", nullable=true)
     */
    private $municipio;
    
    /**
     * @ORM\ManyToOne(targetEntity="\Sunahip\CommonBundle\Entity\SysParroquia")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parroquia", referencedColumnName="id", nullable=true)
     * })
     */
    private $parroquia;

    /**
     *
     * @ORM\ManyToOne(targetEntity="DataEmpresa")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="empresa", referencedColumnName="id", nullable=true)
     * })
     **/
    private $empresa;
    
    /**
     * 
     * @ORM\OneToMany(targetEntity="DataLicenciasAprob", mappedBy="centrohipico")
     * 
     **/
    private $licenciasaprob;

    /**
     * @ORM\OneToOne(targetEntity="Sunahip\FiscalizacionBundle\Entity\Mercantil")
     * @ORM\JoinColumn(name="registro_id", referencedColumnName="id", nullable=true)
     **/
    private $registro;



    
    


   public function __construct() {
        $this->licenciasaprob = new ArrayCollection();
    }
   
   public function getIdentificador(){
        return "$this->persJuridica-$this->rif — $this->denominacionComercial";
   }

    public function __toString() {
        return $this->getDenominacionComercial();
    }
    
   public function getFullrif()
    {
        return "$this->persJuridica-$this->rif";        
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
     * @return DataCentrohipico
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
     * @return DataCentrohipico
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
     * @return DataCentrohipico
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
     * Set estatusLocal
     *
     * @param string $estatusLocal
     * @return DataCentrohipico
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
     * @return DataCentrohipico
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
     * Set clasificacionLocal
     *
     * @param integer $clasificacionLocal
     * @return DataCentrohipico
     */
    public function setClasificacionLocal($clasificacionLocal)
    {
        $this->clasificacionLocal = $clasificacionLocal;

        return $this;
    }

    /**
     * Get clasificacionLocal
     *
     * @return integer
     */
    public function getClasificacionLocal()
    {
        return $this->clasificacionLocal;
    }

    /**
     * Set persJuridica
     *
     * @param RifType $persJuridica
     * @return DataCentrohipico
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
     * @return DataCentrohipico
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
     * Set nombre
     *
     * @param string $nombre
     * @return DataCentrohipico
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


    public function setEmpresa($empresa)
    {
        $this->empresa = $empresa;
    }



    /**
     * Set apellido
     *
     * @param string $apellido
     * @return DataCentrohipico
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
     * @return DataCentrohipico
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
     * @return DataCentrohipico
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
     * @return DataCentrohipico
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
     * @return DataCentrohipico
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
     * @return DataCentrohipico
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
     * @return DataCentrohipico
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
     * @return DataCentrohipico
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
     * @param string $codigoPostal
     * @return DataCentrohipico
     */
    public function setCodigoPostal($codigoPostal)
    {
        $this->codigoPostal = $codigoPostal;

        return $this;
    }

    /**
     * Get codigoPostal
     *
     * @return string
     */
    public function getCodigoPostal()
    {
        return $this->codigoPostal;
    }

    /**
     * Set fax
     *
     * @param string $fax
     * @return DataCentrohipico
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


    public function getCodFax()
    {
        return $this->codFax;
    }

    public function setCodFax($codFax)
    {
        $this->codFax = $codFax;
    }

    /**
     * Set codTlfFijo
     *
     * @param string $codTlfFijo
     * @return DataCentrohipico
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
     * @return DataCentrohipico
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
     * @return DataCentrohipico
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
     * @return DataCentrohipico
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
     * @return DataCentrohipico
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
     * @return DataCentrohipico
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
     * @return DataCentrohipico
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
     * @return DataCentrohipico
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
     * @return DataCentrohipico
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
     * @return DataCentrohipico
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

    /**
     * Add empresa
     *
     * @param \Sunahip\CentrohipicoBundle\Entity\Dataempresa $empresa
     * @return DataCentrohipico
     */
    public function addEmpresa(\Sunahip\CentrohipicoBundle\Entity\DataEmpresa $empresa)
    {
        $this->empresa[] = $empresa;

        return $this;
    }

    /**
     * Remove empresa
     *
     * @param \Sunahip\CentrohipicoBundle\Entity\Dataempresa $empresa
     */
    public function removeEmpresa(\Sunahip\CentrohipicoBundle\Entity\DataEmpresa $empresa)
    {
        $this->empresa->removeElement($empresa);
    }

    /**
     * Get legal
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEmpresa()
    {
        return $this->empresa;
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
     * Add licenciasaprob
     *
     * @param \Sunahip\CentrohipicoBundle\Entity\DataLicenciasAprob $licenciasaprob
     * @return DataCentrohipico
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
     * Set persJuridicaDueno
     *
     * @param RifType $persJuridicaDueno
     * @return DataCentrohipico
     */
    public function setPersJuridicaDueno($persJuridicaDueno)
    {
        $this->persJuridicaDueno = $persJuridicaDueno;

        return $this;
    }

    /**
     * Get persJuridicaDueno
     *
     * @return RifType 
     */
    public function getPersJuridicaDueno()
    {
        return $this->persJuridicaDueno;
    }

    /**
     * Set rifDueno
     *
     * @param integer $rifDueno
     * @return DataCentrohipico
     */
    public function setRifDueno($rifDueno)
    {
        $this->rifDueno = $rifDueno;

        return $this;
    }

    /**
     * Get rifDueno
     *
     * @return integer 
     */
    public function getRifDueno()
    {
        return $this->rifDueno;
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
