<?php

namespace Sunahip\SolicitudesCitasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdmFechasCitas
 *
 * @ORM\Table(name="adm_fecha_citas")
 * @ORM\Entity(repositoryClass="Sunahip\SolicitudesCitasBundle\Entity\AdmFechasCitasRepository")
 */
class AdmFechasCitas
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
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=200)
     */
    private $description;

    /**
     * Especifica que es Simpre Todos los años
     * @var boolean
     *
     * @ORM\Column(name="allways", type="boolean", nullable=true)
     */
    private $allways = false;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="maxcitaxday", type="integer", nullable=true)
     */
    private $maxcitaxday = 10;


    public function __construct() {
        $this->allways=false;// Si no se Especifica click algun Valor
        $this->maxcitaxday=10;// Si no se Especifica click algun Valor
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
     * Set fecha
     *
     * @param \DateTime $date
     * @return AdmFechasCitas
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return AdmFechasCitas
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set allways
     *
     * @param boolean $allways
     * @return AdmFechasCitas
     */
    public function setAllways($allways)
    {
        $this->allways = $allways;

        return $this;
    }

    /**
     * Get allways
     *
     * @return boolean 
     */
    public function getAllways()
    {
        return $this->allways;
    }

    /**
     * Set maxcitaxday
     *
     * @param integer $maxcitaxday
     * @return AdmFechasCitas
     */
    public function setMaxcitaxday($maxcitaxday)
    {
        $this->maxcitaxday = $maxcitaxday;

        return $this;
    }

    /**
     * Get maxcitaxday
     *
     * @return integer 
     */
    public function getMaxcitaxday()
    {
        return $this->maxcitaxday;
    }
}
