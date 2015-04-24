<?php

/*
 * @author Greicodex <info@greicodex.com> 
 * Lista de citados para la fecha
 * Cambio de estatus luego de las revisiones
 */

namespace Sunahip\SolicitudesCitasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sunahip\SolicitudesCitasBundle\Entity\DataRecaudosAprob;
use Sunahip\SolicitudesCitasBundle\Entity\DataSolicitudesAprob;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/gerente")
 */
class AdminLicenciasController extends Controller
{

    /**
     * @Route("/licencias_revisadas/info/{id}", name="gerente_modal_info")
     * @Template("SolicitudesCitasBundle:AdminLicencias:modal.html.twig")
     * @Security("has_role('ROLE_GERENTE') or has_role('ROLE_SUPERINTENDENTE') or has_role('ROLE_COORDINADOR') or has_role('ROLE_FISCAL') or has_role('ROLE_ASESOR')")
     */
    public function getModalInfoAction(Request $request, $id = null) {        
        $em = $this->getDoctrine()->getManager();
        $response = array();
        $user = $this->getUser();
        $securityContext = $this->container->get('security.context');
        $entity = $em->getRepository("SolicitudesCitasBundle:DataSolicitudes")->findOneBy(array('id' => $id));
        $solicitud = $em->getRepository("SolicitudesCitasBundle:DataSolicitudesAprob")->findOneBy(array('solicitud' => $id));

        if($entity)
        {
            $response['status'] = true;
            $response['entity'] = $entity;
            $response['aprob_fiscal'] = $solicitud->getRevisionFiscal();
            $response['fiscal'] = $solicitud->getFiscal()->getFullname();
            $response['fecha'] = $solicitud->getFechaRevisionFiscal();

            if($securityContext->isGranted('ROLE_ASESOR'))
            {
                $response['status'] = true;
                $response['entity'] = $entity;
                $response['aprob_gerente'] = $solicitud->getRevisionGerente();
                $response['gerente'] = $solicitud->getGerente()->getFullname();
                $response['fecha_gerente'] = $solicitud->getFechaRevisionGerente();
            }
            $response['documents'] = $em->getRepository("SolicitudesCitasBundle:DataRecaudosCargados")->getAllRecaudos($id);
            $response['pago'] = $entity->getPago();
        }else
            $response['status'] = false;

        return $response;
    }

    /**
     * @Route("/licencias_revisadas/reacudos_status/{id}", name="gerente_guardar_status")
     * @Security("has_role('ROLE_GERENTE')")
     */
    public function setStatusDocumentAction(Request $request, $id = null) {        
        $em = $this->getDoctrine()->getManager();
        $response = array();
        $user = $this->getUser();
        $securityContext = $this->container->get('security.context');
        
        $totalDocument = intval($request->get('total_document'));
        $aprobado = true;
        for($i=1;$i<$totalDocument;$i++) {
            $option = $request->get("option".$i);
            $option = explode("*", $option);
            if($option[0] == 0) {
                $aprobado = false;
            }
            $recaudo =  $em->getRepository("SolicitudesCitasBundle:DataRecaudosAprob")->findOneBy(array('id' => $option[1]));
            if($recaudo) {
                $recaudo->setAprobGerente($option[0]);
                $recaudo->setFechaAprobGerente( new \Datetime());
                $recaudo->setGerente($user);
                $em->persist($recaudo);
                $em->flush();
                
                $re = $recaudo->getRecaudo();
                if($re) {
                    $re->setStatus($option[0] == 1 ? 'Aprobado' : 'Rechazado');
                    $em->persist($recaudo);
                    $em->flush();
                }                
            }            
        }
        //Pago
        $option = $request->get('pago');
        $option = explode("*", $option);
        $pago = $em->getRepository("PagosBundle:Pagos")->find($option[1]);
        if($pago) {
            $pago->setFechaProceso( new \Datetime());
            if($option[0] == 0) {
                $aprobado = false;
                $pago->setStatus("Rechazado");
            }
            $em->persist($pago);
            $em->flush();
        }
        
        $entity = $em->getRepository("SolicitudesCitasBundle:DataSolicitudesAprob")->findOneBy(array('solicitud' => $id));
        $entity->setGerente($user);
        $entity->setRevisionGerente(1);
        $entity->setFechaRevisionGerente(new \Datetime());
        $em->persist($entity);
        $em->flush();

        if($entity)
        {
            $solicitud = $em->getRepository("SolicitudesCitasBundle:DataSolicitudes")->findOneBy(array('id' => $id));
            if($aprobado) {
                $solicitud->setStatus('Verificada');
            } else {
                $solicitud->setStatus('Rechazada');
                $solicitud->setFechaRechazada(new \Datetime());
                $em->persist($solicitud);
                $em->flush();
                try {                    
                    $title = "Notificación SUNAHIP: Solicitud de Licencia Rechazada";
                    $params['nombre']= $solicitud->getUsuario()->getFullname();
                    $params['message']= "Su solicitud de licencia No. <b>".$solicitud->getCodsolicitud()."</b>, ha sido rechazada.";
                    $this->sendNotificationMail($title, $params, $solicitud->getUsuario()->getEmail());
                } catch (Exception $e) {                    
                }
            }
            $em->persist($solicitud);
            $em->flush();
            $response['status'] = 'true';
        }else {
            $response['status'] = 'false';
            $response['mensaje'] = "Hubo un error al procesar.";
        }
        return new JsonResponse($response);
    }

    /**
     * @Route("/licencias_aprobadas/reacudos_status/{id}", name="asesor_guardar_status")
     * @Security("has_role('ROLE_ASESOR')")
     */
    public function setStatusAsesorAction(Request $request, $id = null) {
        $em = $this->getDoctrine()->getManager();
        $response = array();
        $user = $this->getUser();
        $securityContext = $this->container->get('security.context');
        
        $totalDocument = intval($request->get('total_document'));
        $aprobado = true;
        for($i=1;$i<$totalDocument;$i++) {
            $option = $request->get("option".$i);
            $option = explode("*", $option);
            $recaudo =  $em->getRepository("SolicitudesCitasBundle:DataRecaudosAprob")->findOneBy(array('id' => $option[1]));
            if($recaudo) {                
                $recaudo->setAprobAsesorlegal($option[0]);
                $recaudo->setFechaAprobAsesorlegal( new \Datetime());
                $recaudo->setAsesorLegal($user);
                
                if($option[0] == 0) {
                    $aprobado = false;
                }
                
                $em->persist($recaudo);
                $em->flush();
                
                $re = $recaudo->getRecaudo();
                if($re) {
                    $re->setStatus($option[0] == 1 ? 'Aprobado' : 'Rechazado');
                    $em->persist($recaudo);
                    $em->flush();
                }       
            }            
        }
        //Pago
        $option = $request->get('pago');
        $option = explode("*", $option);
        $pago = $em->getRepository("PagosBundle:Pagos")->find($option[1]);
        if($pago) {
            $pago->setFechaProceso( new \Datetime());
            if($option[0] == 0) {
                $pago->setStatus("RECHAZADO");
                $aprobado = false;
            } else {
                $pago->setStatus("VERIFICADO");
            }
            $em->persist($pago);
            $em->flush();                        
        }
        $entity = $em->getRepository("SolicitudesCitasBundle:DataSolicitudesAprob")->findOneBy(array('solicitud' => $id));
        $solicitud = $em->getRepository("SolicitudesCitasBundle:DataSolicitudes")->findOneBy(array('id' => $id));
        
        if($entity)
        {
            if($aprobado) {
                $entity->setAsesorLegal($user);
                $entity->setRevisionAsesor(1);
                $entity->setFechaRevisionAsesor(new \Datetime());
                $entity->setNumProvidencia($request->get('numero-prov'));
                $entity->setFechaProvidencia($this->strtoDate($request->get('fecha-prov')));
                $entity->setFechaInicio($this->strtoDate($request->get('fecha-inicio')));
                $entity->setFechaFin($this->strtoDate($request->get('fecha-fin')));
                $em->persist($entity);
                $em->flush();       
                
                $licencia = $solicitud->getClasLicencia();
                $num = intval($licencia->getCodActual()) + 1;
                $solicitud->setNumLicenciaAdscrita($licencia->getCodLicencia().str_pad($num, 4, "0", STR_PAD_LEFT));
                $solicitud->setStatus('Aprobada');
                $solicitud->setFechaAprobada(new \Datetime());
                $licencia->setCodActual($num);                
                $dataOperadora = $solicitud->getDataOperadora();
                if($dataOperadora) {
                    $dataOperadora->setHasSolicitud(1);
                    $em->persist($dataOperadora);
                }                
                $em->persist($solicitud);
                $em->persist($licencia);
                $em->flush();
                
                //Crear pago por otorgamiento
                $otorgamiento = new \Sunahip\PagosBundle\Entity\Pagos();
                $operadora = $solicitud->getOperadora();
                if($operadora) {
                    $otorgamiento->setOperadora($operadora);
                } else {
                    $otorgamiento->setCentroHipico($solicitud->getCentroHipico());
                }
                $otorgamiento->setFechaCreacion(new \DateTime());
                $ut = intval($this->container->getParameter('unidad_tributaria'));
                $monto = $licencia->getOtorgamientoUt() * $ut;
                $otorgamiento->setMonto($monto);
                $otorgamiento->setStatus("CREADA");
                $otorgamiento->setTipoPago(\Sunahip\CommonBundle\DBAL\Types\PaymentType::OTORGAMIENTO);
                $otorgamiento->setUsuarioCreacion($user);
                $otorgamiento->setSolicitud($solicitud);
                $em->persist($otorgamiento);
                $em->flush();

                try {                    
                    $title = "Notificación SUNAHIP: Solicitud de Licencia aprobada.";
                    $params['nombre']= $solicitud->getUsuario()->getFullname();
                    $params['message']= "Su solicitud de licencia No. <b>".$solicitud->getCodsolicitud()."</b>, ha sido aprobada con la licencia No. <b>".$solicitud->getNumLicenciaAdscrita()."</b><br><br>";
                    $params['message'].= "  Por favor recuerde realizar el pago por otorgamiento por la cantidad de Número de Unidades Tributarias: ".$licencia->getOtorgamientoUt()." U.T., 
                                            antes de retirar el documento, a través de depósito en la(s) siguiente(s) cuenta(s) bancaria(s):<br><br>";
                    
                    $bancos = $em->getRepository("PagosBundle:Banco")->findBy(array('activo'=>1));
                    foreach ($bancos as $banco) {
                         $params['message'] .= "<span style='font-style:italic;'>Banco ".$banco->getBanco()." ";
                         $params['message'] .= "Cuenta Corriente ".$banco->getNumeroCuenta()."<br>";
                         $params['message'] .= "SUNAHIP G-12345678-9</span><br>";
                    }
                    
                    $params['message'] .= "<br>Podrá retirar el documento y consignar el comprobante de pago, en la siguiente dirección: Oficina Principal: Hipódromo La Rinconada, 
                                            sede central del Instituto Nacional Hipódromo - INH, Piso 5, Parroquia Coche, Municipio Libertador, Caracas, Distrito Capital.";                    
                    
                    $this->sendNotificationMail($title, $params, $solicitud->getUsuario()->getEmail());
                } catch (Exception $e) {                    
                }
                
            } else {
                $entity->setAsesorLegal($user);
                $entity->setRevisionAsesor(1);
                $entity->setFechaRevisionAsesor(new \Datetime());
                $em->persist($entity);                
                $solicitud->setStatus('Rechazada');
                $solicitud->setFechaRechazada(new \Datetime());
                $em->persist($solicitud);
                $em->flush();
                
                try {
                    $title = "Notificación SUNAHIP: Solicitud de Licencia Rechazada";
                    $params['nombre']= $solicitud->getUsuario()->getFullname();
                    $params['message']= "Su solicitud de licencia No. <b>".$solicitud->getCodsolicitud()."</b>, ha sido rechazada.";
                    $this->sendNotificationMail($title, $params, $solicitud->getUsuario()->getEmail());
                } catch (Exception $e) {                    
                }
            }
            
            $response['status'] = 'true';
        }else {
            $response['status'] = 'false';
            $response['mensaje'] = "Hubo un error al procesar.";
        }
        return new JsonResponse($response);
    }

    /**
     * @Route("/licencias/listado/aprobadas", name="solicitudes_aprobadas_listado")
     * @Template("SolicitudesCitasBundle:AdminLicencias:listado.html.twig")
     * @Security("has_role('ROLE_GERENTE') or has_role('ROLE_SUPERINTENDENTE') or has_role('ROLE_COORDINADOR') or has_role('ROLE_FISCAL') or has_role('ROLE_ASESOR')")
     */
    public function listAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $response = array();
        //$user = $this->getUser();
        //$securityContext = $this->container->get('security.context');
        $ajax = $request->get('ajax');

        if (!$ajax) {
            $response['ajax'] = false;
        }else{
            $response['ajax'] = $ajax;
        }

        $entities = $em->getRepository("SolicitudesCitasBundle:DataSolicitudes")->findBy( array("status" => "Aprobada") );
        $arrayEntity = array();
        $cont = 0;
        foreach($entities as $entity)
        {
            $solicitudApr = $em->getRepository("SolicitudesCitasBundle:DataSolicitudesAprob")->findOneBy(array('solicitud' => $entity->getId() ) );
            if($solicitudApr)
            {
                $arrayEntity[$cont][] = $solicitudApr;
                $cont++;
            }

        }

        if($entities)
        {
            $response['status'] = true;
            $response['status'] = true;
            $response['aprob'] = true;
            $paginator = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $arrayEntity,
                $this->get('request')->query->get('page', 1) /*page number*/,
                10
            );
            $response['entities'] = $pagination;
        }else{
            $response['status'] = false;
        }

        return $response;
    }
    
    private function strtoDate($date){
        if (is_object($date) or is_null($date)) {return $date;}
        $dateE=str_replace("/","-",$date);
        return new \DateTime($dateE);
    }

    /**
     * @Route("/licencias/aprobada/imprimir/{id}", name="solicitudes_aprobadas_imprimir")
     * @Security("has_role('ROLE_GERENTE')")
     */
    public function printAction(Request $request, $id = null) {
        $em = $this->getDoctrine()->getManager();
        $response = array();
        $entity = $em->getRepository('SolicitudesCitasBundle:DataSolicitudesAprob')->findOneBy(array('id' => $id));

        $response['num_licencia'] = $entity->getSolicitud()->getClasLicencia()->getCodLicencia();
        $response['tipo_licencia'] = $entity->getSolicitud()->getClasLicencia()->getAdmTiposLicencias(). " " . $entity->getSolicitud()->getClasLicencia();
        $response['cod_licencia'] = $entity->getSolicitud()->getNumLicenciaAdscrita();
        $response['establecimiento'] = ($entity->getSolicitud()->getOperadora()) ?
            $entity->getSolicitud()->getOperadora()->getDenominacionComercial() :
            $entity->getSolicitud()->getCentroHipico()->getDenominacionComercial();
        $response['rif'] = ($entity->getSolicitud()->getOperadora()) ?
            $entity->getSolicitud()->getOperadora()->getPersJuridica().'-'.$entity->getSolicitud()->getOperadora()->getRif():
            $entity->getSolicitud()->getCentroHipico()->getPersJuridica().'-'.$entity->getSolicitud()->getCentroHipico()->getRif();
        $response['num_providencia'] = $entity->getNumProvidencia();
        $response['fecha_providencia'] = $entity->getFechaProvidencia();
        $response['desde'] = $entity->getFechaInicio();
        $response['hasta'] = $entity->getFechaFin();
        $response['estado'] = ($entity->getSolicitud()->getOperadora()) ?
            $entity->getSolicitud()->getOperadora()->getEstado()->getNombre():
            $entity->getSolicitud()->getCentroHipico()->getEstado()->getNombre();
        $response['ciudad'] = ($entity->getSolicitud()->getOperadora()) ?
            $entity->getSolicitud()->getOperadora()->getCiudad():
            $entity->getSolicitud()->getCentroHipico()->getCiudad();
        $response['municipio'] = ($entity->getSolicitud()->getOperadora()) ?
            $entity->getSolicitud()->getOperadora()->getMunicipio()->getNombre():
            $entity->getSolicitud()->getCentroHipico()->getMunicipio()->getNombre();
        $response['parroquia'] = ($entity->getSolicitud()->getOperadora()) ?
            $entity->getSolicitud()->getOperadora()->getParroquia()->getNombre():
            $entity->getSolicitud()->getCentroHipico()->getParroquia()->getNombre();
        $response['sector'] = ($entity->getSolicitud()->getOperadora()) ?
            $entity->getSolicitud()->getOperadora()->getUrbanSector():
            $entity->getSolicitud()->getCentroHipico()->getUrbanSector();
        $response['calle'] = ($entity->getSolicitud()->getOperadora()) ?
            $entity->getSolicitud()->getOperadora()->getAvCalleCarrera():
            $entity->getSolicitud()->getCentroHipico()->getAvCalleCarrera();
        $response['casa'] = ($entity->getSolicitud()->getOperadora()) ?
            $entity->getSolicitud()->getOperadora()->getEdifCasa():
            $entity->getSolicitud()->getCentroHipico()->getEdifCasa();
        $response['afiliado'] = ($entity->getSolicitud()->getCentroHipico()) ?
                (($entity->getSolicitud()->getDataOperadora())? $entity->getSolicitud()->getDataOperadora()->getOperadora()->getDenominacionComercial():""):
                "";
        $response['rif_afiliado'] = ($entity->getSolicitud()->getCentroHipico()) ?
                (($entity->getSolicitud()->getDataOperadora())? $entity->getSolicitud()->getDataOperadora()->getOperadora()->getFullrif():""):
                "";

        $response['data_qr'] = "Establecimiento: ".$response['establecimiento']."  |"
                                ."Rif: ".$response['rif']." "
                                ."Direccion: ".$response['estado'].", ".$response['municipio'].", ".$response['parroquia'].", ".$response['ciudad'].", "
                                .$response['sector'].", ".$response['calle']." ".$response['casa']."  |"
                                ."Codigo de la licencia : ".$response['cod_licencia']."  |"
                                ."Tipo y clasificacion de la licencia: ".$response['tipo_licencia']." - ".$response['num_licencia'];

        
        $html = $this->renderView('SolicitudesCitasBundle:AdminLicencias:pdf/licencia.html.twig', $response);
	//return $this->render('SolicitudesCitasBundle:AdminLicencias:pdf/licencia.html.twig', $response); 
        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html, 
                array(  'orientation' => 'landscape',
                        'page-height' => 279,
                        'page-width' => 219,
                        'encoding' => 'utf-8',
                        'cookie' => array(),
            )),
            200, array('Content-Type' => 'application/pdf')
        );
        /*$mpdfService = $this->get('tfox.mpdfport');
        $mPDF = $mpdfService->getMpdf();
        $mPDF->AddPage('L', // L - landscape, P - portrait
            '', '', '', '',
            0, // margin_left
            0, // margin right
            0, // margin top
            0, // margin bottom
            0, // margin header
            0); // margin footer
        $mPDF->WriteHTML($html,0);
        
        return $mPDF->Output();        
        //return $mpdfService->generatePdfResponse($html, $arguments);*/
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
