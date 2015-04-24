<?php

/*
 * @author Greicodex <info@greicodex.com> 
 * Administración de Bancos
 */

namespace Sunahip\PagosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sunahip\PagosBundle\Entity\Banco;
use Sunahip\PagosBundle\Form\BancoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Banco controller.
 *
 * @Route("/banco")
 */
class BancoController extends Controller
{

    /**
     * Lists all Banco entities.
     *
     * @Route("/", name="banco")
     * @Method("GET")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PagosBundle:Banco')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Banco entity.
     *
     * @Route("/", name="banco_create")
     * @Method("POST")
     * @Template("PagosBundle:Banco:new.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function createAction(Request $request)
    {
        $entity = new Banco();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $flashMessage = "Se agrego los datos del banco sastifactoriamente";
            $this->get('session')->getFlashBag()->add('message', $flashMessage);
            return $this->redirect($this->generateUrl('banco'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Banco entity.
     *
     * @param Banco $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Banco $entity)
    {
        $form = $this->createForm(new BancoType(), $entity, array(
            'action' => $this->generateUrl('banco_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Banco entity.
     *
     * @Route("/new", name="banco_new")
     * @Method("GET")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction()
    {
        $entity = new Banco();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Banco entity.
     *
     * @Route("/{id}", name="banco_show")
     * @Method("GET")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PagosBundle:Banco')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Banco entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Banco entity.
     *
     * @Route("/{id}/edit", name="banco_edit")
     * @Method("GET")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PagosBundle:Banco')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Banco entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView()
        );
    }

    /**
    * Creates a form to edit a Banco entity.
    *
    * @param Banco $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Banco $entity)
    {
        $form = $this->createForm(new BancoType(), $entity, array(
            'action' => $this->generateUrl('banco_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Banco entity.
     *
     * @Route("/{id}", name="banco_update")
     * @Method("PUT")
     * @Template("PagosBundle:Banco:edit.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PagosBundle:Banco')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Banco entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $flashMessage = "Se actualizaron los datos del banco sastifactoriamente";
            $this->get('session')->getFlashBag()->add('message', $flashMessage);
            return $this->redirect($this->generateUrl('banco'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Banco entity.
     *
     * @Route("/{id}/delete", name="banco_delete")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('PagosBundle:Banco')->findOneBy(array('id' => $id));
        $em->remove($entity);
        $em->flush();

        $flashMessage = "Se han eliminado los datos del banco sastifactoriamente";
        $this->get('session')->getFlashBag()->add('message', $flashMessage);

        return $this->redirect($this->generateUrl('banco'));
    }

    /**
     * Creates a form to delete a Banco entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('banco_delete', array('id' => $id)))
            ->setMethod('GET')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
