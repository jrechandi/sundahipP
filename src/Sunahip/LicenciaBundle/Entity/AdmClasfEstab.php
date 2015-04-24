<?php

namespace Sunahip\LicenciaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdmClasfEstab
 *
 * @ORM\Table(name="adm_clasf_estab")
 * @ORM\Entity
 */
class AdmClasfEstab
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
     * @var integer
     *
     * @ORM\Column(name="clasificacion_centrohipico", type="string", length=45, nullable=false)
     */
    private $clasificacionCentrohipico;

    /**
     * @var string
     *
     * @ORM\Column(name="promedio_ventas", type="string", length=45, nullable=false)
     */
    private $promedioVentas;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AdmTipoAporte", mappedBy="admClasfEstab")
     */
    private $admTipoAporte;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->admTipoAporte = new \Doctrine\Common\Collections\ArrayCollection();
    }



    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getClasificacionCentrohipico();
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
     * Set clasificacionCentrohipico
     *
     * @param integer $clasificacionCentrohipico
     * @return AdmClasfEstab
     */
    public function setClasificacionCentrohipico($clasificacionCentrohipico)
    {
        $this->clasificacionCentrohipico = $clasificacionCentrohipico;

        return $this;
    }

    /**
     * Get clasificacionCentrohipico
     *
     * @return integer
     */
    public function getClasificacionCentrohipico()
    {
        return $this->clasificacionCentrohipico;
    }

    /**
     * Set promedioVentas
     *
     * @param string $promedioVentas
     * @return AdmClasfEstab
     */
    public function setPromedioVentas($promedioVentas)
    {
        $this->promedioVentas = $promedioVentas;

        return $this;
    }

    /**
     * Get promedioVentas
     *
     * @return string
     */
    public function getPromedioVentas()
    {
        return $this->promedioVentas;
    }

    /**
     * Add admTipoAporte
     *
     * @param \Sunahip\LicenciaBundle\Entity\AdmTipoAporte $admTipoAporte
     * @return AdmClasfEstab
     */
    public function addAdmTipoAporte(\Sunahip\LicenciaBundle\Entity\AdmTipoAporte $admTipoAporte)
    {
        $this->admTipoAporte[] = $admTipoAporte;

        return $this;
    }

    /**
     * Remove admTipoAporte
     *
     * @param \Sunahip\LicenciaBundle\Entity\AdmTipoAporte $admTipoAporte
     */
    public function removeAdmTipoAporte(\Sunahip\LicenciaBundle\Entity\AdmTipoAporte $admTipoAporte)
    {
        $this->admTipoAporte->removeElement($admTipoAporte);
    }

    /**
     * Get admTipoAporte
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAdmTipoAporte()
    {
        return $this->admTipoAporte;
    }
}
