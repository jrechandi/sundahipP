<?php
/*
 * @author Greicodex <info@greicodex.com> 
 */

namespace Sunahip\LicenciaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sunahip\LicenciaBundle\Entity\AdmRecaudosLicencias;
use Sunahip\LicenciaBundle\Form\AdmRecaudosLicenciasType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * AdmRecaudosLicencias controller.
 *
 * @Route("/admrecaudoslicencias")
 */
class AdmRecaudosLicenciasController extends Controller
{

    /**
     * Lists all AdmRecaudosLicencias entities.
     *
     * @Route("/", name="admrecaudoslicencias")
     * @Method("GET")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LicenciaBundle:AdmRecaudosLicencias')->findAll();
        $paginator = $this->get('knp_paginator');
                $pagination = $paginator->paginate(
                    $entities,
                    $this->get('request')->query->get('page', 1) /*page number*/,
                    10
                );
        return array(
            'entities' => $pagination,
        );
    }
    /**
     * Creates a new AdmRecaudosLicencias entity.
     *
     * @Route("/", name="admrecaudoslicencias_create")
     * @Method("POST")
     * @Template("LicenciaBundle:AdmRecaudosLicencias:new.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function createAction(Request $request)
    {
        $entity = new AdmRecaudosLicencias();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admrecaudoslicencias_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a AdmRecaudosLicencias entity.
     *
     * @param AdmRecaudosLicencias $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(AdmRecaudosLicencias $entity)
    {
        $form = $this->createForm(new AdmRecaudosLicenciasType(), $entity, array(
            'action' => $this->generateUrl('admrecaudoslicencias_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Agregar','attr'=>array('class'=>'btn btn-success btn-sm')));

        return $form;
    }

    /**
     * Displays a form to create a new AdmRecaudosLicencias entity.
     *
     * @Route("/new", name="admrecaudoslicencias_new")
     * @Method("GET")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction()
    {
        $entity = new AdmRecaudosLicencias();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a AdmRecaudosLicencias entity.
     *
     * @Route("/{id}", name="admrecaudoslicencias_show")
     * @Method("GET")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LicenciaBundle:AdmRecaudosLicencias')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AdmRecaudosLicencias entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing AdmRecaudosLicencias entity.
     *
     * @Route("/{id}/edit", name="admrecaudoslicencias_edit")
     * @Method("GET")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LicenciaBundle:AdmRecaudosLicencias')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AdmRecaudosLicencias entity.');
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
    * Creates a form to edit a AdmRecaudosLicencias entity.
    *
    * @param AdmRecaudosLicencias $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(AdmRecaudosLicencias $entity)
    {
        $form = $this->createForm(new AdmRecaudosLicenciasType(), $entity, array(
            'action' => $this->generateUrl('admrecaudoslicencias_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar','attr'=>array('class'=>'btn btn-success btn-sm')));

        return $form;
    }
    /**
     * Edits an existing AdmRecaudosLicencias entity.
     *
     * @Route("/{id}", name="admrecaudoslicencias_update")
     * @Method("PUT")
     * @Template("LicenciaBundle:AdmRecaudosLicencias:edit.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LicenciaBundle:AdmRecaudosLicencias')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AdmRecaudosLicencias entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admrecaudoslicencias_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a AdmRecaudosLicencias entity.
     *
     * @Route("/{id}", name="admrecaudoslicencias_delete")
     * @Method("DELETE")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LicenciaBundle:AdmRecaudosLicencias')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find AdmRecaudosLicencias entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admrecaudoslicencias'));
    }

    /**
     * Creates a form to delete a AdmRecaudosLicencias entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admrecaudoslicencias_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Eliminar','attr'=>array('class'=>'btn btn-danger')))
            ->getForm()
        ;
    }
}
