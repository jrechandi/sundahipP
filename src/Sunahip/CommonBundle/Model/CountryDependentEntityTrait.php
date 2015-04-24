<?php

/**
 * Traits:      Trait para entidad país
 *
 * @package     Sunahip
 * @subpackage  Common
 * @author      Reynier Perez Mira <reynierpm@gmail.com>
 */

namespace Sunahip\CommonBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Sunahip\CommonBundle\Entity\Country;

trait CountryDependentEntityTrait
{

    /**
     * @ORM\ManyToOne(targetEntity="\Sunahip\CommonBundle\Entity\Country")
     * @ORM\JoinColumn(name="country", referencedColumnName="iso", nullable=false)
     */
    protected $country;

    public function setCountry(Country $country)
    {
        $this->country = $country;
    }

    public function getCountry()
    {
        return $this->country;
    }
}
