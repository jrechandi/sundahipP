<?php

namespace Sunahip\LicenciaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdmRecaudosLicencias
 *
 * @ORM\Table(name="adm_recaudos_licencias")
 * @ORM\Entity
 */
class AdmRecaudosLicencias
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
     * @ORM\Column(name="recaudo", type="text", nullable=false)
     */
    private $recaudo;

    /**
     * @var boolean
     *
     * @ORM\Column(name="fecha_vencimiento", type="boolean", nullable=false)
     */
    private $fechaVencimiento;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=45, nullable=false)
     */
    private $status;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AdmClasfLicencias", mappedBy="admRecaudosLicencias")
     */
    private $admClasfLicencias;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->admClasfLicencias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getRecaudo();
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
     * Set recaudo
     *
     * @param string $recaudo
     * @return AdmRecaudosLicencias
     */
    public function setRecaudo($recaudo)
    {
        $this->recaudo = $recaudo;

        return $this;
    }

    /**
     * Get recaudo
     *
     * @return string
     */
    public function getRecaudo()
    {
        return $this->recaudo;
    }

    /**
     * Set fechaVencimiento
     *
     * @param boolean $fechaVencimiento
     * @return AdmRecaudosLicencias
     */
    public function setFechaVencimiento($fechaVencimiento)
    {
        $this->fechaVencimiento = $fechaVencimiento;

        return $this;
    }

    /**
     * Get fechaVencimiento
     *
     * @return boolean
     */
    public function getFechaVencimiento()
    {
        return $this->fechaVencimiento;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return AdmRecaudosLicencias
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
     * Add admClasfLicencias
     *
     * @param \Sunahip\LicenciaBundle\Entity\AdmClasfLicencias $admClasfLicencias
     * @return AdmRecaudosLicencias
     */
    public function addAdmClasfLicencia(\Sunahip\LicenciaBundle\Entity\AdmClasfLicencias $admClasfLicencias)
    {
        $this->admClasfLicencias[] = $admClasfLicencias;

        return $this;
    }

    /**
     * Remove admClasfLicencias
     *
     * @param \Sunahip\LicenciaBundle\Entity\AdmClasfLicencias $admClasfLicencias
     */
    public function removeAdmClasfLicencia(\Sunahip\LicenciaBundle\Entity\AdmClasfLicencias $admClasfLicencias)
    {
        $this->admClasfLicencias->removeElement($admClasfLicencias);
    }

    /**
     * Get admClasfLicencias
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdmClasfLicencias()
    {
        return $this->admClasfLicencias;
    }
}
