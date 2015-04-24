<?php

namespace Sunahip\LicenciaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdmJuegosExplotados
 *
 * @ORM\Table(name="adm_juegos_explotados")
 * @ORM\Entity
 */
class AdmJuegosExplotados
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
     * @ORM\Column(name="juego", type="string", length=45, nullable=false)
     */
    private $juego;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=false)
     */
    private $status;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AdmClasfLicencias", mappedBy="admJuegosExplotados")
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
        return $this->getJuego();
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
     * Set juego
     *
     * @param string $juego
     * @return AdmJuegosExplotados
     */
    public function setJuego($juego)
    {
        $this->juego = $juego;

        return $this;
    }

    /**
     * Get juego
     *
     * @return string
     */
    public function getJuego()
    {
        return $this->juego;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return AdmJuegosExplotados
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Add admClasfLicencias
     *
     * @param \Sunahip\LicenciaBundle\Entity\AdmClasfLicencias $admClasfLicencias
     * @return AdmJuegosExplotados
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
