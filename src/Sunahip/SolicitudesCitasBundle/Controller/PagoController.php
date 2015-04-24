<?php
/**
 * Description of PagoController
 *
 * class PagoController
 * @author 'Ing Carlos A Salzar <csalazart33@gmail.com>'
 * @author Greicodex <info@greicodex.com> 
 */

namespace Sunahip\SolicitudesCitasBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sunahip\PagosBundle\Entity\Pagos;
//use Sunahip\PagosBundle\Form\PagoType;
use Sunahip\FiscalizacionBundle\Form\PagosType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


/**
 *  PagoController
 */
class PagoController extends Controller
{
    /*
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity=$em->getRepository('PagosBundle:Pagos')->find($id);
        $form=$this->createEditForm($entity); 
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em->flush();
            //return new JsonResponse(array('status'=>'OK'), 200) ;
            return $this->render('SolicitudesCitasBundle:DataSolicitudes:List_pagosP_ed.html.twig', array(
                  'pago' =>$entity,
                  ));
        }
        return $this->render('SolicitudesCitasBundle:DataSolicitudes:List_pagosP_edf.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
    
    /**
     * 
     * @param type $id
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity=$em->getRepository('PagosBundle:Pagos')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Lo siento Ha ocurrido un error.');
        }
        $form=$this->createEditForm($entity);
        return $this->render('SolicitudesCitasBundle:DataSolicitudes:List_pagosP_edf.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));        
    }
    
    private function createEditForm(Pagos $entity)
    { 
        $form = $this->createForm(new PagosType(), $entity, array(
            'action' => $this->generateUrl('recaudospago_update',array('id' => $entity->getId())),
            'method' => 'POST',
            'attr'=>array('id'=>'form_pagosP'),
        ));
        $form->add('submit', 'submit', array(
            'label' => 'Actualizar',
            'attr'=>array('class'=>'btn_sig_sol btn '),
            ));

        return $form;
    }
    
    /*
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
     */
    public function newAction($idcl)
    {   $em = $this->getDoctrine()->getManager();
        $clasfL = $em->getRepository('LicenciaBundle:AdmClasfLicencias')->find($idcl);
        // Agregando el Recibo de pago de Procesamiento        
        $ut = intval($this->container->getParameter('unidad_tributaria'));
        $monto = $clasfL->getSolicitudUt() * $ut;
        $session = $this->getRequest()->getSession();
        $session->set('monto_pago', $monto);
        $pagos = new Pagos();
        $pagos->setMonto($monto);
        $form=$this->createCreateForm($pagos);
        return $this->render('SolicitudesCitasBundle:DataSolicitudes:List_pagosP_edf.html.twig', array(
            'entity' => $pagos,
            'form'   => $form->createView(),
            'nuevo'  =>true,
            'PP'=> number_format($monto,2,",","."),
        ));        
    }
    
    private function createCreateForm(Pagos $entity)
    { 
        $form = $this->createForm(new PagosType(), $entity, array(
            'action' => "#", 
            'method' => 'POST',
            'attr'=>array('id'=>'form_pagosP'),
        ));
        $form->add('submit', 'submit', array(
            'label' => 'Cargar',
            'attr'=>array('class'=>'btn_sig_sol btn '),
            ));
        return $form;
    }
    
    /*
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
     */
    public function createAction(Request $request, $ids)
    {   
        $pagos = new Pagos();
        $form=$this->createCreateForm($pagos);
        $form->handleRequest($request);
        if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $DS= $em->getRepository('SolicitudesCitasBundle:DataSolicitudes')->find($ids);
                // Si el pago existe Remover Pago
                if($DS->getPago()) {$this->removerPago($DS->getPago(), $em);} 
                // Agregando el Recibo de pago de Procesamiento        
                $ut = intval($this->container->getParameter('unidad_tributaria'));
                $monto = $DS->getClasLicencia()->getSolicitudUt() * $ut;
                $this->setPagoSolicitud($pagos,$DS->getOperadora(),$DS->getCentroHipico(),$monto, \Sunahip\CommonBundle\DBAL\Types\PaymentType::PROCESAMIENTO);
                $em->persist($pagos);
                $em->flush();
                $response['status']='OK';
                $response['datos']=array(
                    $pagos->getArchivoAdjunto()->getName(),
                    date_format($pagos->getFechaDeposito(), 'd/m/Y'),
                    $pagos->getNumReferencia(),
                    $pagos->getBanco()->getBanco(),
                    $pagos->getMonto(),
                );    
              return $this->render('SolicitudesCitasBundle:DataSolicitudes:List_pagosP_ed.html.twig', array(
                  'pago' =>$pagos,
                  ));
        }         
        return $this->render('SolicitudesCitasBundle:DataSolicitudes:List_pagosP_edf.html.twig', array(
            'entity' => $pagos,
            'form'   => $form->createView(),
            'nuevo'  =>true,
            'PP'=> number_format($monto,2,",","."),
        ));        
    }
    
    private function setPagoSolicitud($pago,$operadora,$centrohipico,$monto,$tipoPago){
         //$pago= new Pagos();
        $pago->setOperadora($operadora);
        $pago->setCentroHipico($centrohipico);
        $pago->setFechaCreacion(new \DateTime());
        $pago->setFechaProceso(new \DateTime());
        // Correccion de Fecha String to Fecha Object
        $pago->setFechaDeposito($this->strtoDate($pago->getFechaDeposito()));
        $pago->setMonto($monto);
        $pago->setStatus("POR VERIFICAR");
        $pago->setTipoPago($tipoPago);
        $pago->setUsuarioCreacion($this->getUser());
        $pago->setUsuarioPaga($this->getUser());
        //Fin Carga del Pago 
        //return $pago;
    }
    
     private function removerPago($pago, $em)
     {
         //$pago= new Pagos();
         $pago->setCentroHipico(null);
         $pago->setBanco(null);
         $pago->setOperadora(null);
         $pago->setSolicitud(null);
         $pago->setUsuarioCreacion(null);
         $pago->setUsuarioPaga(null);
         $em->flush();
         $em->remove($pago);
         $em->flush();
     }
    /**
     * String Date "DD/MM/YYYY" to Date object
     * @param string $date
     * @return \DateTime
     */
    private function strtoDate($date){
        //var_dump($date);
        if (is_object($date) or is_null($date)) {return $date;}
         $dateE=str_replace("/","-",$date);
          //$aDate=  explode("/", $date);
          return new \DateTime($dateE);
         // return new \DateTime($aDate[2]."-".$aDate[1]."-".$aDate[0]);
    }
   
   /*
    * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
    */
   public function showAction($ids)
    {   
        $em = $this->getDoctrine()->getManager();
        $DS= $em->getRepository('SolicitudesCitasBundle:DataSolicitudes')->find($ids);
        // Agregando el Recibo de pago de Procesamiento        
        return $this->render('SolicitudesCitasBundle:DataSolicitudes:List_pagosP_ed.html.twig', array(
                  'pago' =>$DS->getPago(),
                  ));
    }    
}
