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
use Sunahip\LicenciaBundle\Entity\AdmClasfEstab;
use Sunahip\LicenciaBundle\Form\AdmClasfEstabType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * AdmClasfEstab controller.
 *
 * @Route("/admclasfestab")
 */
class AdmClasfEstabController extends Controller
{

    /**
     * Lists all AdmClasfEstab entities.
     *
     * @Route("/", name="admclasfestab")
     * @Method("GET")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LicenciaBundle:AdmClasfEstab')->findAll();
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
     * Creates a new AdmClasfEstab entity.
     *
     * @Route("/", name="admclasfestab_create")
     * @Method("POST")
     * @Template("LicenciaBundle:AdmClasfEstab:new.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function createAction(Request $request)
    {
        $entity = new AdmClasfEstab();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admclasfestab_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a AdmClasfEstab entity.
     *
     * @param AdmClasfEstab $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(AdmClasfEstab $entity)
    {
        $form = $this->createForm(new AdmClasfEstabType(), $entity, array(
            'action' => $this->generateUrl('admclasfestab_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Agregar','attr'=>array('class'=>'btn btn-success btn-sm')));

        return $form;
    }

    /**
     * Displays a form to create a new AdmClasfEstab entity.
     *
     * @Route("/new", name="admclasfestab_new")
     * @Method("GET")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction()
    {
        $entity = new AdmClasfEstab();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a AdmClasfEstab entity.
     *
     * @Route("/{id}", name="admclasfestab_show")
     * @Method("GET")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LicenciaBundle:AdmClasfEstab')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AdmClasfEstab entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing AdmClasfEstab entity.
     *
     * @Route("/{id}/edit", name="admclasfestab_edit")
     * @Method("GET")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LicenciaBundle:AdmClasfEstab')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AdmClasfEstab entity.');
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
    * Creates a form to edit a AdmClasfEstab entity.
    *
    * @param AdmClasfEstab $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(AdmClasfEstab $entity)
    {
        $form = $this->createForm(new AdmClasfEstabType(), $entity, array(
            'action' => $this->generateUrl('admclasfestab_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar','attr'=>array('class'=>'btn btn-success btn-sm')));

        return $form;
    }
    /**
     * Edits an existing AdmClasfEstab entity.
     *
     * @Route("/{id}", name="admclasfestab_update")
     * @Method("PUT")
     * @Template("LicenciaBundle:AdmClasfEstab:edit.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LicenciaBundle:AdmClasfEstab')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AdmClasfEstab entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admclasfestab_show', array('id' => $entity->getId())));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a AdmClasfEstab entity.
     *
     * @Route("/{id}", name="admclasfestab_delete")
     * @Method("DELETE")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LicenciaBundle:AdmClasfEstab')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find AdmClasfEstab entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admclasfestab'));
    }

    /**
     * Creates a form to delete a AdmClasfEstab entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admclasfestab_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Eliminar','attr'=>array('class'=>'btn btn-danger')))
            ->getForm()
        ;
    }
}
