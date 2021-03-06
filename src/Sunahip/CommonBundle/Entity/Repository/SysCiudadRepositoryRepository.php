<?php
/**
 * SysCiudadRepositoryRepository
 *
 * @package       Sunahip
 * @subpackage    Common
 * @author        Felipe Vunoles <felipe.vinoles@gmail.com>
 */

namespace Sunahip\CommonBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * AsociacionEmpresasRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SysCiudadRepositoryRepository extends EntityRepository
{
    
       /**
     * @param int $idEstado
     * @param int $idUser
     * @return traer la ciudad que ya esta seleccionada
     */
    public function getCiudadselect($idEstado, $idUser)
    {
        return $this->createQueryBuilder('c')
            ->Where('c.estado <> :idEstado')
            ->andWhere('d.taxId = :taxId')
            ->setParameter('idEstado', $idEstado)
            ->setParameter('user', $idUser)
            ->getQuery()->getResult();
    }
}
