<?php

/*
 * @author Greicodex <info@greicodex.com> 
 */

namespace Sunahip\ReporteBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sunahip\ReporteBundle\Service\ReporteService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ReporteController extends Controller {

    /**
     * @Route("/{reporte}/xmes", name="informe_xmes")
     * @Template()
     * @Security("has_role('ROLE_GERENTE') or has_role('ROLE_SUPERINTENDENTE') or has_role('ROLE_COORDINADOR') or has_role('ROLE_ASESOR') ")
     */ 
    public function reportePorMesAction(Request $request, $reporte) {
        $tipo = $request->get('tipo');
        $anio = $request->get('anio');
        $mes = $request->get('mes');
        $desde = $request->get('desde');
        $hasta = $request->get('hasta');
        $status = $request->get('status');
        $em = $this->getDoctrine()->getManager();
        $srv = new ReporteService($em);
        $data = array();

        date_default_timezone_set('UTC');
        if(!isset($anio))
        {
            $anio =  date("Y");
        }

        if(!isset($mes))
        {
            $mes =  date("m");
        }

        switch ($reporte){
            case 'licencias':
                $tituloReporte = 'Informe de Licencias por Mes';

                $encab = array(
                    'descripcion' => 'Status',
                    'cantidad' => 'Cantidad de Licencias',
                    'porcentaje' => 'Porcentaje'
                );

                if(isset($anio)){
                    $data = $srv->getDataLicencia($anio, $mes, null, $desde, $hasta, $status);
                }
                break;

            case 'fiscalizaciones':
                $tituloReporte = 'Informe de Fiscalizaciones por Mes';

                $encab = array(
                    'descripcion' => 'Status',
                    'cantidad' => 'Cantidad',
                    'porcentaje' => 'Porcentaje'
                );

                if(isset($anio)){
                    $data = $srv->getDataFiscalizacion($anio, $mes, null, $desde, $hasta, $status);
                }
                break;

            case 'ingresos':
                $tituloReporte = 'Informe de Ingresos por Mes';

                $encab = array(
                    'descripcion' => 'Ingresos por Concepto',
                    'cantidad' => 'Cantidad de Ingresos (Bs)',
                    'porcentaje' => 'Porcentaje'
                );

                if(isset($anio)){
                    $data = $srv->getDataIngreso($anio, $mes, null, $desde, $hasta, $status);
                }
                break;

            case 'usuarios':
                $tituloReporte = 'Informe de Usuarios por Mes';

                $encab = array(
                    'descripcion' => 'Status',
                    'cantidad' => 'Cantidad de Usuarios',
                    'porcentaje' => 'Porcentaje'
                );

                if(isset($anio)){
                    $data = $srv->getDataUsuario($anio, $mes, null, $desde, $hasta, $status);
                }
                break;
        }
        
        return array(
            'reporte' => $reporte,
            'tipo' => $tipo,
            'anio' => $anio,
            'mes' => $mes,
            'desde' => $desde,
            'hasta' => $hasta,
            'status' => $status,
            'tituloReporte' => $tituloReporte,
            'encabezado' => json_encode($encab),
            'data' => json_encode($data),
        );
    }
    
    
    /**
     * @Route("/{reporte}/xanio", name="informe_xanio")
     * @Template("ReporteBundle:Reporte:reportePorAnio.html.twig")
     * @Security("has_role('ROLE_GERENTE') or has_role('ROLE_SUPERINTENDENTE') or has_role('ROLE_COORDINADOR') or has_role('ROLE_ASESOR') ")
     */ 
    public function reportePorAnioAction(Request $request, $reporte) {
        $tipo = $request->get('tipo');
        $anio = $request->get('anio');
        $status = $request->get('status');
        $em = $this->getDoctrine()->getManager();
        $srv = new ReporteService($em);
        $data = array();

        date_default_timezone_set('UTC');
        if(!isset($anio))
        {
            $anio =  date("Y");
        }
        
        switch ($reporte){
            case 'licencias':
                $tituloReporte = 'Informe de Licencias por Año';
                
                $encab = array(
                    'cantidad' => 'Cantidad de Licencias',
                    'porcentaje' => 'Porcentaje'
                );

                $data = $srv->getDataLicenciaAnual($anio, $status);
                break;
            
            case 'fiscalizaciones':
                $tituloReporte = 'Informe de Fiscalizaciones por Año';
                
                $encab = array(
                    'cantidad' => 'Cantidad de Fiscalizaciones',
                    'porcentaje' => 'Porcentaje'
                );
                
                $data = $srv->getDataFiscalizacionAnual($anio, $status);
                break;
            
            case 'ingresos':
                $tituloReporte = 'Informe de Ingresos por Año';
                
                $encab = array(
                    'cantidad' => 'Cantidad de Ingresos (Bs)',
                    'porcentaje' => 'Porcentaje'
                );

                $data = $srv->getDataIngresoAnual($anio, $status);
                break;
            
            case 'usuarios':
                $tituloReporte = 'Informe de Usuarios por Año';
                
                $encab = array(
                    'cantidad' => 'Cantidad de Usuarios',
                    'porcentaje' => 'Porcentaje'
                );

                $data = $srv->getDataUsuarioAnual($anio, $status);
                break;
        }

        return array(
            'reporte' => $reporte,
            'tipo' => $tipo,
            'anio' => $anio,
            'status' => $status,
            'tituloReporte' => $tituloReporte,
            'encabezado' => json_encode($encab),
            'data' => json_encode($data)
        );
    }


    /**
     * @Route("/{reporte}/xestado", name="informe_xestado")
     * @Template("ReporteBundle:Reporte:reportePorEstado.html.twig")
     * @Security("has_role('ROLE_GERENTE') or has_role('ROLE_SUPERINTENDENTE') or has_role('ROLE_COORDINADOR') or has_role('ROLE_ASESOR') ")
     */ 
    public function reportePorEstadoAction(Request $request, $reporte) {
        $tipo = $request->get('tipo');
        $anio = $request->get('anio');
        $mes = $request->get('mes');
        $dia = $request->get('dia');
        $status = $request->get('status');
        $desde = $request->get('desde');
        $hasta = $request->get('hasta');
        $em = $this->getDoctrine()->getManager();
        $srv = new ReporteService($em);
        $data = array();

        date_default_timezone_set('UTC');
        if(!isset($anio))
        {
            $anio =  date("Y");
        }

        if(!isset($mes))
        {
            $mes =  date("m");
        }
        
        switch ($reporte){
            case 'licencias':
                $tituloReporte = 'Informe de Licencias por Estado';
                
                $encab = array(
                    'cantidad' => 'Cantidad de Licencias',
                    'porcentaje' => 'Porcentaje'
                );

                $data = $srv->getDataLicenciaPorEstado($anio, $mes, $dia, $desde, $hasta, $status);
                break;
            
            case 'fiscalizaciones':
                $tituloReporte = 'Informe de Fiscalizaciones por Estado';
                
                $encab = array(
                    'cantidad' => 'Cantidad de Fiscalizaciones',
                    'porcentaje' => 'Porcentaje'
                );
                
                $data = $srv->getDataFiscalizacionPorEstado($anio, $mes, $dia, $desde, $hasta, $status);
                break;
            
            case 'ingresos':
                $tituloReporte = 'Informe de Ingresos por Estado';
                
                $encab = array(
                    'cantidad' => 'Cantidad de Ingresos (Bs)',
                    'porcentaje' => 'Porcentaje'
                );

                $data = $srv->getDataIngresoPorEstado($anio, $mes, $dia, $desde, $hasta, $status);
                break;
            
            case 'usuarios':
                $tituloReporte = 'Informe de Usuarios por Estado';
                
                $encab = array(
                    'cantidad' => 'Cantidad de Usuarios',
                    'porcentaje' => 'Porcentaje'
                );

                $data = $srv->getDataUsuarioPorEstado($anio, $mes, $dia, $desde, $hasta, $status);
                break;
        }

        return array(
            'reporte' => $reporte,
            'tipo' => $tipo,
            'anio' => $anio,
            'mes' => $mes,
            'dia' => $dia,
            'hasta' => $hasta,
            'desde' => $desde,
            'status' => $status,
            'tituloReporte' => $tituloReporte,
            'encabezado' => json_encode($encab),
            'data' => json_encode($data)
        );
    }


    /**
     * @Route("/ejecutivo", name="informe_ejecutivo")
     * @Template()
     * @Security("has_role('ROLE_GERENTE') or has_role('ROLE_SUPERINTENDENTE') or has_role('ROLE_COORDINADOR') or has_role('ROLE_ASESOR') ")
     */
    public function ejecutivoAction() {
        return array(
                // ...
        );
    }
    
    /**
     * @Route("/ejecutivo/imprimir", name="imprimir_ejecutivo")
     * @Template()
     * @Security("has_role('ROLE_GERENTE') or has_role('ROLE_SUPERINTENDENTE') or has_role('ROLE_COORDINADOR') or has_role('ROLE_ASESOR') ")
     */
    public function imprimirEjecutivoAction(Request $request) {
        $anio = $request->get('anio');
        $mes = $request->get('mes');
        $dia = $request->get('dia');
        $em = $this->getDoctrine()->getManager();
        $srv = new ReporteService($em);

        date_default_timezone_set('UTC');
        if(!isset($anio))
        {
            $anio =  date("Y");
        }

        if(!isset($mes))
        {
            $mes =  date("m");
        }

        $data = $srv->getDataEjecutivo($anio, $mes, $dia);

        $mesNombre = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');

        $response = array(
            'dia' => $dia,
            'mes' => $mesNombre[$mes-1],
            'anio' => $anio,
            'data' => json_encode($data)
        );
        
        return $this->render('ReporteBundle:Reporte:imprimirEjecutivo.html.twig', $response);
        /*
        $html = $this->renderView('ReporteBundle:Reporte:imprimirEjecutivo.html.twig', $response);
        
        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html, 
                array(  'orientation' => 'landscape',
                        'page-height' => 279,
                        'page-width' => 219,
                        'encoding' => 'utf-8',
                        'cookie' => array(),
            )),
            200, array('Content-Type' => 'application/pdf')
        );*/
        
    }

}
