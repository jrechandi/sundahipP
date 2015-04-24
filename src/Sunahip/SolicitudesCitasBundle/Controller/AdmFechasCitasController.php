<?php

/*
 * @author Greicodex <info@greicodex.com> 
 * Administración de las citas
 */

namespace Sunahip\SolicitudesCitasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sunahip\SolicitudesCitasBundle\Entity\AdmFechasCitas;
use Sunahip\SolicitudesCitasBundle\Form\AdmFechasCitasType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * AdmFechasCitas controller.
 *
 */
class AdmFechasCitasController extends Controller
{

    /**
     * Lists all AdmFechasCitas entities.
     * @Security("has_role('ROLE_GERENTE')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('SolicitudesCitasBundle:AdmFechasCitas')->findAll();
        $maxcitas= empty($entities)?0:$entities[0]->getMaxcitaxday();

        return $this->render('SolicitudesCitasBundle:AdmFechasCitas:index.html.twig', array(
            'entities' => $entities,
            'maxcita' =>$maxcitas,
        ));
    }
    /**
     * Creates a new AdmFechasCitas entity.
     * @Security("has_role('ROLE_GERENTE')")
     */
    public function createAction(Request $request)
    {
        $entity = new AdmFechasCitas();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('nocitafecha'));
        }

        return $this->render('SolicitudesCitasBundle:AdmFechasCitas:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a AdmFechasCitas entity.
     *
     * @param AdmFechasCitas $entity The entity     
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(AdmFechasCitas $entity)
    {
        $form = $this->createForm(new AdmFechasCitasType(), $entity, array(
            'action' => $this->generateUrl('nocitafecha_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Agregar','attr'=>array('class'=>'btn btn-success btn-sm')));

        return $form;
    }

    /**
     * Displays a form to create a new AdmFechasCitas entity.
     *
     */
    public function newAction()
    {
        $entity = new AdmFechasCitas();
        $form   = $this->createCreateForm($entity);

        return $this->render('SolicitudesCitasBundle:AdmFechasCitas:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a AdmFechasCitas entity.
     * @Security("has_role('ROLE_GERENTE')")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SolicitudesCitasBundle:AdmFechasCitas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AdmFechasCitas entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SolicitudesCitasBundle:AdmFechasCitas:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing AdmFechasCitas entity.
     * @Security("has_role('ROLE_GERENTE')")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SolicitudesCitasBundle:AdmFechasCitas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AdmFechasCitas entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SolicitudesCitasBundle:AdmFechasCitas:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a AdmFechasCitas entity.
    *
    * @param AdmFechasCitas $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(AdmFechasCitas $entity)
    {
        $form = $this->createForm(new AdmFechasCitasType(), $entity, array(
            'action' => $this->generateUrl('nocitafecha_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Editar','attr'=>array('class'=>'btn btn-primary btn-sm')));

        return $form;
    }
    /**
     * Edits an existing AdmFechasCitas entity.
     * @Security("has_role('ROLE_GERENTE')")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('SolicitudesCitasBundle:AdmFechasCitas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AdmFechasCitas entity.');
        }
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            $em->flush();
            //return $this->redirect($this->generateUrl('nocitafecha_edit', array('id' => $id)));
            return $this->redirect($this->generateUrl('nocitafecha' ));
        }
        return $this->render('SolicitudesCitasBundle:AdmFechasCitas:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    /**
     * Deletes a AdmFechasCitas entity.
     * @Security("has_role('ROLE_GERENTE')")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SolicitudesCitasBundle:AdmFechasCitas')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find AdmFechasCitas entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('nocitafecha'));
    }

    /**
     * Creates a form to delete a AdmFechasCitas entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('nocitafecha_delete', array('id' => $id)))
            ->setMethod('DELETE')    
            ->add('submit', 'submit', array('label' => 'Eliminar','attr'=>array('class'=>'btn btn-danger btn-sm')))
            ->getForm()
        ;
    }
    
    /*
     * @Security("has_role('ROLE_GERENTE')")
     */    
    public function maxcitaAction($max)
    {
        $em = $this->getDoctrine()->getManager();
        $row = $em->getRepository('SolicitudesCitasBundle:AdmFechasCitas')->findOneBy(array('maxcitaxday'=>$max));
        if(($row['maxcitaxday'])!=$max){
            $entity = $em->getRepository('SolicitudesCitasBundle:AdmFechasCitas')->setAllMaxCitas($max);
            if ($entity){    
                $response= array(
                       'status'=>'OK',
                       'message'=>'OK'
                       );
            }else{
                $response= array(
                       'status'=>'None',
                       'message'=>'No se pudo procesar la Carga'
                       );
            }
        }else {
                $response= array(
                       'status'=>'OK',
                       'message'=>'Sin Cambios'
                       );
        }
       $jsonR= new \Symfony\Component\HttpFoundation\JsonResponse() ;
       $jsonR->setData($response);
       return $jsonR;
    }
}
