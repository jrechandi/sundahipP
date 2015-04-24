<?php

namespace Sunahip\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DataCitaAsignada
 *
 * @ORM\Table(name="data_cita_asignada")
 * @ORM\Entity(repositoryClass="Sunahip\EntityBundle\Entity\DataCitaAsignadaRepository")
 */
class DataCitaAsignada
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
     * @var \DataCitas
     *
     * @ORM\ManyToOne(targetEntity="DataCitas")
     * @ORM\JoinColumn(name="idcita", referencedColumnName="id")
     */
    private $cita;

    /**
     * @var \SysUsuario
     *
     * @ORM\ManyToOne(targetEntity="\Sunahip\UserBundle\Entity\SysUsuario")
     * @ORM\JoinColumn(name="idusuario", referencedColumnName="id")
     */
    private $usuario;


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
     * @return DataCitaAsignada
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
     * Set cita
     *
     * @param \Sunahip\EntityBundle\Entity\DataCitas $cita
     * @return DataCitaAsignada
     */
    public function setCita(\Sunahip\EntityBundle\Entity\DataCitas $cita = null)
    {
        $this->cita = $cita;

        return $this;
    }

    /**
     * Get cita
     *
     * @return \Sunahip\EntityBundle\Entity\DataCitas 
     */
    public function getCita()
    {
        return $this->cita;
    }

    /**
     * Set usuario
     *
     * @param \Sunahip\UserBundle\Entity\SysUsuario $usuario
     * @return DataCitaAsignada
     */
    public function setUsuario(\Sunahip\UserBundle\Entity\SysUsuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \Sunahip\UserBundle\Entity\SysUsuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}
