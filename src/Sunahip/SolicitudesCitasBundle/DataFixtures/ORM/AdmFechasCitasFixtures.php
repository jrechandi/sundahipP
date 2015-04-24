<?php
/**
 * Fixtures:      AdmFechasCitas
 *
 * @package       Sunahip
 * @subpackage    SolicitudesCita
 * @author        Carlos A Salazar <csalazart33@gmail.com>
 */

namespace Sunahip\SolicitudesCitasBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Sunahip\SolicitudesCitasBundle\Entity\AdmFechasCitas;

class AdmFechasCitasFixtures extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $entity = new AdmFechasCitas();
        $entity->setDescription('Declaración de Independencia');
        $entity->setDate(\DateTime::createFromFormat('Y-m-d', '2014-04-19'));
        $entity->setAllways(true);
        $manager->persist($entity);
        $this->addReference('AdmFecha1', $entity);
        
        $entity = new AdmFechasCitas();     
        $entity->setDescription('Día del Trabajador');
        $entity->setDate( \DateTime::createFromFormat('Y-m-d', '2014-05-01'));
        $entity->setAllways(true);
        $manager->persist($entity);
        $this->addReference('AdmFecha2', $entity);
        
        $entity = new AdmFechasCitas();
        $entity->setDescription('Batalla de Carabobo');
        $entity->setDate(\DateTime::createFromFormat('Y-m-d', '2014-06-24'));
        $entity->setAllways(true);
        $manager->persist($entity);
        $this->addReference('AdmFecha3', $entity);
        
        $entity = new AdmFechasCitas();
        $entity->setDescription('Día de la Independencia, Firma del Acta');
        $entity->setDate(\DateTime::createFromFormat('Y-m-d', '2014-07-05'));
        $entity->setAllways(true);
        $manager->persist($entity);
        $this->addReference('AdmFecha4', $entity);
        
        $entity = new AdmFechasCitas();
        $entity->setDescription('Natalicio de Simón Bolivar');
        $entity->setDate(\DateTime::createFromFormat('Y-m-d', '2014-07-24'));
        $entity->setAllways(true);
        $manager->persist($entity);
        $this->addReference('AdmFecha5', $entity);
        
        $entity = new AdmFechasCitas();
        $entity->setDescription('Día de la Bandera');
        $entity->setDate(\DateTime::createFromFormat('Y-m-d', '2014-08-03'));
        $entity->setAllways(true);
        $manager->persist($entity);
        $this->addReference('AdmFecha6', $entity);

        $entity = new AdmFechasCitas();
        $entity->setDescription('Día de la Resistencia Indígena');
        $entity->setDate(\DateTime::createFromFormat('Y-m-d', '2014-10-12'));
        $entity->setAllways(true);
        $manager->persist($entity);
        $this->addReference('AdmFecha7', $entity);

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
