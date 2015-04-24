<?php
/*
 * 
 * @author Greicodex <info@greicodex.com> 
 */

namespace Sunahip\FiscalizacionBundle\Controller;

use Sunahip\PagosBundle\Entity\Pagos;
use Sunahip\FiscalizacionBundle\Form\PagosType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class CitasController extends BaseController
{

     /**
     * Lists all Fiscalizacion entities.
     * @Security("has_role('ROLE_OPERADOR') or has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_GERENTE')  or has_role('ROLE_SUPERINTENDENTE') or  has_role('ROLE_COORDINADOR') ")
     */
    public function indexAction()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SolicitudesCitasBundle:DataSolicitudes')->findAll();

        $view = $user->hasRole('ROLE_GERENTE')? 'todos':'index';
        return $this->render("FiscalizacionBundle:Citas:index.html.twig", array(
            'entities' => $this->getPaginator($entities),
        ));
    }


    /**
     * @Security("has_role('ROLE_OPERADOR') or has_role('ROLE_CENTRO_HIPICO')")
     */

    public function pagarAction(Request $request, $id, $tipo)
    {
        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository('PagosBundle:Pagos')->find($id);
        $sForm = $this->createCreateForm($result, $id, $tipo);
        $sForm->handleRequest($request);
        if ($sForm->isValid()) {
            $result->setStatus('PAGADO');
            $em->flush();
            return $this->redirect($this->generateUrl('pagos', array('tipo' => $tipo)));
        }

        return $this->render('FiscalizacionBundle:Pagos:form.html.twig', array(
            'form' => $sForm->createView(),
            'url'  => 'pagos_pagar',
            'id'   => $id
        ));
    }

    /**
     * Creates a form to create a Fiscalizacion entity.
     *
     * @param Fiscalizacion $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Pagos $entity, $id, $tipo)
    {
        $form = $this->createForm(new PagosType(), $entity, array(
            'action' => $this->generateUrl('pagos_pagar',
                        array(
                              'id' =>  $id,
                              'tipo' => $tipo
                        )
                    ),
            'method' => 'POST',
            'attr' => array('id' => 'formulario')

        ));
        return $form;
    }


}
