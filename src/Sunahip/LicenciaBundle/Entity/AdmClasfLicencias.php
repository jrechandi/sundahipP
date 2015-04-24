<?php

namespace Sunahip\LicenciaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdmClasfLicencias
 *
 * @ORM\Table(name="adm_clasf_licencias", indexes={@ORM\Index(name="fk_adm_clasf_licencias_adm_tipos_licencias1_idx", columns={"adm_tipos_licencias_id"})})
 * @ORM\Entity
 */
class AdmClasfLicencias
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
     * @ORM\Column(name="clasf_licencia", type="string", length=45, nullable=false)
     */
    private $clasfLicencia;

    /**
     * @var integer
     *
     * @ORM\Column(name="solicitud_ut", type="integer", nullable=false)
     */
    private $solicitudUt;

    /**
     * @var integer
     *
     * @ORM\Column(name="otorgamiento_ut", type="integer", nullable=false)
     */
    private $otorgamientoUt;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=45, nullable=false)
     */
    private $status;
    
    /**
     * @var string
     *
     * @ORM\Column(name="cod_licencia", type="string", length=45, nullable=false)
     */
    private $codLicencia;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="cod_actual", type="integer", nullable=true)
     */
    private $codActual=0;

    /**
     * @var \AdmTiposLicencias
     *
     * @ORM\ManyToOne(targetEntity="AdmTiposLicencias")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="adm_tipos_licencias_id", referencedColumnName="id")
     * })
     */
    private $admTiposLicencias;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AdmJuegosExplotados", inversedBy="admClasfLicencias")
     * @ORM\JoinTable(name="adm_clasf_licencias_has_adm_juegos_explotados",
     *   joinColumns={
     *     @ORM\JoinColumn(name="adm_clasf_licencias_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="adm_juegos_explotados_id", referencedColumnName="id")
     *   }
     * )
     */
    private $admJuegosExplotados;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AdmRecaudosLicencias", inversedBy="admClasfLicencias")
     * @ORM\JoinTable(name="adm_clasf_licencias_has_adm_recaudos_licencias",
     *   joinColumns={
     *     @ORM\JoinColumn(name="adm_clasf_licencias_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="adm_recaudos_licencias_id", referencedColumnName="id")
     *   }
     * )
     */
    private $admRecaudosLicencias;
    
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="has_operadora", type="boolean", nullable=true)
     */
    private $hasOperadora;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="has_hipodromo", type="boolean", nullable=true)
     */
    private $hasHipodromo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->admJuegosExplotados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->admRecaudosLicencias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getClasfLicencia();
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
     * Set clasfLicencia
     *
     * @param string $clasfLicencia
     * @return AdmClasfLicencias
     */
    public function setClasfLicencia($clasfLicencia)
    {
        $this->clasfLicencia = $clasfLicencia;

        return $this;
    }

    /**
     * Get clasfLicencia
     *
     * @return string
     */
    public function getClasfLicencia()
    {
        return $this->clasfLicencia;
    }

    /**
     * Set solicitudUt
     *
     * @param string $solicitudUt
     * @return AdmClasfLicencias
     */
    public function setSolicitudUt($solicitudUt)
    {
        $this->solicitudUt = $solicitudUt;

        return $this;
    }

    /**
     * Get solicitudUt
     *
     * @return string
     */
    public function getSolicitudUt()
    {
        return $this->solicitudUt;
    }

    /**
     * Set otorgamientoUt
     *
     * @param string $otorgamientoUt
     * @return AdmClasfLicencias
     */
    public function setOtorgamientoUt($otorgamientoUt)
    {
        $this->otorgamientoUt = $otorgamientoUt;

        return $this;
    }

    /**
     * Get otorgamientoUt
     *
     * @return string
     */
    public function getOtorgamientoUt()
    {
        return $this->otorgamientoUt;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return AdmClasfLicencias
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
     * Set codLicencia
     *
     * @param string $status
     * @return AdmClasfLicencias
     */
    public function setCodLicencia($codLicencia)
    {
        $this->codLicencia = $codLicencia;

        return $this;
    }

    /**
     * Get codLicencia
     *
     * @return string
     */
    public function getCodLicencia()
    {
        return $this->codLicencia;
    }
    
    /**
     * Set codActual
     *
     * @param integer $codActual
     * @return AdmClasfLicencias
     */
    public function setCodActual($codActual)
    {
        $this->codActual = $codActual;

        return $this;
    }

    /**
     * Get codActual
     *
     * @return integer
     */
    public function getCodActual()
    {
        return $this->codActual;
    }

    /**
     * Set admTiposLicencias
     *
     * @param \Sunahip\LicenciaBundle\Entity\AdmTiposLicencias $admTiposLicencias
     * @return AdmClasfLicencias
     */
    public function setAdmTiposLicencias(\Sunahip\LicenciaBundle\Entity\AdmTiposLicencias $admTiposLicencias = null)
    {
        $this->admTiposLicencias = $admTiposLicencias;

        return $this;
    }

    /**
     * Get admTiposLicencias
     *
     * @return \Sunahip\LicenciaBundle\Entity\AdmTiposLicencias
     */
    public function getAdmTiposLicencias()
    {
        return $this->admTiposLicencias;
    }

    /**
     * Add admJuegosExplotados
     *
     * @param \Sunahip\LicenciaBundle\Entity\AdmJuegosExplotados $admJuegosExplotados
     * @return AdmClasfLicencias
     */
    public function addAdmJuegosExplotado(\Sunahip\LicenciaBundle\Entity\AdmJuegosExplotados $admJuegosExplotados)
    {
        $this->admJuegosExplotados[] = $admJuegosExplotados;

        return $this;
    }

    /**
     * Remove admJuegosExplotados
     *
     * @param \Sunahip\LicenciaBundle\Entity\AdmJuegosExplotados $admJuegosExplotados
     */
    public function removeAdmJuegosExplotado(\Sunahip\LicenciaBundle\Entity\AdmJuegosExplotados $admJuegosExplotados)
    {
        $this->admJuegosExplotados->removeElement($admJuegosExplotados);
    }

    /**
     * Get admJuegosExplotados
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdmJuegosExplotados()
    {
        return $this->admJuegosExplotados;
    }

    /**
     * Add admRecaudosLicencias
     *
     * @param \Sunahip\LicenciaBundle\Entity\AdmRecaudosLicencias $admRecaudosLicencias
     * @return AdmClasfLicencias
     */
    public function addAdmRecaudosLicencia(\Sunahip\LicenciaBundle\Entity\AdmRecaudosLicencias $admRecaudosLicencias)
    {
        $this->admRecaudosLicencias[] = $admRecaudosLicencias;

        return $this;
    }

    /**
     * Remove admRecaudosLicencias
     *
     * @param \Sunahip\LicenciaBundle\Entity\AdmRecaudosLicencias $admRecaudosLicencias
     */
    public function removeAdmRecaudosLicencia(\Sunahip\LicenciaBundle\Entity\AdmRecaudosLicencias $admRecaudosLicencias)
    {
        $this->admRecaudosLicencias->removeElement($admRecaudosLicencias);
    }

    /**
     * Get admRecaudosLicencias
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdmRecaudosLicencias()
    {
        return $this->admRecaudosLicencias;
    }
    
    public function setHasOperadora($hasOperadora)
    {
        $this->hasOperadora = $hasOperadora;
        return $this;
    }
    
    public function getHasOperadora()
    {
        return $this->hasOperadora;
    }            
    
    public function setHasHipodromo($hasHipodromo)
    {
        $this->hasHipodromo = $hasHipodromo;
        return $this;
    }
    
    public function getHasHipodromo()
    {
        return $this->hasHipodromo;
    }   
}
