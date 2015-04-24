<?php

namespace Sunahip\ReporteBundle\Service;

use Doctrine\ORM\EntityManager;

/**
 * Description of ReporteService
 *
 * @author Miguel.Simoni
 */
class ReporteService {

    protected $em;

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

    private $color = ['#D34E47','#2C7980','#37A344','#D38947','#B52E26','#19676E','#1E8C2B','#B56926','#8F130D','#095057','#0A6F16','#8F4A0D','#F57A73','#478E95','#5ABE66','#F5B073','#FFA8A3','#77B4BA','#89D793','#FFCEA3'];
    
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function getDataLicencia($anio, $mes = null, $dia = null, $desde = null, $hasta = "3000-12-12", $status = null) {
        $sql = "SELECT status as label, count(id) as value "
                . "FROM data_solicitudes ";

        if( $this->validateField(!$desde) )
        {
            $sql .= "WHERE YEAR(fecha_solicitud)=$anio "
                    . ($this->validateField($mes) ? "AND MONTH(fecha_solicitud)=$mes " : "")
                    . ($this->validateField($dia) ? "AND DAY(fecha_solicitud)=$dia " : "");
        }else
            $sql  .= ($this->validateField($desde) ? "WHERE fecha_solicitud BETWEEN '$desde'  AND '$hasta' " : "");

        if( $this->validateField($status) )
        {
            $sql  .= " AND status = '$status' ";
        }

        $sql .= "GROUP BY status;";



        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        $data = array();
        $cantidadTotal = 0;
        foreach ($result as $i => $row) {
            $data[] = array(
                'label' => $row['label'],
                'value' => (float) $row['value'],
                'color' => $this->color[$i],
            );
            $cantidadTotal += $row['value'];
        }
        
        $porcentajeTotal = 0;
        if($cantidadTotal > 0){
            foreach($data as $i => $item){
                $data[$i]['percent'] = $item['value']/$cantidadTotal*100;
                $porcentajeTotal += $data[$i]['percent'];
            }
        }

        $total = array(
            'cantidad' => $cantidadTotal,
            'porcentaje' => $porcentajeTotal,
        );
        
        return array(
            'data' => $data,
            'total' => $total,
        );
    }

    public function getDataFiscalizacion($anio, $mes = null, $dia = null, $desde = null, $hasta = "3000-12-12", $status= null) {
        $sql = "SELECT estatus as label, count(id) as value "
                . "FROM data_fiscalizacion "
                . "WHERE YEAR(fecha)=$anio "
                . (isset($mes) ? "AND MONTH(fecha)=$mes " : "")
                . (isset($dia) ? "AND DAY(fecha)<=$dia " : "")
                . "GROUP BY estatus "
                . "UNION "
                . "SELECT '' as label, count(p.id) as value "
                . "FROM data_providencia p "
                . "LEFT JOIN data_centro_prov cp ON p.id = cp.prov_id "
                . "LEFT JOIN data_oper_prov op ON p.id = op.prov_id ";

        if( $this->validateField(!$desde) )
        {
            $sql .= "WHERE YEAR(p.ffinal)>=$anio "
                . (isset($mes) ? "AND MONTH(p.ffinal)=$mes " : "")
                . (isset($dia) ? "AND DAY(p.ffinal)>=$dia AND DAY(p.ffinal)<=31 " : "");
        }else
            $sql  .= ($this->validateField($desde) ? "WHERE p.ffinal BETWEEN '$desde'  AND '$hasta' " : "");

        if( $this->validateField($status) )
        {
            $sql  .= " AND p.status = '$status' ";
        }

        $sql .= "AND p.status <> 'Cerrada' "
                ."GROUP BY label;";

//
//        print_r($sql);
//        die();


        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        $data = array();
        $cantidadTotal = 0;
        foreach ($result as $i => $row) {
            $data[] = array(
                'label' => ($row['label'] != '' ? $row['label'] : 'Por Fiscalizar'),
                'value' => (float) $row['value'],
                'color' => $this->color[$i],
            );
            $cantidadTotal += $row['value'];
        }
        
        $porcentajeTotal = 0;
        if($cantidadTotal > 0){
            foreach($data as $i => $item){
                $data[$i]['percent'] = $item['value']/$cantidadTotal*100;
                $porcentajeTotal += $data[$i]['percent'];
            }
        }

        $total = array(
            'cantidad' => $cantidadTotal,
            'porcentaje' => $porcentajeTotal,
        );
        
        return array(
            'data' => $data,
            'total' => $total,
        );
    }

    public function getDataIngreso($anio, $mes = null, $dia = null, $desde = null, $hasta = "3000-12-12", $status= null) {
        $sql = "SELECT tipo_pago as label, SUM(monto) as value "
                . "FROM data_pagos ";

        if( $this->validateField(!$desde) )
        {
            $sql .= "WHERE YEAR(fecha_solicitud)=$anio  "
                . (isset($mes) ? "AND MONTH(fecha_solicitud)=$mes " : "")
                . (isset($dia) ? "AND DAY(fecha_solicitud)=$dia " : "");
        }else
            $sql  .= ($this->validateField($desde) ? "WHERE fecha_solicitud BETWEEN '$desde'  AND '$hasta' " : "");


        if( $this->validateField($status) )
        {
            $sql  .= " AND tipo_pago = '$status' ";
        }

        $sql .= "GROUP BY tipo_pago;";

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        $data = array();
        $cantidadTotal = 0;
        foreach ($result as $i => $row) {
            $data[] = array(
                'label' => $row['label'],
                'value' => (float) $row['value'],
                'color' => $this->color[$i],
            );
            $cantidadTotal += $row['value'];
        }
        
        $porcentajeTotal = 0;
        if($cantidadTotal > 0){
            foreach($data as $i => $item){
                $data[$i]['percent'] = $item['value']/$cantidadTotal*100;
                $porcentajeTotal += $data[$i]['percent'];
            }
        }

        $total = array(
            'cantidad' => $cantidadTotal,
            'porcentaje' => $porcentajeTotal,
        );
        
        return array(
            'data' => $data,
            'total' => $total,
        );
    }

    public function getDataUsuario($anio, $mes = null, $dia = null, $desde = null, $hasta = "3000-12-12", $status= null) {
        $sql = "SELECT role_type as label, count(idperfil) as value "
                . "FROM sys_perfil INNER JOIN data_solicitudes ON user = idusuario ";

        if( $this->validateField(!$desde) )
        {
            $sql .= "WHERE YEAR(fecha_solicitud)=$anio "
                . (isset($mes) ? "AND MONTH(fecha_solicitud)=$mes " : "")
                . (isset($dia) ? "AND DAY(fecha_solicitud)=$dia " : "");
        }else
            $sql  .= ($this->validateField($desde) ? "WHERE fecha_solicitud BETWEEN '$desde'  AND '$hasta' " : "");

        if( $this->validateField($status) )
        {
            $sql  .= " AND role_type = '$status' ";
        }

        if(!($this->validateField($status)) OR $status == 'ESPERA' )
        {
            if(!($this->validateField($status)) )
            {
                $sql.= " AND role_type IN ('ROLE_CENTRO_HIPICO','ROLE_OPERADOR') ";
            }

            $sql.= "GROUP BY role_type "
                . "UNION "
                . "SELECT '' as label, count(id) as value "
                . "FROM data_solicitudes "
                . "WHERE 1 ";

            if( $this->validateField(!$desde) )
            {
                $sql .= "AND YEAR(fecha_solicitud)=$anio "
                    . (isset($mes) ? "AND MONTH(fecha_solicitud)=$mes " : "")
                    . (isset($dia) ? "AND DAY(fecha_solicitud)=$dia " : "");
            }else
                $sql  .= ($this->validateField($desde) ? "AND fecha_solicitud BETWEEN '$desde'  AND '$hasta' " : "");

            $sql .= "AND status <> 'Aprobada' ; ";
        }

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        $data = array();
        foreach ($result as $i => $row) {
            if($row['value'] > 0){
                $data[] = array(
                    'label' => ($row['label'] == 'ROLE_CENTRO_HIPICO' ? 'Centro Hípico' : ($row['label'] == 'ROLE_OPERADOR' ? 'Operadora' : 'En espera de Licencias')),
                    'value' => (float) $row['value'],
                    'color' => $this->color[$i]
                );
            }
        }

        $data = array();
        $cantidadTotal = 0;
        foreach ($result as $i => $row) {
            if($row['value'] > 0){
                $data[] = array(
                    'label' => ($row['label'] == 'ROLE_CENTRO_HIPICO' ? 'Centro Hípico' : ($row['label'] == 'ROLE_OPERADOR' ? 'Operadora' : 'En espera de Licencias')),
                    'value' => (float) $row['value'],
                    'color' => $this->color[$i]
                );
            }
            $cantidadTotal += $row['value'];
        }
        
        $porcentajeTotal = 0;
        if($cantidadTotal > 0){
            foreach($data as $i => $item){
                $data[$i]['percent'] = $item['value']/$cantidadTotal*100;
                $porcentajeTotal += $data[$i]['percent'];
            }
        }

        $total = array(
            'cantidad' => $cantidadTotal,
            'porcentaje' => $porcentajeTotal,
        );
        
        return array(
            'data' => $data,
            'total' => $total,
        );
    }

    public function getDataLicenciaAnual($anio, $status = null) {
        $sql0 = "SELECT DISTINCT status as serie "
                . "FROM data_solicitudes "
                . "WHERE YEAR(fecha_solicitud) = $anio";

        if( $this->validateField($status) )
        {
            $sql0  .= " AND status = '$status' ";
        }

        $sql0.=";";

        $stmt0 = $this->em->getConnection()->prepare($sql0);
        $stmt0->execute();
        $result0 = $stmt0->fetchAll();
        
        $datasets = array();
        foreach($result0 as $i0 => $row0) {
            $sql = "SELECT status as serie, MONTH(fecha_solicitud) as label, count(id) as value "
                    . "FROM data_solicitudes "
                    . "WHERE YEAR(fecha_solicitud) = $anio AND status='$row0[serie]' "
                    . "GROUP BY status, MONTH(fecha_solicitud);";
            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            
            $serieData = array(0,0,0,0,0,0,0,0,0,0,0,0);
            $total = 0;
            foreach ($result as $row) {
                $serieData[$row['label']-1] = $row['value'];
                $total += $row['value'];
            }

            $seriePercent = array(0,0,0,0,0,0,0,0,0,0,0,0);
            $totalPercent = 0;
            if($total > 0){
                foreach ($serieData as $i => $data) {
                    $seriePercent[$i] = $data/$total*100;
                    $totalPercent += $seriePercent[$i];
                }
            }

            $datasets[] = array(
                'label' => $row0['serie'],
                'fillColor' => $this->color[$i0],
                'pointColor' => $this->color[$i0],
                'data' => $serieData,
                'percent' => $seriePercent,
                'total' => $total,
                'totalPercent' => $totalPercent
            );
        }
        
        $data = array(
            'labels' => array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'),
            'datasets' => $datasets
        );

        return $data;
    }
    
    public function getDataFiscalizacionAnual($anio, $status = null) {
        $sql0 = "SELECT DISTINCT f.estatus as serie "
                . "FROM data_fiscalizacion f "
                . "WHERE YEAR(f.fecha) = $anio "
                . "UNION SELECT '_' as serie";

        if( $this->validateField($status) )
        {
            $sql0  .= " AND f.estatus = '$status' ";
        }

        $sql0.=";";

        $stmt0 = $this->em->getConnection()->prepare($sql0);
        $stmt0->execute();
        $result0 = $stmt0->fetchAll();
        
        $datasets = array();
        foreach($result0 as $i0 => $row0) {
            if($row0['serie'] != '_'){
                $sql = "SELECT estatus as serie, MONTH(fecha) as label, count(id) as value "
                        . "FROM data_fiscalizacion "
                        . "WHERE YEAR(fecha)=$anio AND estatus='$row0[serie]' "
                        . "GROUP BY estatus, MONTH(fecha);";
            } else {
                $sql = "SELECT MONTH(p.ffinal) as label, count(p.id) as value "
                        . "FROM data_providencia p "
                        . "LEFT JOIN data_centro_prov cp ON p.id = cp.prov_id "
                        . "LEFT JOIN data_oper_prov op ON p.id = op.prov_id "
                        . "WHERE YEAR(p.ffinal)=$anio AND p.status <> 'Cerrada' "
                        . "GROUP BY label, MONTH(p.ffinal);";
            }
            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            
            $serieData = array(0,0,0,0,0,0,0,0,0,0,0,0);
            $total = 0;
            foreach ($result as $row) {
                $serieData[$row['label']-1] = $row['value'];
                $total += $row['value'];
            }

            $seriePercent = array(0,0,0,0,0,0,0,0,0,0,0,0);
            $totalPercent = 0;
            if($total > 0){
                foreach ($serieData as $i => $data) {
                    $seriePercent[$i] = $data/$total*100;
                    $totalPercent += $seriePercent[$i];
                }
            }

            $datasets[] = array(
                'label' => ($row0['serie'] != '_' ? $row0['serie'] : 'Por Fiscalizar'),
                'fillColor' => $this->color[$i0],
                'pointColor' => $this->color[$i0],
                'data' => $serieData,
                'percent' => $seriePercent,
                'total' => $total,
                'totalPercent' => $totalPercent
            );
        }
        
        $data = array(
            'labels' => array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'),
            'datasets' => $datasets
        );

        return $data;
    }
    
    public function getDataIngresoAnual($anio, $status = null) {
        $sql0 = "SELECT DISTINCT tipo_pago as serie "
                . "FROM data_pagos "
                . "WHERE YEAR(fecha_solicitud) = $anio";

        if( $this->validateField($status) )
        {
            $sql0  .= " AND tipo_pago = '$status' ";
        }

        $sql0.=";";

        $stmt0 = $this->em->getConnection()->prepare($sql0);
        $stmt0->execute();
        $result0 = $stmt0->fetchAll();
        
        $datasets = array();
        foreach($result0 as $i0 => $row0) {
            $sql = "SELECT tipo_pago as serie, MONTH(fecha_solicitud) as label, SUM(monto) as value "
                    . "FROM data_pagos "
                    . "WHERE YEAR(fecha_solicitud) = $anio AND tipo_pago='$row0[serie]' "
                    . "GROUP BY tipo_pago, MONTH(fecha_solicitud);";
            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            
            $serieData = array(0,0,0,0,0,0,0,0,0,0,0,0);
            $total = 0;
            foreach ($result as $row) {
                $serieData[$row['label']-1] = $row['value'];
                $total += $row['value'];
            }

            $seriePercent = array(0,0,0,0,0,0,0,0,0,0,0,0);
            $totalPercent = 0;
            if($total > 0){
                foreach ($serieData as $i => $data) {
                    $seriePercent[$i] = $data/$total*100;
                    $totalPercent += $seriePercent[$i];
                }
            }

            $datasets[] = array(
                'label' => $row0['serie'],
                'fillColor' => $this->color[$i0],
                'pointColor' => $this->color[$i0],
                'data' => $serieData,
                'percent' => $seriePercent,
                'total' => $total,
                'totalPercent' => $totalPercent
            );
        }
        
        $data = array(
            'labels' => array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'),
            'datasets' => $datasets
        );

        return $data;
    }
    
    public function getDataUsuarioAnual($anio, $status = null) {
        $sql0 = "SELECT DISTINCT role_type as serie "
                . "FROM sys_perfil INNER JOIN data_solicitudes ON user = idusuario "
                . "WHERE YEAR(fecha_solicitud) = $anio ";

        if( $this->validateField($status) )
        {
            $sql0  .= " AND role_type = '$status' ";
        }

        $sql0.=" UNION SELECT '_' as serie  ;";



        $stmt0 = $this->em->getConnection()->prepare($sql0);
        $stmt0->execute();
        $result0 = $stmt0->fetchAll();
        
        $datasets = array();
        foreach($result0 as $i0 => $row0) {
            if($row0['serie'] != '_'){
                $sql = "SELECT role_type as serie, MONTH(fecha_solicitud) as label, count(idperfil) as value "
                        . "FROM sys_perfil INNER JOIN data_solicitudes ON user = idusuario "
                        . "WHERE YEAR(fecha_solicitud) = $anio AND role_type = '$row0[serie]' "
                        . "GROUP BY role_type, MONTH(fecha_solicitud);";
            } else if(!($this->validateField($status)) OR $status == 'ESPERA'  ) {
                $sql = "SELECT '_' as serie, MONTH(fecha_solicitud) as label, count(id) as value "
                        . "FROM data_solicitudes "
                        . "WHERE YEAR(fecha_solicitud) = $anio AND status <> 'Aprobada' "
                        . "GROUP BY serie, MONTH(fecha_solicitud);";
            }

            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            
            $serieData = array(0,0,0,0,0,0,0,0,0,0,0,0);
            $total = 0;
            foreach ($result as $row) {
                $serieData[$row['label']-1] = $row['value'];
                $total += $row['value'];
            }

            $seriePercent = array(0,0,0,0,0,0,0,0,0,0,0,0);
            $totalPercent = 0;
            if($total > 0){
                foreach ($serieData as $i => $data) {
                    $seriePercent[$i] = $data/$total*100;
                    $totalPercent += $seriePercent[$i];
                }
            }

            $datasets[] = array(
                'label' => ($row0['serie'] == 'ROLE_CENTRO_HIPICO' ? 'Centro Hípico' : ($row0['serie'] == 'ROLE_OPERADOR' ? 'Operadora' : 'En espera de Licencias')),
                'fillColor' => $this->color[$i0],
                'pointColor' => $this->color[$i0],
                'data' => $serieData,
                'percent' => $seriePercent,
                'total' => $total,
                'totalPercent' => $totalPercent
            );
        }

        $data = array(
            'labels' => array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'),
            'datasets' => $datasets
        );
        
        return $data;
    }
    
    public function getDataLicenciaPorEstado($anio, $mes = null, $dia = null, $desde = null, $hasta = "3000-12-12", $status = null) {
        $sql0 = "SELECT DISTINCT status as serie "
                . "FROM data_solicitudes ";

        if( $this->validateField(!$desde) )
        {
            $sql0 .= "WHERE YEAR(fecha_solicitud)=$anio "
                . (isset($mes) ? "AND MONTH(fecha_solicitud)=$mes " : "")
                . (isset($dia) ? "AND DAY(fecha_solicitud)=$dia " : "");
        }else
            $sql0  .= ($this->validateField($desde) ? "WHERE fecha_solicitud BETWEEN '$desde'  AND '$hasta' " : "");

        if( $this->validateField($status) )
        {
            $sql0  .= " AND status = '$status' ";
        }

        $sql0 .= ";";

        $stmt0 = $this->em->getConnection()->prepare($sql0);
        $stmt0->execute();
        $result0 = $stmt0->fetchAll();
        
        $datasets = array();
        foreach($result0 as $i0 => $row0) {
            $sql = "SELECT s.status as serie, e.id as labelID, e.nombre as label, count(s.id) as value "
                    . "FROM data_solicitudes s "
                    . "INNER JOIN data_centrohipico ch ON ch.id=s.idcentroh "
                    . "INNER JOIN estado e ON e.id=ch.estado ";

            if( $this->validateField(!$desde) )
            {
                $sql .= "WHERE YEAR(s.fecha_solicitud)=$anio "
                    . (isset($mes) ? "AND MONTH(s.fecha_solicitud)=$mes " : "")
                    . (isset($dia) ? "AND DAY(s.fecha_solicitud)=$dia " : "");
            }else
                $sql  .= ($this->validateField($desde) ? "WHERE s.fecha_solicitud BETWEEN '$desde'  AND '$hasta' " : "");

            $sql .= "AND s.status='$row0[serie]' "
                    ."GROUP BY s.status, e.nombre;";

            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            
            $serieData = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
            $total = 0;
            foreach ($result as $row) {
                $serieData[$row['labelID']-1] = $row['value'];
                $total += $row['value'];
            }

            $seriePercent = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
            $totalPercent = 0;
            if($total > 0){
                foreach ($serieData as $i => $data) {
                    $seriePercent[$i] = $data/$total*100;
                    $totalPercent += $seriePercent[$i];
                }
            }

            $datasets[] = array(
                'label' => $row0['serie'],
                'fillColor' => $this->color[$i0],
                'pointColor' => $this->color[$i0],
                'data' => $serieData,
                'percent' => $seriePercent,
                'total' => $total,
                'totalPercent' => $totalPercent
            );
        }
        
        $sql1 = "SELECT nombre FROM estado;";
        $stmt1 = $this->em->getConnection()->prepare($sql1);
        $stmt1->execute();
        $result1 = $stmt1->fetchAll();
        $labels = array();
        foreach ($result1 as $row1) {
            $labels[] = $row1['nombre'];
        }
        
        $data = array(
            'labels' => $labels,
            'datasets' => $datasets
        );

        return $data;
    }
    
    public function getDataFiscalizacionPorEstado($anio, $mes = null, $dia = null, $desde = null, $hasta = "3000-12-12", $status = null) {
        $sql0 = "SELECT DISTINCT estatus as serie "
                . "FROM data_fiscalizacion ";

        if( $this->validateField(!$desde) )
        {
            $sql0 .= "WHERE YEAR(fecha)=$anio "
                . (isset($mes) ? "AND MONTH(fecha)=$mes " : "")
                . (isset($dia) ? "AND DAY(fecha)>=$dia AND DAY(fecha)<=31 " : "");
        }else
            $sql0  .= ($this->validateField($desde) ? "WHERE fecha BETWEEN '$desde'  AND '$hasta' " : "");

        if( $this->validateField($status) )
        {
            $sql0  .= " AND estatus = '$status' ";
        }

        $sql0 .= " UNION SELECT '_' as serie;";

        $stmt0 = $this->em->getConnection()->prepare($sql0);
        $stmt0->execute();
        $result0 = $stmt0->fetchAll();
        
        $datasets = array();
        foreach($result0 as $i0 => $row0) {
            if($row0['serie'] != '_'){
                $sql = "SELECT f.estatus as serie, e.id as labelID, e.nombre as label, count(f.id) as value "
                        . "FROM data_fiscalizacion f "
                        . "LEFT JOIN data_centrohipico ch ON ch.id=f.centro_id "
                        . "LEFT JOIN data_operadora o ON o.id=f.operadora_id "
                        . "INNER JOIN estado e ON e.id=ch.estado OR e.id=o.idestado ";

                if( $this->validateField(!$desde) )
                {
                    $sql .= "WHERE YEAR(f.fecha)=$anio "
                        . (isset($mes) ? "AND MONTH(f.fecha)=$mes " : "")
                        . (isset($dia) ? "AND DAY(f.fecha)<=$dia " : "");
                }else
                    $sql  .= ($this->validateField($desde) ? "WHERE f.fecha BETWEEN '$desde'  AND '$hasta' " : "");

                $sql .= "AND f.estatus='$row0[serie]' "
                        ."GROUP BY f.estatus, e.nombre;";

            } else {
                $sql = "SELECT serie, labelID, label, SUM(value) as value "
                        . "FROM ("
                            . "SELECT '_' as serie, e.id as labelID, e.nombre as label, count(p.id) as value "
                            . "FROM data_providencia p "
                            . "INNER JOIN data_centro_prov cp ON p.id = cp.prov_id "
                            . "INNER JOIN data_centrohipico ch ON ch.id=cp.centro_id "
                            . "INNER JOIN estado e ON e.id=ch.estado "
                            . "WHERE YEAR(p.ffinal)=$anio "
                            . (isset($mes) ? "AND MONTH(p.ffinal)=$mes " : "")
                            . (isset($dia) ? "AND DAY(p.ffinal)>=$dia AND DAY(p.ffinal)<=31 " : "")
                            . "AND p.status <> 'Cerrada' "
                            . "GROUP BY serie, e.nombre "
                            . "UNION "
                            . "SELECT '_' as serie, e.id as labelID, e.nombre as label, count(p.id) as value "
                            . "FROM data_providencia p "
                            . "INNER JOIN data_oper_prov op ON p.id = op.prov_id "
                            . "INNER JOIN data_operadora o ON o.id=op.centro_id "
                            . "INNER JOIN estado e ON e.id=o.idestado ";

                if( $this->validateField(!$desde) )
                {
                    $sql .= "WHERE YEAR(p.ffinal)=$anio "
                        . (isset($mes) ? "AND MONTH(p.ffinal)=$mes " : "")
                        . (isset($dia) ? "AND DAY(p.ffinal)=$dia " : "");
                }else
                    $sql  .= ($this->validateField($desde) ? "WHERE p.ffinal BETWEEN '$desde'  AND '$hasta' " : "");

                $sql .= "AND p.status <> 'Cerrada' "
                    . "GROUP BY serie, e.nombre"
                    . ") x GROUP BY serie, labelID, label;";
            }
            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            
            $serieData = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
            $total = 0;
            foreach ($result as $row) {
                $serieData[$row['labelID']-1] = $row['value'];
                $total += $row['value'];
            }

            $seriePercent = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
            $totalPercent = 0;
            if($total > 0) {
                foreach ($serieData as $i => $data) {
                    $seriePercent[$i] = $data/$total*100;
                    $totalPercent += $seriePercent[$i];
                }
            }

            $datasets[] = array(
                'label' => ($row0['serie'] != '_' ? $row0['serie'] : 'Por Fiscalizar'),
                'fillColor' => $this->color[$i0],
                'pointColor' => $this->color[$i0],
                'data' => $serieData,
                'percent' => $seriePercent,
                'total' => $total,
                'totalPercent' => $totalPercent
            );
        }
        
        $sql1 = "SELECT nombre FROM estado;";
        $stmt1 = $this->em->getConnection()->prepare($sql1);
        $stmt1->execute();
        $result1 = $stmt1->fetchAll();
        $labels = array();
        foreach ($result1 as $row1) {
            $labels[] = $row1['nombre'];
        }
        
        $data = array(
            'labels' => $labels,
            'datasets' => $datasets
        );

        return $data;
    }
    
    public function getDataIngresoPorEstado($anio, $mes = null, $dia = null, $desde = null, $hasta = "3000-12-12", $status = null) {
        $sql0 = "SELECT DISTINCT tipo_pago as serie "
                . "FROM data_pagos ";

        if( $this->validateField(!$desde) )
        {
            $sql0 .= "WHERE YEAR(fecha_solicitud)=$anio "
                . (isset($mes) ? "AND MONTH(fecha_solicitud)=$mes " : "")
                . (isset($dia) ? "AND DAY(fecha_solicitud)=$dia " : "");

        }else
            $sql0  .= ($this->validateField($desde) ? "WHERE fecha_solicitud BETWEEN '$desde'  AND '$hasta' " : "");

        if( $this->validateField($status) )
        {
            $sql0  .= " AND status = '$status' ";
        }

        $sql0 .= ";";


        $stmt0 = $this->em->getConnection()->prepare($sql0);
        $stmt0->execute();
        $result0 = $stmt0->fetchAll();
        
        $datasets = array();
        foreach($result0 as $i0 => $row0) {
            $sql = "SELECT p.tipo_pago as serie, e.id as labelID, e.nombre as label, count(p.id) as value "
                    . "FROM data_pagos p "
                    . "INNER JOIN data_centrohipico ch ON ch.id=p.idcentroh "
                    . "INNER JOIN estado e ON e.id=ch.estado ";

            if( $this->validateField(!$desde) )
            {
                $sql0 .= "WHERE YEAR(p.fecha_solicitud)=$anio "
                    . (isset($mes) ? "AND MONTH(p.fecha_solicitud)=$mes " : "")
                    . (isset($dia) ? "AND DAY(p.fecha_solicitud)=$dia " : "");

            }else
                $sql0  .= ($this->validateField($desde) ? "WHERE p.fecha_solicitud BETWEEN '$desde'  AND '$hasta' " : "");

            $sql0 .= "AND p.status='$row0[serie]' "
                . "GROUP BY p.status, e.nombre;";


            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            
            $serieData = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
            $total = 0;
            foreach ($result as $row) {
                $serieData[$row['labelID']] = $row['value'];
                $total += $row['value'];
            }

            $seriePercent = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
            $totalPercent = 0;
            if($total > 0) {
                foreach ($serieData as $i => $data) {
                    $seriePercent[$i] = $data/$total*100;
                    $totalPercent += $seriePercent[$i];
                }
            }

            $datasets[] = array(
                'label' => $row0['serie'],
                'fillColor' => $this->color[$i0],
                'pointColor' => $this->color[$i0],
                'data' => $serieData,
                'percent' => $seriePercent,
                'total' => $total,
                'totalPercent' => $totalPercent
            );
        }
        
        $sql1 = "SELECT nombre FROM estado;";
        $stmt1 = $this->em->getConnection()->prepare($sql1);
        $stmt1->execute();
        $result1 = $stmt1->fetchAll();
        $labels = array();
        foreach ($result1 as $row1) {
            $labels[] = $row1['nombre'];
        }
        
        $data = array(
            'labels' => $labels,
            'datasets' => $datasets
        );

        return $data;
    }
    
    public function getDataUsuarioPorEstado($anio, $mes = null, $dia = null, $desde = null, $hasta = "3000-12-12", $status = null) {
        $sql0 = "SELECT DISTINCT role_type as serie "
                . "FROM sys_perfil INNER JOIN data_solicitudes ON user = idusuario ";

        if( $this->validateField(!$desde) )
        {
            $sql0 .= "WHERE YEAR(fecha_solicitud)=$anio "
                    . (isset($mes) ? "AND MONTH(fecha_solicitud)=$mes " : "")
                    . (isset($dia) ? "AND DAY(fecha_solicitud)=$dia " : "");
        }else
            $sql0  .= ($this->validateField($desde) ? "WHERE fecha_solicitud BETWEEN '$desde'  AND '$hasta' " : "");

        if( $this->validateField($status) )
        {
            $sql0  .= " AND role_type = '$status' ";
        }


        $sql0 .= "UNION SELECT '_' as serie;";


        $stmt0 = $this->em->getConnection()->prepare($sql0);
        $stmt0->execute();
        $result0 = $stmt0->fetchAll();
        
        $datasets = array();
        foreach($result0 as $i0 => $row0) {
            if($row0['serie'] != '_'){
                $sql = "SELECT p.role_type as serie, e.id as labelID, e.nombre as label, count(idperfil) as value "
                        . "FROM sys_perfil p INNER JOIN data_solicitudes s ON p.user = s.idusuario "
                        . "INNER JOIN estado e ON e.id=p.estado ";

                if( $this->validateField(!$desde) )
                {
                    $sql .= "WHERE YEAR(s.fecha_solicitud)=$anio "
                            . (isset($mes) ? "AND MONTH(s.fecha_solicitud)=$mes " : "")
                            . (isset($dia) ? "AND DAY(s.fecha_solicitud)=$dia " : "");
                }else
                    $sql  .= ($this->validateField($desde) ? "WHERE s.fecha_solicitud BETWEEN '$desde'  AND '$hasta' " : "");

                if( $this->validateField($status) )
                {
                    $sql0  .= " AND role_type = '$status' ";
                }

                $sql .= " GROUP BY p.role_type, e.nombre;";

            } else {
                $sql = "SELECT '_' as serie, e.id as labelID, e.nombre as label, count(s.id) as value "
                        . "FROM data_solicitudes s "
                        . "INNER JOIN data_centrohipico ch ON ch.id=s.idcentroh "
                        . "INNER JOIN estado e ON e.id=ch.estado ";

                if( $this->validateField(!$desde) )
                {
                    $sql .= "WHERE YEAR(s.fecha_solicitud)=$anio "
                        . (isset($mes) ? "AND MONTH(s.fecha_solicitud)=$mes " : "")
                        . (isset($dia) ? "AND DAY(s.fecha_solicitud)=$dia " : "");
                }else
                    $sql  .= ($this->validateField($desde) ? "WHERE s.fecha_solicitud BETWEEN '$desde'  AND '$hasta' " : "");

                $sql .= "AND s.status <> 'Aprobada' "
                    . "GROUP BY serie, e.nombre;";
            }
            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            
            $serieData = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
            $total = 0;
            foreach ($result as $row) {
                $serieData[$row['labelID']-1] = $row['value'];
                $total += $row['value'];
            }

            $seriePercent = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
            $totalPercent = 0;
            if($total > 0) {
                foreach ($serieData as $i => $data) {
                    $seriePercent[$i] = $data/$total*100;
                    $totalPercent += $seriePercent[$i];
                }
            }

            $datasets[] = array(
                'label' => ($row0['serie'] == 'ROLE_CENTRO_HIPICO' ? 'Centro Hípico' : ($row0['serie'] == 'ROLE_OPERADOR' ? 'Operadora' : 'En espera de Licencias')),
                'fillColor' => $this->color[$i0],
                'pointColor' => $this->color[$i0],
                'data' => $serieData,
                'percent' => $seriePercent,
                'total' => $total,
                'totalPercent' => $totalPercent
            );
        }
        
        $sql1 = "SELECT nombre FROM estado;";
        $stmt1 = $this->em->getConnection()->prepare($sql1);
        $stmt1->execute();
        $result1 = $stmt1->fetchAll();
        $labels = array();
        foreach ($result1 as $row1) {
            $labels[] = $row1['nombre'];
        }
        
        $data = array(
            'labels' => $labels,
            'datasets' => $datasets
        );
        
        return $data;
    }

    
    public function getDataEjecutivo($anio, $mes, $dia) {
        $dataRep = array();
        
        $dataRep[0] = $this->getDataLicencia($anio, $mes, $dia);
        $dataRep[1] = $this->getDataLicenciaPorEstado($anio, $mes, $dia);
        $dataRep[2] = $this->getDataFiscalizacion($anio, $mes, $dia);
        $dataRep[3] = $this->getDataFiscalizacionPorEstado($anio, $mes, $dia);
        $dataRep[4] = $this->getDataIngreso($anio, $mes, $dia);
        $dataRep[5] = $this->getDataIngresoPorEstado($anio, $mes, $dia);
        
        return $dataRep;
    }
    
}
