<?php

/**
 * Traits:      Trait para entidades con identificador
 *
 * @package     Sunahip
 * @subpackage  Common
 * @author      Reynier Perez Mira <reynierpm@gmail.com>
 */

namespace Sunahip\CommonBundle\Model;

use Doctrine\ORM\Mapping as ORM;

trait IdentifiedEntityTrait
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer",unique=true,nullable=false)
     */
    protected $id;

    public function getId()
    {
        return $this->id;
    }
}
