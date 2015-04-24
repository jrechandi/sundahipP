<?php

namespace Sunahip\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DataAfilChipicoOper
 *
 * @ORM\Table(name="data_afil_chipico_oper")
 * @ORM\Entity(repositoryClass="Sunahip\EntityBundle\Entity\DataAfilChipioOperRepository")
 */
class DataAfilChipicoOper
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_solicitud", type="datetime", nullable=false)
     */
    private $fechaSolicitud;

    /**
     * @var string
     *
     * @ORM\Column(name="contrato", type="string", length=255, nullable=false)
     */
    private $contrato;

    /**
     * @var string
     *
     * @ORM\Column(name="buena_pro", type="string", length=255, nullable=false)
     */
    private $buenaPro;

    /**
     * @var string
     *
     * @ORM\Column(name="acepta_condiciones", type="string", length=255, nullable=false)
     */
    private $aceptaCondiciones;

    /**
     * @var \SysUsuario
     *
     * @ORM\ManyToOne(targetEntity="\Sunahip\UserBundle\Entity\SysUsuario")
     * @ORM\JoinColumn(name="idusuario", referencedColumnName="id")
     */
    private $usuario;

    /**
     * @var \DataCentrohipico
     *
     * @ORM\ManyToOne(targetEntity="DataCentrohipico")
     * @ORM\JoinColumn(name="idcentroh", referencedColumnName="id")
     */
    private $centroHipico;

    /**
     * @var \AdmClasfLicencias
     *
     * @ORM\ManyToOne(targetEntity="AdmClasfLicencias")
     * @ORM\JoinColumn(name="idclasf", referencedColumnName="id")
     */
    private $ClasLicencia;



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
     * Set fechaSolicitud
     *
     * @param \DateTime $fechaSolicitud
     * @return DataAfilChipicoOper
     */
    public function setFechaSolicitud($fechaSolicitud)
    {
        $this->fechaSolicitud = $fechaSolicitud;

        return $this;
    }

    /**
     * Get fechaSolicitud
     *
     * @return \DateTime 
     */
    public function getFechaSolicitud()
    {
        return $this->fechaSolicitud;
    }

    /**
     * Set contrato
     *
     * @param string $contrato
     * @return DataAfilChipicoOper
     */
    public function setContrato($contrato)
    {
        $this->contrato = $contrato;

        return $this;
    }

    /**
     * Get contrato
     *
     * @return string 
     */
    public function getContrato()
    {
        return $this->contrato;
    }

    /**
     * Set buenaPro
     *
     * @param string $buenaPro
     * @return DataAfilChipicoOper
     */
    public function setBuenaPro($buenaPro)
    {
        $this->buenaPro = $buenaPro;

        return $this;
    }

    /**
     * Get buenaPro
     *
     * @return string 
     */
    public function getBuenaPro()
    {
        return $this->buenaPro;
    }

    /**
     * Set aceptaCondiciones
     *
     * @param string $aceptaCondiciones
     * @return DataAfilChipicoOper
     */
    public function setAceptaCondiciones($aceptaCondiciones)
    {
        $this->aceptaCondiciones = $aceptaCondiciones;

        return $this;
    }

    /**
     * Get aceptaCondiciones
     *
     * @return string 
     */
    public function getAceptaCondiciones()
    {
        return $this->aceptaCondiciones;
    }

    /**
     * Set usuario
     *
     * @param \Sunahip\UserBundle\Entity\SysUsuario $usuario
     * @return DataAfilChipicoOper
     */
    public function setUsuario(\Sunahip\UserBundle\Entity\SysUsuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \Sunahip\UserBundle\Entity\SysUsuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set centroHipico
     *
     * @param \Sunahip\EntityBundle\Entity\DataCentrohipico $centroHipico
     * @return DataAfilChipicoOper
     */
    public function setCentroHipico(\Sunahip\EntityBundle\Entity\DataCentrohipico $centroHipico = null)
    {
        $this->centroHipico = $centroHipico;

        return $this;
    }

    /**
     * Get centroHipico
     *
     * @return \Sunahip\EntityBundle\Entity\DataCentrohipico 
     */
    public function getCentroHipico()
    {
        return $this->centroHipico;
    }

    /**
     * Set ClasLicencia
     *
     * @param \Sunahip\EntityBundle\Entity\AdmClasfLicencias $clasLicencia
     * @return DataAfilChipicoOper
     */
    public function setClasLicencia(\Sunahip\EntityBundle\Entity\AdmClasfLicencias $clasLicencia = null)
    {
        $this->ClasLicencia = $clasLicencia;

        return $this;
    }

    /**
     * Get ClasLicencia
     *
     * @return \Sunahip\EntityBundle\Entity\AdmClasfLicencias 
     */
    public function getClasLicencia()
    {
        return $this->ClasLicencia;
    }
}
