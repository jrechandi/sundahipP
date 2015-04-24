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
use Sunahip\LicenciaBundle\Entity\AdmTiposLicencias;
use Sunahip\LicenciaBundle\Form\AdmTiposLicenciasType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * AdmTiposLicencias controller.
 *
 * @Route("/admtiposlicencias")
 */
class AdmTiposLicenciasController extends Controller
{

    /**
     * Lists all AdmTiposLicencias entities.
     *
     * @Route("/", name="admtiposlicencias")
     * @Method("GET")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LicenciaBundle:AdmTiposLicencias')->findAll();
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
     * Creates a new AdmTiposLicencias entity.
     *
     * @Route("/", name="admtiposlicencias_create")
     * @Method("POST")
     * @Template("LicenciaBundle:AdmTiposLicencias:new.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function createAction(Request $request)
    {
        $entity = new AdmTiposLicencias();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admtiposlicencias_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a AdmTiposLicencias entity.
     *
     * @param AdmTiposLicencias $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(AdmTiposLicencias $entity)
    {
        $form = $this->createForm(new AdmTiposLicenciasType(), $entity, array(
            'action' => $this->generateUrl('admtiposlicencias_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Agregar','attr'=>array('class'=>'btn btn-success btn-sm')));

        return $form;
    }

    /**
     * Displays a form to create a new AdmTiposLicencias entity.
     *
     * @Route("/new", name="admtiposlicencias_new")
     * @Method("GET")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction()
    {
        $entity = new AdmTiposLicencias();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a AdmTiposLicencias entity.
     *
     * @Route("/{id}", name="admtiposlicencias_show")
     * @Method("GET")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LicenciaBundle:AdmTiposLicencias')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AdmTiposLicencias entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing AdmTiposLicencias entity.
     *
     * @Route("/{id}/edit", name="admtiposlicencias_edit")
     * @Method("GET")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LicenciaBundle:AdmTiposLicencias')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AdmTiposLicencias entity.');
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
    * Creates a form to edit a AdmTiposLicencias entity.
    *
    * @param AdmTiposLicencias $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(AdmTiposLicencias $entity)
    {
        $form = $this->createForm(new AdmTiposLicenciasType(), $entity, array(
            'action' => $this->generateUrl('admtiposlicencias_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar','attr'=>array('class'=>'btn btn-success btn-sm')));

        return $form;
    }
    /**
     * Edits an existing AdmTiposLicencias entity.
     *
     * @Route("/{id}", name="admtiposlicencias_update")
     * @Method("PUT")
     * @Template("LicenciaBundle:AdmTiposLicencias:edit.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LicenciaBundle:AdmTiposLicencias')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AdmTiposLicencias entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admtiposlicencias_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a AdmTiposLicencias entity.
     *
     * @Route("/{id}", name="admtiposlicencias_delete")
     * @Method("DELETE")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LicenciaBundle:AdmTiposLicencias')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find AdmTiposLicencias entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admtiposlicencias'));
    }

    /**
     * Creates a form to delete a AdmTiposLicencias entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admtiposlicencias_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Eliminar', 'attr' => array('class' => 'pagar')))
            ->getForm()
        ;
    }
}
