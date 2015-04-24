<?php
/**
 * Traits:      Ciudad
 *
 * @package     Sunahip
 * @subpackage  Common
 * @author      Reynier Perez Mira <reynierpm@gmail.com>
 */

namespace Sunahip\CommonBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Sunahip\CommonBundle\Entity\City;

trait CityDependentEntityTrait
{
    use StateDependentEntityTrait;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="\Sunahip\CommonBundle\Entity\City")
     * @ORM\JoinColumn(name="city", referencedColumnName="iso", nullable=false)
     */
    protected $city;

    public function setCity(City $city)
    {
        $this->city = $city;
    }

    public function getCity()
    {
        return $this->city;
    }
}
