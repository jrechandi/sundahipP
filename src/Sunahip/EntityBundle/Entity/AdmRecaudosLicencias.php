<?php

namespace Sunahip\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdmRecaudosLicencias
 *
 * @ORM\Table(name="adm_recaudos_licencias")
 * @ORM\Entity(repositoryClass="Sunahip\EntityBundle\Entity\AdmRecaudosLicenciasRepository")
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
     * @var \AdmClasfLicencias
     *
     * @ORM\ManyToOne(targetEntity="AdmClasfLicencias")
     * @ORM\JoinColumn(name="idclasf", referencedColumnName="id")
     */
    private $ClasLicencia;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=45, nullable=false)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="recaudos", type="string", length=255, nullable=false)
     */
    private $recaudos;


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
     * Set recaudos
     *
     * @param string $recaudos
     * @return AdmRecaudosLicencias
     */
    public function setRecaudos($recaudos)
    {
        $this->recaudos = $recaudos;

        return $this;
    }

    /**
     * Get recaudos
     *
     * @return string 
     */
    public function getRecaudos()
    {
        return $this->recaudos;
    }

    /**
     * Set ClasLicencia
     *
     * @param \Sunahip\EntityBundle\Entity\AdmClasfLicencias $clasLicencia
     * @return AdmRecaudosLicencias
     */
    public function setClasLicencia(\Sunahip\EntityBundle\Entity\AdmClasfLicencias $clasLicencia = null)
    {
        $this->ClasLicencia = $clasLicencia;

        return $this;
    }

    /**
     * Get ClasLicencia
     *
     * @return \Sunahip\EntityBundle\Entity\AdmClasfLicencias 
     */
    public function getClasLicencia()
    {
        return $this->ClasLicencia;
    }
}
