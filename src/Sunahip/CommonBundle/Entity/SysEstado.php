<?php

namespace Sunahip\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * SysEstado
 *
 * @ORM\Entity
 * @ORM\Table(name="estado")
 */
class SysEstado
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
     * @ORM\Column(name="nombre", type="string", length=60, nullable=false)
     */
    protected $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="pais", type="integer", nullable=false)
     */
    protected $pais;


    /**
     * @ORM\OneToMany(targetEntity="SysMunicipio", mappedBy="estado")
     **/
    protected $municipios;

    
    public function __construct() {
        $this->municipios = new ArrayCollection();
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
     * @return SysEstado
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
     * Set pais
     *
     * @param integer $pais
     * @return SysEstado
     */
    public function setPais($pais)
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * Get pais
     *
     * @return integer 
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * Add municipios
     *
     * @param \Sunahip\CommonBundle\Entity\SysMunicipio $municipios
     * @return SysEstado
     */
    public function addMunicipio(\Sunahip\CommonBundle\Entity\SysMunicipio $municipios)
    {
        $this->municipios[] = $municipios;

        return $this;
    }

    /**
     * Remove municipios
     *
     * @param \Sunahip\CommonBundle\Entity\SysMunicipio $municipios
     */
    public function removeMunicipio(\Sunahip\CommonBundle\Entity\SysMunicipio $municipios)
    {
        $this->municipios->removeElement($municipios);
    }

    /**
     * Get municipios
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMunicipios()
    {
        return $this->municipios;
    }
}
