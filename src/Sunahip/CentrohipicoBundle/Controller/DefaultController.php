<?php

/*
 * 
 * @author Greicodex <info@greicodex.com> 
 */

namespace Sunahip\CentrohipicoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DefaultController extends Controller
{
    /*
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR')")
     */
    public function indexAction($name)
    {
        return $this->render('CentrohipicoBundle:Default:index.html.twig', array('name' => $name));
    }
    
    /*
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR')")
     */
    public function getCiudadesAction($estado_id = null, $municipio_id = null)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('CommonBundle:SysCiudad')->findBy(array('estado' => $estado_id, 'municipio' => $municipio_id));

        $response['message'] = "";
        $response['entities'] = array();

        if (!$entities) {
            $response['message'] = "No se encontraron ciudades";
        }

        foreach ($entities as $ciudad) {
            $cities = array();
            $cities['id'] = $ciudad->getId();
            $cities['nombre'] = $ciudad->getNombre();
            
            $response['entities'][] = $cities;
        }

        return new JsonResponse($response);
    }
}
