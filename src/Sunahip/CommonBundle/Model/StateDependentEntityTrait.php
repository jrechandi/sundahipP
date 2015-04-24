<?php

/**
 * Traits:      Trait para entidades ciudad
 *
 * @package     Sunahip
 * @subpackage  Common
 * @author      Reynier Perez Mira <reynierpm@gmail.com>
 */

namespace Sunahip\CommonBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Sunahip\CommonBundle\Entity\State;

trait StateDependentEntityTrait
{
    use CountryDependentEntityTrait;

    /**
     * @ORM\ManyToOne(targetEntity="\Sunahip\CommonBundle\Entity\State")
     * @ORM\JoinColumn(name="state", referencedColumnName="iso", nullable=false)
     */
    protected $state;

    public function setState(State $state)
    {
        $this->state = $state;
    }

    public function getState()
    {
        return $this->state;
    }
}
