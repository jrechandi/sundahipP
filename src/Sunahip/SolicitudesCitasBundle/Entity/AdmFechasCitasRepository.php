<?php

namespace Sunahip\SolicitudesCitasBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * AdmFechasCitasRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AdmFechasCitasRepository extends EntityRepository
{
    
    public function setAllMaxCitas($max){
        $query = $this->createQueryBuilder('F')
            ->update()                
            ->set("F.maxcitaxday", $max)    
            //->where("1")
            ->getQuery();
            $resp=$query->getResult();
        return $resp;
    }
    
    
}