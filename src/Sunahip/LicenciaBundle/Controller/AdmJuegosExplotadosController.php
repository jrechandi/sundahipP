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
use Sunahip\LicenciaBundle\Entity\AdmJuegosExplotados;
use Sunahip\LicenciaBundle\Form\AdmJuegosExplotadosType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * AdmJuegosExplotados controller.
 *
 * @Route("/admjuegosexplotados")
 */
class AdmJuegosExplotadosController extends Controller
{

    /**
     * Lists all AdmJuegosExplotados entities.
     *
     * @Route("/", name="admjuegosexplotados")
     * @Method("GET")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LicenciaBundle:AdmJuegosExplotados')->findAll();
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
     * Creates a new AdmJuegosExplotados entity.
     *
     * @Route("/", name="admjuegosexplotados_create")
     * @Method("POST")
     * @Template("LicenciaBundle:AdmJuegosExplotados:new.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function createAction(Request $request)
    {
        $entity = new AdmJuegosExplotados();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admjuegosexplotados_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a AdmJuegosExplotados entity.
     *
     * @param AdmJuegosExplotados $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(AdmJuegosExplotados $entity)
    {
        $form = $this->createForm(new AdmJuegosExplotadosType(), $entity, array(
            'action' => $this->generateUrl('admjuegosexplotados_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Agregar','attr'=>array('class'=>'btn btn-success btn-sm')));

        return $form;
    }

    /**
     * Displays a form to create a new AdmJuegosExplotados entity.
     *
     * @Route("/new", name="admjuegosexplotados_new")
     * @Method("GET")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction()
    {
        $entity = new AdmJuegosExplotados();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a AdmJuegosExplotados entity.
     *
     * @Route("/{id}", name="admjuegosexplotados_show")
     * @Method("GET")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LicenciaBundle:AdmJuegosExplotados')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AdmJuegosExplotados entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing AdmJuegosExplotados entity.
     *
     * @Route("/{id}/edit", name="admjuegosexplotados_edit")
     * @Method("GET")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LicenciaBundle:AdmJuegosExplotados')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AdmJuegosExplotados entity.');
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
    * Creates a form to edit a AdmJuegosExplotados entity.
    *
    * @param AdmJuegosExplotados $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(AdmJuegosExplotados $entity)
    {
        $form = $this->createForm(new AdmJuegosExplotadosType(), $entity, array(
            'action' => $this->generateUrl('admjuegosexplotados_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar','attr'=>array('class'=>'btn btn-success btn-sm')));

        return $form;
    }
    /**
     * Edits an existing AdmJuegosExplotados entity.
     *
     * @Route("/{id}", name="admjuegosexplotados_update")
     * @Method("PUT")
     * @Template("LicenciaBundle:AdmJuegosExplotados:edit.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LicenciaBundle:AdmJuegosExplotados')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AdmJuegosExplotados entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admjuegosexplotados_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a AdmJuegosExplotados entity.
     *
     * @Route("/{id}", name="admjuegosexplotados_delete")
     * @Method("DELETE")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LicenciaBundle:AdmJuegosExplotados')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find AdmJuegosExplotados entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admjuegosexplotados'));
    }

    /**
     * Creates a form to delete a AdmJuegosExplotados entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admjuegosexplotados_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Eliminar','attr'=>array('class'=>'btn btn-danger')))
            ->getForm()
        ;
    }
}
