<?php

namespace Sunahip\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdmTipoAporte
 *
 * @ORM\Table(name="adm_tipo_aporte")
 * @ORM\Entity(repositoryClass="AdmTipoAporteRepository")
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
     * @ORM\Column(name="status", type="string", length=45, nullable=false)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_aporte", type="string", length=255, nullable=false)
     */
    private $tipoAporte;



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
     * Set tipoAporte
     *
     * @param string $tipoAporte
     * @return AdmTipoAporte
     */
    public function setTipoAporte($tipoAporte)
    {
        $this->tipoAporte = $tipoAporte;

        return $this;
    }

    /**
     * Get tipoAporte
     *
     * @return string 
     */
    public function getTipoAporte()
    {
        return $this->tipoAporte;
    }
}
