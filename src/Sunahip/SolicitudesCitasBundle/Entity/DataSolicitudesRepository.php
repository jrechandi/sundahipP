<?php

namespace Sunahip\SolicitudesCitasBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * DataSolicitudesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DataSolicitudesRepository extends EntityRepository
{
    public function getOwnedDS($user){
        return $this->findBy(array("usuario"=>$user->getId()));
    }

    public function findByLocalizador($loc){
        $R=$this->findBy(array('codsolicitud'=>$loc));
        return $R[0]; // One Result
    }

    public function findCitas($status) {
        $q = $this->createQueryBuilder('s');
        $q->where('s.status = :status')
            ->setParameter('status', $status);
        $q->andWhere('s.fechaSolicitud >= :inicio')
            ->setParameter('inicio', new \DateTime(date('Y-m-d')." 00:00:00"));
        $q->andWhere('s.fechaSolicitud <= :fin')
            ->setParameter('fin', new \DateTime(date('Y-m-d')." 23:59:59"));
        return $q->getQuery()->getResult();
    }

    public function getListCitas($usuario, $tipoSolicitud) {
        $qb = $this->createQueryBuilder('s');
        $qb->where('s.usuario = :usuario and s.tipoSolicitud = :tipoSolicitud and s.status != :status')
            ->setParameter('usuario', $usuario)
            ->setParameter('tipoSolicitud', $tipoSolicitud)
            ->setParameter('status', 'Aprobada');

        return $qb->getQuery()
            ->getResult();
    }

    public function getListPorVencer($date) {
        $q = $this->getEntityManager()->createQueryBuilder();
        $q->select('s')
            ->from("SolicitudesCitasBundle:DataSolicitudes","s")
            ->innerJoin("SolicitudesCitasBundle:DataSolicitudesAprob", "sa", "WITH", "s.id = sa.solicitud")
            ->where("s.status = :status")
            ->andWhere("sa.fechaFin <= :fechaFin")
            ->setParameter("status", "Aprobada")
            ->setParameter("fechaFin", new \DateTime($date." 23:59:59"));
        return $q->getQuery()->getResult();
    }

    public function validateField($field)
    {
        if(isset($field))
        {
            $field = trim($field);
            if(strlen($field) > 1 or $field != 0)
            {
                return true;
            }
        }
        return false;
    }


    public function findLicenses($data = array())
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('ds')
            ->addSelect("CASE WHEN (dc.denominacionComercial IS NULL) THEN do.denominacionComercial ELSE dc.denominacionComercial END AS denominacionComercial")
            ->addSelect("CASE WHEN (dc.id IS NULL) THEN '1' ELSE '2' END AS cType")
            ->addSelect("CASE WHEN (dc.id IS NULL) THEN do.id ELSE dc.id END AS cId")
            ->from("SolicitudesCitasBundle:DataSolicitudes", "ds")
            ->leftJoin("SolicitudesCitasBundle:DataSolicitudesAprob", "dsa", "WITH", "ds.id = dsa.solicitud")
            ->leftJoin("CentrohipicoBundle:DataOperadora", "do", "WITH", "ds.operadora = do.id")
            ->leftJoin("CentrohipicoBundle:DataCentrohipico", "dc", "WITH", "ds.centroHipico = dc.id")
            ->leftJoin("PagosBundle:Pagos", "pg", "WITH", "ds.pago = pg.id")
            ->leftJoin("LicenciaBundle:AdmClasfLicencias", "cl", "WITH", "ds.ClasLicencia = cl.id");

        if ($this->validateField($data['denominacion_comercial'])) {
            $qb->where(
                $qb->expr()->orX(
                    $qb->expr()->like('do.denominacionComercial', "'%" . $data['denominacion_comercial'] . "%'"),
                    $qb->expr()->like('dc.denominacionComercial', "'%" . $data['denominacion_comercial'] . "%'")
                )
            );
        }

        if ($this->validateField($data['estados'])) {
            $qb->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->eq('do.estado', "$data[estados]"),
                    $qb->expr()->eq('dc.estado', "$data[estados]")
                )
            );
        }

        if ($this->validateField($data['municipios'])) {
            $qb->andwhere(
                $qb->expr()->orX(
                    $qb->expr()->eq('do.municipio', "$data[municipios]"),
                    $qb->expr()->eq('dc.municipio', "$data[municipios]")
                )
            );
        }

        if ($this->validateField($data['rif_number'])) {
            $qb->where(
                $qb->expr()->orX(
                    $qb->expr()->like('do.rif', "'%" . $data['rif_number'] . "%'"),
                    $qb->expr()->like('dc.rif', "'%" . $data['rif_number'] . "%'")
                )
            );
        }

        if ($this->validateField($data['numero_licencia'])) {
            $qb->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->like('ds.numLicenciaAdscrita', "'%" . $data['numero_licencia'] . "%'")
                )
            );
        }

        if ($this->validateField($data['numero_solicitud'])) {
            $qb->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->like('ds.codsolicitud', "'%" . $data['numero_solicitud'] . "%'")
                )
            );
        }

        if (isset($data['estatus_solicitud'])) {

            switch($data['estatus_solicitud']){
                case 'gerencia':
                    $qb->andWhere('dsa.revisionGerente = :status');
                    break;
                case 'asesor':
                    $qb->andWhere('dsa.revisionAsesor = :status');
                    break;
                case 'direccion':
                    $qb->andWhere('dsa.revisionFiscal = :status');
                    break;
                default:
                    $qb->andWhere('ds.status = :status');
                    break;
            }
            $qb->setParameter('status', $data['estatus_solicitud']);
        }

        if ($this->validateField($data['claf_licencia'])) {
            $qb->andWhere('ds.ClasLicencia = :clasf')
                ->setParameter('clasf', $data['claf_licencia']);
        }

        if (isset($data['estatus_pago'])) {
            $qb->andWhere('pg.status = :status')
                ->setParameter('status', $data['estatus_pago']);
        }

        if (isset($data['estatus_licencia'])) {
            $qb->andWhere('cl.status = :status')
                ->setParameter('status', $data['estatus_licencia']);
        }

//        print_r($qb->getQuery()->getSQL());
//        die();

        return $qb->getQuery()->getResult();

    }
    
    public function findAllCentroHipico() {
         $q = $this->createQueryBuilder('s');
         $q->where("s.status = :status")
                 ->andWhere("s.tipoSolicitud = :tipo")
                 ->andWhere("s.dataOperadora is NULL")
                 ->setParameter("status", "Aprobada")
                 ->setParameter("tipo", "centrohipico");
         return $q->getQuery()->getResult();
    }

}