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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/admin")
 */
class AdminCitasController extends Controller
{

    /**
     * @Route("/licencias/{tipo}-listado", name="fiscal_citas_listado")
     * @Template("SolicitudesCitasBundle:AdminCitas:listado.html.twig")
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or has_role('ROLE_GERENTE') or has_role('ROLE_SUPERINTENDENTE') or has_role('ROLE_COORDINADOR') or has_role('ROLE_FISCAL') or has_role('ROLE_ASESOR')")
     */
    public function listAction(Request $request, $tipo) {    
        $securityContext = $this->container->get('security.context');
        
        if($securityContext->isGranted('ROLE_FISCAL')) {
            if($tipo != 'Solicitada' && $tipo != 'Rechazada') throw $this->createNotFoundException('El estatus es incorrecto.');
        }elseif($securityContext->isGranted('ROLE_GERENTE')) {
            if($tipo != 'Revisada' && $tipo != 'Aprobada' && $tipo != 'Rechazada') throw $this->createNotFoundException('El estatus es incorrecto.');
        }elseif($securityContext->isGranted('ROLE_ASESOR')) {
            if($tipo != 'Verificada' && $tipo != 'Rechazada') throw $this->createNotFoundException('El estatus es incorrecto.');
        }
        
        $em = $this->getDoctrine()->getManager();
        $response = array();
        $response['tipo']=$tipo;
        $ajax = $request->get('ajax');

        if (!$ajax) {
            $response['ajax'] = false;
        }else
            $response['ajax'] = $ajax;
        
        if($securityContext->isGranted('ROLE_FISCAL')) {
            $entities = $em->getRepository("SolicitudesCitasBundle:DataSolicitudes")->findCitas($tipo); //En procucción debe estar esta línea
            //$entities = $em->getRepository("SolicitudesCitasBundle:DataSolicitudes")->findBy(array('status' => $tipo)); //Para las pruebas debe estar esta línea
        } else {
            $entities = $em->getRepository("SolicitudesCitasBundle:DataSolicitudes")->findBy(array('status' => $tipo));
        }

        if(!empty($entities))
        {
            $response['status'] = true;
            $response['status'] = true;
            $response['aprob'] = false;
            $paginator = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $entities,
                $this->get('request')->query->get('page', 1) /*page number*/,
                10
            );
            $response['entities'] = $pagination;
        }else{
            $response['status'] = false;
        }

        return $response;
    }

    /**
     * @Route("/citas_asignadas/info/{id}", name="fiscal_citas_modal_info")
     * @Template("SolicitudesCitasBundle:AdminCitas:modal.html.twig")
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or has_role('ROLE_GERENTE') or has_role('ROLE_SUPERINTENDENTE') or has_role('ROLE_COORDINADOR') or has_role('ROLE_FISCAL') or has_role('ROLE_ASESOR')")
     */
    public function getModalInfoAction(Request $request, $id = null) {
        $em = $this->getDoctrine()->getManager();
        $response = array();
        $entity = $em->getRepository("SolicitudesCitasBundle:DataSolicitudes")->findOneBy(array('id' => $id));

        if($entity)
        {
            $response['status'] = true;
            $response['entity'] = $entity;
            $response['documents'] = $em->getRepository("SolicitudesCitasBundle:DataRecaudosCargados")->findBy( array("solicitud" => $entity->getId()));
            $response['pago'] = $entity->getPago();
        }else
            $response['status'] = false;

        return $response;
    }


    /**
     * @Route("/citas_asignadas/reacudos_status/{id}", name="fiscal_citas_guardar_status")
     * @Security("has_role('ROLE_FISCAL')")
     */
    public function setStatusDocumentAction(Request $request, $id = null) {
        $em = $this->getDoctrine()->getManager();
        $response = array();
        $user = $this->getUser();
        $securityContext = $this->container->get('security.context');
        
        $solicitud = $em->getRepository("SolicitudesCitasBundle:DataSolicitudes")->findOneBy(array('id' => $id));
        $statusRecaudos = $request->get('status_recaudos');
        $totalDocument = intval($request->get('total_document'));
        
        if($solicitud) {
            
            for($i=0;$i<$totalDocument;$i++) {
                $option = $request->get("option-".$i);
                $option = explode("*", $option);

                $recaudo =  $em->getRepository("SolicitudesCitasBundle:DataRecaudosCargados")->findOneBy(array('id' => $option[1]));
                if($recaudo) {
                    $recaudoAprob = $em->getRepository("SolicitudesCitasBundle:DataRecaudosAprob")->findOneBy(array('recaudo' => $recaudo->getId()));
                    if(!$recaudoAprob)
                        $recaudoAprob = new DataRecaudosAprob();
                    $recaudoAprob->setFechaAprobFiscal(new \Datetime());
                    $recaudoAprob->setFiscal($user);
                    $recaudoAprob->setRecaudo($recaudo);
                    $recaudoAprob->setApobacionFiscal($option[0]);
                    $em->persist($recaudoAprob);
                    $em->flush();

                    $recaudo->setStatus($option[0] == 1 ? 'Aprobado' : 'Rechazado');
                    $em->persist($recaudo);
                    $em->flush();
                }
            }
            //Pago
            $option = $request->get('pago');
            $option = explode("*", $option);
            $pago = $em->getRepository("PagosBundle:Pagos")->find($option[1]);
            if($pago) {
                $pago->setFechaProceso( new \Datetime());
                if($option[0] == 0) {
                    $pago->setStatus("Rechazado");
                }
                $em->persist($pago);
                $em->flush();
            }            

            $solicitudAprob = $em->getRepository("SolicitudesCitasBundle:DataSolicitudesAprob")->findOneBy(array('solicitud' => $id));

            if(!$solicitudAprob) {
                $solicitudAprob = new DataSolicitudesAprob();                
            }   
            $solicitudAprob->setSolicitud($solicitud); 
            $solicitudAprob->setRevisionFiscal(1);
            $solicitudAprob->setFiscal($user);
            $solicitudAprob->setFechaRevisionFiscal(new \DateTime());
            $em->persist($solicitudAprob);
            $em->flush();

            if($statusRecaudos == 'Recaudos completos') {
                $solicitud->setStatus('Revisada');
                $em->persist($solicitud);
                $em->flush();
            } else {
                $solicitud->setStatus('Rechazada');
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

        } else {
            $response['status'] = false;
        }
        return new JsonResponse($response);
    }

    /**
     * @Route("/licencias/consulta/", name="gerente_consulta_licencia")
     * @Template("SolicitudesCitasBundle:AdminLicencias:consulta.html.twig")
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or has_role('ROLE_GERENTE') or has_role('ROLE_SUPERINTENDENTE') or has_role('ROLE_COORDINADOR') or has_role('ROLE_FISCAL') or has_role('ROLE_ASESOR')")
     */
    public function searchAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $response = array();

        $entity = $em->getRepository("CommonBundle:SysEstado")->findAll();
        if($entity)
            $response['states'] = $entity;

        $entity = $em->getRepository("CommonBundle:SysMunicipio")->findAll();
        if($entity)
            $response['towns'] = $entity;

        $entity = $em->getRepository("LicenciaBundle:AdmClasfLicencias")->findAll();
        if($entity)
            $response['claf_licenses'] = $entity;

        $entity = $em->getRepository("LicenciaBundle:AdmTiposLicencias")->findAll();
        if($entity)
            $response['licenses'] = $entity;

        if ($request->getMethod() == 'POST') {
            $data = $request->get('data');
            $result = $em->getRepository("SolicitudesCitasBundle:DataSolicitudes")->findLicenses($data);

            $paginator = $this->get('knp_paginator');
            $response['result'] = $paginator->paginate(
                $result,
                $this->get('request')->query->get('page', 1) /*page number*/,
                20
            );

            $response['data'] = $data;
        }

        return $response;
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
