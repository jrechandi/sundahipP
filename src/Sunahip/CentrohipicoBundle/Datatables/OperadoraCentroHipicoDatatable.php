<?php

namespace Sunahip\CentrohipicoBundle\Datatables;

use Sg\DatatablesBundle\Datatable\View\AbstractDatatableView;

class OperadoraCentroHipicoDatatable extends AbstractDatatableView
{

    /**
     * {@inheritdoc}
     */
    public function buildDatatableView()
    {
        //-------------------------------------------------
        // Datatable
        //-------------------------------------------------
        // Features (defaults)
        $this->getFeatures()
            ->setAutoWidth(true)
            ->setDeferRender(false)
            ->setInfo(true)
            ->setJQueryUI(false)
            ->setLengthChange(true)
            ->setOrdering(true)
            ->setPaging(true)
            ->setProcessing(true)  // default: false
            ->setScrollX(true)     // default: false
            ->setScrollY("")
            ->setSearching(true)
            ->setServerSide(true)  // default: false
            ->setStateSave(false);

        // Options (for more options see file: Sg\DatatablesBundle\Datatable\View\Options.php)
        $this->getOptions()
            ->setLengthMenu(array(10, 25, 50, 100, -1))
            ->setOrder(array("column" => 1, "direction" => "desc"));

        $this->getAjax()->setUrl($this->getRouter()->generate("solicitudes_result"));

//        $this->getMultiselect()
//                ->setEnabled(true)
//                ->setPosition("last")
//                ->addAction("Activar", "user_bulk_enable")
//                ->addAction("Desactivar", "user_bulk_disable");

        $this->setStyle(self::BOOTSTRAP_3_STYLE);

        $this->setIndividualFiltering(true);


        //-------------------------------------------------
        // Columns
        //-------------------------------------------------

        $this->getColumnBuilder()
                ->add("id", "column", array(
                    "title" => "ID",
                    "orderable" => true,
                    "visible" => true
                ))
            ->add("centroHipico.denominacionComercial", "column", array(
                    "title" => "Denominacion comercial",
                    "searchable" => true,
                    "orderable" => true,
                    "visible" => true
                ))
            ->add("centroHipico.clasificacionLocal.clasificacionCentrohipico", "column", array(
                    "title" => "Clasificacion local",
                    "searchable" => true,
                    "orderable" => true,
                    "visible" => true
                ))
            ->add("status", "column", array(
                    "title" => "status",
                    "searchable" => true,
                    "orderable" => true,
                    "visible" => true
                ));
//            ->add(null, "action", array(
//                    "route" => "user_edit",
//                    "title" => "Acciones",
//                    "actions" => array(
//                        array(
//                            "route" => "editar-usuario",
//                            "route_parameters" => array(
//                                "id" => "id"
//                            ),
//                            "icon" => "glyphicon glyphicon-edit",
//                            "attributes" => array(
//                                "data-toggle" => "modal",
//                                "data-target" => "#confirm-delete",
//                                "rel" => "tooltip",
//
//                                "title" => "Editar",
//                                "data-placement" => "top",
//                                "role" => "button"
//                            ),
//                            "role" => "ROLE_ADMIN",
//                            "renderif" => array(
//                                "enabled"
//                            )
//                        )
//                    )
//                ));
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity()
    {
        return "CentrohipicoBundle:DataOperadoraEstablecimiento";
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return "operadora_establecimiento_datatable";
    }

}
