<?php
/**
 * Traits:      Trait para entidades con nombre
 *
 * @package     Sunahip
 * @subpackage  Common
 * @author      Reynier Perez Mira <reynierpm@gmail.com>
 */

namespace Sunahip\CommonBundle\Model;

use Doctrine\ORM\Mapping as ORM;

trait NamedEntityTrait
{

    /**
     * @ORM\Column(type="string",nullable=false,length=100)
     */
    protected $name;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

}
