<?php
/**
 * Description of XcelObj Genera la Clase de 
 *
 * class XcelObj
 * @author 'Ing Carlos A Salzar <csalazart33@gmail.com>'
 */

namespace Sunahip\ExportBundle\Service;

class XcelObj {
 
  private $title=''; 
  private $phpExcelObject='';
  private $datarow=1;
  private $firstCol='A';
  private $firstRow='A';
    
 /**
  * Crea el servicio y el Objeto phpexcel 
  * @param string $title Titulo del Ar hivo de Excel 
  * @return Object phpexel Object
  */   
 public function __construct($title,$phpexcelobj) {
        $this->phpExcelObject = $phpexcelobj;
          $this->phpExcelObject->getProperties()->setCreator("SUNAHIP")
           ->setLastModifiedBy("SUNAHIP")
           ->setTitle("Listado de ".$title)
           ->setSubject("Listado de ".$title." - SUNAHIP")
           ->setDescription("Listado de ".$title." Generadas por el Sistema SUNAHIP ")
           ->setCategory("SUNAHIP - ".$title);
          $this->title=$title;
          $this->firtsCol='A';
          $this->firsRow=1;
          $this->datarow=$this->firstRow;
    }
    /**
     * Genera todas las Columnas XLS relacionadas a la cantidad de $num
     * @param intenger $num numero de columnas
     * @return string
     */
    public function generateXlsCols($num) {
        $xlsCols=array(); 
        $xlscol=$this->firstCol; 
        for($i=0;$i<$num;$i++)
         { $xlsCols[]=$xlscol;$xlscol++;} 
        return $xlsCols;
    }

    /**
     * Retorna La Letra de la Columna de la Posicion
     * @param integer $pos numero de la columna de 1 a X
     * @return string Letra de la Columna
     */
    public function getXlsCol($pos) {
        $xlscol=$this->firstCol; 
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
    public function setXlsTitles(array $headers) 
    {
        $this->phpExcelObject->setActiveSheetIndex(0)->setCellValue('A1', $this->title);
        $cend=$this->getXlsCol(count($headers));
        $merge='A'.$this->datarow.":$cend.$this->datarow";
        $this->phpExcelObject->setActiveSheetIndex(0)
                ->mergeCells($merge);
        $xlscol=$this->firstCol;
        $this->datarow++;
        foreach ($headers as $header){
           $this->phpExcelObject->setActiveSheetIndex(0)
                   ->setCellValue($xlscol.$this->datarow, $header);
           $xlscol++;
        }
        $this->datarow++; // Situa el PRimer Registro de datos
    }
    
    /**
     * Setter de Row carga la data de $dataRow en la Fila $row en el Archivo de Xcel
     * @param object $xlsObject Objeto de phpExcel
     * @param array $dataRow array de datos 
     * @param intenger $row Fila en xcel
     */
    public function setXlsRow(array $dataRow) 
    {
        $xlscol=$this->firstCol;
        foreach ($dataRow as $data){
           $this->phpExcelObject->setActiveSheetIndex(0)
                   ->setCellValue($xlscol.$this->datarow, $data);
           $xlscol++;
        }
        $this->datarow++; // incrementa el Valor al Row Siguiente.
    }
    
    /**
     * Responser XLS de xcel genera y responde el Xcel
     * @param Object $phpExcelObject
     * @param string $filename File Name y title of File attach download
     * @return Object Rsponse Object Xcel stream
     */
    public function ResponseXls($filename="Listado_Sunahip") 
    {   //phpExcelObject
          $this->phpExcelObject->setActiveSheetIndex(0);
          $this->phpExcelObject->getActiveSheet()->setTitle($filename);
      // create the writer
           $writer = $this->get('phpexcel')->createWriter($this->phpExcelObject, 'Excel5');
      // create the response
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
        // adding headers
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename='.$filename.".xls");
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        return $response;        
    }
    
    /**
     * Getter del phpExcel Object
     * @return type
     */
    public function getPhpXcel() {
        return $this->phpExcelObject;
    }
    
}
