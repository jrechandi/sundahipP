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
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sunahip\UserBundle\Entity\SysUsuario;
use Sunahip\UserBundle\Form\UsuarioType;
use Sunahip\UserBundle\Entity\SysPerfil;
use Sunahip\CommonBundle\Tools\StringTools;

class RegistroController extends Controller {

    /**
     * @Route("/registro", name="registro")
     * @Template()
     */
    public function signupAction() {
        $entity = new SysUsuario();
        $form = $this->createForm(new UsuarioType(), $entity, array('action' => $this->generateUrl('guardar_registro')));
        return array('entity' => $entity, 'form' => $form->createView());
    }

    /**
     * @Route("/registro/guardar", name="guardar_registro")
     * @Method("POST")
     * @todo Fix view when errors are returned
     */
    public function registroAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->container->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');
        /** @var $mailer FOS\UserBundle\Mailer\MailerInterface */
        $mailer = $this->container->get('fos_user.mailer');

        $user = $userManager->createUser();

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $entity = new SysUsuario();
        $form = $this->createForm(new UsuarioType(), $entity);
        $form->handleRequest($request);

        $user_data = $request->get('user_register');
        $profile_data = $request->get('user_register')['perfil'];

        if ($form->isValid()) {
            $user->setUsername($profile_data['persJuridica'] . $profile_data['rif']);
            $user->setEmail($user_data['email']);
            $user->setPlainPassword($user_data['password']);
            $user->setFullname($profile_data['nombre'] . " " . $profile_data['apellido']);

            $role = $profile_data['roleType'];
            $user->addRole($role);
            
            $str = new StringTools();
            if (null === $user->getConfirmationToken()) {
                $user->setConfirmationToken($str->generateRandomString(32));
            }
            
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
            
            $mailer->sendConfirmationEmailMessage($user);
            if (null === $response = $event->getResponse()) {
                $url = $this->container->get('router')->generate('fos_user_registration_confirmed');
                $response = new RedirectResponse($url);
            }            

            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));
            
            return $response;
        } else {
            $errors = $this->getFormErrors($formProfile);
        }
        return new JsonResponse(array('status' => true, 'errors' => $errors));
    }

    /**
     * @Route("/registro/check-user", name="check_user_registro")
     * @Method("POST")
     * @todo Fix view when errors are returned
     */
    public function checkUser(Request $request) 
    {
        $error = 0;
        $msj = "";
        $data = $profile_data = $request->get('user_register');
        $dataperfil = $request->get('user_register')['perfil'];
        if(strlen($data['password'])<6) {
            $error = 1;
            $msj = "La contraseña debe ser por lo menos de 6 dígitos.";
        } elseif($data['password'] != $data['confirm']) {
            $error = 1;
            $msj = "Las contraseñas no coinciden.";
        }elseif(strlen($dataperfil['rif']) < 7) {
            $error = 1;
            $msj = "Ingrese un rif correcto";
        }elseif($dataperfil['persJuridica'] == 'V' || $dataperfil['persJuridica'] == 'E') {
            if(strlen($dataperfil['ci']) < 6) {
            $error = 1;
            $msj = "Ingrese una cedula correcta";
            } 
        }elseif(strlen($dataperfil['nombre']) < 2) {
            $error = 1;
            $msj = "Ingrese un nombre correcto";
        }elseif(strlen($dataperfil['apellido']) < 2) {
            $error = 1;
            $msj = "Ingrese un apellido correcto";
        }
        $userManager = $this->container->get('fos_user.user_manager');
        $profile_data = $request->get('user_register')['perfil'];        
        $user_data = $request->get('user_register');
        if($error == 0) {
            $user = $userManager->findUserByEmail($user_data['email']);
            if($user) {
                $error = 1;
                $msj = "El email ya está registrado.";
            } else {
                $user = $userManager->findUserByUsername($profile_data['persJuridica'] . $profile_data['rif']);
                if($user) {
                    $error = 1;
                    $msj = "El RIF ya está registrado.";
                }
            }
        }
        return new JsonResponse(array('error' => $error, 'msj' => $msj));
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
