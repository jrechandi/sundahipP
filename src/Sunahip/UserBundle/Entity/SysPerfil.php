<?php
namespace Sunahip\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sunahip\CommonBundle\DBAL\Types\RifType;
use Fresh\Bundle\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * SysPerfil
 *
 * @ORM\Entity
 * @ORM\Table(name="sys_perfil")
 * @ORM\Entity(repositoryClass="Sunahip\UserBundle\Entity\PerfilRepository")
 */
class SysPerfil
{

    /**
     * @var integer
     *
     * @ORM\Column(name="idperfil", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $idperfil;

    /**
     * @var string
     * @ORM\Column(name="pers_juridica", type="RifType", nullable=false)
     * @DoctrineAssert\Enum(entity="Sunahip\CommonBundle\DBAL\Types\RifType")
     */
    protected $persJuridica;

    /**
     * @var string
     * @ORM\Column(name="role_type", type="RoleType", nullable=false)
     * @DoctrineAssert\Enum(entity="Sunahip\CommonBundle\DBAL\Types\RoleType")
     */
    protected $roleType;

    /**
     * @var boolean
     *
     * @ORM\Column(name="rif", type="integer", nullable=false)
     */
    protected $rif;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ci", type="integer", nullable=true)
     */
    protected $ci;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50, nullable=true)
     */
    protected $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=50, nullable=true)
     */
    protected $apellido;

    /**
     * @ORM\ManyToOne(targetEntity="SysUsuario", inversedBy="perfil")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user", referencedColumnName="id")
     * })
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="\Sunahip\CommonBundle\Entity\SysEstado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="estado", referencedColumnName="id")
     * })
     */
    protected $estado;

    /**
     * @ORM\Column(name="ciudad", type="string", length=60, nullable=true)
     */
    protected $ciudad;

    /**
     * @ORM\ManyToOne(targetEntity="\Sunahip\CommonBundle\Entity\SysMunicipio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="municipio", referencedColumnName="id")
     * })
     */
    protected $municipio;

    /**
     * @ORM\ManyToOne(targetEntity="\Sunahip\CommonBundle\Entity\SysParroquia")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parroquia", referencedColumnName="id")
     * })
     */
    protected $parroquia;

    /**
     * @ORM\Column(name="urbanizacion", type="string", length=150, nullable=true)
     */
    protected $urbanizacion;

    /**
     * @ORM\Column(name="calle", type="string", length=150, nullable=true)
     */
    protected $calle;

    /**
     * @ORM\Column(name="apartamento", type="string", length=150, nullable=true)
     */
    protected $apartamento;

    /**
     * @ORM\Column(name="apartamento_no", type="string", length=150, nullable=true)
     */
    protected $apartamento_no;

    /**
     * @ORM\Column(name="referencia", type="string", length=250, nullable=true)
     */
    protected $referencia;

    /**
     * @ORM\Column(name="codigo_postal", type="string", length=250, nullable=true)
     */
    protected $codigo_postal;
    
    /**
     * @ORM\Column(name="cod_fax", type="string", length=4, nullable=true)
     */
    protected $cod_fax;

    /**
     * @ORM\Column(name="fax", type="string", length=250, nullable=true)
     */
    protected $fax;
    
    /**
     * @ORM\Column(name="cod_telefono_local", type="string", length=4, nullable=true)
     */
    protected $cod_telefono_local;

    /**
     * @ORM\Column(name="telefono_local", type="string", length=10, nullable=true)
     */
    protected $telefono_local;
        
     /**
     * @ORM\Column(name="cod_telefono_movil", type="string", length=4, nullable=true)
     */
    protected $cod_telefono_movil;
    /**
     * @ORM\Column(name="telefono_movil", type="string", length=10, nullable=true)
     */
    protected $telefono_movil;

    /**
     * @ORM\Column(name="correo_alternativo", type="string", length=250, nullable=true)
     */
    protected $correo_alternativo;

    /**
     * @ORM\Column(name="sitio_web", type="string", length=250, nullable=true)
     */
    protected $sitio_web;


    public function __toString() {
        return $this->getFullName();
    }


    /**
     * Envia el nombre mas el apellido
     * @return string
     */
    public function getFullName(){
        return "$this->nombre $this->apellido";
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->idperfil;
    }

    /**
     * @var string
     *
     * @param string $persJuridica
     * @return SysUsuario
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
     * @var string
     *
     * @param string $roleType
     * @return SysUsuario
     */
    public function setRoleType($roleType)
    {
        $this->roleType = $roleType;
        return $this;
    }

    /**
     * Get roleType
     *
     * @return string 
     */
    public function getRoleType()
    {
        return $this->roleType;
    }

    /**
     * Set rif
     *
     * @param boolean $rif
     * @return SysUsuario
     */
    public function setRif($rif)
    {
        $this->rif = $rif;

        return $this;
    }

    /**
     * Get rif
     *
     * @return boolean 
     */
    public function getRif()
    {
        return $this->rif;
    }

    /**
     * Set ci
     *
     * @param boolean $ci
     * @return SysUsuario
     */
    public function setCi($ci)
    {
        $this->ci = $ci;

        return $this;
    }

    /**
     * Get ci
     *
     * @return boolean 
     */
    public function getCi()
    {
        return $this->ci;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return SysUsuario
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
     * @return SysUsuario
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

    public function setUser(SysUsuario $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setEstado(\Sunahip\CommonBundle\Entity\SysEstado $estado)
    {
        $this->estado = $estado;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;
    }

    public function getCiudad()
    {
        return $this->ciudad;
    }

    public function setMunicipio(\Sunahip\CommonBundle\Entity\SysMunicipio $municipio)
    {
        $this->municipio = $municipio;
    }

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

    public function setUrbanizacion($urbanizacion)
    {
        $this->urbanizacion = $urbanizacion;
    }

    public function getUrbanizacion()
    {
        return $this->urbanizacion;
    }

    public function setCalle($calle)
    {
        $this->calle = $calle;
    }

    public function getCalle()
    {
        return $this->calle;
    }

    public function setApartamento($apartamento)
    {
        $this->apartamento = $apartamento;
    }

    public function getApartamento()
    {
        return $this->apartamento;
    }

    public function setApartamentoNo($apartamento_no)
    {
        $this->apartamento_no = $apartamento_no;
    }

    public function getApartamentoNo()
    {
        return $this->apartamento_no;
    }

    public function setReferencia($referencia)
    {
        $this->referencia = $referencia;
    }

    public function getReferencia()
    {
        return $this->referencia;
    }

    public function setCodigoPostal($codigo_postal)
    {
        $this->codigo_postal = $codigo_postal;
    }

    public function getCodigoPostal()
    {
        return $this->codigo_postal;
    }

    public function setFax($fax)
    {
        $this->fax = $fax;
    }

    public function getFax()
    {
        return $this->fax;
    }
    
    public function setCodTelefonoLocal($cod_telefono_local)
    {
        $this->cod_telefono_local = $cod_telefono_local;
    }

    public function getCodTelefonoLocal()
    {
        return $this->cod_telefono_local;
    }

    public function setTelefonoLocal($telefono_local)
    {
        $this->telefono_local = $telefono_local;
    }

    public function getTelefonoLocal()
    {
        return $this->telefono_local;
    }
    
    public function setCodTelefonoMovil($cod_telefono_movil)
    {
        $this->cod_telefono_movil = $cod_telefono_movil;
    }

    public function getCodTelefonoMovil()
    {
        return $this->cod_telefono_movil;
    }
    
    public function setTelefonoMovil($telefono_movil)
    {
        $this->telefono_movil = $telefono_movil;
    }

    public function getTelefonoMovil()
    {
        return $this->telefono_movil;
    }

    public function setCorreoAlternativo($correo_alternativo)
    {
        $this->correo_alternativo = $correo_alternativo;
    }

    public function getCorreoAlternativo()
    {
        return $this->correo_alternativo;
    }

    public function setSitioWeb($sitio_web)
    {
        $this->sitio_web = $sitio_web;
    }

    public function getSitioWeb()
    {
        return $this->sitio_web;
    }
    
    public function setCodFax($cod_fax)
    {
        $this->cod_fax = $cod_fax;
    }

    public function getCodFax()
    {
        return $this->cod_fax;
    }


    /**
     * Get idperfil
     *
     * @return integer 
     */
    public function getIdperfil()
    {
        return $this->idperfil;
    }
}
