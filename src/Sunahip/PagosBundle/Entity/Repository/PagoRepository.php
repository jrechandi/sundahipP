<?php

namespace Sunahip\PagosBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class PagoRepository extends EntityRepository
{
    public function porUsuario($user, $tipo){
        $id = $user->getId();
        $q = $this->createQueryBuilder('p');
        $q->where('p.tipoPago = :tipo')
            ->setParameter('tipo', $tipo);
        if(!$user->hasRole('ROLE_GERENTE') && !$user->hasRole('ROLE_COORDINADOR')){
            $q->leftjoin('p.centroHipico', 'c')
                ->leftjoin('p.operadora', 'o')
                ->andWhere('o.usuario = :id or c.usuario = :id')
                ->setParameter('id', $id);
        }

        return $q->getQuery()->getResult();
    }
    
    public function verificar($numReferencia) {
        $q = $this->createQueryBuilder("p");
        $q->where("p.status = :status")
            ->setParameter("status", "POR VERIFICAR")
            ->andWhere("p.numReferencia = :numReferencia")
            ->setParameter("numReferencia", $numReferencia);
        return $q->getQuery()->getResult();
    }
}
