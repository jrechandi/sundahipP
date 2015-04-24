<?php

namespace Sunahip\FiscalizacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Verificacion
 *
 * @ORM\Table(name="data_verificacion")
 * @ORM\Entity
 */
class Verificacion
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
     * Set fiscalizacion
     *
     * @param \Sunahip\FiscalizacionBundle\Entity\Fiscalizacion $fiscalizacion
     * @return Verificacion
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
