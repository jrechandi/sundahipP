<?php
/**
 * Fixtures:      Tipos de Licencias
 *
 * @package       Sunahip
 * @subpackage    LicenciaBundle
 * @author        Carlos A Salazar <csalazart33@gmail.com>
 */

namespace Sunahip\LicenciaBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Sunahip\LicenciaBundle\Entity\AdmTiposLicencias;

class AdmTiposLicenciasFixtures extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $entity = new AdmTiposLicencias();
        $entity->setTipoLicencia('Autorizacion');
        $entity->setStatus('1');
        $entity->setRoleType('ROLE_CENTRO_HIPICO');
        $manager->persist($entity);
        $this->addReference('tipolic1', $entity);
        
        $entity = new AdmTiposLicencias();
        $entity->setTipoLicencia('Licencia');
        $entity->setStatus('1');
        $entity->setRoleType('ROLE_OPERADOR');
        $manager->persist($entity);
        $this->addReference('tipolic2', $entity);
        
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 3;
    }

}
