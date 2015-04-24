<?php

namespace Sunahip\CentrohipicoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sunahip\CommonBundle\DBAL\Types\RifType;
use Sunahip\CommonBundle\DBAL\Types\CIType;
use Fresh\Bundle\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * DataEmpresa Centrohipicon
 *
 * @ORM\Table(name="data_empresa_ch")
 * @ORM\Entity(repositoryClass="DataEmpresaCHRepository")
 */
class DataEmpresaCH
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="\Sunahip\CentrohipicoBundle\Entity\DataCentrohipico")
     * @ORM\JoinColumn(name="idcentroh", referencedColumnName="id")
     */
    private $centroHipico;


    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="\Sunahip\CentrohipicoBundle\Entity\DataEmpresa")
     * @ORM\JoinColumn(name="idempresa", referencedColumnName="id")
     */
    private $empresa;


    public function setCentroHipico(\Sunahip\CentrohipicoBundle\Entity\DataCentrohipico $centrohipico)
    {
        $this->centroHipico = $centrohipico;
    }

    public function getCentroHipico()
    {
        return $this->centroHipico;
    }

    public function setEmpresa(\Sunahip\CentrohipicoBundle\Entity\DataEmpresa $empresa)
    {
        $this->empresa = $empresa;
    }

    public function getEmpresa()
    {
        return $this->empresa;
    }

}