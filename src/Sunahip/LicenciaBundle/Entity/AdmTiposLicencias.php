<?php

namespace Sunahip\LicenciaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sunahip\CommonBundle\DBAL\Types\UsuarioLicenciaType;
use Fresh\Bundle\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;

/**
 * AdmTiposLicencias
 *
 * @ORM\Table(name="adm_tipos_licencias")
 * @ORM\Entity
 */
class AdmTiposLicencias
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
     * @ORM\Column(name="tipo_licencia", type="string", length=45, nullable=false)
     */
    private $tipoLicencia;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=45, nullable=false)
     */
    private $status;
    
    /**
     * @var string
     *
     * @ORM\Column(name="role_type", type="UsuarioLicenciaType", nullable=false)
     * @DoctrineAssert\Enum(entity="Sunahip\CommonBundle\DBAL\Types\UsuarioLicenciaType")
     */
    protected $roleType;  


    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getTipoLicencia();
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
     * Set tipoLicencia
     *
     * @param string $tipoLicencia
     * @return AdmTiposLicencias
     */
    public function setTipoLicencia($tipoLicencia)
    {
        $this->tipoLicencia = $tipoLicencia;

        return $this;
    }

    /**
     * Get tipoLicencia
     *
     * @return string
     */
    public function getTipoLicencia()
    {
        return $this->tipoLicencia;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return AdmTiposLicencias
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
     * @var string
     *
     * @param string $roleType
     * @return AdmTiposLicencias
     */
    public function setRoleType($roleType)
    {
        $this->roleType = $roleType;
        return $this;
    }
    
    /**
     * Get roleType
     *
     * @return string 
     */
    public function getRoleType()
    {
        return $this->roleType;
    }    
}
