<?php
/**
 * Controler:   Administracion de Usuarios
 *
 * @package     Sunahip
 * @subpackage  User
 * @author      Reynier Perez Mira <reynierpm@gmail.com>
 */

namespace Sunahip\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DatatableController extends Controller
{

    /**
     * Post datatable.
     *
     * @Route("/usuarios/listado", name="usuarios_listado_dt")
     * @Method("GET")
     * @Template()
     *
     * @return array
     */
    public function indexAction()
    {
        $postDatatable = $this->get("sg_datatables.user");
        $postDatatable->buildDatatableView();

        return array(
            "datatable" => $postDatatable,
        );
    }


    /**
     * Get all Post entities.
     *
     * @Route("/user_results", name="user_results")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexResultsAction()
    {
        /**
         * @var \Sg\DatatablesBundle\Datatable\Data\DatatableData $datatable
         */
        $datatable = $this->get("sg_datatables.datatable")->getDatatable($this->get("sg_datatables.user"));

        // Callback example
//        $function = function($qb) {
//            $qb->andWhere("enabled = true");
//        };

        // Add callback
//        $datatable->addWhereBuilderCallback($function);

        return $datatable->getResponse();
    }

    /**
     * @Route("/bulk/delete", name="user_bulk_delete")
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
            $repository = $em->getRepository("UserBundle:SysUsuario");

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
     * @Route("/bulk/disable", name="user_bulk_disable")
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
            $repository = $em->getRepository("UserBundle:SysUsuario");

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
     * @Route("/bulk/enable", name="user_bulk_enable")
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
            $repository = $em->getRepository("UserBundle:SysUsuario");

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
