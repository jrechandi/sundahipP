<?php
/**
 * Tipo:        Tipo para Roles
 *
 * @package     Sunahip
 * @subpackage  CommonBundle
 * @author      Reynier Perez Mira <reynierpm@gmail.com>
 */

namespace Sunahip\CommonBundle\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Fresh\Bundle\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class AdminRoleType extends AbstractEnumType
{

    const ROLE_ADMIN = "ROLE_ADMIN";
    const ROLE_GERENTE = "ROLE_GERENTE";
    const ROLE_FISCAL = "ROLE_FISCAL";
    const ROLE_CENTRO_HIPICO = "ROLE_CENTRO_HIPICO";
    const ROLE_OPERADOR = "ROLE_OPERADOR";
    const ROLE_ASESOR = "ROLE_ASESOR";
    const ROLE_SUPERINTENDENTE  = 'ROLE_SUPERINTENDENTE';
    const ROLE_COORDINADOR      = 'ROLE_COORDINADOR';

    /**
     * @var string Name of this type
     */
    protected $name = 'AdminRoleType';

    /**
     * @var array Readable choices
     * @static
     */
    protected static $choices = [
        self::ROLE_ADMIN            => 'Administrador',
        self::ROLE_GERENTE          => 'Gerente',
        self::ROLE_FISCAL           => 'Fiscal',
        self::ROLE_ASESOR           => 'Asesor Legal',
        self::ROLE_SUPERINTENDENTE  => 'Superintendente',
        self::ROLE_COORDINADOR      => 'Coordinador'
        //self::ROLE_CENTRO_HIPICO => 'Centro Hípico',
        //self::ROLE_OPERADOR => 'Operadora'
    ];

}
