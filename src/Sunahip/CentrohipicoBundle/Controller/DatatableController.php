<?php
/*
 * @author Greicodex <info@greicodex.com> 
 * Utilizando bundle datatables (no se está usando actualmente)
 */  

namespace Sunahip\CentrohipicoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DatatableController extends Controller
{

    /**
     * Post datatable.
     *
     * @Route("/solicitudes/listado", name="solicitudes_listado_dt")
     * @Method("GET")
     * @Template()
     *
     * @return array
     */
    public function indexAction()
    {
        $postDatatable = $this->get("sg_datatables.operadora_establecimiento");
        $postDatatable->buildDatatableView();

        return array(
            "datatable" => $postDatatable,
        );
    }


    /**
     * Get all Post entities.
     *
     * @Route("/solicitudes_result", name="solicitudes_result")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexResultsAction()
    {
        /**
         * @var \Sg\DatatablesBundle\Datatable\Data\DatatableData $datatable
         */
        $datatable = $this->get("sg_datatables.datatable")->getDatatable($this->get("sg_datatables.operadora_establecimiento"));

        // Callback example
//        $function = function($qb) {
//            $qb->andWhere("enabled = true");
//        };

        // Add callback
//        $datatable->addWhereBuilderCallback($function);

        return $datatable->getResponse();
    }

    /**
     * @Route("/solicitudes/bulk/delete", name="solicitudes_bulk_delete")
     * @Method("POST")
     *
     * @return Response
     */
    public function bulkDeleteAction()
    {
        $request = $this->getRequest();
        $isAjax = $request->isXmlHttpRequest();

        if ($isAjax) {
            $choices = $request->request->get("data");

            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository("CentrohipicoBundle:DataOperadoraEstablecimiento");

            foreach ($choices as $choice) {
                $entity = $repository->find($choice["value"]);
                $em->remove($entity);
            }

            $em->flush();

            return new Response("This is ajax response.");
        }

        return new Response("This is not ajax.", 400);
    }

    /**
     * @Route("/bulk/disable", name="solicitudes_bulk_disable")
     * @Method("POST")
     *
     * @return Response
     */
    public function bulkDisableAction()
    {
        $request = $this->getRequest();
        $isAjax = $request->isXmlHttpRequest();

        if ($isAjax) {
            $choices = $request->request->get("data");

            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository("CentrohipicoBundle:DataOperadoraEstablecimiento");

            foreach ($choices as $choice) {
                $entity = $repository->find($choice["value"]);
                $entity->setVisible(false);
                $em->persist($entity);
            }

            $em->flush();

            return new Response("This is ajax response.");
        }

        return new Response("This is not ajax.", 400);
    }

    /**
     * @Route("/bulk/enable", name="solicitudes_bulk_enable")
     * @Method("POST")
     *
     * @return Response
     */
    public function bulkEnableAction()
    {
        $request = $this->getRequest();
        $isAjax = $request->isXmlHttpRequest();

        if ($isAjax) {
            $choices = $request->request->get("data");

            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository("CentrohipicoBundle:DataOperadoraEstablecimiento");

            foreach ($choices as $choice) {
                $entity = $repository->find($choice["value"]);
                $entity->setVisible(false);
                $em->persist($entity);
            }

            $em->flush();

            return new Response("This is ajax response.");
        }

        return new Response("This is not ajax.", 400);
    }

}
