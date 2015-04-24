<?php

namespace Sunahip\CentrohipicoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sunahip\CommonBundle\DBAL\Types\RifType;
use Sunahip\CommonBundle\DBAL\Types\CIType;
use Fresh\Bundle\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;

/**
 * DataLegal
 *
 * @ORM\Table(name="data_legal")
 * @ORM\Entity(repositoryClass="DataLegalRepository")
 */
class DataLegal
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_registro", type="datetime", nullable=true)
     */
    private $fechaRegistro;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=45, nullable=true)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_comercial", type="string", length=120, nullable=true)
     */
    private $nombreComercial;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=45, nullable=true)
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
     * @ORM\Column(name="pers_juridica", type="RifType", nullable=true)
     * @DoctrineAssert\Enum(entity="Sunahip\CommonBundle\DBAL\Types\RifType")
     */
    private $persJuridica;

    /**
     * @var integer
     *
     * @ORM\Column(name="rif", type="integer", nullable=true)
     */
    private $rif;

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
     * @ORM\Column(name="codigo_postal", type="string",length=5, nullable=true)
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
     * @ORM\ManyToOne(targetEntity="\Sunahip\CentrohipicoBundle\Entity\DataEmpresa")
     * @ORM\JoinColumn(name="empresa", referencedColumnName="id")
     */
    private $empresa;

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
     *   @ORM\JoinColumn(name="estado", referencedColumnName="id")
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="ciudad", type="string", length=60, nullable=true)
     */
    private $ciudad;

    /**
     * @var \SysMunicipio
     *
     * @ORM\ManyToOne(targetEntity="\Sunahip\CommonBundle\Entity\SysMunicipio")
     * @ORM\JoinColumn(name="municipio", referencedColumnName="id")
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
     * @var \Sunahip\CentrohipicoBundle\Entity\DataLegal
     *
     * @ORM\ManyToOne(targetEntity="\Sunahip\CentrohipicoBundle\Entity\DataLegal")
     *   @ORM\JoinColumn(name="padre", referencedColumnName="id")
     */
    private $padre;

    /**
     * @var string
     *
     * @ORM\Column(name="is_socio", type="boolean", length=1, nullable=true)
     */
    private $isSocio;



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
     *
     * @return integer
     */
    public function getPadre()
    {
        return $this->id;
    }


    /**
     * Set operadora
     *
     * @param \Sunahip\CentrohipicoBundle\Entity\DataLegal $padre
     * @return Pago
     */
    public function setPadre(\Sunahip\CentrohipicoBundle\Entity\DataLegal $padre = null)
    {
        $this->padre = $padre;

        return $this;
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
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }


    /**
     */
    public function setEmpresa(\Sunahip\CentrohipicoBundle\Entity\DataEmpresa $empresa = null)
    {
        $this->empresa = $empresa;

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
     * Set fechaRegistro
     *
     * @param \DateTime $fechaRegistro
     * @return DataLegal
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
     * @return DataLegal
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
     * Set nombre
     *
     * @param string $nombre
     * @return DataLegal
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
     * @return DataLegal
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
     * Set persJuridica
     *
     * @param string $persJuridica
     * @return DataLegal
     */
    public function setPersJuridica($persJuridica)
    {
        $this->persJuridica = $persJuridica;

        return $this;
    }

    /**
     * Get persJuridica
     *
     * @return string 
     */
    public function getPersJuridica()
    {
        return $this->persJuridica;
    }

    /**
     * Set rif
     *
     * @param integer $rif
     * @return DataLegal
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
     * Set ci
     *
     * @param integer $ci
     * @return DataLegal
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
     * @return DataLegal
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
     * @return DataLegal
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
     * @return DataLegal
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
     * @return DataLegal
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
     * @return DataLegal
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
     * @return DataLegal
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
     * @return DataLegal
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
     * @return DataLegal
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
     * @return DataLegal
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
     * @return DataLegal
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
     * @return DataLegal
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
     * @return DataLegal
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
     * @return DataLegal
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
     * @return DataLegal
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
     * @return DataLegal
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
     * @return DataLegal
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
     * @return DataLegal
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
    
    public function setParroquia(\Sunahip\CommonBundle\Entity\SysParroquia $parroquia = null)
    {
        $this->parroquia = $parroquia;
    }

    public function getParroquia()
    {
        return $this->parroquia;
    }

    /**
     * Set nombreComercial
     *
     * @param string $nombreComercial
     * @return DataLegal
     */
    public function setNombreComercial($nombreComercial)
    {
        $this->nombreComercial = $nombreComercial;

        return $this;
    }

    /**
     * Get nombreComercial
     *
     * @return string 
     */
    public function getNombreComercial()
    {
        return $this->nombreComercial;
    }

    /**
     * Set tipoci
     *
     * @param CIType $tipoci
     * @return DataLegal
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
     * Set isSocio
     *
     * @param boolean $isSocio
     * @return DataLegal
     */
    public function setIsSocio($isSocio)
    {
        $this->isSocio = $isSocio;

        return $this;
    }

    /**
     * Get isSocio
     *
     * @return boolean 
     */
    public function getIsSocio()
    {
        return $this->isSocio;
    }
}
