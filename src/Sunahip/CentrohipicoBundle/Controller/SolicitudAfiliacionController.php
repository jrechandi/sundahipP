<?php
/**
 * Controlador Solicitud de afiliacion a centro hipico
 *
 * Class SolicitudAfiliacionController
 * @author Nestor Sanchez <nestor86sanchez@gmail.com>
 * @author Greicodex <info@greicodex.com> 
 * Solicitud de afiliación y desafiliación
 */
namespace Sunahip\CentrohipicoBundle\Controller;

use Sunahip\CentrohipicoBundle\Entity\DataOperadoraEstablecimiento;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sunahip\CentrohipicoBundle\Form\SolicitudEstablecimientoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class SolicitudAfiliacionController extends Controller
{

    /*
     * @Security("has_role('ROLE_OPERADOR')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $valid = $em->getRepository("CentrohipicoBundle:DataOperadora")->findOneBy(array("usuario" => $user->getId()));

        if($valid)
        {
            $entitiesS = $em->getRepository('SolicitudesCitasBundle:DataSolicitudes')->findBy(array('operadora' => $valid->getId(), 'status' => 'Aprobada'));
            if(count($entitiesS)==0)
                $message = "No puede afiliar hasta que tenga una licencia aprobada‏";
            else
                $message = null;
            
            return $this->render('CentrohipicoBundle:SolicitudAfiliacion:paso1.html.twig', array('message' => $message));
        }
        else{
            $message = "Para afiliarse primero debe crear su oficina principal";
            return $this->render('CentrohipicoBundle:SolicitudAfiliacion:paso1.html.twig', array('message' => $message));
        }

    }

    /*
     * @Security("has_role('ROLE_OPERADOR')")
     */
    public function doneAction($rif_type, $rif_number, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $response = array();

        $user = $this->getUser();
        $operadora = $em->getRepository("CentrohipicoBundle:DataOperadora")->findOneBy(array("usuario" => $user->getId()));        
        $entity = $em->getRepository("CentrohipicoBundle:DataCentrohipico")->findOneBy(array("persJuridica"=> $rif_type,"rif"=> $rif_number,"id"=>$id));        
        
        if($entity && $operadora) {
            $entitiesS = $em->getRepository('SolicitudesCitasBundle:DataSolicitudes')->findBy(array('operadora' => $operadora->getId(), 'status' => 'Aprobada'));
        
            $formLicencias = array();
            $cont = 0;
            foreach($entitiesS as $item)
            {
                    $formLicencias[$cont]['id'] = $item->getClasLicencia()->getId();
                    $formLicencias[$cont]['clasif_licencia'] = $item->getClasLicencia()->getClasfLicencia();
                    $cont++;
            }

            $entityOE = new DataOperadoraEstablecimiento();
            $form = $this->createForm(
                new SolicitudEstablecimientoType(),
                $entityOE,
                array('action' => $this->generateUrl('Centrohipico_solicitud_afiliacion_guardar'))
            );
            $response['form'] = $form->createView();
            $response['formLicencias'] = $formLicencias;
            $response['status'] = true;
            $response['entity'] = $entity;
            $response['operadora'] = $operadora->getId();
        } else {
            $response['status'] = false;
            $response['entity'] = null;
            $response['message'] = "No existe el Centro Hípico";
        }          
        return $this->render('CentrohipicoBundle:SolicitudAfiliacion:paso2.html.twig', $response);
    }

    /*
     * @Security("has_role('ROLE_OPERADOR')")
     */
    public function saveAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = new DataOperadoraEstablecimiento();
        $form = $this->createForm(new SolicitudEstablecimientoType(), $entity);
        $form->handleRequest($request);
        $user = $this->getUser();

        $data = $request->get('sunahip_centrohipicobundle_data_operadora_establecimiento');        
        $operadora = $em->getRepository("CentrohipicoBundle:DataOperadora")->findOneBy(array("id" => $data['id_operadora']));
        try {
            $em->persist($entity);
            $entity->setStatus("Por Aprobar");
            $entity->setOperadora($operadora);
            $entytyCH = $em->getRepository('CentrohipicoBundle:DataCentrohipico')->findOneBy(array('id' => $data['id']));
            $clasLicencia = $em->getRepository('LicenciaBundle:AdmClasfLicencias')->find($data['id_s']); 
            $entity->setCentroHipico($entytyCH);
            $entity->setClasLicencia($clasLicencia);
            $entity->setUsuario($user);
            $entity->setFechaSolicitud(new \DateTime());
            $entity->setFechaActualizacion(new \DateTime());
            $em->persist($entity);
            $em->flush();

            $flashMessage = "Se ha creado la solicitud";
            $this->get('session')->getFlashBag()->add('message', $flashMessage);

            return $this->redirect($this->generateUrl('Centrohipico_solicitud_afiliacion_listado'));
        } catch (Exception $e) {
            $errors = $this->getFormErrors($form);
        }

        return new JsonResponse(array('status' => true, 'errors' => $errors));
    }

    /*
     * @Security("has_role('ROLE_OPERADOR') or has_role('ROLE_GERENTE') or has_role('ROLE_SUPERINTENDENTE') or has_role('ROLE_COORDINADOR') or has_role('ROLE_FISCAL')")
     */

    public function findByRifAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $response = array();
        $rifType = $request->get('rif_type');
        $rifNumber = $request->get('rif_number');
        $nombre = $request->get('nombre');
        
        $entity = $em->getRepository("CentrohipicoBundle:DataCentrohipico")->findByAction($rifType,$rifNumber,$nombre);

        if(count($entity)>0)
        {
            $response['status'] = true;
            $response['id']=$entity[0]->getId();
            $response['message'] = "";
        }
        else
        {
            $response['status'] = false;
            $response['message'] = "No existe el Centro Hípico: ".$rifType."-".$rifNumber." ".$nombre;
        }
        return new JsonResponse($response);
    }

    /*
     * @Security("has_role('ROLE_OPERADOR') or has_role('ROLE_GERENTE') or has_role('ROLE_SUPERINTENDENTE') or has_role('ROLE_COORDINADOR') or has_role('ROLE_FISCAL')")
     */
    public function listAction(Request $request)
    {
        $ajax = $request->get('ajax');

        if (!$ajax) {
            $ajax = false;
        }
        
        $em = $this->getDoctrine()->getManager();
        $response = array();
        $user = $this->getUser();
        $securityContext = $this->container->get('security.context');

        if ($securityContext->isGranted('ROLE_GERENTE'))
        {
            $entities = $em->getRepository("CentrohipicoBundle:DataOperadoraEstablecimiento")->findByAction(null, $request->get('keyword'), $request->get('estatus'));
        }
        else
        {
            $entities = $em->getRepository("CentrohipicoBundle:DataOperadoraEstablecimiento")->findByAction($user->getId(), $request->get('keyword'), $request->get('estatus'));
        }

        if(!$entities)
        {
            $response['status'] = false;
            $response['entities'] = null;
        }else
        {
            $response['status'] = true;
            $paginator = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $entities,
                $this->get('request')->query->get('page', 1) /*page number*/,
                10
            );
            $response['entities'] = $pagination;
        }

        $response['ajax'] = $ajax;
        return $this->render('CentrohipicoBundle:SolicitudAfiliacion:listado.html.twig', $response);
    }

    /*
     * @Security("has_role('ROLE_GERENTE')")
     */
    public function rejectedAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $request->get('id');
        $nota = $request->get('nota');

        $entity = $em->getRepository("CentrohipicoBundle:DataOperadoraEstablecimiento")->findOneBy(array('id'=>$id));

        $entity->setFechaCancelacion(new \DateTime());
        $entity->setNotas($nota);
        $entity->setStatus("Rechazado");
        $entity->setGerente($this->getUser());
        $em->persist($entity);
        $em->flush();

        return new JsonResponse(array('status' => true));
    }
    
    /*
     * @Security("has_role('ROLE_GERENTE')")
     */
    public function approveAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $ids = $request->get('ids');

        foreach($ids as $id)
        {
            $entity = $em->getRepository("CentrohipicoBundle:DataOperadoraEstablecimiento")->findOneBy(array('id'=>$id));
            $entity->setFechaAprobacion(new \DateTime());
            $entity->setStatus("Aprobado");
            $entity->setGerente($this->getUser());
            $em->persist($entity);
            $em->flush();
        }
        return new JsonResponse(array('status' => true));
    }

    /*
     * @Security("has_role('ROLE_OPERADOR') or has_role('ROLE_GERENTE') or has_role('ROLE_SUPERINTENDENTE') or has_role('ROLE_COORDINADOR') or has_role('ROLE_FISCAL')")
     */
    public function detailsAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $entity = $em->getRepository("CentrohipicoBundle:DataOperadoraEstablecimiento")->findOneBy(array('id'=>$id));

        if(!$entity)
        {
            $response['status'] = false;
            $response['message'] = "No existe la solicitud";
            $response['entity'] = null;
        }else
        {
            $response['status'] = true;
            $response['entity'] = $entity;
        }

        return $this->render('CentrohipicoBundle:SolicitudAfiliacion:detalles.html.twig', $response);
    }
    
    /*
     * @Security("has_role('ROLE_OPERADOR') or has_role('ROLE_GERENTE') or has_role('ROLE_SUPERINTENDENTE') or has_role('ROLE_COORDINADOR') or has_role('ROLE_FISCAL')")
     */
    public function desafiliacionAction($id) 
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository("CentrohipicoBundle:DataOperadoraEstablecimiento")->findOneBy(array('id'=>$id));        
        if($entity) {
            $securityContext = $this->container->get('security.context');
            if ($securityContext->isGranted('ROLE_OPERADOR')) {
                $user = $this->getUser();
                if($entity->getUsuario()->getId()!=$user->getId()) {
                    $response['status'] = 'false';
                    $response['mensaje'] = "La desafiliación no puede ser solicitada por otro usario que no sea el que la solicito.";
                } else {
                    $entity->setStatus("Por Desafiliar");
                    $entity->setFechaActualizacion(new \DateTime());
                    $em->persist($entity);
                    $em->flush();
                    $response['status'] = 'true';
                }
            }
            if ($securityContext->isGranted('ROLE_GERENTE')) {
                if($entity->getStatus() == "Por Desafiliar") {
                    $entity->setStatus("Desafiliado");
                    $entity->setGerenteDesafiliacion($this->getUser());
                    $em->persist($entity);
                    $em->flush();
                    $response['status'] = 'true';
                } else {
                    $response['status'] = 'false';
                    $response['mensaje'] = "La solicitud no está aprobada.";
                }
            }
        } else {
            $response['status'] = 'false';
            $response['mensaje'] = "No existe la solicitud.";
        }
        return new JsonResponse($response);
    }
    
    /*
     * @Security("has_role('ROLE_GERENTE')")
     */
    public function isValidAction($centroHipico, $operadora, $clasificacion)
    {
        $em = $this->getDoctrine()->getManager();
        $ope = $em->getRepository("CentrohipicoBundle:DataOperadora")->findOneBy(array("id"=>$operadora));        
        $centro = $em->getRepository("CentrohipicoBundle:DataCentrohipico")->findOneBy(array("id"=>$centroHipico));
        $licencia = $em->getRepository("LicenciaBundle:AdmClasfLicencias")->findOneBy(array("id"=>$clasificacion));
        $response['status'] = false;
        if($ope && $centro && $licencia) {
            $solicitud = $em->getRepository("CentrohipicoBundle:DataOperadoraEstablecimiento")->findSolicitudAfiliacion($centro, $ope, $licencia);
            if(count($solicitud)>0) {
                $response['message'] = "No se puede afiliar el Centro Hípico porque tiene una solicitud con estatus: ".$solicitud[0]['status']."<br>";
                $response['message'] .= "Centro Hípico: ".$centro->getIdentificador()."<br>Operadora: ".$ope->getIdentificador()."<br>Licencia: ".$licencia->getClasfLicencia();
            } else {
                $response['status'] = true;
            }
        } else {
            $response['message'] = "Datos incorrectos.";
        }        
        return new JsonResponse($response);
    }

}
