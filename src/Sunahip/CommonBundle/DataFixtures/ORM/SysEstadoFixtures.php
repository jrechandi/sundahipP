<?php
/**
 * Fixtures:      Estados
 *
 * @package       Sunahip
 * @subpackage    Common
 * @author        Reynier Perez <reynierpm@gmail.com>
 */

namespace Sunahip\CommonBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\Connection;
use Sunahip\CommonBundle\Entity\SysEstado;

//use Sunahip\CommonBundle\Tools\StringTools;

class SysEstadoFixtures extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        define('__DSEPARATOR__', '/');       
        $estado= file_get_contents(__DIR__.__DSEPARATOR__.'datasql'.__DSEPARATOR__.'estado.sql');
        $municipio= file_get_contents(__DIR__.__DSEPARATOR__.'datasql'.__DSEPARATOR__.'municipio.sql');
        $parroquia= file_get_contents(__DIR__.__DSEPARATOR__.'datasql'.__DSEPARATOR__.'parroquia.sql');
        $manager->getConnection()->query($estado);
        $manager->getConnection()->query($municipio);
        $manager->getConnection()->query($parroquia);        
        
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }

}
