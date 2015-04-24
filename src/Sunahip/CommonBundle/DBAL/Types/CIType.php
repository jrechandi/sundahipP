<?php
/**
 * Tipo:        Tipo para CI (ENUM)
 *
 * @package     Sunahip
 * @subpackage  CommonBundle
 * @author      Reynier Perez Mira <reynierpm@gmail.com>
 */

namespace Sunahip\CommonBundle\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Fresh\Bundle\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class CIType extends AbstractEnumType
{

    const V = "V";
    const E = "E";

    /**
     * @var string Name of this type
     */
    protected $name = 'CIType';

    /**
     * @var array Readable choices
     * @static
     */
    protected static $choices = [
        self::V => 'V',
        self::E => 'E'
    ];

}
