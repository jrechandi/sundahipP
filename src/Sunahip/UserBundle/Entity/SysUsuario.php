<?php

namespace Sunahip\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * SysUsuario
 *
 * @ORM\Table(name="sys_usuario")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="SysUsuarioRepository")
 */
class SysUsuario extends BaseUser
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="SysGrupos")
     * @ORM\JoinTable(name="sys_usuarios_grupos",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;

    /**
     * @var string
     * @ORM\Column(name="fullname", type="string", length=150, nullable=false)
     */
    protected $fullname;

    /**
     * @ORM\OneToMany(targetEntity="SysPerfil", mappedBy="user")
     * */
    protected $perfil;
    
      /**
     * @var \Sunahip\CentrohipicoBundle\Entity\DataOperadora
     *
     * @ORM\OneToMany(targetEntity="\Sunahip\CentrohipicoBundle\Entity\DataOperadora", mappedBy="usuario")
     */
    private $operadora;

    public function setFullname($fullname)
    {
        $this->fullname = $fullname;
    }

    public function getFullname()
    {
        return $this->fullname;
    }

    public function setPerfil(SysPerfil $perfil)
    {
        $this->perfil = $perfil;
    }

    public function getPerfil()
    {
        return $this->perfil;
    }
    
    public function getOperadora()
    {
        return $this->operadora;
    }

}
