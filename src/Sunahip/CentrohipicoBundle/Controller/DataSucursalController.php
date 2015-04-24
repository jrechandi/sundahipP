<?php
/**
 * Controlador Data Sucursales
 *
 * Class DataSucursalesController
 * @author Greicodex <info@greicodex.com> 
 * Creación de oficinas sucursales de Operadora
 */  

namespace Sunahip\CentrohipicoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sunahip\CentrohipicoBundle\Entity\DataSucursal;
use Sunahip\CentrohipicoBundle\Form\DataSucursalType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * DataSucursal controller.
 *
 */
class DataSucursalController extends Controller
{

    /**
     * Lists all DataSucursal entities.
     * @Security("has_role('ROLE_OPERADOR') or has_role('ROLE_GERENTE') or has_role('ROLE_SUPERINTENDENTE') or has_role('ROLE_COORDINADOR') or has_role('ROLE_FISCAL')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CentrohipicoBundle:DataSucursal')->findBy(array("usuario"=>$this->getUser()));
        
        return $this->render('CentrohipicoBundle:DataSucursal:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new DataSucursal entity.
     * @Security("has_role('ROLE_OPERADOR')")
     */
    public function createAction(Request $request)
    {
        $entity = new DataSucursal();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('datasucursal_show', array('id' => $entity->getId())));
        }

        return $this->render('CentrohipicoBundle:DataSucursal:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a DataSucursal entity.
     *
     * @param DataSucursal $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DataSucursal $entity)
    {
        $form = $this->createForm(new DataSucursalType(), $entity, array(
            'action' => $this->generateUrl('datasucursal_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DataSucursal entity.
     * @Security("has_role('ROLE_OPERADOR')")
     */
    public function newAction()
    {
        $entity = new DataSucursal();
        $form   = $this->createCreateForm($entity);

        return $this->render('CentrohipicoBundle:DataSucursal:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a DataSucursal entity.
     * @Security("has_role('ROLE_OPERADOR') or has_role('ROLE_GERENTE') or has_role('ROLE_SUPERINTENDENTE') or has_role('ROLE_COORDINADOR') or has_role('ROLE_FISCAL')")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CentrohipicoBundle:DataSucursal')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DataSucursal entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CentrohipicoBundle:DataSucursal:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing DataSucursal entity.
     * @Security("has_role('ROLE_OPERADOR')")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CentrohipicoBundle:DataSucursal')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DataSucursal entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CentrohipicoBundle:DataSucursal:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a DataSucursal entity.
    *
    * @param DataSucursal $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DataSucursal $entity)
    {
        $form = $this->createForm(new DataSucursalType(), $entity, array(
            'action' => $this->generateUrl('datasucursal_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DataSucursal entity.
     * @Security("has_role('ROLE_OPERADOR')")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CentrohipicoBundle:DataSucursal')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DataSucursal entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('datasucursal_edit', array('id' => $id)));
        }

        return $this->render('CentrohipicoBundle:DataSucursal:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a DataSucursal entity.
     * @Security("has_role('ROLE_OPERADOR')")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CentrohipicoBundle:DataSucursal')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DataSucursal entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('datasucursal'));
    }

    /**
     * Creates a form to delete a DataSucursal entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('datasucursal_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
