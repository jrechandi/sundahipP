<?php
/*
 * 
 * @author Greicodex <info@greicodex.com> 
 * Se crea las providencias de las fiscalizaciones
 */

namespace Sunahip\FiscalizacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

use Sunahip\FiscalizacionBundle\Entity\Providencia;
use Sunahip\FiscalizacionBundle\Form\ProvidenciaType;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Providencia controller.
 *
 */
class ProvidenciaController extends BaseController
{

    /**
     * Lists all Providencia entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FiscalizacionBundle:Providencia')->byRol($this->get('security.context'));

        return $this->render('FiscalizacionBundle:Providencia:index.html.twig', array(
            'entities' => $this->getPaginator($entities),
        ));
    }
    /**
     * Creates a new Providencia entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Providencia();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            /*Fiscales extras*/
            $cant = (int)$form['extra']->getData();
            $gerente = $form['gerente']->getData();
            $em = $this->getDoctrine()->getManager();
            $fiscales = $em->getRepository('UserBundle:SysPerfil')->findFiscal($cant, $gerente);
            foreach ($fiscales->getResult() as $f) {
                $entity->addFiscale($f);
            }
            $entity->setStatus('Abierta');
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('providencia_show', array('id' => $entity->getId())));
        }

        return $this->render('FiscalizacionBundle:Providencia:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Providencia entity.
     *
     * @param Providencia $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Providencia $entity)
    {
        $form = $this->createForm(new ProvidenciaType(), $entity, array(
            'action'      => $this->generateUrl('providencia_create'),
            'method'      => 'POST',
            'repository' => $this->getDoctrine()->getManager()->getRepository('UserBundle:SysPerfil')
        ));
        return $form;
    }

    /**
     * Displays a form to create a new Providencia entity.
     *
     */
    public function newAction()
    {
        $entity = new Providencia();
        $form   = $this->createCreateForm($entity);

        return $this->render('FiscalizacionBundle:Providencia:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Providencia entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FiscalizacionBundle:Providencia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Providencia entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FiscalizacionBundle:Providencia:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Providencia entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FiscalizacionBundle:Providencia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Providencia entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FiscalizacionBundle:Providencia:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Providencia entity.
    *
    * @param Providencia $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Providencia $entity)
    {
        $form = $this->createForm(new ProvidenciaType(), $entity, array(
            'action' => $this->generateUrl('providencia_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Providencia entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FiscalizacionBundle:Providencia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Providencia entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('providencia_edit', array('id' => $id)));
        }

        return $this->render('FiscalizacionBundle:Providencia:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Providencia entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FiscalizacionBundle:Providencia')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Providencia entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('providencia'));
    }

    /**
     * Creates a form to delete a Providencia entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('providencia_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    /**
     * Respuesta ajax los estados
     */
    public function estadoAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CommonBundle:SysEstado')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Estado entity.');
        }

        $json = array();
        $item  = $entity->getMunicipios();
        foreach ($item as $value) {
            $json[] = $value->getId();
        }
        return new JsonResponse($json);
    }


     /**
     * Respuesta ajax los municipios
     */
    public function municipioAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CommonBundle:SysMunicipio')->find($id);

        $json = array();
        if($entity){
            $item  = $entity->getCentros();
            foreach ($item as $value) {
                $json[] = $value->getId();
            }
        }
        return new JsonResponse($json);
    }

    /**
     * Respuesta ajax a las operadoras
     */
    public function operadoraAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CommonBundle:SysMunicipio')->find($id);

        $json = array();

        if($entity){
            $item  = $entity->getOperadoras();
            foreach ($item as $value) {
                $json[] = $value->getId();
            }
        }
        return new JsonResponse($json);
    }

    public function fiscalizacionAction($tipo, $prov, $id){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FiscalizacionBundle:Fiscalizacion')
                ->createQueryBuilder('u')
                ->join('u.providencia', 'p')
                ->join("u.$tipo", 't')
                ->where('p.id =  :prov')
                ->andWhere('t.id =  :id')
                ->setParameter('prov', $prov)
                ->setParameter('id', $id)->getQuery()->getResult();
        if(isset($entity[0])){
            $url   = 'fiscalizacion_show';
            $param = array('id' => $entity[0]->getId());
        }else{
            $url   = 'fiscalizacion_new';
            $param = array('idprov' => $prov, 'idcentro' => $id, 'tipo'=>$tipo);
        }
        return $this->redirect($this->generateUrl($url, $param));
    }
}
