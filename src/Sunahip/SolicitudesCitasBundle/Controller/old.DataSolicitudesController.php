<?php

/*
 * @author Greicodex <info@greicodex.com> 
 * Solicitar licencia Operadora y Centro Hípico
 */

namespace Sunahip\SolicitudesCitasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sunahip\SolicitudesCitasBundle\Entity\DataSolicitudes;
use Sunahip\SolicitudesCitasBundle\Form\DataSolicitudesType;
use Sunahip\SolicitudesCitasBundle\Entity\DataCitas;
use Sunahip\SolicitudesCitasBundle\Entity\DataRecaudosCargados;
//use Sunahip\SolicitudesCitasBundle\Form\DataRecaudosCargadosType;
//use Sunahip\PagosBundle\Form\PagoType;
use Sunahip\PagosBundle\Entity\Pagos;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\FormError;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * DataSolicitudes controller.
 *
 */
class DataSolicitudesController extends Controller
{

    /**
     * Lists all DataSolicitudes entities.
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('SolicitudesCitasBundle:DataSolicitudes')->findBy(array(
            'usuario'=>$this->getUser(),
            'tipoSolicitud'=>'centrohipico'
            ));
        
        return $this->render('SolicitudesCitasBundle:DataSolicitudes:index.html.twig', array(
            'entities' => $entities,
        ));
    }
 
    /**
     * Lists all DataSolicitudes entities.
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
     */
    public function indexOperadoraAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SolicitudesCitasBundle:DataSolicitudes')->findBy(array(
            'usuario'=>$this->getUser(),
            'tipoSolicitud'=>'operadora'
            ));//getListCitas($this->getUser(),'operadora');

        return $this->render('SolicitudesCitasBundle:DataSolicitudes:indexOperadora.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new DataSolicitudes Hipodromo.
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
     */
    public function createAction(Request $request)
    {
        $entity = new DataSolicitudes();
        $options=array('path'=>'datasolicitudes_create','tipoL'=>'ROLE_CENTRO_HIPICO');
        $form = $this->createCreateForm($entity,$options);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $user=  $this->getUser();
        // Verificar Cita y Validez   
        // Generar la Cita, guardar y Extraer.
        $aGencita['status'] = ""; 
        $isValid = true;
        $licencia = $em->getRepository("LicenciaBundle:AdmClasfLicencias")->find($request->get("sunahip_solicitudescitasbundle_datasolicitudes")["ClasLicencia"]);
        $fechaSol = $this->strtoDate($request->get("datacita"));
        $cantCitas = $em->getRepository("SolicitudesCitasBundle:DataCitas")->findByUser($fechaSol->format('Y-m-d'), $user);
        if($cantCitas>0) {
            $form->addError(new FormError('Ya tiene una cita generada para el día seleccionado.'));
            $isValid = false;
        }elseif($licencia->getHasOperadora()==1) {
            if($request->get("data_operadora_establecimiento")==="") {
                 $form->addError(new FormError('Para solicitar la licencia debe estar afiliado a una Operadora.'));
                 $isValid = false;
            } else {
                $dataOperadora = $em->getRepository("CentrohipicoBundle:DataOperadoraEstablecimiento")
                                    ->findOneBy(array('id'=>$request->get("data_operadora_establecimiento"), 'status' => 'Aprobado', 'hasSolicitud' => 0));
                if($dataOperadora) {
                    $entity->setDataOperadora($dataOperadora);
                }else {
                     $form->addError(new FormError('Para solicitar la licencia debe estar afiliado a una Operadora.'));
                     $isValid = false;
                }                
            }
        }        
        $aGencita=$this->generacita($request->get("datacita"));
        if($aGencita['status']=="OK" && $isValid)
        {   
            $cita=$this->newCita($aGencita);
            /*********************************************/
            // Verificar subida de Documentos Asignar Id 
            // Datos Agregados a la Solicitud
            $entity->setUsuario($user);
            $dataSF=$form->getData();
            $params=$request->request->all();
            // Carga de Recaudos.....
            $recaudos=$dataSF->getRecaudoscargados();
            $recaudoLicencia= $params['recaudoLicencia'];
            foreach($recaudos as $indx=>$recaudoC){
                $recaudoC->setRecaudoLicencia($em->getRepository('LicenciaBundle:AdmRecaudosLicencias')->find($recaudoLicencia[$indx]));
                $recaudoC->setFechaVencimiento($this->strtoDate($recaudoC->getFechaVencimiento()));
            }
            //Agregando Pago
            $centrohipico=$dataSF->getCentroHipico();
            $pago=$this->setPagoSolicitud($dataSF->getPago(),null,$centrohipico,\Sunahip\CommonBundle\DBAL\Types\PaymentType::PROCESAMIENTO);
            //Fin Carga del Pago
            ///***************** Fin recaudos   
            if(isset($params['juegose'])){ 
                foreach ($params['juegose'] as $juego){             
                    $dataSF->addJuegosExplotado($em->getRepository('LicenciaBundle:AdmJuegosExplotados')->find($juego));      
                }
            }
            $entity->setCita($cita);
            $entity->setCodsolicitud($cita->getCodsolicitud());
            $entity->setTipoSolicitud("centrohipico");
            $RC=$entity->getRecaudoscargados();
            foreach($RC as $recaudo){
                $recaudo->setSolicitud($entity);
            }            
            $pago->setSolicitud($entity);            
            $em->persist($pago);
            $em->persist($cita);
            $em->persist($entity);
            $em->flush();
            //actualizando la cita
            $cita->setSolicitud($entity->getId());
            $em->persist($cita);
            $em->flush();
            
            $title = "Notificación SUNAHIP: Cita de Solicitud de Licencia generada";
            $params['nombre']= $entity->getUsuario()->getFullname();
            $params['message']= "Ha solicitado una cita para la solicitud de licencia No. <b>".$entity->getCodsolicitud()."</b>, para el día <b>".$cita->getFechaSolicitud()->format("d/m/Y").
                                "</b>. Asistir a la siguiente dirección: Oficina Principal: Hipódromo La Rinconada, sede central del Instituto Nacional Hipódromo - INH, Piso 5, 
                                 Parroquia Coche, Municipio Libertador,  Caracas, Distrito Capital.<br><br>
                                 Por favor recuerde que para la cita debe consignar todos los recaudos solicitados, y realizar el pago por procesamiento";
            $params['message'] .= " por la cantidad de Número de Unidades Tributarias: ".$entity->getClasLicencia()->getSolicitudUt()." U.T. ";
            
            $file = $this->get('kernel')->getRootDir() . '/../web/media/tmp/'.$entity->getCodsolicitud().".pdf";
            $this->PrintGeneradaAction($entity->getId(),1,$file);
            $this->sendNotificationMail($title, $params, $entity->getUsuario()->getEmail(), $file);
            return $this->render('SolicitudesCitasBundle:DataSolicitudes:generada.html.twig', array(
                'entity' => $entity,
            ));
                
        }// Fin Si CITA se genero..
        $this->get('session')->getFlashBag()->add(
            'Error',
            $form->getErrors()
        );
        return $this->render('SolicitudesCitasBundle:DataSolicitudes:crear.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }// Fin Accion
    
    /**
     * Creates a new DataSolicitudes Operadora.
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
     */
    public function createOperadoraAction(Request $request)
    {
        $entity = new DataSolicitudes();
        $options=array('path'=>'solicitudoperadora_create','tipoL'=>'ROLE_OPERADOR');
        $form = $this->createCreateForm($entity,$options);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $user=$this->getUser();
        // Verificar Cita y Validez
        // Generar la Cita, guardar y Extraer.
        $aGencita['status'] = ""; 
        $isValid = true;
        $fechaSol = $this->strtoDate($request->get("datacita"));
        $cantCitas = $em->getRepository("SolicitudesCitasBundle:DataCitas")->findByUser($fechaSol->format('Y-m-d'), $user);
        if($cantCitas>0) {
            $form->addError(new FormError('Ya tiene una cita generada para el día seleccionado.'));
            $isValid = false;
        }
        $aGencita=$this->generacita($request->get("datacita"));
        if($aGencita['status']=="OK" && $isValid)
        {  
            $cita=$this->newCita($aGencita);
            // Verificar subida de Documentos Asignar Id 
            // Datos Agregados a la Solicitud
            $entity->setUsuario($user);
            $dataSF=$form->getData();
            $params=$request->request->all();
                // Carga de Recaudos
                $recaudos=$dataSF->getRecaudoscargados();
                $recaudoLicencia= $params['recaudoLicencia'];
                foreach($recaudos as $indx=>$recaudoC){
                    $recaudoC->setRecaudoLicencia($em->getRepository('LicenciaBundle:AdmRecaudosLicencias')->find($recaudoLicencia[$indx]));
                    $recaudoC->setFechaVencimiento($this->strtoDate($recaudoC->getFechaVencimiento()));
                }
                //**********Fin Recaudos*  
                if(isset($params['juegose'])){ 
                    foreach ($params['juegose'] as $juego){             
                        $dataSF->addJuegosExplotado($em->getRepository('LicenciaBundle:AdmJuegosExplotados')->find($juego));      
                    }
                } 
                // Buscar operadora
                $operadora = $em->getRepository('CentrohipicoBundle:DataOperadora')->findOneBy(array('usuario'=>$this->getUser()));
                // Carga de Pago
                $pago=$this->setPagoSolicitud($dataSF->getPago(),$operadora,null,\Sunahip\CommonBundle\DBAL\Types\PaymentType::PROCESAMIENTO);
                $entity->setCita($cita);
                $entity->setCodsolicitud($cita->getCodsolicitud());
                $entity->setOperadora($operadora);
                $entity->setTipoSolicitud("operadora");
                $RC=$entity->getRecaudoscargados();
                foreach($RC as $recaudo){
                    $recaudo->setSolicitud($entity);
                }                
                $pago->setSolicitud($entity);
                $em->persist($pago);
                $em->persist($cita);
                $em->persist($entity);
                $em->flush();
                //actualizando la cita
                $cita->setSolicitud($entity->getId());
                $em->persist($cita);
                $em->flush();
                
                $title = "Notificación SUNAHIP: Cita de Solicitud de Licencia generada";
                $params['nombre']= $entity->getUsuario()->getFullname();
                $params['message']= "Ha solicitado una cita para la solicitud de licencia No. <b>".$entity->getCodsolicitud()."</b>, para el día <b>".$cita->getFechaSolicitud()->format("d/m/Y").
                                    "</b>. Asistir a la siguiente dirección: Oficina Principal: Hipódromo La Rinconada, sede central del Instituto Nacional Hipódromo - INH, Piso 5, 
                                     Parroquia Coche, Municipio Libertador,  Caracas, Distrito Capital.<br><br>
                                     Por favor recuerde que para la cita debe consignar todos los recaudos solicitados, y realizar el pago por procesamiento";
                $params['message'] .= " por la cantidad de Número de Unidades Tributarias: ".$entity->getClasLicencia()->getSolicitudUt()." U.T. ";

                $file = $this->get('kernel')->getRootDir() . '/../web/media/tmp/'.$entity->getCodsolicitud().".pdf";
                $this->PrintGeneradaAction($entity->getId(),2,$file);           
                $this->sendNotificationMail($title, $params, $entity->getUsuario()->getEmail(), $file);
                
                return $this->render('SolicitudesCitasBundle:DataSolicitudes:generadaOperadora.html.twig', array(
                    'entity' => $entity,
                ));                
        }// Fin Si CITA se genero..
        $this->get('session')->getFlashBag()->add(
            'Error',
            $form->getErrors()
        );
        return $this->render('SolicitudesCitasBundle:DataSolicitudes:crearOperadora.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }// Fin Accion
    
    function vergeneradaAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('SolicitudesCitasBundle:DataSolicitudes')->find($id);
        
        if ($entity->getCentroHipico()!=null){
           $rif =  $entity->getCentroHipico()->getRif();
        }else {
           $rif = $entity->getOperadora()->getRif();
        }

        return $this->render('SolicitudesCitasBundle:DataSolicitudes:generadaOperadora.html.twig', array(
        //return $this->render('SolicitudesCitasBundle:DataSolicitudes:generada.html.twig', array(
              'entity' => $entity,'rif'=>$rif
            ));
    }
    
    function PrintGeneradaAction($id,$tipo,$path="")
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('SolicitudesCitasBundle:DataSolicitudes')->find($id);
        //$entity = $em->getRepository('SolicitudesCitasBundle:DataSolicitudes')->findByLocalizador($id);
        $temp[1]='generadaCH_print.html.twig';
        $temp[2]='generadaOp_print.html.twig';
        error_reporting(~E_STRICT);
        $html = $this->renderView('SolicitudesCitasBundle:DataSolicitudes:'.$temp[$tipo], array(
              'entity' => $entity,
            ));
        $mpdfService = $this->get('tfox.mpdfport');
        if($path==="") {
            return $mpdfService->generatePdfResponse($html);
        } else {
            $mpdfService->generatePdf($html, array('outputFilename'=>$path));
            return;
        }
    }

    /**
     * Creates a form to create a DataSolicitudes entity.
     *
     * @param DataSolicitudes $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DataSolicitudes $entity,$options=array()) {
        
        $tipoL = $tipoL = is_object($this->getTipoLicencia($options['tipoL']))?$this->getTipoLicencia($options['tipoL'])->getId():false;
        if(!$tipoL) {return false;}
        $form = $this->createForm(new DataSolicitudesType($this->getUser(),$tipoL), $entity, array(
            'action' => $this->generateUrl($options['path']),
            'method' => 'POST',
            'attr'=>array('id'=>'form_dsch'),
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Generar Solicitud',
            'attr'=>array(
                'class'=>'btn_sig_sol btn '
            ),
            ));

        return $form;
    }
    /**
     * Creates a form to Edit a DataSolicitudes entity.
     *
     * @param DataSolicitudes $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(DataSolicitudes $entity,$options=array()) {
        
        $tipoL = is_object($this->getTipoLicencia($options['tipoL']))?$this->getTipoLicencia($options['tipoL'])->getId():false;
        if(!$tipoL) {return false;}        
        $form = $this->createForm(new DataSolicitudesType($this->getUser(),$tipoL), $entity, array(
            'action' => $this->generateUrl($options['path'],$options['params']),
            'method' => 'POST',
            'attr'=>array('id'=>'form_dsch'),
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Actualizar Datos',
            'attr'=>array('class'=>'btn_sig_sol btn '),
            ));

        return $form;
    }

    /**
     * Displays a form to create a new DataSolicitudes entity.
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
     */
    public function newAction()
    {
        $entity = new DataSolicitudes();
        $options=array('path'=>'datasolicitudes_create','tipoL'=>'ROLE_CENTRO_HIPICO'); 
        //tipoL= CH:'Autorizacion' , Oper:'Licencia' 
        $form   = $this->createCreateForm($entity,$options);
        if(!$form) { throw  new \Symfony\Component\HttpKernel\Exception\HttpException(500,'Lo siento pero Faltan Datos en la Base de Datos Contacte con el Administrador');}
        //if(!$form) { throw  new \Symfony\Component\Config\Definition\Exception\Exception('Lo siento pero Faltan Datos en la Base de Datos Contacte con el Administrador',500);}
        return $this->render('SolicitudesCitasBundle:DataSolicitudes:crear.html.twig',array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
    /**
     * Displays a form to create a new DataSolicitudes entity.
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
     */
    public function newOperadoraAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user= $this->getUser();
        $valid = $em->getRepository("CentrohipicoBundle:DataLegal")->findOneBy(array('usuario'=> $user->getId()));
        if(!$valid)
        {
            return $this->render('SolicitudesCitasBundle:DataSolicitudes:noempresa.html.twig');
        }

        $entity = new DataSolicitudes();
        $options=array('path'=>'solicitudoperadora_create','tipoL'=>'ROLE_OPERADOR'); 
        $form   = $this->createCreateForm($entity,$options);
        if(!$form) { throw new \Symfony\Component\HttpKernel\Exception\HttpException(500,'Lo siento pero Faltan Datos en la Base de Datos Contacte con el Administrador');}
        return $this->render('SolicitudesCitasBundle:DataSolicitudes:crearOperadora.html.twig',array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a DataCita entity.
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
     */
    public function editDSchAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('SolicitudesCitasBundle:DataSolicitudes')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar La Solicitud o Exite un problema con la Base de Datos <br>Disculpe las Molestias Reintente mas Tarde.');
        }
        $options=array('path'=>'datasolicitudes_update','tipoL'=>'ROLE_CENTRO_HIPICO','params'=>array('id'=>$id)); 
        $form   = $this->createEditForm(new DataSolicitudes(),$options);
        if(!$form) { throw new \Symfony\Component\HttpKernel\Exception\HttpException(500,'Lo siento pero Faltan Datos en la Base de Datos Contacte con el Administrador');}
        return $this->render('SolicitudesCitasBundle:DataSolicitudes:editCH2.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /** Esta Accion dejo de Funcionar Ya no es Necesaria **/
    /*
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
     */
    public function updateDSchAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $DSE = $em->getRepository('SolicitudesCitasBundle:DataSolicitudes')->find($id);
        $entity = new DataSolicitudes();
        $options=array('path'=>'datasolicitudes_update','tipoL'=>'ROLE_CENTRO_HIPICO','params'=>array('id'=>$id)); 
        $form = $this->createEditForm($entity,$options);
        $form->handleRequest($request);
        $user=  $this->getUser();
            //Capturar Cita
            $cita=$DSE->getCita();
            /*********************************************/
            // Verificar subida de Documentos Asignar Id 
            // Datos Agregados a la Solicitud
            $entity->setUsuario($user);
            $dataSF=$form->getData();
            $params=$request->request->all();
            // Carga de Recaudos.....
                $this->cargaRecaudos($dataSF, $params);
                //Agregando Pago
                $pago=$this->setPagoSolicitud($dataSF->getPago(),null,$dataSF->getCentroHipico(),\Sunahip\CommonBundle\DBAL\Types\PaymentType::PROCESAMIENTO);
                //Fin Carga del Pago
                ///***************** Fin recaudos   
                if(isset($params['juegose'])){ 
                    foreach ($params['juegose'] as $juego){             
                        $dataSF->addJuegosExplotado($em->getRepository('LicenciaBundle:AdmJuegosExplotados')->find($juego));      
                    }
                }
                $entity->setCita($cita);
                $entity->setCodsolicitud($cita->getCodsolicitud());
                $entity->setTipoSolicitud("centrohipico");
                $RC=$entity->getRecaudoscargados();
                foreach($RC as $recaudo){
                    $recaudo->setSolicitud($entity);
                }
                $entity->setFechaSolicitud($DSE->getFechaSolicitud());
                $DSE->setUsuario(null);
                $DSE->setStatus("ELIMINADA");
                
                $cita->setSolicitud($entity->getId());
                $pago->setSolicitud($entity);
                $em->persist($pago);
                $em->persist($cita);
                $em->persist($entity);
                $em->persist($DSE);
                $em->flush();
                // solamente Cuadno se Modifique la cita.. 
                $title = "Notificación SUNAHIP: Cita de Solicitud de Licencia generada";
                $params['nombre']= $entity->getUsuario()->getFullname();
                $params['message']= "Ha solicitado una cita para la solicitud de licencia No. <b>".$entity->getCodsolicitud()."</b>, para el día <b>".$cita->getFechaSolicitud()->format("d/m/Y").
                                    "</b>. Asistir a la siguiente dirección: Oficina Principal: Hipódromo La Rinconada, sede central del Instituto Nacional Hipódromo - INH, Piso 5, 
                                     Parroquia Coche, Municipio Libertador,  Caracas, Distrito Capital.<br><br>
                                     Por favor recuerde que para la cita debe consignar todos los recaudos solicitados, y realizar el pago por procesamiento";
                $params['message'] .= " por la cantidad de Número de Unidades Tributarias: ".$entity->getClasLicencia()->getSolicitudUt()." U.T. ";

                $file = $this->get('kernel')->getRootDir() . '/../web/media/tmp/'.$entity->getCodsolicitud().".pdf";
                $this->PrintGeneradaAction($entity->getId(),1,$file);
                $this->sendNotificationMail($title, $params, $entity->getUsuario()->getEmail(), $file);
                
                return $this->render('SolicitudesCitasBundle:DataSolicitudes:generada.html.twig', array(
                    'entity' => $entity,
                ));
    }// Fin Accion
    
    //Remover Recaudos Cargados a la Solicitu para Agrgar Nuevos
    private function removerRecaudos($DSE,$em)
    {
        foreach($DSE->getRecaudoscargados() as $recaudo){
           $recaudo->setSolicitud(null); $em->remove($recaudo);
         }
         $DSE->setHipodromoInter('No Tiene');
         $em->flush();
    }
    
    /**
     * Finds and displays a DataCita entity.
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
     */
    public function editDSopAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('SolicitudesCitasBundle:DataSolicitudes')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar La Solicitud o Exite un problema con la Base de Datos <br>Disculpe las Molestias Reintente mas Tarde.');
        }
        $options=array('path'=>'solicitudoperadora_update','tipoL'=>'ROLE_OPERADOR','params'=>array('id'=>$id)); 
        $form   = $this->createEditForm(new DataSolicitudes(),$options);
        if(!$form) { throw new \Symfony\Component\HttpKernel\Exception\HttpException(500,'Lo siento pero Faltan Datos en la Base de Datos Contacte con el Administrador');}
        return $this->render('SolicitudesCitasBundle:DataSolicitudes:editOperadora.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
    
    /*
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
     */
    public function updateDSopAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $DSE = $em->getRepository('SolicitudesCitasBundle:DataSolicitudes')->find($id);
        $entity = new DataSolicitudes();
        $options=array('path'=>'solicitudoperadora_update','tipoL'=>'ROLE_OPERADOR','params'=>array('id'=>$id)); 
        $form = $this->createEditForm($entity,$options);
        $form->handleRequest($request);
        $user=  $this->getUser();
            //Capturar Cita
            $cita=$DSE->getCita();
            /*********************************************/
            // Verificar subida de Documentos Asignar Id 
            // Datos Agregados a la Solicitud
            $entity->setUsuario($user);
            $dataSF=$form->getData();
            $params=$request->request->all();
            // Carga de Recaudos.....
                $recaudos=$dataSF->getRecaudoscargados();
                $recaudoLicencia= $params['recaudoLicencia'];
                foreach($recaudos as $indx=>$recaudoC){
                    $recaudoC->setRecaudoLicencia($em->getRepository('LicenciaBundle:AdmRecaudosLicencias')->find($recaudoLicencia[$indx]));
                    $fecha=is_object($recaudoC->getFechaVencimiento())?$recaudoC->getFechaVencimiento():$this->strtoDate($recaudoC->getFechaVencimiento());
                    $recaudoC->setFechaVencimiento($fecha);
                }
                if(isset($params['juegose'])){ 
                    foreach ($params['juegose'] as $juego){             
                        $dataSF->addJuegosExplotado($em->getRepository('LicenciaBundle:AdmJuegosExplotados')->find($juego));      
                    }
                }
                //Agregando Pago a la Operadora
                $pago=$this->setPagoSolicitud($dataSF->getPago(),$DSE->getOperadora(),null,\Sunahip\CommonBundle\DBAL\Types\PaymentType::PROCESAMIENTO);
                //Fin Carga del Pago
             ///***************** Fin recaudos   
                $entity->setCita($cita);
                $entity->setCodsolicitud($cita->getCodsolicitud());
                $entity->setOperadora($DSE->getOperadora());
                $entity->setTipoSolicitud("operadora");
                $RC=$entity->getRecaudoscargados();
                foreach($RC as $recaudo){
                    $recaudo->setSolicitud($entity);
                }
                $entity->setFechaSolicitud($DSE->getFechaSolicitud());
                $DSE->setUsuario(null);
                $DSE->setStatus("ELIMINADA");
                                
                $pago->setSolicitud($entity);
                $em->persist($pago);
                $em->persist($cita);
                $em->persist($entity);
                $em->persist($DSE);
                $em->flush();
                //actualizando la cita
                $cita->setSolicitud($entity->getId());
                $em->persist($cita);
                $em->flush();
                
                $title = "Notificación SUNAHIP: Cita de Solicitud de Licencia generada";
                $params['nombre']= $entity->getUsuario()->getFullname();
                $params['message']= "Ha solicitado una cita para la solicitud de licencia No. <b>".$entity->getCodsolicitud()."</b>, para el día <b>".$cita->getFechaSolicitud()->format("d/m/Y").
                                    "</b>. Asistir a la siguiente dirección: Oficina Principal: Hipódromo La Rinconada, sede central del Instituto Nacional Hipódromo - INH, Piso 5, 
                                     Parroquia Coche, Municipio Libertador,  Caracas, Distrito Capital.<br><br>
                                     Por favor recuerde que para la cita debe consignar todos los recaudos solicitados, y realizar el pago por procesamiento";
                $params['message'] .= " por la cantidad de Número de Unidades Tributarias: ".$entity->getClasLicencia()->getSolicitudUt()." U.T. ";

                $file = $this->get('kernel')->getRootDir() . '/../web/media/tmp/'.$entity->getCodsolicitud().".pdf";
                $this->PrintGeneradaAction($entity->getId(),2,$file);           
                $this->sendNotificationMail($title, $params, $entity->getUsuario()->getEmail(), $file);
                
                return $this->render('SolicitudesCitasBundle:DataSolicitudes:generadaOperadora.html.twig', array(
                    'entity' => $entity,
                ));
    }// Fin Accion
    
    /*
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
     */
    public function updatecitaAction($id,$fecha)
    {   //$id : Codigo de solicitud
        $fecha2 = $this->tstoDate($fecha);
        $date=$fecha2->format('d/m/Y');
        $aGencita=$this->generacita($date);
        if ($aGencita['status']==="none"){
             throw $this->createNotFoundException('Lo sentimos no se pudo Actualizar la Cita<br/>Intente  de Nuevo Mas tarde');
        }
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('SolicitudesCitasBundle:DataSolicitudes')->find($id);
        $cita=$entity->getCita();
        $cita->setCodsolicitud($aGencita['codsol']);
        $cita->setFechaSolicitud($aGencita['fecha']);
        $entity->setCodsolicitud($aGencita['codsol']);
        $em->persist($cita);
        $em->persist($entity);
        $em->flush();          
        
        $title = "Cita Reprogramada Solicitud de Licencia";
        $params['nombre']= $entity->getUsuario()->getFullname();
        $params['message']= "Ha reprogramado una cita para la solicitud de licencia No. <b>".$entity->getCodsolicitud()."</b>, para el día <b>".$cita->getFechaSolicitud()->format("d/m/Y").
                            "</b>. Asistir a la siguiente dirección: Oficina Principal: Hipódromo La Rinconada, sede central del Instituto Nacional Hipódromo - INH, Piso 5, 
                             Parroquia Coche, Municipio Libertador,  Caracas, Distrito Capital.<br><br>
                             Por favor recuerde que para la cita debe consignar todos los recaudos solicitados, y realizar el pago por procesamiento";
        $params['message'] .= " por la cantidad de Número de Unidades Tributarias: ".$entity->getClasLicencia()->getSolicitudUt()." U.T. ";

        $file = $this->get('kernel')->getRootDir() . '/../web/media/tmp/'.$entity->getCodsolicitud().".pdf";
        $tipo=1;
        if($entity->getOperadora()) {
            $tipo = 2;
        }
        $this->PrintGeneradaAction($entity->getId(),$tipo,$file);           
        $this->sendNotificationMail($title, $params, $entity->getUsuario()->getEmail(), $file);
        
        return $this->render('SolicitudesCitasBundle:DataSolicitudes:editCitaOk.html.twig');
    }
    
    /**
     * Finds and displays a DataCita entity.
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
     */
    public function showcitaAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('SolicitudesCitasBundle:DataSolicitudes')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar La Solicitud o Exite un problema con la Base de Datos <br>Disculpe las Molestias Reintente mas Tarde.');
        }
        return $this->render('SolicitudesCitasBundle:DataSolicitudes:editCita.html.twig', array(
            'datasolicitud'      => $entity,
        ));
    }
    
    /*
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
     */
    public function chlistAction() 
     {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CentrohipicoBundle:DataCentrohipico')->findBy(array('usuario'=>$this->getUser()));
        return $this->render('SolicitudesCitasBundle:DataSolicitudes:List_ch.html.twig', array(
            'list'=>$entity,
        ));
    }
    
    /*
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
     */
    public function autorizaAction() 
    {
        $em = $this->getDoctrine()->getManager();
        $tipoL = $em->getRepository('LicenciaBundle:AdmTiposLicencias')->findOneBy(array('tipoLicencia'=>'ROLE_CENTRO_HIPICO'));
        $clasfL = $em->getRepository('LicenciaBundle:AdmClasfLicencias')->findBy(array('admTiposLicencias'=>$tipoL,'status'=>1));
        return $this->render('SolicitudesCitasBundle:DataSolicitudes:List_auto.html.twig', array(
            'list'=>$clasfL,
        ));
    }
    
    /*
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
     */
    public function juegosexpAction($id, $tipo) 
     {
        $em = $this->getDoctrine()->getManager();
        $clasfL = $em->getRepository('LicenciaBundle:AdmClasfLicencias')->find($id);
       if($clasfL) {
          //$TipoAporte = $em->getRepository('LicenciaBundle:AdmTipoAporte')->findBy(array('admClasfLicencias'=>$clasfL));
          $juegosE = $this->getJuegosEActivos($clasfL->getAdmJuegosExplotados());
          //$porJuego= !empty($TipoAporte)?$TipoAporte[0]->getPorJuego():0;
          if(count($juegosE)>0){ $porJuego = 1;}
          else {$porJuego = 0;}
       }else {$porJuego=0; $juegosE=null;}
       return $this->render('SolicitudesCitasBundle:DataSolicitudes:List_juegos.html.twig', array(
            'list'=>$juegosE,
            'porJuego'=>$porJuego,
            'tipo'=>$tipo,
       ));
    }
    
    /*
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
     */
    public function recaudosAction($id, $tipo) 
    {
        $em = $this->getDoctrine()->getManager();
        $clasfL = $em->getRepository('LicenciaBundle:AdmClasfLicencias')->find($id);
        $recaudosLicencia = $this->getRecaudosActivos($clasfL->getAdmRecaudosLicencias());
        $EDSolicitud=new DataSolicitudes();
        foreach ($recaudosLicencia as $row){ 
            $EDSolicitud->addRecaudoscargado(new DataRecaudosCargados()); 
        }
        // Agregando el Recibo de pago de Procesamiento        
        $ut = intval($this->container->getParameter('unidad_tributaria'));
        $session = $this->getRequest()->getSession();
        $monto = $clasfL->getSolicitudUt() * $ut;
        $session->set('monto_pago', $monto);
        $pagos = new Pagos();
        $pagos->setMonto($monto);
        $EDSolicitud->setPago($pagos);
        //Creando Form para Recaudos y Pago
        $options=array('path'=>'datasolicitudes_create','tipoL'=>'ROLE_CENTRO_HIPICO'); 
        $FDSolicitud=$this->createCreateForm($EDSolicitud,$options);
        $template = $tipo=='create'?'List_recaudos':'List_recaudos_edf2';
        return $this->render('SolicitudesCitasBundle:DataSolicitudes:'.$template.'.html.twig', array(
            'list'=>$recaudosLicencia,
            'FDSolicitud'=>$FDSolicitud->createView(),
            'PP'=> number_format($monto,2,",",".")
        ));
    }
    
    private function getJuegosEActivos($juegosE)
     {
        $juegosA=array();
        foreach($juegosE as $juego){
            if($juego->getStatus()) {$juegosA[]=$juego;}
        }
        return $juegosA;
     }
     
    private function getRecaudosActivos($recaudos)
     {
        $recaudosA=array();
        foreach($recaudos as $recaudo){
            if($recaudo->getStatus()) {$recaudosA[]=$recaudo;}
        }
        return $recaudosA;
     }
    
    /**
     * Actualiza el Centro hipico de la Solicitud
     * @param type $id
     * @param type $idds
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
     */
    public function actualizachAction($id,$idds)
    {
        $em = $this->getDoctrine()->getManager();
        $DS = $em->getRepository('SolicitudesCitasBundle:DataSolicitudes')->find($idds);
        $CH = $em->getRepository('CentrohipicoBundle:DataCentrohipico')->find($id);
        $DS->setCentroHipico($CH);
        $em->persist($DS);
        $em->flush();
        return new Response($CH->getDenominacionComercial());
    }
    
    /**
     * Actualiza la Licencia de la Solicitud
     * @param type $id
     * @param type $idds
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
     */
    public function actualizaLicAction($id,$idds)
    {
        $em = $this->getDoctrine()->getManager();
        $DS = $em->getRepository('SolicitudesCitasBundle:DataSolicitudes')->find($idds);
        $LIC = $em->getRepository('LicenciaBundle:AdmClasfLicencias')->find($id);
        $DS->setClasLicencia($LIC);
        $em->persist($DS);
        $em->flush();
        $this->removerRecaudos($DS, $em);
        return new Response($LIC->getClasfLicencia());
    }
    
    
    private function setPagoSolicitud($pago,$operadora,$centrohipico,$tipoPago){
         //$pago= new Pagos();
        $pago->setOperadora($operadora);
        $pago->setCentroHipico($centrohipico);
        $pago->setFechaCreacion(new \DateTime());
        $pago->setFechaProceso(new \DateTime());
        // Correccion de Fecha String to Fecha Object
        $pago->setFechaDeposito($this->strtoDate($pago->getFechaDeposito()));
        $session = $this->getRequest()->getSession();
        if($session->get('monto_pago')!="") {
            $pago->setMonto($session->get('monto_pago'));
        } else $pago->setMonto(0);
        $pago->setStatus("POR VERIFICAR");
        $pago->setTipoPago($tipoPago);
        $pago->setUsuarioCreacion($this->getUser());
        $pago->setUsuarioPaga($this->getUser());
        //Fin Carga del Pago 
        return $pago;
    }
    
    private function getTipoLicencia($tipo="ROLE_CENTRO_HIPICO"){
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository('LicenciaBundle:AdmTiposLicencias')->findOneBy(array('roleType'=>$tipo));
    }
    /**
     * Generadno la Nueva cita de De la Solicitud para Ser agregada.
     * @param type $aGencita
     * @return DataCitas
     */
    private function newCita($aGencita)
    { 
            $cita = new DataCitas();
            $cita->setStatus('Asignada');
            $cita->setSolicitud(0);
            $cita->setCodsolicitud($aGencita['codsol']);
            $cita->setUsuario($this->getUser());
            $cita->setFechaSolicitud($aGencita['fecha']);
            $em=$this->getDoctrine()->getManager();
            $em->persist($cita);
            $em->flush();
          return $cita;  
    }
    
    /**
     * TimeStamp to Date Object
     * @param TimeStamp $ts
     * @return \DateTime
     */
    private function tstoDate($ts) {
        $phpdate=$ts/1000; // Se actualiza de javascript a php Date timeStamp
        $fecha = new \DateTime();
        $fecha->setTimestamp($phpdate);
        $fecha->add(new \DateInterval('P1D') ); // C
        return $fecha;
    }
    /**
     * String Date "DD/MM/YYYY" to Date object
     * @param string $date
     * @return \DateTime
     */
    private function strtoDate($date){
        //var_dump($date);
        if (is_object($date) or is_null($date)) {return $date;}
         $dateE=str_replace("/","-",$date);
          //$aDate=  explode("/", $date);
          return new \DateTime($dateE);
         // return new \DateTime($aDate[2]."-".$aDate[1]."-".$aDate[0]);
    }
    
    private function generacita($date)
    {
        $fecha2 = $this->strtoDate($date);
        $resp=$fecha2->format('Y-m-d');
        $em=$this->getDoctrine()->getManager();
        $cant=$em->getRepository('SolicitudesCitasBundle:DataCitas')->ContCitaDay($resp);
        $lastcont=$em->getRepository('SolicitudesCitasBundle:DataCitas')->LastCitaDay($resp);
        $admfechas=$em->getRepository('SolicitudesCitasBundle:AdmFechasCitas')->findAll();
        $maxcita= !empty($admfechas)?$admfechas[0]->getMaxcitaxday():10;
        //$maxcita = 10;
        if ($cant<$maxcita) { // Establecer parametro de Configuración a determinar Cantidad de Citas Diarias
            // Si Cant Citas por Dia es La aceptable Se Genera la Cita--
            $cod=explode("-",$lastcont);
            $cont=intval($cod[1]);
              $codsol=$fecha2->format('Ymd')."-".str_pad($cont+1, 3, '0', STR_PAD_LEFT);
                $response=array(
                    'status'=>"OK",
                    'cont'=> $cant+1,
                    'fecha' => $fecha2,  
                    'codsol' => $codsol  
                 );
        } else {
           $response= array(
               'status'=>'none',
               );
        }
        return $response;
    } //fin Function Generacita  
    
    /*
     * Válido para centro Hípico verifica que tenga una operadora afiliada
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
     */
    public function operadoraEstablecimientoAction($id, $idCentro){
        $em = $this->getDoctrine()->getManager();
        $licencia =  $em->getRepository("LicenciaBundle:AdmClasfLicencias")->findOneBy(array('id' => $id));
        $response['status'] = 'false';
        $response['mensaje'] = "No se pudo verificar la licencia.";
        if($licencia) {
            if($licencia->getHasOperadora()==1) {
                $dataOperadoras = $em->getRepository("CentrohipicoBundle:DataOperadoraEstablecimiento")
                                        ->findBy(array('centroHipico' => $idCentro, 'status' => 'Aprobado', 'hasSolicitud' => 0));
                if(count($dataOperadoras)>0) {
                    $msj = "<select class='form-control' id='data_operadora_establecimiento' name='data_operadora_establecimiento' >";
                    foreach ($dataOperadoras as $data) {
                        //$msj .= "<option value=''>Seleccione Operadora Afiliada</option>";
                        $msj .= "<option value='".$data->getId()."'>".$data->getOperadora()->getFullrif()." ".$data->getOperadora()->getDenominacionComercial();
                        $msj .= "</option";
                    }
                    $msj .= "</select>";
                    $response['status'] = 'true';
                    $response['mensaje'] = $msj;
                    /*$operadora = $em->getRepository("CentrohipicoBundle:DataOperadora")->find($idCentro);
                    if($operadora) {
                        $response['status'] = 'true';
                        $response['mensaje'] = "Operadora Afiliada: " .$operadora->getFullrif()." <br> ".$operadora->getDenominacionComercial();
                    } else {
                        $response['status'] = 'false';
                        $response['mensaje'] = "Para hacer una solicitud de licencia ".$licencia->getClasfLicencia()." debe estar afiliado a una Operadora.";
                    }*/                  
                } else {
                    $response['status'] = 'false';
                    $response['mensaje'] = "Para hacer una solicitud de licencia ".$licencia->getClasfLicencia()." debe estar afiliado a una Operadora.";
                }
            } else {
                $response['status'] = 'true';
                $response['mensaje'] = "La licencia no requiere Operadora.";
            }
        }
        return new JsonResponse($response);
    }    
    
    /*
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
     */
    public function hipodromosAction($id, $tipo) {
        $em = $this->getDoctrine()->getManager();
        $licencia =  $em->getRepository("LicenciaBundle:AdmClasfLicencias")->findOneBy(array('id' => $id));
        $hasHipodromo = 'false';
        if($licencia) {
            if($licencia->getHasHipodromo()==1) {
                 $hasHipodromo = 'true';
            }
        }
        $template = $tipo=='create'?'hipodromos':'hipodromos_ed';
        return $this->render("SolicitudesCitasBundle:DataSolicitudes:".$template.".html.twig", array(
            'hasHipodromo' => $hasHipodromo,
        ));
    }
    /**
     * Actualiza Hipodromos Internacionales en la Solicitud
     * @param type $id
     * @param type $tipo
     * @return type
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
     */
    public function hipodromosUpdateAction(Request $request, $id) 
    {
        $em = $this->getDoctrine()->getManager();
        $DS=  $em->getRepository("SolicitudesCitasBundle:DataSolicitudes")->find($id);
        $DS->setHipodromoInter($request->get("hipointer"));
        $em->flush();
        return new Response($DS->getHipodromoInter(),200);
    }
    
    private function sendNotificationMail($title, $params=array(), $to, $file="") {
        
        $user = $this->container->getParameter("mailer_user");
        $html = $this->renderView('UserBundle:Notification:mail.html.twig', $params);
        
        $message = \Swift_Message::newInstance()
                        ->setSubject($title)
                        ->setFrom($user)
                        ->setTo($to)
                        ->setBody($html,'text/html');
        
        if($file!=="") {
            if(file_exists($file)){
                $message->attach(\Swift_Attachment::fromPath($file));
            }            
        }        
        return $this->get('mailer')->send($message);
    }
}
