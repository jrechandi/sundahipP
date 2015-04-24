<?php

/**
 * Controller:    Parroquia
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

class ParroquiaController extends Controller
{
    /**
     * Obtiene un listado de estados
     *
     * @Route("/parroquias/{municipio_id}", name="parroquias")
     * @Method("GET")
     * @return string Arreglo de datos transformado a JSON
     */
    public function getParroquiasAction($municipio_id = null)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('CommonBundle:SysParroquia')->findBy(array('municipio' => $municipio_id));

        $response['message'] = "";
        $response['entities'] = array();

        if (!$entities) {
            $response['message'] = "No se encontraron parroquias";
        }

        foreach ($entities as $parroquia) {
            $cities = array();
            $cities['id'] = $parroquia->getId();
            $cities['nombre'] = $parroquia->getNombre();
            
            $response['entities'][] = $cities;
        }

        return new JsonResponse($response);
    }

}
