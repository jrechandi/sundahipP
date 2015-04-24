<?php

/*
 * 
 * @author Greicodex <info@greicodex.com> 
 * Generador de PDFs de las fiscalizaciones
 */

namespace Sunahip\FiscalizacionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Sunahip\FiscalizacionBundle\Form\VerificacionType;
use Sunahip\FiscalizacionBundle\Form\RetencionType;
use Sunahip\FiscalizacionBundle\Form\CitacionType;
use Sunahip\FiscalizacionBundle\Form\MercantilType;

use Sunahip\FiscalizacionBundle\Entity\Verificacion;
use Sunahip\FiscalizacionBundle\Entity\Retencion;
use Sunahip\FiscalizacionBundle\Entity\Citacion;
use Sunahip\FiscalizacionBundle\Entity\Mercantil;

class PDFController extends Controller
{


        /**
     * Creates a form to create a Fiscalizacion entity.
     *
     * @param Fiscalizacion $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createTypeForm($type, $e)
    {
        $form = $this->createForm($type, $e, array(
            'method' => 'POST'
        ));
        return $form;
    }

    /*
        @Security("has_role('ROLE_GERENTE') or has_role('ROLE_FISCAL')")
     */
    public function verificacionAction(Request $request, $id)
    {
        $r = $this->registro($id, 'verificacion');
        if($r) return $r;
        return $this->documento(
            $request, $id, 'verificacion', new Verificacion(), new VerificacionType());
    }

    /*Verifica si hay registro y en caso de no haberlo
    de el form*/
    protected function registro($id, $tipo){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FiscalizacionBundle:Fiscalizacion')->find($id);
        $centro = $entity->getCentro();
        $form = $this->createTypeForm(new MercantilType(), new Mercantil());
        if($centro->getRegistro() == NULL){
            return $this->render('FiscalizacionBundle:PDF:form.html.twig', array(
                'form'   => $form->createView(),
                'id'   => $id,
                'creado' => false,
                'type'   => false,
                'auto'  => isset($auto),
                'url' =>  $this->generateUrl('pdf_mercantil', array('id'=>$id,'type'=>$tipo))
            ));
        }
    }

    /**
     * Guarda el registro mercantil
     */
    public function mercantilAction(Request $request, $id, $type)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FiscalizacionBundle:Fiscalizacion')->find($id);
        $centro = $entity->getCentro();
        $registro = new Mercantil();
        $form = $this->createTypeForm(new MercantilType(), $registro);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $centro->setRegistro($registro);
            $em->persist($registro);
            $em->persist($centro);
            $em->flush();
            return $this->redirect($this->generateUrl("pdf_$type", array('id' => $id)));
        }
        return $this->render('FiscalizacionBundle:PDF:form.html.twig', array(
                'form'   => $form->createView(),
                'id'   => $id,
                'creado' => false,
                'type'   => false,
                'auto'  => isset($auto),
                'url' =>  $this->generateUrl('pdf_mercantil', array('id'=>$id,'type'=>$type))
        ));
    }




    public function aceptacionAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FiscalizacionBundle:Fiscalizacion')->find($id);
        return $this->renderPDF('aceptacion', array(
            'entity' => $entity,
        ));
    }

    /*
        @Security("has_role('ROLE_GERENTE') or has_role('ROLE_FISCAL')")
     */
    public function citacionAction(Request $request, $id)
    {
        return $this->documento(
                $request, $id, 'citacion', new Citacion(), new CitacionType(),
                function($e){$e->setEstatus('Citado');}
        );
    }

    /*
        @Security("has_role('ROLE_GERENTE') or has_role('ROLE_FISCAL')")
     */
    public function retencionAction(Request $request, $id)
    {
        return $this->documento($request, $id, 'retencion', new Retencion(), new RetencionType());
    }

    protected function documento(Request $request, $id, $type, $ent, $form, $after=null)
    {
        $em = $this->getDoctrine()->getManager();
        $repo   = ucfirst($type);
        $entity = $em->getRepository('FiscalizacionBundle:Fiscalizacion')->find($id);
        $datos  = $em->getRepository("FiscalizacionBundle:$repo")->findOneByFiscalizacion($entity);
        /*Se ha creado?*/
        $creado  = !is_null($datos);
        /*Evita el null*/
        $datos   = is_null($datos) ? $ent:$datos;  
        $form = $this->createTypeForm($form, $datos);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $datos->setFiscalizacion($entity);
            if(is_callable($after)){
                $after($entity);
            }
            $em->persist($entity);
            $em->persist($datos);
            $em->flush();
            $creado = true;
            $auto = true;
        }
        return $this->render('FiscalizacionBundle:PDF:form.html.twig', array(
            'form'   => $form->createView(),
            'id'   => $id,
            'creado' => $creado,
            'type'   => $type,
            'auto'   => isset($auto),
            'url'    => $this->generateUrl("pdf_$type", array('id'=>$id))
        ));
    }


    public function showAction($id, $type){
        $em = $this->getDoctrine()->getManager();
        $repo   = ucfirst($type);
        $entity = $em->getRepository('FiscalizacionBundle:Fiscalizacion')->find($id);
        $datos  = $em->getRepository("FiscalizacionBundle:$repo")->findOneByFiscalizacion($entity);
        $juegos = $em->getRepository("LicenciaBundle:AdmJuegosExplotados")->findBy(array('status'=>1));
        if ($datos) {
            return  $this->renderPDF($type, array(
                'entity' => $entity,
                'data' => $datos,
                'juegos' => $juegos
            ));
        }else{
            return new Response("No existe acta de $type generada");
        }

    }

    protected function renderPDF($tpl, Array $args)
    {
        /*No remover. Si se quita y está activado el reporting error en ALL
        Salta una advertencia y no genera el PDF*/
        error_reporting(~E_STRICT);
        $html = $this->renderView("FiscalizacionBundle:PDF:{$tpl}.html.twig",$args);
        $mpdfService = $this->get('tfox.mpdfport');
        return $mpdfService->generatePdfResponse($html);
    }
}
