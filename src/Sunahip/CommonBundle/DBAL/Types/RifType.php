<?php
/**
 * Tipo:        Tipo para RIF (ENUM)
 *
 * @package     Sunahip
 * @subpackage  CommonBundle
 * @author      Reynier Perez Mira <reynierpm@gmail.com>
 */

namespace Sunahip\CommonBundle\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Fresh\Bundle\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class RifType extends AbstractEnumType
{

    const J = "J";
    const G = "G";
    const V = "V";
    const E = "E";

    /**
     * @var string Name of this type
     */
    protected $name = 'RifType';

    /**
     * @var array Readable choices
     * @static
     */
    protected static $choices = [
        self::J => 'J',
        self::G => 'G',
        self::V => 'V',
        self::E => 'E'
    ];

}
