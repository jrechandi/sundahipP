<?php
/**
 * Controlador Data Centro Hipico Controller
 *
 * Class DataCentrohipicoController
 * @author Carlos Salazar <info@greicodex.com> 
 * Creación de centros hípicos
 */
namespace Sunahip\CentrohipicoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sunahip\CentrohipicoBundle\Entity\DataCentrohipico;
use Sunahip\CentrohipicoBundle\Form\DataCentrohipicoType;
use Doctrine\ORM\EntityRepository;
use Sunahip\CentrohipicoBundle\Entity\DataLegal;
use Sunahip\CentrohipicoBundle\Form\DataLegalType;
use Sunahip\CentrohipicoBundle\Form\DataSocioLegalType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * DataCentrohipico controller.
 *
 */
class DataCentrohipicoController extends Controller
{

    /**
     * Permite saber el ultimo centro hipico registrado
     */
    protected $last = null;

    /**
     * Lists all DataCentrohipico entities.
     * @Security("has_role('ROLE_CENTRO_HIPICO')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user= $this->getUser();
        
        $entities = $em->getRepository('CentrohipicoBundle:DataCentrohipico')->findBy(array("usuario"=>$user));

        return $this->render('CentrohipicoBundle:DataCentrohipico:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /*
     * @Security("has_role('ROLE_CENTRO_HIPICO')")
     */
    
    public function createEstablishmentAction(Request $request)
    {
        $edch = new DataCentrohipico();
        $fdch = $this->createCreateFDCH($edch);
        $fdch->handleRequest($request);
        $user= $this->getUser();
        if ($fdch->isValid()) {
            $em = $this->getDoctrine()->getManager();
            /*Intenta obtener la empresa*/
            $fields = $request->get("sunahip_centrohipicobundle_datacentrohipico");
            $empresa = $em->getRepository("CentrohipicoBundle:DataEmpresa")->findOneBy(array('id'=> $fields['empresa']));
            if(!is_null($empresa)){
                $edch->setRif($empresa->getRif());
                $edch->setPersJuridica($empresa->getPersJuridica());
            }else{
                $edch->setRif($edch->getRifDueno());
                $edch->setPersJuridica($edch->getPersJuridicaDueno());  
            }
            //Agregar valores Faltantes
            //Datos Centro Hipico
            $edch->setCiudad(strtoupper($edch->getCiudad()));
            $edch->setUsuario($user);
            $edch->setFechaRegistro(new \DateTime());
            $edch->setStatus("Pendiente");

            $em->persist($edch);
            $em->flush();
            /*NO ELIMINAR, SE USA EN FISCALIZACION*/
            $this->last = $edch;
            return $this->redirect($this->generateUrl('datacentrohipico_list'));
        }

        return $this->render('CentrohipicoBundle:DataCentrohipico:newEstablishment.html.twig', array(
            'entity' => $edch,
            'form'   => $fdch->createView(),
            /*NO ELIMINAR SE USA EN FISCALIZACION*/
            'hidden' => isset($this->hidden)
            ));
    }



    /**
     * Creates a new DataCentrohipico entity.
     * @Security("has_role('ROLE_CENTRO_HIPICO')")
     */
    public function createAction(Request $request)
    {
        $edl = new DataLegal();
        $data = $request->get('sunahip_centrohipicobundle');
        if(isset($data['partner']))
        {
            $fdl = $this->createCreateSocio($edl);
        }else
            $fdl = $this->createCreateFDL($edl);

        $fdl->handleRequest($request);

        if (/*$fdch->isValid() &&*/ $fdl->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user= $this->getUser();

            if(isset($data['partner']))
            {
                $parent = $em->getRepository("CentrohipicoBundle:DataLegal")->findOneBy(array('usuario'=> $user->getId()));
                $edl->setPadre($parent);
                $url = $this->generateUrl('datacentrohipico_list_partner');
            }else
                $url = $this->generateUrl('datacentrohipico_list');

            // Datos Legales
            $edl->setFechaRegistro(new \DateTime());
            $edl->setStatus("Pendiente");
            $edl->setUsuario($user);
            $edl->setCiudad(strtoupper($edl->getCiudad()));
            $edl->setIsSocio(false);
            /*Persiste*/
            $em->persist($edl);
            $em->flush();
            return $this->redirect($url);
        }

        return $this->render('CentrohipicoBundle:DataCentrohipico:new.html.twig', array(
                'fdl'   => $fdl->createView()
            ));
    }

    /**
     * Creates a form to create a DataCentrohipico entity.
     *
     * @param DataCentrohipico $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    protected function createCreateFDCH(DataCentrohipico $entity)
    {
        $user= $this->getUser();
        $form = $this->createForm(new DataCentrohipicoType($user->getId()), $entity, array(
            'action' => $this->generateUrl('datacentrohipico_create_est'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Guardar'));

        return $form;
    }
    /**
     * Creates a form to create a DataCentrohipico entity.
     *
     * @param DataCentrohipico $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateFDL(DataLegal $entity)
    {
        $form = $this->createForm(new DataLegalType, $entity, array(
            /*NO MODIFICAR, SE USA EN FISCALIZACION*/
            'action' => $this->generateUrl($this->urlCreate),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Guardar'));

        return $form;
    }

    /**
     * Displays a form to create a new DataCentrohipico entity.
     * @Security("has_role('ROLE_CENTRO_HIPICO')")
     */
    public function newAction()
    {
        $edl = new DataLegal();
        $fdl   = $this->createCreateFDL($edl);

        return $this->render('CentrohipicoBundle:DataCentrohipico:new.html.twig', array(
            'fdl'   => $fdl->createView(),
        ));
    }

    /**
     * Displays a form to create a new DataCentrohipico entity.
     * @Security("has_role('ROLE_CENTRO_HIPICO')")
     */
    public function newEstablishmentAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user= $this->getUser();
        $valid = $em->getRepository("CentrohipicoBundle:DataEmpresa")->findOneBy(array('usuario'=> $user->getId()));

        if(!$valid)
        {
            return $this->render('CentrohipicoBundle:DataCentrohipico:newEstablishment.html.twig', array(
                    'message' => "Debe tener al menos una empresa registrada"
                ));
        }else{
            $edch = new DataCentrohipico();
            $fdch   = $this->createCreateFDCH($edch);

            return $this->render('CentrohipicoBundle:DataCentrohipico:newEstablishment.html.twig', array(
                    'entity' => $edch,
                    'hidden' => false,
                    'form'   => $fdch->createView(),
                ));
        }
    }

    /**
     * Finds and displays a DataCentrohipico entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CentrohipicoBundle:DataCentrohipico')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DataCentrohipico entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CentrohipicoBundle:DataCentrohipico:show.html.twig', array(
            'entity' => $entity,
        ));
    }

    /**
     * Displays a form to edit an existing DataCentrohipico entity.
     * @Security("has_role('ROLE_CENTRO_HIPICO')")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CentrohipicoBundle:DataCentrohipico')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DataCentrohipico entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CentrohipicoBundle:DataCentrohipico:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a DataCentrohipico entity.
    *
    * @param DataCentrohipico $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DataCentrohipico $entity)
    {
        $user= $this->getUser();
        $form = $this->createForm(new DataCentrohipicoType($user->getId()), $entity, array(
            'action' => $this->generateUrl('datacentrohipico_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DataCentrohipico entity.
     * @Security("has_role('ROLE_CENTRO_HIPICO')")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CentrohipicoBundle:DataCentrohipico')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DataCentrohipico entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('datacentrohipico_edit', array('id' => $id)));
        }

        return $this->render('CentrohipicoBundle:DataCentrohipico:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a DataCentrohipico entity.
     * @Security("has_role('ROLE_CENTRO_HIPICO')")
     */
    public function deleteAction(Request $request, $id)
    {
        /*$form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CentrohipicoBundle:DataCentrohipico')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DataCentrohipico entity.');
            }

            $em->remove($entity);
            $em->flush();
        }*/

        return $this->redirect($this->generateUrl('datacentrohipico'));
    }

    /**
     * Creates a form to delete a DataCentrohipico entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('datacentrohipico_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    public function partnerAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user= $this->getUser();
        
        $response = array();
        $parent = $em->getRepository("CentrohipicoBundle:DataLegal")->findOneBy(array('usuario'=> $user->getId()));
        $entities=null;
        if(!$parent)
        {
            $response['message'] = "<h5>Debe tener al menos una empresa registrada.</h5><a href=\"".$this->generateUrl('datacentrohipico_new')."\">Agregar Oficina</a>" ;
        }else{
            $entities = $em->getRepository("CentrohipicoBundle:DataLegal")->findBy(array('padre'=> $parent->getId()));
            if(!$entities)
            {
                $response['message'] = "No posee socios registrados";
                $response['status'] = false;
                $response['entities'] = null;
                //$entities = $em->getRepository("CentrohipicoBundle:DataLegal")->findBy(array('padre'=> $parent->getId()));
            }else{
                $response['status'] = true;
                $paginator = $this->get('knp_paginator');
                $pagination = $paginator->paginate(
                    $entities,
                    $this->get('request')->query->get('page', 1) /*page number*/,
                    10
                );
                $response['entities'] = $pagination;
            }
        }

        return $this->render('CentrohipicoBundle:DataCentrohipico:listPartner.html.twig',$response);
    }

    /**
     * Creates a form to create a DataCentrohipico entity.
     *
     * @param DataCentrohipico $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateSocio(DataLegal $entity)
    {
        $user = $this->getUser();
        $form = $this->createForm(new DataSocioLegalType($user->getId()), $entity, array(
                'action' => $this->generateUrl('datacentrohipico_create'),
                'method' => 'POST',
            ));

        //$form->add('submit', 'submit', array('label' => 'Guardar'));

        return $form;
    }
    /*
     * @Security("has_role('ROLE_CENTRO_HIPICO')")
     */
    public function newPartnerAction()
    {
        $entity = new DataLegal();
        $form   = $this->createCreateSocio($entity);

        return $this->render('CentrohipicoBundle:DataCentrohipico:newPartner.html.twig', array(
                'form'   => $form->createView(),
            ));
    }



}
