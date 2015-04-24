<?php
/**
 * Controlador Data Legal
 *
 * Class DataLegalController
 * @author Greicodex <info@greicodex.com> 
 * Creación de datos legales de la empresa
 */  

namespace Sunahip\CentrohipicoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sunahip\CentrohipicoBundle\Entity\DataLegal;
use Sunahip\CentrohipicoBundle\Form\DataLegalType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * DataLegal controller.
 *
 */
class DataLegalController extends Controller
{

    /**
     * Lists all DataLegal entities.
     * @Security("has_role('ROLE_CENTRO_HIPICO')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CentrohipicoBundle:DataLegal')->findAll();

        return $this->render('CentrohipicoBundle:DataLegal:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new DataLegal entity.
     * @Security("has_role('ROLE_CENTRO_HIPICO')")
     */
    public function createAction(Request $request)
    {
        $entity = new DataLegal();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $dlmunicipio = $em->getRepository('CommonBundle:SysMunicipio')->find($request->get('dlmunicipio'));
            //$dlciudad = $em->getRepository('CommonBundle:SysCiudad')->find($request->get('dlciudad'));
            $user= $this->getUser();
            // Datos Legales
            $entity->setFechaRegistro(new \DateTime());
            $entity->setStatus("Pendiente");
            $entity->setUsuario($user);
            //$entity->setCiudad($dlciudad);
            $entity->setMunicipio($dlmunicipio);
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('datalegal_show', array('id' => $entity->getId())));
        }

        return $this->render('CentrohipicoBundle:DataLegal:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a DataLegal entity.
     *
     * @param DataLegal $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DataLegal $entity)
    {
        $form = $this->createForm(new DataLegalType(), $entity, array(
            'action' => $this->generateUrl('datalegal_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DataLegal entity.
     * @Security("has_role('ROLE_CENTRO_HIPICO')")
     */
    public function newAction()
    {
        $entity = new DataLegal();
        $form   = $this->createCreateForm($entity);

        return $this->render('CentrohipicoBundle:DataLegal:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a DataLegal entity.
     * @Security("has_role('ROLE_CENTRO_HIPICO')")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CentrohipicoBundle:DataLegal')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DataLegal entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CentrohipicoBundle:DataLegal:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing DataLegal entity.
     * @Security("has_role('ROLE_CENTRO_HIPICO')")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CentrohipicoBundle:DataLegal')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DataLegal entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CentrohipicoBundle:DataLegal:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a DataLegal entity.
    *
    * @param DataLegal $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DataLegal $entity)
    {
        $form = $this->createForm(new DataLegalType(), $entity, array(
            'action' => $this->generateUrl('datalegal_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DataLegal entity.
     * @Security("has_role('ROLE_CENTRO_HIPICO')")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CentrohipicoBundle:DataLegal')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DataLegal entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('datalegal_edit', array('id' => $id)));
        }

        return $this->render('CentrohipicoBundle:DataLegal:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a DataLegal entity.
     * @Security("has_role('ROLE_CENTRO_HIPICO')")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CentrohipicoBundle:DataLegal')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DataLegal entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('datalegal'));
    }

    /**
     * Creates a form to delete a DataLegal entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('datalegal_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
