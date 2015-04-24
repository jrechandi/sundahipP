<?php

namespace Sunahip\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SysParroquia
 *
 * @ORM\Entity
 * @ORM\Table(name="parroquia" )
 */
class SysParroquia
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
     * @ORM\Column(name="nombre", type="string", length=90, nullable=true)
     */
    protected $nombre;

    /**
     * @var \SysMunicipio
     *
     * @ORM\ManyToOne(targetEntity="SysMunicipio")
     * @ORM\JoinColumn(name="municipioid", referencedColumnName="id")
     */
    protected $municipio;




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
     * @return SysParroquia
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
     * Set municipio
     *
     * @param \Sunahip\CommonBundle\Entity\SysMunicipio $municipio
     * @return SysParroquia
     */
    public function setMunicipio(\Sunahip\CommonBundle\Entity\SysMunicipio $municipio = null)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get municipio
     *
     * @return \Sunahip\CommonBundle\Entity\SysMunicipio 
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }
}
