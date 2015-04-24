<?php

namespace Sunahip\PagosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Table(name="data_banco")
 * @ORM\Entity
 */
class Banco
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
     * @ORM\Column(name="banco", type="string", length=150, nullable=false)
     */
    protected $banco;


    /**
     * @ORM\Column(name="numero_cuenta",type="string", length=255)
     *
     */
    protected $numeroCuenta;

    /**
     * @var string
     *
     * @ORM\Column(name="activo", type="string", length=45, nullable=false)
     */
    private $activo;

    
    public function __toString() {
        return $this->getBanco();
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
     * Set banco
     *
     * @param string $banco
     * @return Banco
     */
    public function setBanco($banco)
    {
        $this->banco = $banco;

        return $this;
    }

    /**
     * Get banco
     *
     * @return string 
     */
    public function getBanco()
    {
        return $this->banco;
    }

    /**
     * Set numeroCuenta
     *
     * @param integer $numeroCuenta
     * @return Banco
     */
    public function setNumeroCuenta($numeroCuenta)
    {
        $this->numeroCuenta = $numeroCuenta;

        return $this;
    }

    /**
     * Get numeroCuenta
     *
     * @return integer 
     */
    public function getNumeroCuenta()
    {
        return $this->numeroCuenta;
    }

    /**
     * Set activo
     *
     * @param string $activo
     * @return Banco
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return string 
     */
    public function getActivo()
    {
        return $this->activo;
    }
}
