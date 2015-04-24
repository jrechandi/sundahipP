<?php
namespace Sunahip\FiscalizacionBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Sunahip\CentrohipicoBundle\Entity\DataCentrohipico as DataCentrohipico;
use Sunahip\FiscalizacionBundle\Validator as Val;

/**
 * Providencia
 *
 * @ORM\Table(name="data_providencia")
 * @ORM\Entity(repositoryClass="Sunahip\FiscalizacionBundle\Entity\ProvidenciaRepository")
 */
class Providencia
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
     * @var string
     *
     * @ORM\Column(name="num", type="string", length=50)
     */
    private $num;

    /**
     * @var \DateTime
     * 
     * @Val\ProvidenciaFecha(inicio=true)
     * @ORM\Column(name="finicio", type="date")
     */
    private $finicio;

    /**
     * @var \DateTime
     * @Val\ProvidenciaFecha(inicio=false)
     * @ORM\Column(name="ffinal", type="date")
     */
    private $ffinal;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="motivo", type="string", length=255)
     */
    private $motivo;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Sunahip\UserBundle\Entity\SysPerfil", inversedBy="providencias")
     * @ORM\JoinColumn(name="gerente_id", referencedColumnName="idperfil")
     */
    private $gerente;

    /**
     * @ORM\ManyToMany(targetEntity="Sunahip\UserBundle\Entity\SysPerfil")
     * @ORM\JoinTable(name="prov_fiscal",
     *      joinColumns={@ORM\JoinColumn(name="prov_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="fiscal_id", referencedColumnName="idperfil")}
     *      )
     **/
    private $fiscales;

     /**
     * @ORM\ManyToMany(targetEntity="Sunahip\CentrohipicoBundle\Entity\DataCentrohipico")
     * @ORM\JoinTable(name="data_centro_prov",
     *      joinColumns={@ORM\JoinColumn(name="prov_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="centro_id", referencedColumnName="id")}
     *      )
     */
    private $centros;

    /**
     * @ORM\ManyToMany(targetEntity="Sunahip\CentrohipicoBundle\Entity\DataOperadora")
     * @ORM\JoinTable(name="data_oper_prov",
     *      joinColumns={@ORM\JoinColumn(name="prov_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="centro_id", referencedColumnName="id")}
     *      )
     */
    private $operadoras;

    public function __construct() {
        $this->fiscales    = new ArrayCollection();
        $this->centros     = new ArrayCollection(); 
        $this->operadoras = new ArrayCollection(); 
    }

    /**
     * Esto ya no va
     * Assert\True(message = "Debe seleccionar al menos un centro u operadora")
     */
    public function isValid()
    {
        return ($this->centros->count() + $this->operadoras->count()) >= 0;
    }

    /**
     * @Assert\True(message = "La fecha de finalización debe ser mayor a la de inicio")
     */
    public function isMayor(){
          return ($this->ffinal > $this->finicio);
    }

    /**
     * @Assert\True(message = "La fecha de inicio debe ser mayor o igual a la de hoy")
     */
    public function isMayorHoy(){
        $now = new \DateTime();
        $now->setTime (0,0);
        return ($this->finicio >= $now);
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
     * Set num
     *
     * @param string $num
     * @return Providencia
     */
    public function setNum($num)
    {
        $this->num = $num;

        return $this;
    }

    /**
     * Get num
     *
     * @return string 
     */
    public function getNum()
    {
        return $this->num;
    }

    /**
     * Set finicio
     *
     * @param \DateTime $finicio
     * @return Providencia
     */
    public function setFinicio($finicio)
    {
        $this->finicio = $finicio;

        return $this;
    }

    /**
     * Get finicio
     *
     * @return \DateTime 
     */
    public function getFinicio()
    {
        return $this->finicio;
    }

    /**
     * Set ffinal
     *
     * @param \DateTime $ffinal
     * @return Providencia
     */
    public function setFfinal($ffinal)
    {
        $this->ffinal = $ffinal;

        return $this;
    }

    /**
     * Get ffinal
     *
     * @return \DateTime 
     */
    public function getFfinal()
    {
        return $this->ffinal;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Providencia
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
     * Set motivo
     *
     * @param string $motivo
     * @return Providencia
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;

        return $this;
    }

    /**
     * Get motivo
     *
     * @return string 
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * Set gerente
     *
     * @param \Sunahip\UserBundle\Entity\SysPerfil $gerente
     * @return Providencia
     */
    public function setGerente(\Sunahip\UserBundle\Entity\SysPerfil $gerente = null)
    {
        $this->gerente = $gerente;

        return $this;
    }

    /**
     * Get gerente
     *
     * @return \Sunahip\UserBundle\Entity\SysPerfil 
     */
    public function getGerente()
    {
        return $this->gerente;
    }

    /**
     * Add fiscales
     *
     * @param \Sunahip\UserBundle\Entity\SysPerfil $fiscales
     * @return Providencia
     */
    public function addFiscale(\Sunahip\UserBundle\Entity\SysPerfil $fiscales)
    {
        $this->fiscales[] = $fiscales;

        return $this;
    }

    /**
     * Remove fiscales
     *
     * @param \Sunahip\UserBundle\Entity\SysPerfil $fiscales
     */
    public function removeFiscale(\Sunahip\UserBundle\Entity\SysPerfil $fiscales)
    {
        $this->fiscales->removeElement($fiscales);
    }

    /**
     * Get fiscales
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFiscales()
    {
        return $this->fiscales;
    }


    /**
     * Add centros
     *
     * @param \Sunahip\CentrohipicoBundle\Entity\DataCentrohipico $centros
     * @return Providencia
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
     * @return Providencia
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
}
