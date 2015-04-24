<?php
/**
 * Fixtures:      Usuario
 *
 * @package       Sunahip
 * @subpackage    Common
 * @author        Reynier Perez <reynierpm@gmail.com>
 */

namespace Sunahip\CommonBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Sunahip\UserBundle\Entity\SysUsuario;

class SysUsuarioFixtures extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $entity = new SysUsuario();

        $entity->setUsername("J1234567");
        $entity->setEmail("admin@local.com");
        $entity->setPlainPassword("123456");
        $entity->setFullname("User Admin");
        $entity->addRole("ROLE_ADMIN");
        $entity->setEnabled(true);

        $manager->persist($entity);
        $this->addReference('useradmin', $entity);

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 4;
    }

}
