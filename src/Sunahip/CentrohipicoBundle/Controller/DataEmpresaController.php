<?php
/* 
 * @author Greicodex <info@greicodex.com> 
 * Creación de empresas usuario centro hípico
 */

namespace Sunahip\CentrohipicoBundle\Controller;

use Sunahip\CentrohipicoBundle\Form\DataLegalType;
use Sunahip\CentrohipicoBundle\Form\PartnerLegalType;
use Sunahip\CentrohipicoBundle\Form\PartnerType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityRepository;
use Sunahip\CentrohipicoBundle\Entity\DataLegal;
use Sunahip\CentrohipicoBundle\Entity\DataEmpresa;
use Sunahip\CentrohipicoBundle\Form\DataEmpresaType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * DataEmpresa controller.
 *
 */
class DataEmpresaController extends Controller
{

    /**
     * @Route("/empresa/listado/", name="data_empresa_list")
     * @Method("GET")
     * @Template()
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_GERENTE') or has_role('ROLE_SUPERINTENDENTE') or has_role('ROLE_COORDINADOR') or has_role('ROLE_FISCAL')")
     */
    public function listAction(Request $request )
    {
        $response = array();
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $entities = $em->getRepository("CentrohipicoBundle:DataEmpresa")->findBy(array("usuario" => $user->getId(), 'padre' => null),array('id' => 'DESC'));

        $paginator = $this->get('knp_paginator');
        $response['entities'] = $paginator->paginate(
            $entities,
            $this->get('request')->query->get('page', 1) /*page number*/,
            10
        );

        if (!$entities) {
            $response['message'] = "No posee empresas registradas";
        }

        return $response;
    }




    /**
     * @Route("/empresa/", name="data_empresa_new" )
     * @Template()
     * @Security("has_role('ROLE_CENTRO_HIPICO')")
     */
    public function newAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entity = new DataEmpresa();
        $form = $this->createForm(
            new DataEmpresaType(),
            $entity,
            array('action' => $this->generateUrl('data_empresa_save'))
        );

        $entityLegal = new DataLegal();
        $formLegal = $this->createForm(
            new DataLegalType(),
            $entityLegal
        );

        return array('form' => $form->createView(), 'formLegal' => $formLegal->createView());
    }


    /**
     * Guarda nueva entidad empresa
     * @param Request $request
     * @Route("/empresa/save/", name="data_empresa_save")
     * @Method("POST")
     * @return Object JsonResponse
     * @Security("has_role('ROLE_CENTRO_HIPICO')")
     */
    public function saveAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $errors = null;
        $entity = new DataEmpresa();
        $form = $this->createForm(new DataEmpresaType(), $entity);
        $form->handleRequest($request);

        $entityLegal = new DataLegal();
        $formLegal = $this->createForm(new DataLegalType(), $entityLegal  );
        $formLegal->handleRequest($request);


        if($form->isValid() && $formLegal->isValid())
        {
            try {
                $user = $this->getUser();
                $entity->setFechaRegistro(new \DateTime());
                $entity->setUsuario($user);
                $em->persist($entity);
                $em->flush();

                $entityLegal->setEmpresa($entity);
                $entityLegal->setIsSocio(false);
                $em->persist($entityLegal);
                $em->flush();

                $flashMessage = "Se agrego la empresa sastifactoriamente";
                $this->get('session')->getFlashBag()->add('message', $flashMessage);

            } catch (Exception $e) {
                $errors = $this->getFormErrors($form);
            }
        }else{
            $errors = $this->getFormErrors($form);
        }

        return new JsonResponse(array('status' => true, 'company_id' => $entity->getId() , 'errors' => $errors));
    }



    /**
     * Guarda nueva entidad empresa
     * @param Request $request
     * @Route("/empresa/partner/save/", name="data_empresa_partner_save")
     * @Method("POST")
     * @return Object JsonResponse
     * @Security("has_role('ROLE_CENTRO_HIPICO')")
     */
    public function savePartnerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $errors = null;
        $type = $request->get('typeForm');

        if($type == 1)
        {
            $entity = new DataEmpresa();
            $form = $this->createForm(new PartnerType(), $entity);
            $form->handleRequest($request);
        }else{
            $entity = new DataLegal();
            $form = $this->createForm(new PartnerLegalType(), $entity);
            $form->handleRequest($request);
        }


        if($form->isValid())
        {
            try {

                $partnerId = $request->get('partnerId');

                if($partnerId == 0)
                {
                    $cId = $request->get('c_id');
                }else
                {
                    $parentId = $request->get('parentId');

                    if($parentId == 0)
                        $cId = $request->get('c_id');
                    else
                        $cId = $request->get('p_id');

                }

                $cmp = $em->getRepository("CentrohipicoBundle:DataEmpresa")->findOneBy(array("id" => $cId));

                if($type == 1)
                {
                    $user = $this->getUser();
                    $entity->setPersJuridica($request->get('pers_juridicaPartner'));
                    $entity->setRif($request->get('rifPartner'));
                    $entity->setUsuario($user);
                    $entity->setPadre($cmp);
                    $entity->setFechaRegistro(new \DateTime());
                    $em->persist($entity);
                    $em->flush();
                }else{
                    $entity->setPersJuridica($request->get('pers_juridicaPartner'));
                    $entity->setRif($request->get('rifPartner'));
                    $entity->setEmpresa($cmp);
                    $entity->setIsSocio(true);
                    $entity->setFechaRegistro(new \DateTime());
                    $entity->setStatus("Activo");
                    $em->persist($entity);
                    $em->flush();
                }

            } catch (Exception $e) {
                $errors = $this->getFormErrors($form);
            }
        }else{
            $errors = $this->getFormErrors($form);
        }

        return new JsonResponse(array('status' => true, 'errors' => $errors, 'p_id' => $entity->getId()));
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

    /*
     * @Security("has_role('ROLE_CENTRO_HIPICO')")
     */
    
    public function addPartner($data = array(), $company)
    {
        $em = $this->getDoctrine()->getManager();

        foreach($data as $item)
        {
            $entity = new DataLegal();

            $entity->setEmpresa($company);
            $entity->setNombreComercial($item['nombreComercial']);
            $entity->setNombre($item['nombre']);
            $entity->setApellido($item['apellido']);
            $entity->setPersJuridica($item['persJuridica']);
            $entity->setRif($item['rif']);
            $entity->setTipoci($item['tipoci']);
            $entity->setCi($item['ci']);
            $entity->setUrbanSector($item['urbanSector']);
            $entity->setAvCalleCarrera($item['avCalleCarrera']);
            $entity->setEdifCasa($item['edifCasa']);
            $entity->setOfcAptoNum($item['ofcAptoNum']);
            $entity->setPuntoReferencia($item['puntoReferencia']);
            $entity->setCodigoPostal($item['codigoPostal']);
            $entity->setFax($item['fax']);
            $entity->setCodTlfFijo($item['codTlfFijo']);
            $entity->setTflFijo($item['tflFijo']);
            $entity->setCodTlfCelular($item['codTlfCelular']);
            $entity->setTflCelular($item['tflCelular']);
            $entity->setEmail($item['email']);
            $entity->setPagWeb($item['pagWeb']);
            $entity->setIsSocio(true);

            $state = $em->getRepository('CommonBundle:SysEstado')->find($item['estado']);
            $entity->setEstado($state);
            $entity->setCiudad($item['ciudad']);

            $em->persist($entity);
            $em->flush();
        }

    }


    /**
     * Verifica si existe el rif en bd
     * @param Request $request
     * @Route("/empresa/verificar-rif/{rifType}/{rifNumber}/", name="empresa_verificar_rif")
     * @Method("GET")
     * @return Object JsonResponse
     * @Security("has_role('ROLE_CENTRO_HIPICO')")
     */
    public function verifiyRifAction(Request $request, $rifType, $rifNumber)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository("CentrohipicoBundle:DataEmpresa")->findOneBy(array('persJuridica' => $rifType, 'rif' => $rifNumber ));

        if($entity)
            return new JsonResponse(array('status'=>true));
        else
            return new JsonResponse(array('status'=>false));
    }


    /**
     * @Route("/empresa/detall/{id}", name="data_empresa_detail")
     * @Method("GET")
     * @Template()
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_GERENTE') or has_role('ROLE_SUPERINTENDENTE') or has_role('ROLE_COORDINADOR') or has_role('ROLE_FISCAL')")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CentrohipicoBundle:DataEmpresa')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DataEmpresa entity.');
        }

        $entityLegal = $em->getRepository('CentrohipicoBundle:DataLegal')->findOneBy(array('empresa'=> $entity->getId()));
        if (!$entityLegal) {
            $entityLegal = null;
        }

        $entityPartner = $em->getRepository('CentrohipicoBundle:DataLegal')->findBy(array('empresa'=> $entity->getId(), 'isSocio' => 1 ));
        if (!$entityPartner) {
            $entityPartner = null;
        }

        $entityPartner2 = $em->getRepository('CentrohipicoBundle:DataEmpresa')->findBy(array('padre'=> $entity->getId()));
        if (!$entityPartner2) {
            $entityPartner2 = null;
        }

        return $this->render('CentrohipicoBundle:DataEmpresa:modal.html.twig',
            array(
                'entity' => $entity,
                'legal' => $entityLegal,
                'partner1' => $entityPartner,
                'partner2' => $entityPartner2
            ));
    }


    /**
     * Agregar formulario para socios
     * @param String $type
     * @Route("/empresa/agregar-formulario/{type}/", name="empresa_agregar_form_socio")
     * @Method("GET")
     * @return Object JsonResponse
     * @Template()
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_GERENTE') or has_role('ROLE_SUPERINTENDENTE') or has_role('ROLE_COORDINADOR') or has_role('ROLE_FISCAL')")
     */
    public function showPartnerFormAction($type)
    {
        if($type == 1)
        {
            $entity = new DataEmpresa();
            $form = $this->createForm(
                new PartnerType(),
                $entity,
                array('action' => $this->generateUrl('data_empresa_save'))
            );

            return $this->render('CentrohipicoBundle:DataEmpresa:formPartner.html.twig',
                array(
                    'form' => $form->createView()
                ));
        }else{
            $entity = new DataLegal();
            $form = $this->createForm(
                new PartnerLegalType(),
                $entity
            );
            return $this->render('CentrohipicoBundle:DataEmpresa:formPartnerLegal.html.twig',
                array(
                    'form' => $form->createView()
                ));
        }

    }

    /**
     * @Route("/empresa/editar/{id}/", name="data_empresa_edit" )
     * @Template()
     * @Security("has_role('ROLE_CENTRO_HIPICO')")
     */
    public function editAction($id = null)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository("CentrohipicoBundle:DataEmpresa")->findOneBy(array("id"=> $id));

        if($entity)
        {
            $form = $this->createForm(
                new DataEmpresaType(),
                $entity,
                array('action' => $this->generateUrl('data_empresa_update', array('id' => $id)), 'method' => 'POST')
            );

            return array('form' => $form->createView());
        }
    }


    /**
     * Actualiza una entidad empresa
     * @param Request $request
     * @param integer $id
     * @Route("/empresa/update/{id}/", name="data_empresa_update")
     * @Method("POST")
     * @return Object JsonResponse
     * @Security("has_role('ROLE_CENTRO_HIPICO')")
     */
    public function updateAction(Request $request, $id = null)
    {

        $em = $this->getDoctrine()->getManager();
        $errors = null;
        $entity = $em->getRepository("CentrohipicoBundle:DataEmpresa")->findOneBy(array("id"=> $id));
        $form = $this->createForm(new DataEmpresaType(), $entity);
        $form->handleRequest($request);

        if($form->isValid())
        {
            try {
                $user = $this->getUser();
                $entity->setUsuario($user);
                $em->persist($entity);
                $em->flush();

                $flashMessage = "Se edito la empresa sastifactoriamente";
                $this->get('session')->getFlashBag()->add('message', $flashMessage);

                return $this->redirect($this->generateUrl('data_empresa_list'));
            } catch (Exception $e) {
                $errors = $this->getFormErrors($form);
            }
        }else{
            $errors = $this->getFormErrors($form);
        }

        return new JsonResponse(array('status' => true, 'errors' => $errors));
    }



    /**
     * @Route("/empresa/socios/{id}/", name="data_empresa_add_partner" )
     * @Template()
     * @Security("has_role('ROLE_CENTRO_HIPICO')")
     */
    public function addPartnerAction($id = null)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository("CentrohipicoBundle:DataEmpresa")->findOneBy(array("id"=> $id));

        if($entity)
        {
            return array('entity' => $entity);
        }
    }


    /**
     * Guarda una entidad socio
     * @param Request $request
     * @param integer $id
     * @Route("/empresa/socios/save/{id}/", name="data_empresa_save_partner")
     * @Method("POST")
     * @return Object JsonResponse
     * @Security("has_role('ROLE_CENTRO_HIPICO')")
     */
    public function addPartnerSaveAction(Request $request, $id = null)
    {

        $em = $this->getDoctrine()->getManager();
        $errors = null;
        $entity = $em->getRepository("CentrohipicoBundle:DataEmpresa")->findOneBy(array("id"=> $id));
        $form = $this->createForm(new DataEmpresaType(), $entity);
        $form->handleRequest($request);

        if($form->isValid())
        {
            try {
                $user = $this->getUser();
                $entity->setUsuario($user);
                $em->persist($entity);
                $em->flush();

                $flashMessage = "Se edito la empresa sastifactoriamente";
                $this->get('session')->getFlashBag()->add('message', $flashMessage);

                return $this->redirect($this->generateUrl('data_empresa_list'));
            } catch (Exception $e) {
                $errors = $this->getFormErrors($form);
            }
        }else{
            $errors = $this->getFormErrors($form);
        }

        return new JsonResponse(array('status' => true, 'errors' => $errors));
    }


}
