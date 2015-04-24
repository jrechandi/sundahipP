<?php

/**
 * Controller:    Municipio
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

class MunicipioController extends Controller
{
    /**
     * Obtiene un listado de estados
     *
     * @Route("/municipios/{estado_id}", name="municipios")
     * @Method("GET")
     * @return string Arreglo de datos transformado a JSON
     */
    public function getMunicipiosAction($estado_id = null)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('CommonBundle:SysMunicipio')->findBy(array('estado' => $estado_id));

        $response['message'] = "";
        $response['entities'] = array();

        if (!$entities) {
            $response['message'] = "No se encontraron municipios";
        }

        foreach ($entities as $municipio) {
            $cities = array();
            $cities['id'] = $municipio->getId();
            $cities['nombre'] = $municipio->getNombre();
            
            $response['entities'][] = $cities;
        }

        return new JsonResponse($response);
    }

}
