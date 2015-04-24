<?php
/*
 * 
 * @author Greicodex <info@greicodex.com> 
 * Realizar pagos (Multas, Aporte Mensual, etc)
 */

namespace Sunahip\FiscalizacionBundle\Controller;

use Sunahip\PagosBundle\Entity\Pagos;
use Sunahip\FiscalizacionBundle\Form\PagosType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class PagosController extends BaseController
{

     /**
     * Lists all Fiscalizacion entities.
     * @Security("has_role('ROLE_OPERADOR') or has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_GERENTE') or has_role('ROLE_SUPERINTENDENTE') or has_role('ROLE_COORDINADOR') or has_role('ROLE_ASESOR') ")
     */
    public function indexAction($tipo)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        
        $entities = $em->getRepository('PagosBundle:Pagos')->porUsuario($user, $tipo);

        $view = $user->hasRole('ROLE_GERENTE')? 'todos':'index';
        return $this->render("FiscalizacionBundle:Pagos:{$view}.html.twig", array(
            'entities' => $this->getPaginator($entities),
            'title'    => str_replace('_', ' ', $tipo),
            'tipo'    =>  $tipo
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
            $result->setStatus('POR VERIFICAR');
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
    
    /*
     * @Security("has_role('ROLE_GERENTE')")
     */
    public function validarAction(Request $request) {
        $form = $this->createImportForm();
        
        $form->handleRequest($request);
        if($form->isValid()) {            
            $file = $form['file']->getData();

            if (strtolower($file->getClientOriginalExtension()) === 'csv') {
                $em = $this->getDoctrine()->getManager();
                
                $csv = $file->openFile();
                $csv->fgetcsv(";");
                $cont=0;
                $total=0;
                while ($csv->valid()) {
                    $row = $csv->fgetcsv(";");
                    if(!empty($row[2])) {
                        $total++;
                        $pagos = $em->getRepository('PagosBundle:Pagos')->verificar($row[2]);
                        foreach ($pagos as $pago) {
                            $pago->setStatus("VERIFICADO");
                            $em->persist($pago);
                            $em->flush();
                            $cont++;
                        }
                    }
                }
                $this->get('session')->getFlashBag()->add('message', "Se han verificado ".$cont." pagos registrados en el sistema de un total de ".$total." pagos del archivo");
            }            
        }
        return $this->render('FiscalizacionBundle:Pagos:validar.html.twig', array(
            'form' => $form->createView(),
            
        ));
    }
    
    private function createImportForm() {
        return $this->createFormBuilder()
                ->setAction($this->generateUrl('pagos_validar'))
                ->setMethod('POST')
                ->setAttribute('enctype', 'multipart/form-data')
                ->add('file', 'file', array(
                    'required' => true,
                    'label' => 'Archivo', 
                    'attr' => array('class' => 'form-control')
                ))
                /*->add('submit', 'submit', array('label' => 'Procesar', 
                    'attr' => array('class' => 'btn btn-primary btn-sm')
                 ))*/
                ->getForm()
        ;
    }
    
    private function strtoDate($date){
        if (is_object($date) or is_null($date)) {return $date;}
        $dateE=str_replace("/","-",$date);
        return new \DateTime($dateE);
    }
}