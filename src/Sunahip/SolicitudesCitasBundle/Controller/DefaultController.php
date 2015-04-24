<?php

/*
 * @author Greicodex <info@greicodex.com> 
 * Solicitar licencia Operadora y Centro Hípico
 */

namespace Sunahip\SolicitudesCitasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sunahip\SolicitudesCitasBundle\Entity\DataCitas;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class DefaultController extends Controller
{
    /*
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
     */
    public function indexAction()
    {
        $name="Citas";
        return $this->render('SolicitudesCitasBundle:Default:index.html.twig', array('name' => $name));
    }

    /*
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
     */
    public function crearCitaAction()
    {
        // Ver el listado
        //return $this->render('SolicitudesCitasBundle:SolicitudLicencia:crear.html.twig');
        return $this->render('SolicitudesCitasBundle:DataSolicitudes:crear.html.twig');
    }
    
    /*
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
     */
    public function generacitaAction($date)
    {
        $phpdate=$date/1000; // Se actualiza de javascript a php Date
        $fecha2 = new \DateTime();
        $fecha2->setTimestamp($phpdate);
        //$fecha2->add(new \DateInterval('P1D') ); // Correccion de Error Javascript de 1 Dia
        $resp=$fecha2->format('Y-m-d');
        $em=$this->getDoctrine()->getManager();
        $cant=$em->getRepository('SolicitudesCitasBundle:DataCitas')->ContCitaDay($resp);
        if ($cant<6) { // Establecer parametro de Configuraci�n a determinar Cantidad de Citas Diarias
            // Si Cant Citas por Dia es La aceptable Se Genera la Cita--
            $cita = new DataCitas();
            $cita->setStatus('on');
            $cita->setSolicitud(1);
            $cita->setUsuario(1);
            $cita->setFechaSolicitud($fecha2);
            $em->persist($cita);
            $em->flush();
        //$response='Su Cita ha Sido Establecida para el D&iacute;a: '.$fecha2->format('d/m/Y')
        //        .'<br/>Recuerde Tener Completos Todos sus recaudos necesarios. ';
        $response=array(
            'status'=>"OK",
            'eventData'=>array(
                'title'=>'Cita Otorgada',
                'start'=>$date,
                'end'=>$date
            ),
            'message'=>'Su Cita ha Sido Establecida para el D&iacute;a: '.$fecha2->format('d/m/Y')
                .'<br/>Recuerde Tener Completos Todos sus recaudos necesarios. '
        );
        } else {
           //$response='Las Citas para Este D&iacute;a '. $fecha2->format('d/m/Y').' estan completas..';
           $response= array(
               'status'=>'none',
               'message'=>'Las Citas para Este D&iacute;a '. $fecha2->format('d/m/Y').' estan completas..'
               );
        }
       //$json= new \Symfony\Component\HttpFoundation\Tests\JsonResponseTest ;
       $jsonR= new \Symfony\Component\HttpFoundation\JsonResponse() ;
       $jsonR->setData($response);
       //return \Symfony\Component\HttpFoundation\Response::create($response);
       return $jsonR;
    }
    
    /*
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
     */
    public function avaibleDaysAction()
    {
        $maxDate= new \DateTime();
        $maxDate->add(new \DateInterval('P15D'));
        $fecha2 = new \DateTime();
        $fecha2->add(new \DateInterval('P1D') ); // mas 1 Dia
        $today=$fecha2->format('Y-m-d');
       
        $em=$this->getDoctrine()->getManager();
        
       // Establecer parametro de Configuraci�n a determinar Cantidad de Citas Diarias
       // Si Cant Citas por Dia es La aceptable Se Genera la Cita--
       //$response='Su Cita ha Sido Establecida para el D&iacute;a: '.$fecha2->format('d/m/Y')
       //        .'<br/>Recuerde Tener Completos Todos sus recaudos necesarios. ';
            for($i=1;$i<=21;$i++){
                $count=$em->getRepository('SolicitudesCitasBundle:DataCitas')->ContCitaDay($fecha2->format('Y-m-d'));
                //var_dump($fecha2->format('Y-m-d'). ' '.$count);
                if($count<5 && ($fecha2->format('w')!=0) && ($fecha2->format('w')!=6) ){
                            $eventData[]=array(
                                  'title'=>'Disponible',
                                  'start'=>$fecha2->format('Y-m-d'),
                                  'end'=>$fecha2->format('Y-m-d'),
                                  'allDay'=>'true'
                              );
                }
               $fecha2->add(new \DateInterval('P1D') ); // mas 1 Dia
            }
        $response=array(
            'status'=>"OK",
            'eventData'=> $eventData
        );
     
       $jsonR= new \Symfony\Component\HttpFoundation\JsonResponse() ;
       //$jsonR->setData($response);
       $jsonR->setData($eventData);
       //return \Symfony\Component\HttpFoundation\Response::create($response);
       return $jsonR;
    }
    
    /**
     * 
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
     */
    public function DatePickerAction()
    {
        //$maxDate= new \DateTime();
        //$maxDate->add(new \DateInterval('P21D'));
        $maxDays=21;
        $fecha2 = new \DateTime();
        $fecha2->add(new \DateInterval('P1D') ); // mas 1 Dia
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('SolicitudesCitasBundle:AdmFechasCitas')->findAll();
        $eventData=array(); // Fechas Invalidas
        $maxcitas=10; // Cantidad Maxima de Citas por Dia
        foreach($entities as $obj){
            $maxcitas=$obj->getMaxcitaxday();
            $eventData[]=  date_format($obj->getDate(), "Y-m-d") ;
        }
            for($i=1;$i<=$maxDays;$i++){
                $count=$em->getRepository('SolicitudesCitasBundle:DataCitas')->ContCitaDay($fecha2->format('Y-m-d'));
                if($count>=$maxcitas || ($fecha2->format('w')==0) || ($fecha2->format('w')==6) ){
                            $eventData[]=$fecha2->format('Y-m-d');
                }
               $fecha2->add(new \DateInterval('P1D') ); // mas 1 Dia
            }    
       $jsonR= new \Symfony\Component\HttpFoundation\JsonResponse() ;
       //$jsonR->setData($response);
       $jsonR->setData($eventData);
       //return \Symfony\Component\HttpFoundation\Response::create($response);
       return $jsonR;
    }
}
