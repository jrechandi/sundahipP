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
 * @ORM\Table(name="data_empresa")
 * @ORM\Entity(repositoryClass="DataEmpresaRepository")
 */
class DataEmpresa
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
     * @ORM\JoinColumn(name="estado", referencedColumnName="id")
     */
    private $estado;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_registro", type="datetime", nullable=true)
     */
    private $fechaRegistro;

    /**
     * @var string
     *
     * @ORM\Column(name="ciudad", type="string", length=60, nullable=true)
     */
    private $ciudad;

    /**
     * @var \SysMunicipio
     *
     * @ORM\ManyToOne(targetEntity="\Sunahip\CommonBundle\Entity\SysMunicipio", inversedBy="centros")
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

//    protected $socios;


    /**
     * @var \SysUsuario
     *
     * @ORM\ManyToOne(targetEntity="\Sunahip\CentrohipicoBundle\Entity\DataEmpresa")
     * @ORM\JoinColumn(name="padre", referencedColumnName="id")
     */
    private $padre;

    public function __construct()
    {
       // $this->socios = new ArrayCollection();
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

//    public function getSocios()
//    {
//        return $this->socios;
//    }
//
//    public function setSocios(ArrayCollection $socios)
//    {
//        $this->socios = $socios;
//    }


    public function getPadre()
    {
        return $this->padre;
    }

    public function setPadre(\Sunahip\CentrohipicoBundle\Entity\DataEmpresa $padre)
    {
        $this->padre = $padre;
    }

    /**
     * Set denominacionComercial
     *
     * @param string $denominacionComercial
     * @return DataEmpresa
     */
    public function setDenominacionComercial($denominacionComercial)
    {
        $this->denominacionComercial = $denominacionComercial;

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
     * @return DataEmpresa
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
     * @return DataEmpresa
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
     * Set urbanSector
     *
     * @param string $urbanSector
     * @return DataEmpresa
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
     * @return DataEmpresa
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
     * @return DataEmpresa
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
     * @return DataEmpresa
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
     * @return DataEmpresa
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
     * @return DataEmpresa
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
     * @return DataEmpresa
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
     * @return DataEmpresa
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
     * @return DataEmpresa
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
     * @return DataEmpresa
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
     * @return DataEmpresa
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
     * @return DataEmpresa
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
     * @return DataEmpresa
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
     * @return DataEmpresa
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
     * @return DataEmpresa
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
     * @param String $ciudad
     * @return DataEmpresa
     */
    public function setCiudad($ciudad = null)
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    /**
     * Get ciudad
     *
     * @return \Sunahip\CommonBundle\Entity\SysCiudad 
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * Set municipio
     *
     * @param \Sunahip\CommonBundle\Entity\SysMunicipio $municipio
     * @return DataEmpresa
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
     * Set parroquia
     *
     * @param \Sunahip\CommonBundle\Entity\SysParroquia $parroquia
     * @return DataEmpresa
     */
    public function setParroquia(\Sunahip\CommonBundle\Entity\SysParroquia $parroquia = null)
    {
        $this->parroquia = $parroquia;

        return $this;
    }

    /**
     * Get parroquia
     *
     * @return \Sunahip\CommonBundle\Entity\SysParroquia 
     */
    public function getParroquia()
    {
        return $this->parroquia;
    }
}
