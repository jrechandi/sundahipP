<?php

namespace Sunahip\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdmClasfEstab
 *
 * @ORM\Table(name="adm_clasf_estab")
 * @ORM\Entity(repositoryClass="Sunahip\EntityBundle\Entity\AdmClasfEstabRepository")
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
     * @ORM\Column(name="clasificacion_centrohipico", type="integer", nullable=false)
     */
    private $clasificacionCentrohipico;

    /**
     * @var string
     *
     * @ORM\Column(name="promedio_ventas", type="string", length=45, nullable=false)
     */
    private $promedioVentas;




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
}
