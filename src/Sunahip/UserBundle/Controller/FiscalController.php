<?php
/**
 * Controler:   Administracion de Usuarios con rol fiscal
 *
 * @package     Sunahip
 * @subpackage  User
 * @author      Nestor Sanchez <nestor86sanchez@gmail.com>
 */

namespace Sunahip\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sunahip\UserBundle\Entity\SysUsuario;

/**
 * @Route("/fiscal")
 */
class FiscalController extends Controller
{

    /**
     * @Route("/listado", name="fiscal_list")
     * @Template()
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $response = array();
        $entities = $em->getRepository('UserBundle:SysUsuario')->findByRole('ROLE_FISCAL');

        if($entities)
        {
            $response['status'] = true;
            $paginator = $this->get('knp_paginator');
            $response['entities'] = $paginator->paginate(
                $entities,
                $this->get('request')->query->get('page', 1) /*page number*/,
                10
            );
        }else{
            $response['status'] = false;
        }

        return $response;
    }


    /**
     * @Route("/cambiar-estado/{user_id}/{status_id}", name="fiscal-change-status")
     * @Method("GET")
     */
    public function cambiarEstadoAction(Request $request)
    {
        $status = $request->get('status_id');

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('UserBundle:SysUsuario')->findOneBy(array('id' => $request->get('user_id')));

        if (!$entity) {
            $this->get('session')->getFlashBag()->add('message', "El fiscal no existe");
        }

        switch ($status) {
            case 0:
                $entity->setEnabled(false);
                $this->get('session')->getFlashBag()->add('message', "El fiscal ha sido desactivado satisfactoriamente");
                break;
            case 1:
                $entity->setEnabled(true);
                $this->get('session')->getFlashBag()->add('message', "El fiscal ha sido activado satisfactoriamente");
                break;
        }

        $em->flush();
        return $this->redirect($this->generateUrl('fiscal_list'));
    }

    /**
     * @Route("/listado/gestiones/", name="fiscal_list_requests")
     * @Template()
     */
    public function listWithRequestsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $response = array();
        $entities = $em->getRepository('UserBundle:SysUsuario')->findByRole('ROLE_FISCAL');

        if($entities)
        {
            $arrayData = array();
            $cont = 0;
            foreach($entities as $item)
            {
                $requestsList1 = $em->getRepository('SolicitudesCitasBundle:DataSolicitudesAprob')->findBy(array('fiscal' => $item->getId() ));
                if($requestsList1)
                {
                    $arrayData[$cont]['gestiones'] = count($requestsList1);
                }

                $requestsList2 = $em->getRepository('FiscalizacionBundle:Fiscalizacion')->findBy(array('fiscal' => $item->getId() ));
                if($requestsList2)
                {
                    $arrayData[$cont]['fiscalizaciones'] = $requestsList2;
                }

                $arrayData[$cont][] = $item;
                $cont++;
            }

            $response['status'] = true;
          //  $response['entities'] = $arrayData;
            $paginator = $this->get('knp_paginator');
            $response['entities'] = $paginator->paginate(
                $arrayData,
                $this->get('request')->query->get('page', 1) /*page number*/,
                10
            );
        }else{
            $response['status'] = false;
        }

        return $response;

    }

    /**
     * @Route("/modal-gestiones/{user_id}/", name="fiscal-modal-requests")
     * @Method("GET")
     * @Template("UserBundle:Fiscal:modal1.html.twig")
     */
    public function fiscalModalRequestsAction(Request $request)
    {
        $userId = $request->get('user_id');
        $response = array();
        $em = $this->getDoctrine()->getManager();
        $response['entities'] = $em->getRepository('SolicitudesCitasBundle:DataSolicitudesAprob')->findBy(array('fiscal' => $userId ));

        return $response;
    }


    /**
     * @Route("/modal-fiscalizaciones/{user_id}/", name="fiscal-modal-requests2")
     * @Method("GET")
     * @Template("UserBundle:Fiscal:modal2.html.twig")
     */
    public function fiscalModalRequests2Action(Request $request)
    {
        $userId = $request->get('user_id');
        $response = array();
        $em = $this->getDoctrine()->getManager();
        $response['entities'] = $em->getRepository('FiscalizacionBundle:Fiscalizacion')->findBy(array('fiscal' => $userId ));
        $response['user'] = $em->getRepository('UserBundle:SysUsuario')->findOneBy(array('id'=> $userId));

        return $response;
    }




}