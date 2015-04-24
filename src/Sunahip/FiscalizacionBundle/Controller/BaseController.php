<?php
namespace Sunahip\FiscalizacionBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller{

    protected function getPaginator($e){
        $paginator = $this->get('knp_paginator');
        return $paginator->paginate(
            $e,
            $this->get('request')->query->get('page', 1), /*page number*/
            10
        );

    }
}