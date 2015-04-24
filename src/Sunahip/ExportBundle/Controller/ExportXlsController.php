<?php
/**
 * Controlador para Exportar Listados a Excel XLS
 * Controlador ExportXlsController
 * Class ExportXlsController
 * @author Carlos Salazar <csalazart33@gmail.com>
 */

namespace Sunahip\ExportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ExportXlsController extends Controller
{
      
 /**
  * Crea el Objeto phpexcel 
  * @param string $title Titulo del Ar hivo de Excel 
  * @return Object phpexel Object
  */   
 private function CreateXLSObj($title,$cols) {
        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();
          $phpExcelObject->getProperties()->setCreator("SUNAHIP")
           ->setLastModifiedBy("SUNAHIP")
           ->setTitle("Listado de ".$title)
           ->setSubject("Listado de ".$title." - SUNAHIP")
           ->setDescription("Listado de ".$title." Generadas por el Sistema SUNAHIP ")
           ->setCategory("SUNAHIP - ".$title);
               $phpExcelObject->setActiveSheetIndex(0)->setCellValue('A1', $title);
                $cend=$this->getXlsCol($cols);
                $merge='A1:'.$cend.'1';
                $phpExcelObject->setActiveSheetIndex(0)
                        //->mergeCells($this->cellsToMergeByColsRow(0,count($headers),1));
                        ->mergeCells($merge);
         return  $phpExcelObject;
    }
    /**
     * Genera todas las Columnas XLS relacionadas a la cantidad de $num
     * @param intenger $num numero de columnas
     * @return string
     */
    private function generateXlsCols($num) {
        $xlsCols=array(); 
        $xlscol='A'; 
        for($i=0;$i<$num;$i++)
         { $xlsCols[]=$xlscol;$xlscol++;} 
        return $xlsCols;
    }

    /**
     * Retorna La Letra de la Columna de la Posicion
     * @param integer $pos numero de la columna de 1 a X
     * @return string Letra de la Columna
     */
    private function getXlsCol($pos) {
        $xlscol='A'; 
        for($i=1;$i<$pos;$i++)
         { $xlscol++;} 
        return $xlscol;
    }

    /**
     * Genera el Encabezado del Archivo XLS
     * @param type $xlsObject Objeto Xls
     * @param array $headers Arreglo de Encabezados Xls
     * @return Object Objecto Xls
     */
    private function setXlsTitles($xlsObject,array $headers) 
    {
        $xlscol='A';
        foreach ($headers as $header){
           $xlsObject->setActiveSheetIndex(0)
                   ->setCellValue($xlscol.'2', $header);
           $xlscol++;
        }
        //return $xlsObject;
    }
    
    private function cellsToMergeByColsRow($start = -1, $end = -1, $row = -1){
            $merge = 'A1:A1';
            if($start>=0 && $end>=0 && $row>=0){
                $start = PHPExcel_Cell::stringFromColumnIndex($start);
                $end = PHPExcel_Cell::stringFromColumnIndex($end);
                $merge = "$start{$row}:$end{$row}";
            }
            return $merge;
        }
    
    /**
     * Setter de Row carga la data de $dataRow en la Fila $row en el Archivo de Xcel
     * @param object $xlsObject Objeto de phpExcel
     * @param array $dataRow array de datos 
     * @param intenger $row Fila en xcel
     */
    private function setXlsRow($xlsObject,array $dataRow, $row) 
    {
        $xlscol='A';
        foreach ($dataRow as $data){
           $xlsObject->setActiveSheetIndex(0)
                   ->setCellValue($xlscol.$row, $data);
           $xlscol++;
        }
        //return $xlsObject;
    }
    
    /**
     * Responser XLS de xcel genera y responde el Xcel
     * @param Object $phpExcelObject
     * @param string $filename File Name y title of File attach download
     * @return Object Rsponse Object Xcel stream
     */
    public function ResponseXls($phpExcelObject,$filename="Listado_Sunahip") 
    {
          $phpExcelObject->setActiveSheetIndex(0);
          $phpExcelObject->getActiveSheet()->setTitle($filename);
      // create the writer
           $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
      // create the response
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
        // adding headers
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename='.$filename.".xls");
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        return $response;        
    }
    
    
    //Accion Exportar listas de Operadoras en Gerente 
    // Gestion de Operadoras Listado
    public function gerenteOperListAction() 
    {
        $coltitles=array('Nº','RIF','Operadora','Fecha de Afiliación','Tipo de Licencia'
                             ,'Nº de Licencia','Estatus','Nº Afiliados','Aporte Mensual (Bs.)');
         $phpExcelObject=$this->CreateXLSObj("Listado de Operadoras",count($coltitles));
         $this->setXlsTitles($phpExcelObject,$coltitles);
         $em = $this->getDoctrine()->getManager();
           //Obtener todas las operadoras que son principal esSucursal = false
           $entities = $em->getRepository('CentrohipicoBundle:DataOperadora')->findBy(array('esSucursal'=>false));
             foreach ($entities as $index=>$entity) 
             {     $numAfil=$em->getRepository('CentrohipicoBundle:DataOperadora')->contSucursales($entity->getUsuario()->getId());
                    $numLic="";$tLic="";
                    foreach ($entity->getLicenciasaprob() as $lic) {
                       $tLic.=$lic->getClasfLicencia();
                       $numLic.=$lic->getNumLicencia();
                    }
                    $data=array($index+1,$entity->getFullrif(),strtoupper($entity->getDenominacionComercial())
                        ,date_format($entity->getFechaRegistro() , "d-m-Y"),$tLic,$numLic,
                        $entity->getStatus(),$numAfil,'-');
                    $this->setXlsRow($phpExcelObject,$data,$index+3);
               } //Fin Entities  
        return $this->ResponseXls($phpExcelObject, "listado_operadoras");
    }
    
    /**
     *  Exportación a XLS de Afiliados en Listado Consultar Afiliados Operadora
     * @return response
     */
    public function operAfiliadosAction() 
    {   
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
       $securityContext = $this->container->get('security.context');
       if ($securityContext->isGranted('ROLE_GERENTE')){
        $entities = $em->getRepository("CentrohipicoBundle:DataOperadoraEstablecimiento")->findByAction( null,null );
       }else {$entities = $em->getRepository("CentrohipicoBundle:DataOperadoraEstablecimiento")->findByAction( $user->getId(),null );}
        $coltitles=array('Nº','RIF','Denomiación Comercial','Licencia','Operadora'
                             ,'Estatus Adscrito');
         $phpExcelObject=$this->CreateXLSObj("Listado de Afiliados",count($coltitles));
         $this->setXlsTitles($phpExcelObject,$coltitles);
         foreach ($entities as $index=>$entity){
             $data=array( $index+1, $entity['persJuridica']."-".$entity['rif'],
                         strtoupper($entity['denominacionComercial']),
                         $entity['licencia'], $entity['operadora'],
                         $entity['status']);
             
                    $this->setXlsRow($phpExcelObject,$data,$index+3);
         }
         return $this->ResponseXls($phpExcelObject, "listado_afiliados_operadoras");     
    }
    
    /**
     * Accion Listado de Providencias Excel
     * @return response
     */
    public function ProvidenciaListAction() 
    {   
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('FiscalizacionBundle:Providencia')->byRol($this->get('security.context'));
        $coltitles=array('No','No Providencia','Fecha de inicio / Fecha de fin',
                          'Estatus','Motivo');
         $phpExcelObject=$this->CreateXLSObj("Listado de Providencias",count($coltitles));
         $this->setXlsTitles($phpExcelObject,$coltitles);
         foreach ($entities as $index=>$entity){
             $FinFout=date_format($entity->getFinicio(), 'd/m/Y')." - ".date_format($entity->getFfinal(), 'd/m/Y');
             $data=array( $index+1, $entity->getNum(),$FinFout,
                         $entity->getStatus(), 
                         $entity->getMotivo());
                    $this->setXlsRow($phpExcelObject,$data,$index+3);
         }
         return $this->ResponseXls($phpExcelObject, "listado_providencias");     
    }
    
    /**
     *  Listado Licencias Abstrac Func Create Xls
     * @param type $entities
     * @return response
     */
    private function getListadoLic($entities, $tipo)
    {
        $coltitles=array('No','RIF','Denomiación Comercial',
                             'Licencia','Clasificación de Licencia',
                             'No Solicitud','Fecha de cita');
         $phpExcelObject=$this->CreateXLSObj("Listado de Licencias ".$tipo,count($coltitles));
         $this->setXlsTitles($phpExcelObject,$coltitles);
         foreach ($entities as $index=>$entity){
             $rif=$entity->getOperadora()? $entity->getOperadora()->getFullrif():$entity->getCentroHipico()->getFullrif(); 
             $denominacion=$entity->getOperadora()? $entity->getOperadora()->getDenominacionComercial():$entity->getCentroHipico()->getDenominacionComercial();
             $fechaSol=date_format($entity->getCita()->getFechaSolicitud(), 'd/m/Y');
             $data=array($index + 1, $rif,
                         strtoupper($denominacion),
                         $entity->getClasLicencia()->getAdmTiposLicencias()->getTipoLicencia(),
                         $entity->getClasLicencia()->getClasfLicencia(),
                         $entity->getCodsolicitud(),
                         $fechaSol);
                    $this->setXlsRow($phpExcelObject,$data,$index+3);
         }
         
         return $this->ResponseXls($phpExcelObject, "listado_Licencias"); 
    }
    /**
     * Export XLS Listado Licencias Asesor
     * @return Response XLS
     */
    public function LicenciasListAction($tipo) 
    {   
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository("SolicitudesCitasBundle:DataSolicitudes")->findBy(array('status' => $tipo));
        $tipo=($tipo=='Verificada')?'Por Aprobar':$tipo;
        return $this->getListadoLic($entities, $tipo);    
    }
    
    /**
     * Export XLS Listado Licencias Asesor
     * @return Response XLS
     */
    public function LicenciasListAprobAction() 
    {   
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository("SolicitudesCitasBundle:DataSolicitudes")->findBy( array("status" => "Aprobada") );
        $arrayEntity=array();
        foreach($entities as $entity){
            $solicitudApr = $em->getRepository("SolicitudesCitasBundle:DataSolicitudesAprob")->findOneBy(array('solicitud' => $entity->getId() ) );
            if($solicitudApr){
                $arrayEntity[] = $solicitudApr;
            }
         }
         $coltitles=array('No','RIF','Denomiación Comercial',
                             'Licencia','Clasificación de Licencia',
                             'No Licencia','No Providencia', 'Vencimiento');
         $phpExcelObject=$this->CreateXLSObj("Listado de Licencias Aprobadas",count($coltitles));
         $this->setXlsTitles($phpExcelObject,$coltitles);
         foreach ($arrayEntity as $index=>$entity){
             $en=$entity->getSolicitud();
             $rif=$en->getOperadora()? $en->getOperadora()->getFullrif():$en->getCentroHipico()->getFullrif(); 
             $denominacion=$en->getOperadora()? $en->getOperadora()->getDenominacionComercial():$en->getCentroHipico()->getDenominacionComercial();
             $fechaVen=date_format($entity->getFechaFin(), 'd/m/Y');
             $data=array($index+1, $rif,
                         strtoupper($denominacion),
                         $en->getClasLicencia()->getAdmTiposLicencias()->getTipoLicencia(),
                         $en->getClasLicencia()->getClasfLicencia(),
                         $en->getNumLicenciaAdscrita(),
                         $entity->getNumProvidencia(),
                         $fechaVen);
                    $this->setXlsRow($phpExcelObject,$data,$index+3);
         }
         return $this->ResponseXls($phpExcelObject, "listado_Licencias");
        //return $this->getListadoLic($arrayEntity,'Aprobadas');    
        //return $this->getListadoLic($entities,'Aprobada');    
    }
    
   public function FiscalesListAction() 
     {   
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('UserBundle:SysUsuario')->findByRole('ROLE_FISCAL');
        $coltitles=array('No','Cedula de identidad','Nombre y apellido',
                          'Fecha de ingreso','Estatus');
        $phpExcelObject=$this->CreateXLSObj("Listado de Fiscales",count($coltitles));
         $this->setXlsTitles($phpExcelObject,$coltitles);
         foreach ($entities as $index=>$entity){
             $perfil= $entity->getPerfil();
             $data=array( $index+1, $perfil[0]->getCi(),
                         $perfil[0]->getNombre().", ".$perfil[0]->getApellido(),
                         "10/09/2014", //pendiente Corregir 
                         $entity->isEnabled()?'Activo':'Inactivo');
                    $this->setXlsRow($phpExcelObject,$data,$index+3);
         }
         return $this->ResponseXls($phpExcelObject, "listado_Fiscales");     
      }
    
    public function PagosListAction($tipo)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('PagosBundle:Pagos')->porUsuario($user, $tipo);
        if( $user->hasRole('ROLE_GERENTE')){
            $coltitles=array('D. Comercial','Nº de Licencia','RIF',
                          'Creado','Estatus','Monto','F. de Pago');
        }else {
            $coltitles=array('D. Comercial','Nº de Licencia','RIF',
                          'Creado','Estatus',);
        }
         $phpExcelObject=$this->CreateXLSObj("Listado de Pagos {$tipo}",count($coltitles));
         $this->setXlsTitles($phpExcelObject,$coltitles);
         foreach ($entities as $index=>$entity){
             $centro=$entity->getCentroHipico()?$entity->getCentroHipico():$entity->getOperadora();
             $numLic=$centro->getLicenciasaprob()[0]?$centro->getLicenciasaprob()[0]->getNumLicencia():'---';
             $F= $entity->getFechaCreacion()?date_format($entity->getFechaCreacion(),'d/m/Y'):'Sin Fecha';
             $data=array( $centro->getDenominacionComercial(),
                         $numLic,
                         $centro->getFullrif(),  
                         $F,
                         $entity->getStatus(),
                      );
             if( $user->hasRole('ROLE_GERENTE')){
                 $data[]=$entity->getMonto();//number_format($entity->getMonto(),2);
                 $data[]=$entity->getFechaDeposito()?date_format($entity->getFechaDeposito(),'d/m/Y'):'Sin Fecha';
             }
                    $this->setXlsRow($phpExcelObject,$data,$index+3);
         }
         return $this->ResponseXls($phpExcelObject, "Pagos_{$tipo}");    
    }

    /**
     * Listado de Citas Excel
     * @return type
     */
    public function CitasListAction() 
    {
        $coltitles=array('No','RIF','D. Comercial','Tipo de Licencia','Fecha Cita',
                         'Bloque','Tipo Operación', 'F. Creación','F. Actualización','Estatus');
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('SolicitudesCitasBundle:DataSolicitudes')->findAll();
       $phpExcelObject=$this->CreateXLSObj("Listado de Citas",count($coltitles));
         $this->setXlsTitles($phpExcelObject,$coltitles);
         foreach ($entities as $index=>$entity){
             $centro=$entity->getCentroHipico()?$entity->getCentroHipico():$entity->getOperadora();
             $data=array($index+1,$centro->getFullrif(),
                         $centro->getDenominacionComercial(),
                         $entity->getClasLicencia()->getClasfLicencia(),
                         date_format($entity->getCita()->getFechaSolicitud(),'d/m/Y'),
                         date_format($entity->getCita()->getFechaSolicitud(),'A'),
                         $entity->getTipoSolicitud(),
                         date_format($entity->getFechaSolicitud(),'d/m/Y'),
                         date_format($entity->getFechaSolicitud(),'d/m/Y'),
                         $entity->getStatus(),
                      );
                    $this->setXlsRow($phpExcelObject,$data,$index+3);
         }
         return $this->ResponseXls($phpExcelObject, "Listado_Citas");   
    }
    
    public function FiscalizacionListAction($tipo) 
     {   
        $em = $this->getDoctrine()->getManager();
        //$entities = $em->getRepository('FiscalizacionBundle:Fiscalizacion')->todos($this->get('security.context'));
        if($tipo==='todos'){
         $entities = $em->getRepository('FiscalizacionBundle:Fiscalizacion')->todos($this->get('security.context'));
        }elseif($tipo==='citados'){
          $entities = $em->getRepository('FiscalizacionBundle:Fiscalizacion')->citados($this->get('security.context'));
        }elseif($tipo==='multados'){
          $entities = $em->getRepository('FiscalizacionBundle:Fiscalizacion')->multados($this->get('security.context'));
        }
        if($tipo==='citados'){
               $coltitles=array('No','F. Citación', 'D. Comercial','RIF','Providencia','Responsable',
                         'Cedula','Cargo','Estatus');
        }else{
            $coltitles=array('No','D. Comercial','RIF','Providencia','Responsable',
                         'Cedula','Cargo','Estatus');
        }    
        $phpExcelObject=$this->CreateXLSObj("Listado de Fiscalización ".$tipo,count($coltitles));
         $this->setXlsTitles($phpExcelObject,$coltitles);
         $data=array();
         foreach ($entities as $index=>$entity){
             $est= $entity->getCentro()? $entity->getCentro():$entity->getOperadora();
             unset($data);
             $data[]=$index+1;
             if($tipo==='citados'){$data[]=$entity->getCitacion()->getFecha()?date_format($entity->getCitacion()->getFecha(),'d/m/Y'):'Sin Fecha';}
             $data[]=$est->getDenominacionComercial();
             $data[]=$est->getFullrif();
             $data[]=$entity->getProvidencia()?$entity->getProvidencia()->getNum():'-';
             $data[]=$entity->getResponsable();
             $data[]=$entity->getCedula(); $data[]=$entity->getCargo(); $data[]=$entity->getEstatus();
             
                    $this->setXlsRow($phpExcelObject,$data,$index+3);
         }
         return $this->ResponseXls($phpExcelObject, "listado_Fiscalizacion_".$tipo);     
      }
}
