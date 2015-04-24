<?php

/*
 * 
 * @author Greicodex <info@greicodex.com> 
 */

namespace Sunahip\FiscalizacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class OperadoraController extends BaseController
{
    

    /**
     * @Security("has_role('ROLE_GERENTE') or has_role('ROLE_COORDINADOR') or has_role('ROLE_SUPERINTENDENTE')")
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function indexAction(Request $request){
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CentrohipicoBundle:DataOperadora')->findAll();
        return $this->render("FiscalizacionBundle:Operadora:index.html.twig", array(
            'entities' => $this->getPaginator($entities),
        ));
    }
}
