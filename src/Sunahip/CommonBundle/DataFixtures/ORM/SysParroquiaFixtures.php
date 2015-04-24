<?php
/**
 * Fixtures:      Parroquias
 *
 * @package       Sunahip
 * @subpackage    Common
 * @author        Reynier Perez <reynierpm@gmail.com>
 */

namespace Sunahip\CommonBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Sunahip\CommonBundle\Entity\SysParroquia;
use Sunahip\CommonBundle\Tools\StringTools;

class SysParroquiaFixtures extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
//        $entity = new SysParroquia();
//        $entity->setNombre('Chacao');
//        $entity->setEstado($this->getReference('sysestado-miranda'));
//        $entity->setMunicipio($this->getReference('sysmunicipio-chacao'));
//        $manager->persist($entity);
//        $this->addReference('sysparroquia-chacao', $entity);
//            
//        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 3;
    }

}
