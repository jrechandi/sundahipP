<?php
/**
 * Tipo:        Tipo de pago (ENUM)
 *
 * @package     Sunahip
 * @subpackage  CommonBundle
 */

namespace Sunahip\CommonBundle\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Fresh\Bundle\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class PaymentType extends AbstractEnumType
{

    const MULTA = "MULTA";
    const PROCESAMIENTO = "PROCESAMIENTO";
    const OTORGAMIENTO = "OTORGAMIENTO";
    const APORTE_MENSUAL = "APORTE_MENSUAL";

    /**
     * @var string Name of this type
     */
    protected $name = 'PaymentType';

    /**
     * @var array Readable choices
     * @static
     */
    protected static $choices = [
        self::MULTA => 'Multa',
        self::PROCESAMIENTO => 'Procesamiento',
        self::OTORGAMIENTO => 'Otorgamiento',
        self::APORTE_MENSUAL => 'Aporte Mensual'
    ];

}