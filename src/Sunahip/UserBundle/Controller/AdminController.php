<?php
/**
 * Controler:   Administracion de Usuarios
 *
 * @package     Sunahip
 * @subpackage  User
 * @author      Reynier Perez Mira <reynierpm@gmail.com>
 */

namespace Sunahip\UserBundle\Controller;

use Sunahip\UserBundle\Form\EditarPerfilUsuarioType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Sunahip\UserBundle\Entity\SysUsuario;
use Sunahip\UserBundle\Form\AdminUsuarioType;
use Sunahip\UserBundle\Entity\SysPerfil;
use Sunahip\UserBundle\Form\EditarUsuarioType;
use Symfony\Component\Form\FormError;
use Sunahip\CommonBundle\DBAL\Types\RoleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AdminController extends Controller
{

    /**
     * @Route("/listado", name="listado")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function listadoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $keyword = $request->get('keyword');
        $role = $request->get('role');

        $entities = $em->getRepository("UserBundle:SysUsuario")->findByAction($keyword, $role);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities,
            $this->get('request')->query->get('page', 1) /*page number*/,
            10
        );

        return array('usuarios' => $pagination, 'roles' => RoleType::getChoices());
    }

    /**
     * @Route("/listado_json", name="listado_json")
     */
    public function listadoJsonAction()
    {
        $userManager = $this->get('fos_user.user_manager');
        $usuarios = $userManager->findUsers();

        $response = array();

        foreach ($usuarios as $usuario) {
            $userArr = array();
            $userArr['id'] = $usuario->getId();
            $userArr['nombre'] = $usuario->getPerfil()[0]->getNombre();

            $array_usuarios[] = $userArr;
        }

        $response['data'] = $array_usuarios;
        return new JsonResponse($response);
    }

    /**
     * @Route("/nuevo-usuario", name="nuevo-usuario")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function nuevoUsuarioAction()
    {
        $entity = new SysUsuario();
        $form = $this->createForm(new AdminUsuarioType(), $entity, array('action' => $this->generateUrl('guardar-nuevo-usuario')));
        return array('entity' => $entity, 'form' => $form->createView());
    }

    /**
     * @Route("/nuevo-usuario/guardar", name="guardar-nuevo-usuario")
     * @Method("POST") 
     * @Template("UserBundle:Admin:nuevoUsuario.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function guardarAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->container->get('fos_user.user_manager');

        $user = $userManager->createUser();

        $entity = new SysUsuario();
        $form = $this->createForm(new AdminUsuarioType(), $entity);
        $form->handleRequest($request);

        $user_data = $request->get('user_register');
        $profile_data = $request->get('user_register')['perfil'];

        
        $usuario = $profile_data['persJuridica'] . $profile_data['rif'];
        /*arregla el bug del duplicate*/
        $hay  = $em->getRepository("UserBundle:SysUsuario")->findByUsername($usuario);
        if($hay){
           $form->get('perfil')->addError(new FormError('RIF ya registrado'));
        } else {
            $hay = $userManager->findUserByEmail($user_data['email']);
            if($hay){
               $form->get('perfil')->addError(new FormError('Email ya registrado'));
            }
        }

        if ($form->isValid()) {
            $user->setUsername($usuario);
            $user->setEmail($user_data['email']);
            $user->setPlainPassword($user_data['password']);
            $user->setFullname($profile_data['nombre'] . " " . $profile_data['apellido']);

            $enabled = isset($user_data['enabled']) ? true : false;
            $user->setEnabled($enabled);

            $role = $profile_data['roleType'];
            $user->addRole($role);

            $userManager->updateUser($user);

            $profile = new SysPerfil();
            $profile->setPersJuridica($profile_data['persJuridica']);
            $profile->setRif($profile_data['rif']);

            $ci = isset($profile_data['ci']) ? $profile_data['ci'] : null;
            if ($ci != NULL) {
                $profile->setCi($profile_data['ci']);
            }

            $profile->setNombre($profile_data['nombre']);
            $profile->setApellido($profile_data['apellido']);
            $profile->setRoleType($profile_data['roleType']);
            $profile->setUser($user);

            $em->persist($profile);
            $em->flush();

            $this->get('session')->getFlashBag()->add('message', "El usuario se ha creado satisfactoriamente");
            return $this->redirect($this->generateUrl('listado'));
        }
        else {
            $errors = $this->getFormErrors($form);
        }
        return array('entity' => $entity, 'form' => $form->createView());
        //return new JsonResponse(array('status' => true, 'errors' => $errors));
    }

    /**
     * @Route("/editar-usuario/{user_id}", name="editar-usuario")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editarUsuarioAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $request->get('user_id');

        if(!$id)
            $id = $request->get('id');

        $entity = $em->getRepository('UserBundle:SysUsuario')->findOneby(array('id' => $id) );

        if (!$entity) {
            throw $this->createNotFoundException('El usuario que está tratando de editar no existe.');
        }else{
            $entityP = $entity->getPerfil()[0];
            $form = $this->createForm(new EditarUsuarioType(), $entity, array('action' => $this->generateUrl('actualizar-usuario', array('user_id' => $id) ) ) );
            $formPerfil = $this->createForm(new EditarPerfilUsuarioType(), $entityP);
            return array('entity' => $entity, 'form' => $form->createView(), 'form_perfil' => $formPerfil->createView());
        }

    }

    /**
     * @Route("/actualizar-usuario/{user_id}", name="actualizar-usuario")
     * @Method("POST")
     * @Template("UserBundle:Admin:editarUsuario.html.twig")
     * @todo Fix view when errors are returned
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function actualizarUsuarioAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $request->get('user_id');
        $entity = $em->getRepository('UserBundle:SysUsuario')->findOneby(array('id' => $id) );
        $entityP = $entity->getPerfil()[0];
        $data = $request->get('user_edit');
        $dataPerfil = $request->get('user_profile_edit');

        $form = $this->createForm(new EditarUsuarioType(), $entity);
        $formPerfil = $this->createForm(new EditarPerfilUsuarioType(), $entityP);

        $form->handleRequest($request);
        $formPerfil->handleRequest($request);

        if ($form->isValid() && $formPerfil->isValid()) {
            if(strlen($data['password'])>5){
                $entity->setPlainPassword($data['password']);
            }
            $entity->setFullname($dataPerfil['nombre'] . " " . $dataPerfil['apellido']);
            $enabled = isset($data['enabled']) ? true : false;
            $entity->setEnabled($enabled);

            $role = $dataPerfil['roleType'];
            $entity->addRole($role);

            $em->persist($entity);
            $em->flush();
            //$entityP->setPersJuridica($entityP->getPersJuridica());
            //$entityP->setRif($entityP->getRif());

            $ci = isset($dataPerfil['ci']) ? $dataPerfil['ci'] : null;
            if ($ci != NULL) {
                $entityP->setCi($dataPerfil['ci']);
            }

            $entityP->setNombre($dataPerfil['nombre']);
            $entityP->setApellido($dataPerfil['apellido']);
            $entityP->setRoleType($dataPerfil['roleType']);
            $entityP->setUser($entity);

            $em->persist($entityP);
            $em->flush();

            $this->get('session')->getFlashBag()->add('message', "El usuario se ha actualizado satisfactoriamente");
            return $this->redirect($this->generateUrl('ver_usuario', array('id'=>$entity->getId())));
        }
        else {
            $errors = $this->getFormErrors($form);
            return array('entity' => $entity, 'form' => $form->createView(), 'form_perfil' => $formPerfil->createView());
        }
    }

    /**
     * @Route("/cambiar-estado-usuario/{user_id}/{estado_id}", name="cambiar-estado-usuario")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function cambiarEstadoAction(Request $request)
    {
        $estado_id = $request->get('estado_id');

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('UserBundle:SysUsuario')->findOneBy(array('id' => $request->get('user_id')));

        if (!$entity) {
            $this->get('session')->getFlashBag()->add('message', "El usuario no existe");
        }

        switch ($estado_id) {
            case 0:
                $entity->setEnabled(false);
                $this->get('session')->getFlashBag()->add('message', "El usuario ha sido desactivado satisfactoriamente");
                break;
            case 1:
                $entity->setEnabled(true);
                $this->get('session')->getFlashBag()->add('message', "El usuario ha sido activado satisfactoriamente");
                break;
        }

        $em->flush();
        return $this->redirect($this->generateUrl('listado'));
    }

    /**
     * @Route("/eliminar-usuario/{user_id}", name="eliminar-usuario")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function eliminarUsuarioAction(Request $request)
    {
        return $this->redirect($this->generateUrl('listado'));
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
    /**
     * @Route("/ver/{id}", name="ver_usuario")
     * @Method("GET")
     * @Template()
     */
   
    function showAction($id){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('UserBundle:SysUsuario')->findOneby(array('id' => $id) );
        return array('entity' => $entity);
    }


}