<?php

namespace Sunahip\LicenciaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdmTipoAporte
 *
 * @ORM\Table(name="adm_tipo_aporte", indexes={@ORM\Index(name="fk_adm_tipo_aporte_adm_clasf_licencias1_idx", columns={"adm_clasf_licencias_id"})})
 * @ORM\Entity
 */
class AdmTipoAporte
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
     * @ORM\Column(name="monto_aporte", type="string", length=255, nullable=false)
     */
    private $montoAporte;

    /**
     * @var string
     *
     * @ORM\Column(name="por_juego", type="string", length=45, nullable=false)
     */
    private $porJuego;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=45, nullable=false)
     */
    private $status;

    /**
     * @var \AdmClasfLicencias
     *
     * @ORM\ManyToOne(targetEntity="AdmClasfLicencias")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="adm_clasf_licencias_id", referencedColumnName="id")
     * })
     */
    private $admClasfLicencias;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AdmClasfEstab", inversedBy="admTipoAporte")
     * @ORM\JoinTable(name="adm_tipo_aporte_has_adm_clasf_estab",
     *   joinColumns={
     *     @ORM\JoinColumn(name="adm_tipo_aporte_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="adm_clasf_estab_id", referencedColumnName="id")
     *   }
     * )
     */
    private $admClasfEstab;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->admClasfEstab = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set montoAporte
     *
     * @param string $montoAporte
     * @return AdmTipoAporte
     */
    public function setMontoAporte($montoAporte)
    {
        $this->montoAporte = $montoAporte;

        return $this;
    }

    /**
     * Get montoAporte
     *
     * @return string 
     */
    public function getMontoAporte()
    {
        return $this->montoAporte;
    }

    /**
     * Set porJuego
     *
     * @param string $porJuego
     * @return AdmTipoAporte
     */
    public function setPorJuego($porJuego)
    {
        $this->porJuego = $porJuego;

        return $this;
    }

    /**
     * Get porJuego
     *
     * @return string 
     */
    public function getPorJuego()
    {
        return $this->porJuego;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return AdmTipoAporte
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
     * Set admClasfLicencias
     *
     * @param \Sunahip\LicenciaBundle\Entity\AdmClasfLicencias $admClasfLicencias
     * @return AdmTipoAporte
     */
    public function setAdmClasfLicencias(\Sunahip\LicenciaBundle\Entity\AdmClasfLicencias $admClasfLicencias = null)
    {
        $this->admClasfLicencias = $admClasfLicencias;

        return $this;
    }

    /**
     * Get admClasfLicencias
     *
     * @return \Sunahip\LicenciaBundle\Entity\AdmClasfLicencias 
     */
    public function getAdmClasfLicencias()
    {
        return $this->admClasfLicencias;
    }

    /**
     * Add admClasfEstab
     *
     * @param \Sunahip\LicenciaBundle\Entity\AdmClasfEstab $admClasfEstab
     * @return AdmTipoAporte
     */
    public function addAdmClasfEstab(\Sunahip\LicenciaBundle\Entity\AdmClasfEstab $admClasfEstab)
    {
        $this->admClasfEstab[] = $admClasfEstab;

        return $this;
    }

    /**
     * Remove admClasfEstab
     *
     * @param \Sunahip\LicenciaBundle\Entity\AdmClasfEstab $admClasfEstab
     */
    public function removeAdmClasfEstab(\Sunahip\LicenciaBundle\Entity\AdmClasfEstab $admClasfEstab)
    {
        $this->admClasfEstab->removeElement($admClasfEstab);
    }

    /**
     * Get admClasfEstab
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAdmClasfEstab()
    {
        return $this->admClasfEstab;
    }
}
