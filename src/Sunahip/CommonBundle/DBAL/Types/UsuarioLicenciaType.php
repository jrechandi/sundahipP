<?php
/**
 * Tipo:        Tipo para UsuarioLicencia (ENUM)
 *
 * @package     Sunahip
 * @subpackage  CommonBundle
 * @author      luis@greicodex.com
 */

namespace Sunahip\CommonBundle\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Fresh\Bundle\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class UsuarioLicenciaType extends AbstractEnumType
{

    const ROLE_CENTRO_HIPICO = "ROLE_CENTRO_HIPICO";
    const ROLE_OPERADOR = "ROLE_OPERADOR";

    /**
     * @var string Name of this type
     */
    protected $name = 'UsuarioLicenciaType';

    /**
     * @var array Readable choices
     * @static
     */
    protected static $choices = [
        self::ROLE_CENTRO_HIPICO => 'Centro Hípico',
        self::ROLE_OPERADOR => 'Operadora',
    ];

}