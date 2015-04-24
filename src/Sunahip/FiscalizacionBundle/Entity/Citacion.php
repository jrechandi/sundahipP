<?php

namespace Sunahip\FiscalizacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Citacion
 *
 * @ORM\Table(name="data_citacion")
 * @ORM\Entity
 */
class Citacion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="incumple", type="string", length=255, nullable=true)
     */
    private $incumple;

    /**
     * @var string
     *
     * @ORM\Column(name="renovacion", type="string", length=255, nullable=true)
     */
    private $renovacion;

    /**
     * @var string
     *
     * @ORM\Column(name="juego", type="string", length=255, nullable=true)
     */
    private $juego;

    /**
     * @var string
     *
     * @ORM\Column(name="explota", type="string", length=255, nullable=true)
     */
    private $explota;

    /**
     * @var string
     *
     * @ORM\Column(name="permiso", type="string", length=255, nullable=true)
     */
    private $permiso;

    /**
     * @var string
     *
     * @ORM\Column(name="otros", type="string", length=255, nullable=true)
     */
    private $otros;
    
    /**
     * @ORM\OneToOne(targetEntity="Fiscalizacion")
     * @ORM\JoinColumn(name="fiscalizacion_id", referencedColumnName="id")
     */
    private $fiscalizacion;


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
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Citacion
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set incumple
     *
     * @param string $incumple
     * @return Citacion
     */
    public function setIncumple($incumple)
    {
        $this->incumple = $incumple;

        return $this;
    }

    /**
     * Get incumple
     *
     * @return string 
     */
    public function getIncumple()
    {
        return $this->incumple;
    }

    /**
     * Set renovacion
     *
     * @param string $renovacion
     * @return Citacion
     */
    public function setRenovacion($renovacion)
    {
        $this->renovacion = $renovacion;

        return $this;
    }

    /**
     * Get renovacion
     *
     * @return string 
     */
    public function getRenovacion()
    {
        return $this->renovacion;
    }

    /**
     * Set juego
     *
     * @param string $juego
     * @return Citacion
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
     * Set explota
     *
     * @param string $explota
     * @return Citacion
     */
    public function setExplota($explota)
    {
        $this->explota = $explota;

        return $this;
    }

    /**
     * Get explota
     *
     * @return string 
     */
    public function getExplota()
    {
        return $this->explota;
    }

    /**
     * Set permiso
     *
     * @param string $permiso
     * @return Citacion
     */
    public function setPermiso($permiso)
    {
        $this->permiso = $permiso;

        return $this;
    }

    /**
     * Get permiso
     *
     * @return string 
     */
    public function getPermiso()
    {
        return $this->permiso;
    }

    /**
     * Set otros
     *
     * @param string $otros
     * @return Citacion
     */
    public function setOtros($otros)
    {
        $this->otros = $otros;

        return $this;
    }

    /**
     * Get otros
     *
     * @return string 
     */
    public function getOtros()
    {
        return $this->otros;
    }

    /**
     * Set fiscalizacion
     *
     * @param \Sunahip\FiscalizacionBundle\Entity\Fiscalizacion $fiscalizacion
     * @return Citacion
     */
    public function setFiscalizacion(\Sunahip\FiscalizacionBundle\Entity\Fiscalizacion $fiscalizacion = null)
    {
        $this->fiscalizacion = $fiscalizacion;

        return $this;
    }

    /**
     * Get fiscalizacion
     *
     * @return \Sunahip\FiscalizacionBundle\Entity\Fiscalizacion 
     */
    public function getFiscalizacion()
    {
        return $this->fiscalizacion;
    }
}
