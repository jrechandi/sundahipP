<?php
/**
 * Traits:      Trait para entidades con descripcion
 *
 * @package     Sunahip
 * @subpackage  Common
 * @author      Reynier Perez Mira <reynierpm@gmail.com>
 */

namespace Sunahip\CommonBundle\Model;

use Doctrine\ORM\Mapping as ORM;

trait DescribedEntityTrait
{

    /**
     * @ORM\Column(type="string",nullable=false)
     */
    protected $description;

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

}
