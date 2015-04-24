<?php
/**
 * Controler:   Notificaciones de Usuarios
 *
 * @package     Sunahip
 * @subpackage  User
 * @author      Nestor Sanchez <nestor86sanchez@gmail.com>
 * Greicodex <info@greicodex.com>
 */

namespace Sunahip\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class NotificationController extends Controller
{

    /**
     * Post datatable.
     *
     * @Route("/notificaciones/", name="notification")
     * @Method("GET")
     * @Template()
     *
     * @return array
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $response = array();
        $securityContext = $this->container->get('security.context');
        $total = $this->getCount();

        if ($securityContext->isGranted('ROLE_FISCAL'))
        {
            $response['notification'][]= "Tiene para la fecha ". $total . " citas asignadas";
        }else if($securityContext->isGranted('ROLE_GERENTE'))
        {
            $entities = $em->getRepository("SolicitudesCitasBundle:DataSolicitudes")->findBy(array('status' => 'Revisada'));
            $entitiesRequest = $em->getRepository("CentrohipicoBundle:DataOperadoraEstablecimiento")->findBy( array('status'=>'Por Aprobar') );
            $entitiesRequest1 = $em->getRepository("CentrohipicoBundle:DataOperadoraEstablecimiento")->findBy( array('status'=>'Por Desafiliar') );
            $response['notification'][]= "Tiene para la fecha ". count($entities) . " solicitudes de licencia para revisar";            
            $response['notification'][]= "Tiene para la fecha ". (count($entitiesRequest) +  count($entitiesRequest1)) . " solicitudes de afiliación/desafiliación para aprobar";            
        }else if($securityContext->isGranted('ROLE_ASESOR'))
        {
            $response['notification'][]= "Tiene para la fecha ". $total . " solicitudes de licencia para aprobar";
        }else if($securityContext->isGranted('ROLE_OPERADOR'))
        {
            $entitiesRequest = $em->getRepository("CentrohipicoBundle:DataOperadoraEstablecimiento")->findBy( array('status'=>'Por Aprobar', 'usuario' => $user->getId()) );
            $entities = $em->getRepository('SolicitudesCitasBundle:DataSolicitudes')->findBy(array(
                    'usuario'=>$user->getId(),
                    'tipoSolicitud'=>'operadora',
                    'status'=>'Solicitada'
            ));
            $response['notification'][]= "Tiene para la fecha ". count($entitiesRequest) . " solicitudes de afiliación";
            $response['notification'][]= "Tiene para la fecha ". count($entities) . " solicitudes de licencia";
        }else if($securityContext->isGranted('ROLE_CENTRO_HIPICO') )
        {
            $response['notification'][]= "Tiene para la fecha ". $total . " solicitudes de licencia";
        }


        //$entitiesRequest = $em->getRepository("CentrohipicoBundle:DataOperadoraEstablecimiento")->findByAction( $user->getId(),null );

        if($total == 0)
            $response['notification'][] = "No tiene nuevas notificaciones";


        return $response;
    }


    /**
     * Post datatable.
     *
     * @Route("/usuarios/contador_notificaciones/", name="notification_count")
     * @Method("GET")
     * @Template()
     * @return array
     */
    public function countAction()
    {
        $total = $this->getCount();
        return new JsonResponse($total);
    }

    protected function getCount()
    {
        $em = $this->getDoctrine()->getManager();
        $response = array();
        $user = $this->getUser();
        $securityContext = $this->container->get('security.context');

        if ($securityContext->isGranted('ROLE_FISCAL'))
        {
            $entities = $em->getRepository("SolicitudesCitasBundle:DataSolicitudes")->findCitas('Solicitada');
            if($entities)
                $response['notification']= count($entities);

        }else if($securityContext->isGranted('ROLE_GERENTE'))
        {
            $entities = $em->getRepository("SolicitudesCitasBundle:DataSolicitudes")->findBy(array('status' => 'Revisada'));
            $entitiesRequest = $em->getRepository("CentrohipicoBundle:DataOperadoraEstablecimiento")->findBy( array('status'=>'Por Aprobar') );
            $entitiesRequest1 = $em->getRepository("CentrohipicoBundle:DataOperadoraEstablecimiento")->findBy( array('status'=>'Por Desafiliar') );
            if($entities || $entitiesRequest)
                $response['notification']= count($entities) + count($entitiesRequest) + count($entitiesRequest1);

        }else if($securityContext->isGranted('ROLE_ASESOR'))
        {
            $entities = $em->getRepository("SolicitudesCitasBundle:DataSolicitudes")->findBy(array('status' => 'Verificada'));
            if($entities)
                $response['notification']= count($entities);

        }else if($securityContext->isGranted('ROLE_OPERADOR'))
        {
            $entitiesRequest = $em->getRepository("CentrohipicoBundle:DataOperadoraEstablecimiento")->findBy( array('status'=>'Por Aprobar', 'usuario' => $user->getId()) );
            $entitiesRequest1 = $em->getRepository("CentrohipicoBundle:DataOperadoraEstablecimiento")->findBy( array('status'=>'Por Desafiliar', 'usuario' => $user->getId()) );
            $entities = $em->getRepository('SolicitudesCitasBundle:DataSolicitudes')->findBy(array(
                    'usuario'=>$user->getId(),
                    'tipoSolicitud'=>'operadora',
                    'status'=>'Solicitada'
                ));
            if($entities or $entitiesRequest)
                $response['notification']= count($entities) + count($entitiesRequest) + count($entitiesRequest1);

        }else if($securityContext->isGranted('ROLE_CENTRO_HIPICO') )
        {
            $entities = $em->getRepository('SolicitudesCitasBundle:DataSolicitudes')->findBy(array(
                    'usuario'=>$user->getId(),
                    'tipoSolicitud'=>'centrohipico',
                    'status'=>'Solicitada'
                ));
            if($entities)
                $response['notification']= count($entities);
        }

        if(!isset($response['notification']))
            $response['notification'] = 0;


        return $response['notification'];
    }

    public function sendNotificationMail($title, $params=array(), $to, $file="") {
        
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
