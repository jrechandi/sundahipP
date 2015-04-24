<?php

/*
 * @author Greicodex <info@greicodex.com> 
 */

namespace Sunahip\PagosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sunahip\PagosBundle\Entity\Pagos;
use Sunahip\PagosBundle\Form\PagoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Pago controller.
 *
 * @Route("/pago")
 */
class PagosController extends Controller
{

    /**
     * Lists all Pago entities.
     *
     * @Route("/", name="pago")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PagosBundle:Pagos')->findAll();

        if($entities)
        {
            $response['status'] = true;
            $response['status'] = true;
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
     * Creates a new Pago entity.
     *
     * @Route("/", name="pago_create")
     * @Method("POST")
     * @Template("PagosBundle:Pagos:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Pagos();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('pago_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Pago entity.
     *
     * @param Pago $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Pago $entity)
    {
        $form = $this->createForm(new PagoType(), $entity, array(
            'action' => $this->generateUrl('pago_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Pago entity.
     *
     * @Route("/new", name="pago_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Pagos();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Pago entity.
     *
     * @Route("/{id}", name="pago_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PagosBundle:Pagos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pago entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Pago entity.
     *
     * @Route("/{id}/edit", name="pago_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PagosBundle:Pagos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pago entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Pago entity.
    *
    * @param Pago $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Pagos $entity)
    {
        $form = $this->createForm(new PagoType(), $entity, array(
            'action' => $this->generateUrl('pago_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Pago entity.
     *
     * @Route("/{id}", name="pago_update")
     * @Method("PUT")
     * @Template("PagosBundle:Pago:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PagosBundle:Pagos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pago entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('pago_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Pago entity.
     *
     * @Route("/{id}", name="pago_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PagosBundle:Pagos')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Pago entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('pago'));
    }

    /**
     * Creates a form to delete a Pago entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pago_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    /**
     * Get Pago entity.
     *
     * @Route("/info/{id}", name="pago_info")
     * @Method("GET")
     * @Template("PagosBundle:Pagos:modal.html.twig")
     */
    public function getInfoAction($id= null)
    {
        $em = $this->getDoctrine()->getManager();
        $response = array();
        $entity = $em->getRepository('PagosBundle:Pagos')->findOneBy(array('id'=> $id));

        if($entity)
        {
            $response['status'] = true;
            $response['entity'] = $entity;

            if($entity->getOperadora())
            {
                $payments = $em->getRepository('PagosBundle:Pagos')->findBy(array('operadora'=> $entity->getOperadora()->getId() ));
                $legal = $em->getRepository('CentrohipicoBundle:DataLegal')->findOneBy(array('operadora'=> $entity->getOperadora()->getId() ));
                $activeRequests = $em->getRepository('SolicitudesCitasBundle:DataSolicitudes')->findBy(array('operadora'=> $entity->getOperadora()->getId()));
                //$documents = $em->getRepository('SolicitudesCitasBundle:DataRecaudosAprob')->findBy(array('operadora'=> $entity->getOperadora()->getId()));
            }
            else
            {
                $payments = $em->getRepository('PagosBundle:Pagos')->findBy(array('centroHipico'=> $entity->getCentroHipico()->getId()));
                $legal = $em->getRepository('CentrohipicoBundle:DataLegal')->findOneBy(array('centroHipico'=> $entity->getCentroHipico()->getId() ));
                $activeRequests = $em->getRepository('SolicitudesCitasBundle:DataSolicitudes')->findBy(array('centroHipico'=> $entity->getCentroHipico()->getId()));
                //$documents = $em->getRepository('SolicitudesCitasBundle:DataRecaudosAprob')->findBy(array('centroHipico'=> $entity->getCentroHipico()->getId()));
            }

            $documents = array();
            foreach($activeRequests as $item)
            {
                $documents[] = $em->getRepository('SolicitudesCitasBundle:DataRecaudosCargados')->findBy(array('solicitud'=> $item->getId()));
            }


            $response['requestor'] = $em->getRepository('UserBundle:SysPerfil')->findBy(array('user'=> $entity->getUsuarioCreacion()->getId()));
            $response['activeRequests'] = $activeRequests;
            $response['documents'] = $documents;
            $response['payments'] = $payments;
            $response['legal'] = $legal;
        }else{
            $response['status'] = false;
        }

        return $response;
    }


}
