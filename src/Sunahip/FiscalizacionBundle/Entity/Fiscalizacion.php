<?php

namespace Sunahip\FiscalizacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Fiscalizacion
 *
 * @ORM\Table(name="data_fiscalizacion")
 * @ORM\Entity(repositoryClass="Sunahip\FiscalizacionBundle\Entity\FiscalizacionRepository")
 */
class Fiscalizacion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="responsable", type="string", length=255)
     */
    private $responsable;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="cod", type="string", length=1)
     */
    private $codCedula;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/^[0-9]{6,8}$/",
     *     message="La cédula no valida, formato V-12345678"
     * )
     * @ORM\Column(name="cedula", type="string", length=8)
     */
    private $cedula;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="cargo", type="string", length=255)
     */
    private $cargo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

     /**
     * @Assert\NotBlank()
     * @ORM\ManyToMany(targetEntity="Sunahip\LicenciaBundle\Entity\AdmJuegosExplotados")
     * @ORM\JoinTable(name="data_fisc_juego",
     *      joinColumns={@ORM\JoinColumn(name="fis_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="juego_id", referencedColumnName="id")}
     *      )
     */
    private $juegos;

    /**
     * 
     * @Assert\Count(
     *      min = "1",
     *      minMessage = "Debe especificar al menos un documento adjunto",
     * )
     * @Assert\Valid()
     * @ORM\OneToMany(targetEntity="Documento", mappedBy="fiscalizacion", cascade={"persist"})
     **/
    private $documentos;

     /**
     * @ORM\ManyToOne(targetEntity="Sunahip\CentrohipicoBundle\Entity\DataCentrohipico", inversedBy="fiscalizacion")
     * @ORM\JoinColumn(name="centro_id", referencedColumnName="id")
     */
    private $centro;

    /** 
     * @ORM\ManyToOne(targetEntity="Sunahip\CentrohipicoBundle\Entity\DataOperadora", inversedBy="fiscalizacion")
     * @ORM\JoinColumn(name="operadora_id", referencedColumnName="id")
     */
    private $operadora;

    /**
     * @ORM\ManyToOne(targetEntity="Providencia", inversedBy="fiscalizacion")
     * @ORM\JoinColumn(name="prov_id", referencedColumnName="id")
     */
    private $providencia;

    /**
     * @var string
     * @ORM\Column(name="estatus", nullable=true, type="string", columnDefinition="enum('Solvente', 'Citado', 'Multado')")
     */ 
    private $estatus;

    /**
     * @ORM\ManyToOne(targetEntity="Sunahip\UserBundle\Entity\SysPerfil", inversedBy="fiscalizacion")
     * @ORM\JoinColumn(name="fiscal_id", referencedColumnName="idperfil", nullable=FALSE)
     */
    private $fiscal; 

     /**
     * @ORM\OneToOne(targetEntity="Citacion", mappedBy="fiscalizacion")
     */
    private $citacion;

    public function __construct() {
        $this->juegos = new ArrayCollection();
        $this->documentos = new ArrayCollection();
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
     * Set responsable
     *
     * @param string $responsable
     * @return Fiscalizacion
     */
    public function setResponsable($responsable)
    {
        $this->responsable = $responsable;

        return $this;
    }

    /**
     * Get responsable
     *
     * @return string 
     */
    public function getResponsable()
    {
        return $this->responsable;
    }

    /**
     * Set cedula
     *
     * @param string $cedula
     * @return Fiscalizacion
     */
    public function setCedula($cedula)
    {
        $this->cedula = $cedula;

        return $this;
    }

    /**
     * Get cedula
     *
     * @return string 
     */
    public function getCedula()
    {
        return $this->cedula;
    }

    /**
     * Set cargo
     *
     * @param string $cargo
     * @return Fiscalizacion
     */
    public function setCargo($cargo)
    {
        $this->cargo = $cargo;

        return $this;
    }

    /**
     * Get cargo
     *
     * @return string 
     */
    public function getCargo()
    {
        return $this->cargo;
    }

    /**
     * Add juegos
     *
     * @param \Sunahip\LicenciaBundle\Entity\AdmJuegosExplotados $juegos
     * @return Fiscalizacion
     */
    public function addJuego(\Sunahip\LicenciaBundle\Entity\AdmJuegosExplotados $juegos)
    {
        $this->juegos[] = $juegos;

        return $this;
    }

    /**
     * Remove juegos
     *
     * @param \Sunahip\LicenciaBundle\Entity\AdmJuegosExplotados $juegos
     */
    public function removeJuego(\Sunahip\LicenciaBundle\Entity\AdmJuegosExplotados $juegos)
    {
        $this->juegos->removeElement($juegos);
    }

    /**
     * Get juegos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getJuegos()
    {
        return $this->juegos;
    }

    /**
     * Set centro
     *
     * @param \Sunahip\CentrohipicoBundle\Entity\DataCentrohipico $centro
     * @return Fiscalizacion
     */
    public function setCentro(\Sunahip\CentrohipicoBundle\Entity\DataCentrohipico $centro = null)
    {
        $this->centro = $centro;

        return $this;
    }

    /**
     * Get centro
     *
     * @return \Sunahip\CentrohipicoBundle\Entity\DataCentrohipico 
     */
    public function getCentro()
    {
        return !is_null($this->centro)?$this->centro:$this->operadora;
    }

    /**
     * Set providencia
     *
     * @param \Sunahip\FiscalizacionBundle\Entity\Providencia $providencia
     * @return Fiscalizacion
     */
    public function setProvidencia(\Sunahip\FiscalizacionBundle\Entity\Providencia $providencia = null)
    {
        $this->providencia = $providencia;

        return $this;
    }

    /**
     * Get providencia
     *
     * @return \Sunahip\FiscalizacionBundle\Entity\Providencia 
     */
    public function getProvidencia()
    {
        return $this->providencia;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Fiscalizacion
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

   
    /**
     * Add documentos
     *
     * @param \Sunahip\FiscalizacionBundle\Entity\Documento $documentos
     * @return Fiscalizacion
     */
    public function addDocumento(\Sunahip\FiscalizacionBundle\Entity\Documento $documentos)
    {
        $documentos->setFiscalizacion($this);
        $this->documentos[] = $documentos;
        return $this;
    }

    /**
     * Remove documentos
     *
     * @param \Sunahip\FiscalizacionBundle\Entity\Documento $documentos
     */
    public function removeDocumento(\Sunahip\FiscalizacionBundle\Entity\Documento $documentos)
    {
        $this->documentos->removeElement($documentos);
    }

    /**
     * Get documentos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDocumentos()
    {
        return $this->documentos;
    }

    /**
     * Set operadora
     *
     * @param \Sunahip\CentrohipicoBundle\Entity\DataOperadora $operadora
     * @return Fiscalizacion
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
     * Set codCedula
     *
     * @param string $codCedula
     * @return Fiscalizacion
     */
    public function setCodCedula($codCedula)
    {
        $this->codCedula = $codCedula;

        return $this;
    }

    /**
     * Get codCedula
     *
     * @return string 
     */
    public function getCodCedula()
    {
        return $this->codCedula;
    }

    /**
     * Set estatus
     *
     * @param string $estatus
     * @return Fiscalizacion
     */
    public function setEstatus($estatus)
    {
        $this->estatus = $estatus;

        return $this;
    }

    /**
     * Get estatus
     *
     * @return string 
     */
    public function getEstatus()
    {
        return $this->estatus;
    }

    /**
     * Set fiscal
     *
     * @param \Sunahip\UserBundle\Entity\SysPerfil $fiscal
     * @return Fiscalizacion
     */
    public function setFiscal(\Sunahip\UserBundle\Entity\SysPerfil $fiscal)
    {
        $this->fiscal = $fiscal;

        return $this;
    }

    /**
     * Get fiscal
     *
     * @return \Sunahip\UserBundle\Entity\SysPerfil 
     */
    public function getFiscal()
    {
        return $this->fiscal;
    }

    /**
     * Set citacion
     *
     * @param \Sunahip\FiscalizacionBundle\Entity\Citacion $citacion
     * @return Fiscalizacion
     */
    public function setCitacion(\Sunahip\FiscalizacionBundle\Entity\Citacion $citacion = null)
    {
        $this->citacion = $citacion;

        return $this;
    }

    /**
     * Get citacion
     *
     * @return \Sunahip\FiscalizacionBundle\Entity\Citacion 
     */
    public function getCitacion()
    {
        return $this->citacion;
    }
}
