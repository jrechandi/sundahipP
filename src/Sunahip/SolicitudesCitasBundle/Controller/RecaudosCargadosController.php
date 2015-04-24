<?php
/**
 * Description of DataRecaudosCargadosController
 *
 * class DataRecaudosCargadosController
 * @author 'Ing Carlos A Salzar <csalazart33@gmail.com>'
 * @author Greicodex <info@greicodex.com> 
 */

namespace Sunahip\SolicitudesCitasBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sunahip\SolicitudesCitasBundle\Entity\DataRecaudosCargados;
use Sunahip\SolicitudesCitasBundle\Form\DataRecaudosCargadosType;
use Sunahip\SolicitudesCitasBundle\Form\RecaudosCType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 *  RecaudosCargadosController
 */
class RecaudosCargadosController extends Controller
{
    /*
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity=$em->getRepository('SolicitudesCitasBundle:DataRecaudosCargados')->find($id);
        $form=$this->createEditForm($entity); 
        $form->handleRequest($request);
          $errors=false;
        if ($form->isValid()) {
            $entity->setStatus("Por Revisar");
            $em->flush();
            $response=new \Symfony\Component\HttpFoundation\JsonResponse(array('status'=>'OK'), 200) ;
            return $response;
        } else {
            $errors=$form->getErrors();
        }
        return $this->render('SolicitudesCitasBundle:DataSolicitudes:List_recaudos_edf.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'errors'=>$errors,
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
        $entity=$em->getRepository('SolicitudesCitasBundle:DataRecaudosCargados')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Lo siento Ha ocurrido un error.');
        }
        $form=$this->createEditForm($entity);
        return $this->render('SolicitudesCitasBundle:DataSolicitudes:List_recaudos_edf.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));        
    }
    
    private function createEditForm(DataRecaudosCargados $entity)
    { 
        $form = $this->createForm(new DataRecaudosCargadosType(), $entity, array(
            'action' => $this->generateUrl('recaudoscargados_update',array('id' => $entity->getId())),
            'method' => 'POST',
            'attr'=>array('id'=>'form_drecaudos'),
        ));
        $form->add('submit', 'submit', array(
            'label' => 'Actualizar',
            'attr'=>array('class'=>'btn_sig_sol btn '),
            ));

        return $form;
    }
    
    /**
     * 
     * @param type $id
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
     */
    public function newAction($id)
    {   $em = $this->getDoctrine()->getManager();
        $recaudoLicencia = $em->getRepository('LicenciaBundle:AdmRecaudosLicencias')->find($id);
         $form=$this->createCreateForm(new DataRecaudosCargados());
        return $this->render('SolicitudesCitasBundle:DataSolicitudes:List_recaudos_edf3.html.twig', array(
            'form'   => $form->createView(),
            'recaudoLicencia' =>$recaudoLicencia,
        ));        
    }
    
    
    private function createCreateForm(DataRecaudosCargados $entity)
    { 
        $form = $this->createForm(new DataRecaudosCargadosType(), $entity, array(
            'action' => "#",//$this->generateUrl('recaudoscargados_add'),
            'method' => 'POST',
            'attr'=>array('id'=>'form_drecaudos'),
        ));
        $form->add('submit', 'submit', array(
            'label' => 'Actualizar',
            'attr'=>array('class'=>'btn_sig_sol btn '),
            ));

        return $form;
    }
    /**
     * Creates a new RecaudosCargados.
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
     */
    public function createAction(Request $request, $rlid, $ids)
    {
        $entity = new DataRecaudosCargados();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

            $em = $this->getDoctrine()->getManager();
            $entity->setRecaudoLicencia($em->getRepository('LicenciaBundle:AdmRecaudosLicencias')->find($rlid));
             $fecha=$entity->getFechaVencimiento()?$entity->getFechaVencimiento():$this->strtoDate($entity->getFechaVencimiento());
             $entity->setFechaVencimiento($fecha);
             $entity->setSolicitud($em->getRepository('SolicitudesCitasBundle:DataSolicitudes')->find($ids));
            $entity->setStatus("Por Revisar");
            $em->persist($entity);
            $em->flush();
            $response['status']='OK';
            $response['datos']=array(
                $entity->getRecaudoLicencia()->getRecaudo(),
                $entity->getMediarecaudo()->getName(),
                $entity->getFechaVencimiento()?date_format($entity->getFechaVencimiento(), 'd/m/Y'):'None'
                );
        return new JsonResponse($response);
    }
    
    /*
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
     */
    public function removeRecaudosAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $DSE = $em->getRepository('SolicitudesCitasBundle:DataSolicitudes')->find($id);
        //$recaudos = $em->getRepository('SolicitudesCitasBundle:DataRecaudosCargados')->findBy(array('solicitud'=>$id));
        foreach($DSE->getRecaudoscargados() as $recaudo){
           $recaudo->setSolicitud(null); $em->remove($recaudo);
         }
        $em->flush();
        return new Response('Eliminado');
    }   
    
    /*
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
     */
   public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('SolicitudesCitasBundle:DataSolicitudes')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar La Solicitud o Exite un problema con la Base de Datos <br>Disculpe las Molestias Reintente mas Tarde.');
        }       
        return $this->render('SolicitudesCitasBundle:DataSolicitudes:List_recaudos_ed.html.twig', array(
            'entity' => $entity
        ));
    }
    
    /*
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR') or  has_role('ROLE_GERENTE')")
     */
   public function newRecaudosAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('SolicitudesCitasBundle:DataSolicitudes')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar La Solicitud o Exite un problema con la Base de Datos <br>Disculpe las Molestias Reintente mas Tarde.');
        }       
        return $this->render('SolicitudesCitasBundle:DataSolicitudes:List_recaudos_ed.html.twig', array(
            'entity' => $entity
        ));
    }
    
    /**
     * String Date "DD/MM/YYYY" to Date object
     * @param string $date
     * @return \DateTime
     */
    private function strtoDate($date){
        if (is_object($date) or is_null($date)) {return $date;}
         $dateE=str_replace("/","-",$date);
          //$aDate=  explode("/", $date);
          return new \DateTime($dateE);
         // return new \DateTime($aDate[2]."-".$aDate[1]."-".$aDate[0]);
    }
}
