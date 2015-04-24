<?php
/**
 * Fixtures:      Perfil
 *
 * @package       Sunahip
 * @subpackage    Common
 * @author        Reynier Perez <reynierpm@gmail.com>
 */

namespace Sunahip\CommonBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Sunahip\UserBundle\Entity\SysPerfil;
use Sunahip\CommonBundle\Tools\StringTools;

class SysPerfilFixtures extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $strTool = new StringTools();

        $profile = new SysPerfil();

        $profile->setPersJuridica("J");
        $profile->setRif($strTool->generateRandomNumeric(11));
        $profile->setCi($strTool->generateRandomNumeric(11));
        $profile->setNombre("User");
        $profile->setApellido("Admin");
        $profile->setRoleType("ROLE_ADMIN");
        $profile->setUser($this->getReference('useradmin'));
        $manager->persist($profile);
        $this->addReference('perfil-', $profile);
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 5;
    }

}
