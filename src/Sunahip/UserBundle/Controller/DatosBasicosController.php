<?php
/**
 * Controler:   Registro Usuario
 *
 * @package     Sunahip
 * @subpackage  User
 * @author      Reynier Perez Mira <reynierpm@gmail.com>
 */

namespace Sunahip\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sunahip\UserBundle\Form\ExtraPerfilType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DatosBasicosController extends Controller
{

    /**
     * @Route("/editar/datos-basicos", name="editar-datos-basicos")
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR')")
     * @Template()
     */
    public function editDatosBasicosAction()
    {
        $em = $this->getDoctrine()->getManager();
        $id = $this->getUser()->getId();
        $entity = $em->getRepository('UserBundle:SysPerfil')->findOneBy(array("user" => $id));
        if(count($entity->getEstado())>0){
            $idEstado = $entity->getEstado()->getId();
        }else{
            $idEstado = null;
        }

        if(count($entity->getMunicipio())>0){
            $idMunicipio = $entity->getMunicipio()->getId();
        }else{
            $idMunicipio  = null;
        }

        if(count($entity->getParroquia())>0){
            $idParroquia = $entity->getParroquia()->getId();
        }else{
            $idParroquia = null;
        }
        $form = $this->createForm(new ExtraPerfilType($idEstado,$idMunicipio, $idParroquia), $entity, array('action' => $this->generateUrl('guardar-datos-basicos')));
        return array('entity' => $entity, 'form' => $form->createView(),'idEstado' => $idEstado);
    }
    
    
    /**
     * @Route("/datos-basicos", name="datos-basicos")
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR')")
     * @Template()
     */
    public function datosBasicosAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        return array('entity' => $user);
    }

    /**
     * @Route("/datos-basicos/guardar", name="guardar-datos-basicos")
     * @Method("POST")
     * @Template("UserBundle:DatosBasicos:editDatosBasicos.html.twig")
     */
    public function guardarAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        //$id = $this->getUser()->getId();
        $entityProfile = $em->getRepository('UserBundle:SysPerfil')->findOneBy(array("user" => $this->getUser()));
        if(count($entityProfile->getEstado())>0){
            $idEstado = $entityProfile->getEstado()->getId();
        }else{
            $idEstado = null;
        }
        if(count($entityProfile->getMunicipio())>0){
            $idMunicipio= $entityProfile->getMunicipio()->getId();
        }else{
            $idMunicipio  = null;
        }
        if(count($entityProfile->getParroquia())>0){
            $idParroquia = $entityProfile->getParroquia()->getId();
        }else{
            $idParroquia = null;
        }
        $formProfile = $this->createForm(new ExtraPerfilType($idEstado,$idMunicipio, $idParroquia), $entityProfile);
        $formProfile->handleRequest($request);

       // $data = $request->get('extra_user_profile');

        /*
        YA ESTA PARTE NO ES NECESARIA
        CON LA NUEVA IMPLEMENTACIÓN DEL FORMULARIO
        (Alberto)

         
       if($idEstado != ""){
            $idMunicipio = $data['municipio'];
            //$ciudad = $data['ciudad'];
           $idParroquia = $data['parroquia'];
       }else{
            $municipio = $formProfile->get('municipio');
            //$ciudad = $request->get('ciudad');
            $parroquia = $request->get('parroquia');
        }
            //var_dump($municipio);die;
//        if ($formProfile->isValid()) {
            $municipio = $em->getRepository('CommonBundle:SysMunicipio')->find($idMunicipio);
            $parroquia = $em->getRepository('CommonBundle:SysParroquia')->find($idParroquia);
            //$ciudad = $em->getRepository('CommonBundle:SysCiudad')->find($ciudad);
            //$entityProfile->setUrbanizacion($request->get('urbanizacion'));
            if ($municipio) {
                $entityProfile->setMunicipio($municipio);
            }
            if ($parroquia) {
                $entityProfile->setParroquia($parroquia);
            }
        }*/
            // Ciudad a Mayusculas. para combinar con estados municipio parroquia
            $entityProfile->setCiudad(strtoupper($entityProfile->getCiudad()));
//            if ($ciudad) {
//                $entityProfile->setCiudad($ciudad);
//            }
            $em->persist($entityProfile);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                   'success',
                   'Datos Básicos Actualizados.'
               );
            return $this->redirect($this->generateUrl('datos-basicos'));
//        }
//        else {
//            $errors = $this->getFormErrors($formProfile);
//        }
        return array('entity' => $entityProfile, 'form' => $formProfile->createView(), 'errors' => $errors, 'idEstado' => $idEstado);
    }

    /**
     * Obtiene todos los errores del formulario
     *
     * @param  \Symfony\Component\Form\Form $form
     * @return array
     */
    private function getFormErrors(\Symfony\Component\Form\Form $form)
    {
        $errors = array();

        foreach ($form->getErrors() as $key => $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = $this->getFormErrors($child);
            }
        }

        return $errors;
    }

}
