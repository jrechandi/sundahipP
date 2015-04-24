<?php
/**
 * Controlador para Exportar a PDF
 * Controlador ExportPdf
 * Class ExportPdfController
 * @author Carlos Salazar <csalazart33@gmail.com>
 */
namespace Sunahip\ExportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ExportPdfController extends Controller
{

    /**
     * Responser Export a PDF
     * @param object $html
     * @return Object response PDF
     */
    private function exportPDF($html) 
        {   error_reporting(~E_STRICT);
            $mpdfService = $this->get('tfox.mpdfport');
            //$mpdfService->generatePdf($html);
            return $mpdfService->generatePdfResponse($html);
        }               
            
  
    public function operAfiliadosAction() 
    {   
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $securityContext = $this->container->get('security.context');
       if ($securityContext->isGranted('ROLE_GERENTE')){
         $entities = $em->getRepository("CentrohipicoBundle:DataOperadoraEstablecimiento")->findByAction( null,null );
       }else{$entities = $em->getRepository("CentrohipicoBundle:DataOperadoraEstablecimiento")->findByAction( $user->getId(),null );}
        $html = $this->renderView('ExportBundle:Operadoras:operafiliados.html.twig', array('entities'  => $entities));
        return $this->exportPDF($html);
    }

     public function gerenteOperListAction() 
    {
         error_reporting(~E_STRICT);
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('CentrohipicoBundle:DataOperadora')->findBy(array('esSucursal'=>false));
        $html = $this->renderView('ExportBundle:Operadoras:gerenteOperperadoras.html.twig', array('entities'  => $entities));
        $mpdfService = $this->get('tfox.mpdfport');
        //$mpdfService->generatePdf($html);
        return $mpdfService->generatePdfResponse($html);
    }
    
   public function LicenciasListAction($tipo) 
    {
        error_reporting(~E_STRICT);
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository("SolicitudesCitasBundle:DataSolicitudes")->findBy(array('status' => $tipo));
        $html = $this->renderView('ExportBundle:AdminCitas:listado.html.twig', array('entities'  => $entities,'aprob'=>false, 'tipo'=>$tipo));
        error_reporting(~E_STRICT);
        $mpdfService = $this->get('tfox.mpdfport');
        return $mpdfService->generatePdfResponse($html);
    }
    
   public function LicenciasListAprobAction() 
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository("SolicitudesCitasBundle:DataSolicitudes")->findBy( array("status" => "Aprobada") );
        $arrayEntity=array();
        foreach($entities as $entity){
            $solicitudApr = $em->getRepository("SolicitudesCitasBundle:DataSolicitudesAprob")->findOneBy(array('solicitud' => $entity->getId() ) );
            if($solicitudApr){
                $arrayEntity[] = $solicitudApr;
            }
         }
        $html = $this->renderView('ExportBundle:AdminLicencias:listado.html.twig', array('entities'  => $arrayEntity,'aprob'=>true));
        //$html = $this->renderView('ExportBundle:AdminCitas:listado.html.twig', array('entities'  => $entities,'aprob'=>true));
         error_reporting(~E_STRICT);
        $mpdfService = $this->get('tfox.mpdfport');
        return $mpdfService->generatePdfResponse($html);
    }

   public function ProvidenciaListAction() 
    {
        error_reporting(~E_STRICT);
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('FiscalizacionBundle:Providencia')->byRol($this->get('security.context'));
        $html = $this->renderView('ExportBundle:Providencia:index.html.twig', array('entities'  => $entities));
        $mpdfService = $this->get('tfox.mpdfport');
        //$mpdfService->generatePdf($html);
        return $mpdfService->generatePdfResponse($html);
    }
   
    public function FiscalesListAction() 
    {
        error_reporting(~E_STRICT);
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('UserBundle:SysUsuario')->findByRole('ROLE_FISCAL');
        $html = $this->renderView('ExportBundle:Fiscal:list.html.twig', array('entities'  => $entities));
        $mpdfService = $this->get('tfox.mpdfport');
        return $mpdfService->generatePdfResponse($html);
    }
    
    /**
     * Listado de Pagos.
     * @param type $tipo
     * @return type
     */
    public function PagosListAction($tipo)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('PagosBundle:Pagos')->porUsuario($user, $tipo);
        $view = $user->hasRole('ROLE_GERENTE')? 'todos':'index';
        error_reporting(~E_STRICT);
        $html = $this->renderView("ExportBundle:Pagos:{$view}.html.twig", array(
            'entities' => $entities,
            'title'    => str_replace('_', ' ', $tipo)
        ));
        $mpdfService = $this->get('tfox.mpdfport');
        return $mpdfService->generatePdfResponse($html);
    }

    /**
     * Listado de citas 
     * @return type
     */
    public function CitasListAction() 
    {
        error_reporting(~E_STRICT);
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('SolicitudesCitasBundle:DataSolicitudes')->findAll();
        $html = $this->renderView('ExportBundle:Citas:index.html.twig', array(
            'entities' => $entities,
        ));
        $mpdfService = $this->get('tfox.mpdfport');
        return $mpdfService->generatePdfResponse($html);
    }
    
    /**
     * Fiscalizaciones Export PDF
     * @return type
     */
    public function FiscalizacionListAction($tipo) 
    {
        error_reporting(~E_STRICT);
        $em = $this->getDoctrine()->getManager();
        if($tipo==='todos'){
         $entities = $em->getRepository('FiscalizacionBundle:Fiscalizacion')->todos($this->get('security.context'));
         $view='index';
        }elseif($tipo=='citados'){
          $entities = $em->getRepository('FiscalizacionBundle:Fiscalizacion')->citados($this->get('security.context'));
          $view='citados';
        }elseif($tipo=='multados'){
         $entities = $em->getRepository('FiscalizacionBundle:Fiscalizacion')->multados($this->get('security.context'));
         $view='multados';
        }
        
        $html = $this->renderView("ExportBundle:Fiscalizacion:{$view}.html.twig", array('entities' => $entities));
        $mpdfService = $this->get('tfox.mpdfport');
        return $mpdfService->generatePdfResponse($html);
    }
}
