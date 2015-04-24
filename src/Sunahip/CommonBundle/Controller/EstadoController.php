<?php

/**
 * Controller:    Estado
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

class EstadoController extends Controller
{
    /**
     * Obtiene un listado de estados
     *
     * @Route("/estados", name="estados")
     * @Method("GET")
     * @return string Arreglo de datos transformado a JSON
     */
    public function getEstadosAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('CommonBundle:SysEstados')->findAll();

        $response['message'] = "";
        $response['entities'] = array();

        if (!$entities) {
            $response['message'] = "No se encontraron estados";
        }

        foreach ($entities as $state) {
            $states = array();
            $states['nombre'] = $state->getNombre();
            $response['entities'][] = $states;
        }

        return new JsonResponse($response);
    }

}
