<?php
/**
 * Controlador Data Operadora
 *
 * Class DataOperadoraController
 * @author Greicodex <info@greicodex.com> 
 * Creación de oficina principal de Operadora
 */  

namespace Sunahip\CentrohipicoBundle\Controller;

use Sunahip\CentrohipicoBundle\Entity\DataLegal;
use Sunahip\CentrohipicoBundle\Form\DataOperadoraType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sunahip\CentrohipicoBundle\Entity\DataOperadora;
use Sunahip\CentrohipicoBundle\Form\DataLegalType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * DataOperadora controller.
 *
 */
class DataOperadoraController extends Controller
{

    /**
     * List Operadoras
     * @Security("has_role('ROLE_OPERADOR') or has_role('ROLE_GERENTE') or has_role('ROLE_SUPERINTENDENTE') or has_role('ROLE_COORDINADOR') or has_role('ROLE_FISCAL')")
     */
    public function indexAction(Request $request)
    {
        $ajax = $request->get('ajax');

        if (!$ajax) {
            $ajax = false;
        }
        
        $securityContext = $this->container->get('security.context');
        $keyword = $request->get('keyword');

        $em = $this->getDoctrine()->getManager();
        $response = array();
        
        if($securityContext->isGranted('ROLE_OPERADOR'))
        {
            $user = $this->getUser();
            $entities = $em->getRepository('CentrohipicoBundle:DataOperadora')->findBy(array('usuario' => $user));
        } else {
            $entities = $em->getRepository('CentrohipicoBundle:DataOperadora')->findAll();
        }

        if(!$entities)
        {
            $response['status'] = false;
            $response['message'] = "No existen solicitudes registradas";
            $response['entities'] = null;
        }else
        {
            $data = array();
            $cont = 0;
            foreach($entities as $entity)
            {
                $data[$cont]['id'] = $entity->getId();
                $data[$cont]['persJuridica'] = $entity->getPersJuridica();
                $data[$cont]['rif'] = $entity->getRif();
                $data[$cont]['denominacionComercial'] = $entity->getDenominacionComercial();
                $data[$cont]['fechaRegistro'] = $entity->getFechaRegistro();

                $afiliado = $em->getRepository('CentrohipicoBundle:DataOperadoraEstablecimiento')
                                ->findBy(array('usuario' => $entity->getUsuario()->getId(), 'status' => 'Aprobado', 'operadora' => $entity->getId()));

                $data[$cont]['afiliados'] = count($afiliado);
                $data[$cont]['status'] = $entity->getStatus();
                $data[$cont]['licenciasaprob'] = $entity->getLicenciasAprob();
                $pagos = $em->getRepository('PagosBundle:Pagos')
                            ->findBy(array('operadora'=>$entity->getId(), 'tipoPago'=>'APORTE_MENSUAL'), array('fechaCreacion'=>'DESC'));
                if(count($pagos)>0) {
                    $data[$cont]['aporte'] = $pagos;
                }
                
                $cont++;
            }


            $response['status'] = true;
            $paginator = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $data,
                $this->get('request')->query->get('page', 1) /*page number*/,
                10
            );
            $response['entities'] = $pagination;
        }

        $response['ajax'] = $ajax;
        return $this->render('CentrohipicoBundle:DataOperadora:index.html.twig', $response);
    }
    
    /**
     * Creates a new DataOperadora entity.
     * @Security("has_role('ROLE_OPERADOR')")
     */
    public function createAction(Request $request)
    {
        $entity = new DataLegal();
        $form = $this->createCreateForm($entity);
        

        return $this->render('CentrohipicoBundle:DataOperadora:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a DataOperadora entity.
     *
     * @param DataOperadora $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DataLegal $entity)
    {
        $form = $this->createForm(new DataLegalType, $entity, array(
                'action' => $this->generateUrl('operadora_new'),
                'method' => 'POST',
            ));

        //$form->add('submit', 'submit', array('label' => 'Guardar'));

        return $form;
    }

    /**
    * Displays a form to create a new DataOperadora entity.
    * @Security("has_role('ROLE_OPERADOR')")
    */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user= $this->getUser();
        $entity = $em->getRepository("CentrohipicoBundle:DataLegal")->findOneBy(array('usuario'=> $user->getId()));
        $tab = is_null($entity);
        if(!$entity){
            $entity = new DataLegal();
        }
            $form   = $this->createCreateForm($entity);
            //die;
            $form->handleRequest($request);
            //var_dump($form->get('municipio')->getData()->getID);die;
            //die($request->get('dlmunicipio'));
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            // $dlmunicipio = $em->getRepository('CommonBundle:SysMunicipio')->find($request->get('municipio'));
            //$dlParroquia = $em->getRepository('CommonBundle:SysParroquia')->find($request->get('parroquia'));
            $user= $this->getUser();

            $entity->setFechaRegistro(new \DateTime());
            $entity->setStatus("Nuevo Registro");
            $entity->setUsuario($user);
            $entity->setCiudad(strtoupper($entity->getCiudad()));
           // $entity->setMunicipio($dlmunicipio);
            //$entity->setParroquia($dlParroquia);
            $entity->setIsSocio(false);
            
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                   'success',
                   'Datos guardados con éxito.'
               );
            return $this->redirect($this->generateUrl('operadora_new'));
        }
            return $this->render('CentrohipicoBundle:DataOperadora:new.html.twig', array(
                'form'   => $form->createView(),
                 'entity' => $entity,
                'tab'  => $tab
            ));
        //}
    }

    /**
     * Creates a form to create a DataOperadora entity.
     *
     * @param DataOperadora $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDOForm(DataOperadora $entity,$tipo)
    {
        $action=($tipo=="P")?$this->generateUrl('operadora_new_office'):$this->generateUrl('operadora_create_sucursal');
        $form = $this->createForm(new DataOperadoraType(), $entity, array(
                'action' => $action,
                'method' => 'POST',
            ));
        //$form->add('submit', 'submit', array('label' => 'Guardar'));
        return $form;
    }

    /**
     * Creates a new DataOperadora entity.
     * @todo debe desaparecer
     */
    public function createOfficeAction(Request $request,$tipo)
    {
        $entity = new DataOperadora();

        $form = $this->createDOForm($entity,$tipo);
        die('Form noValid');
        return $this->render('CentrohipicoBundle:DataOperadora:newOffice.html.twig', array(
                'entity' => $entity,
                'form'   => $form->createView(),
               'tipo'=>$tipo
            ));
    }

    /**
     * Displays a form to create a new DataCentrohipico entity.
     *
     */
    public function newOfficeAction(Request $request, $tipo)
    {
        $em = $this->getDoctrine()->getManager();
        $user= $this->getUser();
        $valid = $em->getRepository("CentrohipicoBundle:DataLegal")->findOneBy(array('usuario'=> $user->getId()));
        if(!$valid)
        {
            return $this->render('CentrohipicoBundle:DataOperadora:noreplegal.html.twig');
        }
        $entity = new DataOperadora();
        $entity->setStatus("Nuevo Registro");
        $entity->setFechaRegistro(new \DateTime());
        $tab = true;
        if($tipo==="P") {// Oficina Pricipal
            $ent = $em->getRepository("CentrohipicoBundle:DataOperadora")->findOneBy(array('usuario'=> $user,"esSucursal"=>false));            
            if($ent) {
                $tab = false;
                $entity = $ent;
            }
        }
        $form   = $this->createDOForm($entity,$tipo);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user= $this->getUser();
            $legal = $em->getRepository("CentrohipicoBundle:DataLegal")->findOneBy(array('usuario'=> $user->getId()));
            $entity->setUsuario($user);
            $entity->setCiudad(strtoupper($entity->getCiudad()));
            $entity->setLegal($legal);
            $entity->setEsSucursal($tipo==="P"?false:true);

            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                'Datos guardados con éxito.'
            );
            if($tipo == 'P'){
                 $url = $this->generateUrl('operadora_new_office');
            }else{
                $url = $this->generateUrl('operadora_show', array('id' => $entity->getId()));
            }
            return $this->redirect($url);
        }
        $m = $entity->getMunicipio() ? $entity->getMunicipio()->getId():'';
        $p = $entity->getParroquia() ? $entity->getParroquia()->getId(): '';
        return $this->render('CentrohipicoBundle:DataOperadora:newOffice.html.twig', array(
                'entity' => $entity,
                'form'   => $form->createView(),
                'tipo'   => $tipo,
                'tab'    => $tab,
                'idmunicipio' => $m,
                'idparroquia' => $p,

        ));
    }

    /**
     * Finds and displays a DataOperadora entity.
     * @Security("has_role('ROLE_OPERADOR') or has_role('ROLE_GERENTE') or has_role('ROLE_SUPERINTENDENTE') or has_role('ROLE_COORDINADOR') or has_role('ROLE_FISCAL')")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CentrohipicoBundle:DataOperadora')->find($id);
         
        return $this->render('CentrohipicoBundle:DataOperadora:show.html.twig', array(
            'entity'      => $entity
        ));
    }

    /**
     * Displays a form to edit an existing DataOperadora entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CentrohipicoBundle:DataOperadora')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DataOperadora entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CentrohipicoBundle:DataOperadora:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a DataOperadora entity.
    *
    * @param DataOperadora $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DataOperadora $entity)
    {
        $form = $this->createForm(new DataOperadoraType(), $entity, array(
            'action' => $this->generateUrl('operadora_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DataOperadora entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CentrohipicoBundle:DataOperadora')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DataOperadora entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('operadora_edit', array('id' => $id)));
        }

        return $this->render('CentrohipicoBundle:DataOperadora:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
   

    /**
     * Creates a form to delete a DataOperadora entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('operadora_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    /**
     * Info Operadora
     * @Security("has_role('ROLE_OPERADOR') or has_role('ROLE_GERENTE') or has_role('ROLE_SUPERINTENDENTE') or has_role('ROLE_COORDINADOR') or has_role('ROLE_FISCAL')")
     */
    public function getInfoAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $response = array();
        $entity = $em->getRepository("CentrohipicoBundle:DataOperadora")->findOneBy(array('id' => $id));

        if($entity)
        {
            $response['entity'] = $entity;
            
            $entity = $em->getRepository("UserBundle:SysPerfil")->findOneBy(array('user' => $entity->getUsuario()));
            if($entity)
            {
                $response['basicos'] = $entity;
            }
            
            $entity = $em->getRepository("CentrohipicoBundle:DataLegal")->findOneBy(array('operadora' => $id));
            if($entity)
            {
                $response['legal'] = $entity;
            }

            $entity = $em->getRepository("PagosBundle:Pagos")->findBy(array('operadora' => $id, 'status'=>'VERIFICADO'));
            if($entity)
            {
                $response['payments'] = $entity;
            }

            $entity = $em->getRepository("SolicitudesCitasBundle:DataSolicitudes")->findBy(array('operadora' => $id));
            if(count($entity)>0)
            {
                $response['licenses'] = $entity;
            }
            
            $entity = $em->getRepository("SolicitudesCitasBundle:DataSolicitudesAprob")->getAprobadas($id, null);
            if(count($entity)>0)
            {
                $response['licensesAprob'] = $entity;
            }
        }      

        return $this->render('CentrohipicoBundle:DataOperadora:info.html.twig', $response);
    }
    
    /**
     * Lists all Sucursales entities.
     * @Security("has_role('ROLE_OPERADOR') or has_role('ROLE_GERENTE') or has_role('ROLE_SUPERINTENDENTE') or has_role('ROLE_COORDINADOR') or has_role('ROLE_FISCAL')")
     */
    public function sucursaleslstAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user= $this->getUser();
        
        $entities = $em->getRepository('CentrohipicoBundle:DataOperadora')->findBy(array("usuario"=>$user,"esSucursal"=>true));

        return $this->render('CentrohipicoBundle:DataOperadora:sucursales.html.twig', array(
            'entities' => $entities,
        ));
    }
    
    /*
     * @Security("has_role('ROLE_OPERADOR')")
     */
    public function sucursalDelAction($id) 
    {
        $em = $this->getDoctrine()->getManager();
        $user= $this->getUser();        
        $entity = $em->getRepository('CentrohipicoBundle:DataOperadora')->find($id);
      if(!$entity){
         throw $this->createNotFoundException('Proceso no Realizado Se Ha Encontrado un Error.');
      }  
            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                   'success',
                   'Sucursal Eliminada correctamente.'
               ); 
        return $this->redirect($this->generateUrl('operadora_sucursales'));
    } 
    
}
