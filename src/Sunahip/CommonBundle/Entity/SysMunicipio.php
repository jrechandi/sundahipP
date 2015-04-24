<?php

namespace Sunahip\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SysMunicipio
 * 
 * @ORM\Table(name="municipio" )
 * @ORM\Entity
 */
class SysMunicipio
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=90, nullable=false)
     */
    protected $nombre;

    /**
     * @var \SysEstado
     *
     * @ORM\ManyToOne(targetEntity="SysEstado", inversedBy="municipios")
     * @ORM\JoinColumn(name="estadoid", referencedColumnName="id")
     * 
     */
    protected $estado;

    /**
     * @ORM\OneToMany(targetEntity="Sunahip\CentrohipicoBundle\Entity\DataCentrohipico", mappedBy="municipio")
     **/
    protected $centros;

    /**
     * @ORM\OneToMany(targetEntity="Sunahip\CentrohipicoBundle\Entity\DataOperadora", mappedBy="municipio")
     **/
    protected $operadoras;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->centros = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add centros
     *
     * @param \Sunahip\CentrohipicoBundle\Entity\DataCentrohipico $centros
     * @return SysMunicipio
     */
    public function addCentro(\Sunahip\CentrohipicoBundle\Entity\DataCentrohipico $centros)
    {
        $this->centros[] = $centros;

        return $this;
    }

    /**
     * Remove centros
     *
     * @param \Sunahip\CentrohipicoBundle\Entity\DataCentrohipico $centros
     */
    public function removeCentro(\Sunahip\CentrohipicoBundle\Entity\DataCentrohipico $centros)
    {
        $this->centros->removeElement($centros);
    }

    /**
     * Get centros
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCentros()
    {
        return $this->centros;
    }

    /**
     * Add operadoras
     *
     * @param \Sunahip\CentrohipicoBundle\Entity\DataOperadora $operadoras
     * @return SysMunicipio
     */
    public function addOperadora(\Sunahip\CentrohipicoBundle\Entity\DataOperadora $operadoras)
    {
        $this->operadoras[] = $operadoras;

        return $this;
    }

    /**
     * Remove operadoras
     *
     * @param \Sunahip\CentrohipicoBundle\Entity\DataOperadora $operadoras
     */
    public function removeOperadora(\Sunahip\CentrohipicoBundle\Entity\DataOperadora $operadoras)
    {
        $this->operadoras->removeElement($operadoras);
    }

    /**
     * Get operadoras
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOperadoras()
    {
        return $this->operadoras;
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
     * Set nombre
     *
     * @param string $nombre
     * @return SysMunicipio
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set estado
     *
     * @param \Sunahip\CommonBundle\Entity\SysEstado $estado
     * @return SysMunicipio
     */
    public function setEstado(\Sunahip\CommonBundle\Entity\SysEstado $estado = null)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return \Sunahip\CommonBundle\Entity\SysEstado 
     */
    public function getEstado()
    {
        return $this->estado;
    }
}
