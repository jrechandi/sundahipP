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
use Sunahip\LicenciaBundle\Entity\AdmTipoAporte;
use Sunahip\LicenciaBundle\Form\AdmTipoAporteType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * AdmTipoAporte controller.
 *
 * @Route("/admtipoaporte")
 */
class AdmTipoAporteController extends Controller
{

    /**
     * Lists all AdmTipoAporte entities.
     *
     * @Route("/", name="admtipoaporte")
     * @Method("GET")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LicenciaBundle:AdmTipoAporte')->findAll();
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
     * Creates a new AdmTipoAporte entity.
     *
     * @Route("/", name="admtipoaporte_create")
     * @Method("POST")
     * @Template("LicenciaBundle:AdmTipoAporte:new.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function createAction(Request $request)
    {
        $entity = new AdmTipoAporte();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admtipoaporte_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a AdmTipoAporte entity.
     *
     * @param AdmTipoAporte $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(AdmTipoAporte $entity)
    {
        $form = $this->createForm(new AdmTipoAporteType(), $entity, array(
            'action' => $this->generateUrl('admtipoaporte_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Agregar','attr'=>array('class'=>'btn btn-success btn-sm')));

        return $form;
    }

    /**
     * Displays a form to create a new AdmTipoAporte entity.
     *
     * @Route("/new", name="admtipoaporte_new")
     * @Method("GET")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction()
    {
        $entity = new AdmTipoAporte();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a AdmTipoAporte entity.
     *
     * @Route("/{id}", name="admtipoaporte_show")
     * @Method("GET")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LicenciaBundle:AdmTipoAporte')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AdmTipoAporte entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing AdmTipoAporte entity.
     *
     * @Route("/{id}/edit", name="admtipoaporte_edit")
     * @Method("GET")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LicenciaBundle:AdmTipoAporte')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AdmTipoAporte entity.');
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
    * Creates a form to edit a AdmTipoAporte entity.
    *
    * @param AdmTipoAporte $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(AdmTipoAporte $entity)
    {
        $form = $this->createForm(new AdmTipoAporteType(), $entity, array(
            'action' => $this->generateUrl('admtipoaporte_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar','attr'=>array('class'=>'btn btn-success btn-sm')));

        return $form;
    }
    /**
     * Edits an existing AdmTipoAporte entity.
     *
     * @Route("/{id}", name="admtipoaporte_update")
     * @Method("PUT")
     * @Template("LicenciaBundle:AdmTipoAporte:edit.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LicenciaBundle:AdmTipoAporte')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AdmTipoAporte entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admtipoaporte_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a AdmTipoAporte entity.
     *
     * @Route("/{id}", name="admtipoaporte_delete")
     * @Method("DELETE")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LicenciaBundle:AdmTipoAporte')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find AdmTipoAporte entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admtipoaporte'));
    }

    /**
     * Creates a form to delete a AdmTipoAporte entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admtipoaporte_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Eliminar','attr'=>array('class'=>'btn btn-danger')))
            ->getForm()
        ;
    }
}
