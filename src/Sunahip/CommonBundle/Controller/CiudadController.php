<?php

/**
 * Controller:    Ciudades
 *
 * @package       Sunahip
 * @subpackage    Common
 * @author        Reynier Perez <reynierpm@gmail.com>
 */

namespace Sunahip\CommonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;

class CiudadController extends Controller
{
    /**
     * Obtiene un listado de estados
     *
     * @Route("/ciudades/{estado_id}", name="ciudades")
     * @Method("GET")
     * @return string Arreglo de datos transformado a JSON
     */
    public function getCiudadesAction($estado_id = null)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('CommonBundle:SysCiudad')->findBy(array('estado' => $estado_id));

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

    
        /**
     * Obtiene un listado de estados
     *
     * @Route("/ciudades/select/{estado_id}", name="ciudades_select")
     * @Method("GET")
     * @return string Arreglo de datos transformado a JSON
     */
    public function getCiudadesSelectAction($estado_id = null)
    {
        $em = $this->getDoctrine()->getManager();
        $idUser = $this->getUser()->getId();
        $entities = $em->getRepository('CommonBundle:SysCiudad')->getCiudadselect($estado_id, $idUser);

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
