<?php

namespace Sunahip\FiscalizacionBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * ProvidenciaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProvidenciaRepository extends EntityRepository
{
    /**
     * Devuelve las providencias dependiendo del rol
     * @return [type] [description]
     */
    public function byRol($c){
        if(true === $c->isGranted('ROLE_GERENTE') 
           || true === $c->isGranted('ROLE_COORDINADOR')
           || true === $c->isGranted('ROLE_SUPERINTENDENTE')){
            return $this->findAll();
        }elseif(true === $c->isGranted('ROLE_FISCAL')){
            $id = $c->getToken()->getUser()->getPerfil()[0]->getId();
            $q = $this->createQueryBuilder('u');
            $q->join('u.fiscales', 'f')
                ->join('u.gerente', 'g')
                //->where('gerente = :gerente')
                ->where('g.idperfil =  :id')
                ->orWhere('f.idperfil =  :id')
                ->setParameter('id', $id);
            return $q->getQuery()->getResult();
        }
        throw new AccessDeniedException();
    }

    /**
     * Devuelve la providencia actual
     */
    public function current(){
        $q = $this->createQueryBuilder('f');
        $q->where('f.finicio <=  :hoy')
            ->andWhere('f.ffinal  >=  :hoy')
            ->setParameter('hoy', date('Y-m-d'))
            ->setMaxResults(1);
        return $q->getQuery()->getResult();
    }
    
    public function validProvidenciaByFecha($fecha) {
        $q = $this->createQueryBuilder('f');
        $q->where("f.finicio <= :fechainicio");
        $q->andWhere("f.ffinal >= :fechafin");
        $q->setParameter("fechainicio", $fecha . " 00:00:00")
                ->setParameter("fechafin", $fecha . " 00:00:00");
        return $q->getQuery()->getResult();
    }
}
