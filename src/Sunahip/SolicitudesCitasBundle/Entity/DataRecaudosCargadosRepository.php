<?php

namespace Sunahip\SolicitudesCitasBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * DataRecaudosCargadosRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DataRecaudosCargadosRepository extends EntityRepository
{    
    public function findByRecaudos($solicitud) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        
        $qb->select('r')
            ->from("SolicitudesCitasBundle:DataRecaudosCargados", "r")
            ->innerJoin("LicenciaBundle:AdmRecaudosLicencias", "re", "WITH", "r.recaudoLicencia = re.id")
            ->where("r.solicitud=?1")
            ->setParameter(1, $solicitud);
        
        return $qb->getQuery()->getResult();
    }
    
    public function getAllRecaudos($solicitud) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        
        $qb->select('ra')
            ->from("SolicitudesCitasBundle:DataRecaudosCargados", "r")
            ->innerJoin("SolicitudesCitasBundle:DataRecaudosAprob", "ra", "WITH", "r.id = ra.recaudo")
            ->where("r.solicitud=?1")
            ->setParameter(1, $solicitud);
        
        return $qb->getQuery()->getResult();
    }
}