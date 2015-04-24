<?php

/*
 * 
 * @author Greicodex <info@greicodex.com> 
 */

namespace Sunahip\FiscalizacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sunahip\FiscalizacionBundle\Entity\Fiscalizacion;
use Sunahip\FiscalizacionBundle\Form\FiscalizacionType;
use Sunahip\FiscalizacionBundle\Form\MultaType;
use Sunahip\PagosBundle\Entity\Pagos;
use Doctrine\ORM\NoResultException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Fiscalizacion controller.
 *
 */
class FiscalizacionController extends BaseController
{

    /**
     * Lists all Fiscalizacion entities.
     * @Security("has_role('ROLE_GERENTE') or has_role('ROLE_FISCAL') or has_role('ROLE_COORDINADOR') or  has_role('ROLE_SUPERINTENDENTE')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FiscalizacionBundle:Fiscalizacion')->todos($this->get('security.context'));

        return $this->render('FiscalizacionBundle:Fiscalizacion:index.html.twig', array(
            'entities' => $this->getPaginator($entities),
            'tipo' =>'todos',
        ));
    }

    /**
     * Lists all Fiscalizacion entities.
     *  @Security("has_role('ROLE_GERENTE') or has_role('ROLE_FISCAL')")
     */
    public function citadosAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FiscalizacionBundle:Fiscalizacion')->citados($this->get('security.context'));

        return $this->render('FiscalizacionBundle:Fiscalizacion:citados.html.twig', array(
            'entities' => $this->getPaginator($entities),
            'hidden_button' => true,
            'tipo' =>'citados',
        ));
    }

       /**
     * Lists all Fiscalizacion entities.
     *  @Security("has_role('ROLE_GERENTE') or has_role('ROLE_FISCAL') or has_role('ROLE_COORDINADOR') ")
     *
     */
    public function multadosAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FiscalizacionBundle:Fiscalizacion')->multados($this->get('security.context'));

        return $this->render('FiscalizacionBundle:Fiscalizacion:multados.html.twig', array(
            'entities'      => $this->getPaginator($entities),
            'hidden_button' => true,
            'tipo' =>'multados',
        ));
    }


    /**
     * Creates a new Fiscalizacion entity.
     *  @Security("has_role('ROLE_GERENTE') or has_role('ROLE_FISCAL')")
     *
     */
    public function createAction(Request $request, $idprov, $idcentro, $tipo)
    {
        $rep = array('centro' =>'CentrohipicoBundle:DataCentrohipico', 'operadora' => 'CentrohipicoBundle:DataOperadora');
        $entity = new Fiscalizacion();
        $em = $this->getDoctrine()->getManager();
        $prov   = $em->getRepository('FiscalizacionBundle:Providencia')->find($idprov);
        $centro = $em->getRepository($rep[$tipo])->find($idcentro);
        /*Evita crear dos iguales*/
        $em->getRepository('FiscalizacionBundle:Fiscalizacion')->exist($prov, $centro, $tipo);
        /*agrega el centro hipico*/
        $set = 'set'.ucfirst($tipo);
        $entity->$set($centro);
        $entity->setFecha(new \DateTime());
        $entity->setProvidencia($prov);
        /*cargo el fiscal que hizo la fiscalizacion*/
        $perfil = $em->getRepository('UserBundle:SysPerfil')->findOneByUser($this->getUser()->getId());
        $entity->setFiscal($perfil);
        /*Por default está creada No definida */
        //$entity->setEstatus('Creada');
        $form = $this->createCreateForm($entity, $idcentro, $idprov, $tipo);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('message', "Fiscalización lista para generar actas");
            return $this->redirect($this->generateUrl('fiscalizacion_show', array('id' => $entity->getId())));
        }
        
        return $this->render('FiscalizacionBundle:Fiscalizacion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'prov'     => $prov,
            'centro'   => $centro,
        ));
    }

    /**
     * Creates a form to create a Fiscalizacion entity.
     *
     * @param Fiscalizacion $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Fiscalizacion $entity, $centro, $prov, $tipo)
    {
        $form = $this->createForm(new FiscalizacionType(), $entity, array(
            'action' => $this->generateUrl('fiscalizacion_create',
                        array(
                              'idprov' =>  $prov,
                              'idcentro' =>  $centro,
                              'tipo' => $tipo
                        )
                    ),
            'method' => 'POST',
            'attr' => array('id' => 'formulario')

        ));
        return $form;
    }

    /**
     * Displays a form to create a new Fiscalizacion entity.
     *  @Security("has_role('ROLE_GERENTE') or has_role('ROLE_FISCAL')")
     *
     */
    public function newAction($idprov, $idcentro, $tipo)
    {
        try{
            $rep = array(
                'centro'    =>'CentrohipicoBundle:DataCentrohipico',
                'operadora' => 'CentrohipicoBundle:DataOperadora'
            );

            $entity = new Fiscalizacion();
            $em = $this->getDoctrine()->getManager();
            $prov   = $this->getProvidencia($em, $idprov);
            $centro = $em->getRepository($rep[$tipo])->find($idcentro);

            $em->getRepository('FiscalizacionBundle:Fiscalizacion')->exist($prov, $centro, $tipo);

            $form   = $this->createCreateForm($entity, $idcentro, $prov->getId(), $tipo);
            return $this->render('FiscalizacionBundle:Fiscalizacion:new.html.twig', array(
                'prov'     => $prov,
                'centro'   => $centro,
                'entity' => $entity,
                'form'   => $form->createView(),
            ));
        }catch(NoResultException $e){
            return $this->render('FiscalizacionBundle:Fiscalizacion:noprov.html.twig');
        }catch(\RuntimeException $e){
            return $this->render('FiscalizacionBundle:Fiscalizacion:fiscalizado.html.twig', 
                array('e' => $e)
            );
        }
    }

    protected function getProvidencia($em, $id){
        $prov   = $em->getRepository('FiscalizacionBundle:Providencia')->find($id);
        if(is_null($prov)){
            $prov = $em->getRepository('FiscalizacionBundle:Providencia')->current();
        }

        return $prov;
    }

    /**
     * Finds and displays a Fiscalizacion entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FiscalizacionBundle:Fiscalizacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fiscalizacion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        $centro = $entity->getCentro() ? $entity->getCentro():$entity->getOperadora();
        return $this->render('FiscalizacionBundle:Fiscalizacion:show.html.twig', array(
            'entity'      => $entity,
            'centro'      => $centro,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Fiscalizacion entity.
    *
    * @param Fiscalizacion $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Fiscalizacion $entity)
    {
        $form = $this->createForm(new FiscalizacionType(), $entity, array(
            'action' => $this->generateUrl('fiscalizacion_edit', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        return $form;
    }
    /**
     * Edits an existing Fiscalizacion entity.
     *   @Security("has_role('ROLE_GERENTE') or has_role('ROLE_FISCAL')")
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FiscalizacionBundle:Fiscalizacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fiscalizacion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('fiscalizacion_show', array('id' => $id)));
        }
        $centro = $entity->getCentro() ? $entity->getCentro():$entity->getOperadora();
        return $this->render('FiscalizacionBundle:Fiscalizacion:edit.html.twig', array(
            'entity'      => $entity,
            'centro' => $centro, 
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Fiscalizacion entity.
     *  @Security("has_role('ROLE_GERENTE') or has_role('ROLE_FISCAL')")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FiscalizacionBundle:Fiscalizacion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Fiscalizacion entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('fiscalizacion'));
    }

    /**
     * Creates a form to delete a Fiscalizacion entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fiscalizacion_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }


    /**
     * Edits an existing Fiscalizacion entity.
     *  @Security("has_role('ROLE_GERENTE') or has_role('ROLE_FISCAL')")
     */
    public function fiscalizarAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $sForm = $this->createFormBuilder()
            ->setAction($this->generateUrl('fiscalizacion_fiscalizar'))
            ->setMethod('post')
            ->add('tipo', 'choice', array(
                'choices' => array('rif' => 'RIF', 'denominacionComercial' => 'D. Comercial'),
                'label'   => 'Buscar Por'
            ))
            ->add('busca', 'text', array(
                'label' => ''
            ))
            ->getForm()
        ;


        try{
            $prov = $em->getRepository('FiscalizacionBundle:Providencia')->current();

        }catch(NoResultException $e){
            /*No hay proviencia vigente*/
            return $this->render('FiscalizacionBundle:Fiscalizacion:noprov.html.twig');
        }
        
        if(count($prov)==0) {
            /*No hay proviencia vigente*/
            return $this->render('FiscalizacionBundle:Fiscalizacion:noprov.html.twig');
        } else {
            $result = null;
            $sForm->handleRequest($request);
            if ($sForm->isValid()) {
                $d = $sForm->getData();
                $result = $em->getRepository('CentrohipicoBundle:DataCentrohipico')->buscar($d['tipo'], $d['busca']);

            }
            return $this->render('FiscalizacionBundle:Fiscalizacion:fiscalizar.html.twig', array(
                'form'   => $sForm->createView(),
                'result' => $result,
                'prov'   => $prov[0]
            ));
        }
    }

    /**
     * Activa una multa
     *  @Security("has_role('ROLE_GERENTE') or has_role('ROLE_FISCAL')")
     */
    public function multarAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FiscalizacionBundle:Fiscalizacion')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fiscalizacion entity.');
        }

        $pago = new Pagos();
        $form = $this->createForm(new MultaType(), $pago,array(
            'action' => $this->generateUrl('fiscalizacion_multar', array('id' => $id)),
            'method' => 'POST'
        ));
        $form->handleRequest($request);
        if ($form->isValid()) {
            $entity->setEstatus('Multado');
            $centro = $entity->getCentro() ? $entity->getCentro() : $entity->getOperadora();
            $tipo   = $entity->getCentro() ? 'CentroHipico' : 'Operadora';
            $set    = 'set'.ucfirst($tipo);
            $pago->$set($centro);
            $pago->setUsuarioCreacion($this->getUser());
            $pago->setTipoPago('MULTA');
            $pago->setFechaCreacion(new \DateTime());
            $pago->setStatus('CREADA');
            $em->persist($pago);
            $em->flush();
            return $this->redirect($this->generateUrl('fiscalizacion_multados'));
        }
        return $this->render('FiscalizacionBundle:Fiscalizacion:multa.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Lists all Fiscalizacion entities.
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR')")
     */
    public function misAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FiscalizacionBundle:Fiscalizacion')->usuario($this->get('security.context'));

        return $this->render('FiscalizacionBundle:Fiscalizacion:mis.html.twig', array(
            'entities' => $this->getPaginator($entities),
            'hidden_button' => true
        ));
    }
}
