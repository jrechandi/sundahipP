<?php

namespace Sunahip\CentrohipicoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class ListadoSolicitudesController extends Controller
{
    /**
     * set datatable configs
     *
     * @return \Ali\DatatableBundle\Util\Datatable
     */
    private function _datatable()
    {
        return $this->get('datatable')
            ->setEntity("CentrohipicoBundle:DataOperadoraEstablecimiento", "x") // replace "XXXMyBundle:Entity" by your entity
            ->setFields(
                array(
                    "Name" => 'x.centroHipico.denominacionComercial', // Declaration for fields:
                    "_identifier_" => 'x.id'
                ) // you have to put the identifier field without label. Do not replace the "_identifier_"
            )
            ->setHasAction(true); // you can disable action column from here by setting "false".
    }


    /*
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR')")
     */
    public function gridAction()
    {
        return $this->_datatable()->execute(); // call the "execute" method in your grid action
    }

    /*
     * @Security("has_role('ROLE_CENTRO_HIPICO') or has_role('ROLE_OPERADOR')")
     */
    public function indexAction()
    {
        $this->_datatable(); // call the datatable config initializer
        return $this->render('CentrohipicoBundle:ListadoSolicitudes:index.html.twig'); // replace "XXXMyBundle:Module:index.html.twig" by yours
    }
}