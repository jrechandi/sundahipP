<?php
/**
 * Fixtures:      Municipios
 *
 * @package       Sunahip
 * @subpackage    Common
 * @author        Reynier Perez <reynierpm@gmail.com>
 */

namespace Sunahip\CommonBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Sunahip\CommonBundle\Entity\SysMunicipio;
//use Sunahip\CommonBundle\Tools\StringTools;

class SysMunicipioFixtures extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
 //        $entity = new SysMunicipio();
//        $entity->setNombre('Chacao');
//        $entity->setEstado($this->getReference('sysestado-miranda'));
//        $manager->persist($entity);
//        $this->addReference('sysmunicipio-chacao', $entity);
//
//        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2;
    }

}
