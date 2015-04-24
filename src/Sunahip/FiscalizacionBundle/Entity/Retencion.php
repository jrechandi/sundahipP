<?php

namespace Sunahip\FiscalizacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Retencion
 *
 * @ORM\Table(name="data_retencion")
 * @ORM\Entity
 */
class Retencion
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
     * @ORM\ManyToOne(targetEntity="Sunahip\UserBundle\Entity\SysPerfil")
     * @ORM\JoinColumn(name="funcionario", referencedColumnName="idperfil")
     */
    private $funcionario;

    /**
     * @var string
     * 
     * @ORM\OneToMany(targetEntity="Equipo", mappedBy="retencion", cascade={"persist"})
     */
    private $equipos;

    /**
     * @ORM\OneToOne(targetEntity="Fiscalizacion")
     * @ORM\JoinColumn(name="fiscalizacion_id", referencedColumnName="id")
     */
    private $fiscalizacion;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->equipos = new \Doctrine\Common\Collections\ArrayCollection();
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
    
    public function setFuncionario(\Sunahip\UserBundle\Entity\SysPerfil $funcionario)
    {
        $this->funcionario = $funcionario;

        return $this;
    }
    
    public function getFuncionario()
    {
        return $this->funcionario;
    }

    /**
     * Add equipos
     *
     * @param \Sunahip\FiscalizacionBundle\Entity\Equipos $equipos
     * @return Retencion
     */
    public function addEquipo(\Sunahip\FiscalizacionBundle\Entity\Equipo $equipos)
    {
        $this->equipos[] = $equipos;
        $equipos->setRetencion($this);
        return $this;
    }

    /**
     * Remove equipos
     *
     * @param \Sunahip\FiscalizacionBundle\Entity\Equipos $equipos
     */
    public function removeEquipo(\Sunahip\FiscalizacionBundle\Entity\Equipo $equipos)
    {
        $this->equipos->removeElement($equipos);
    }

    /**
     * Get equipos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEquipos()
    {
        return $this->equipos;
    }

    /**
     * Set fiscalizacion
     *
     * @param \Sunahip\FiscalizacionBundle\Entity\Fiscalizacion $fiscalizacion
     * @return Retencion
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
