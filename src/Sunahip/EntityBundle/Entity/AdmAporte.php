<?php

namespace Sunahip\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdmAporte
 *
 * @ORM\Table(name="adm_aporte")
 * @ORM\Entity(repositoryClass="Sunahip\EntityBundle\Entity\AdmAporteRepository")
 */
class AdmAporte
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
     * @ORM\Column(name="status", type="string", length=45, nullable=false)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="aporte", type="string", length=255, nullable=false)
     */
    private $aporte;

    /**
     * @var \AdmTipoAporte
     *
     * @ORM\ManyToOne(targetEntity="AdmTipoAporte")
     * @ORM\JoinColumn(name="idtipoaporte", referencedColumnName="id")
     */
    private $tipoaporte;

    /**
     * @var \AdmClasfLicencias
     *
     * @ORM\ManyToOne(targetEntity="AdmClasfLicencias")
     * @ORM\JoinColumn(name="idclasf", referencedColumnName="id")
     */
    private $ClasLicencia;



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
     * @return AdmAporte
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
     * Set aporte
     *
     * @param string $aporte
     * @return AdmAporte
     */
    public function setAporte($aporte)
    {
        $this->aporte = $aporte;

        return $this;
    }

    /**
     * Get aporte
     *
     * @return string 
     */
    public function getAporte()
    {
        return $this->aporte;
    }

    /**
     * Set tipoaporte
     *
     * @param \Sunahip\EntityBundle\Entity\AdmTipoAporte $tipoaporte
     * @return AdmAporte
     */
    public function setTipoaporte(\Sunahip\EntityBundle\Entity\AdmTipoAporte $tipoaporte = null)
    {
        $this->tipoaporte = $tipoaporte;

        return $this;
    }

    /**
     * Get tipoaporte
     *
     * @return \Sunahip\EntityBundle\Entity\AdmTipoAporte 
     */
    public function getTipoaporte()
    {
        return $this->tipoaporte;
    }

    /**
     * Set ClasLicencia
     *
     * @param \Sunahip\EntityBundle\Entity\AdmClasfLicencias $clasLicencia
     * @return AdmAporte
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
