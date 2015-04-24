<?php

namespace Sunahip\UserBundle\Datatables;

use Sg\DatatablesBundle\Datatable\View\AbstractDatatableView;

class UserDatatable extends AbstractDatatableView
{

    /**
     * {@inheritdoc}
     */
    public function buildDatatableView()
    {
        $disabled = 0;

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

        $this->getAjax()->setUrl($this->getRouter()->generate("user_results"));

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
//                ->add("id", "column", array(
//                    "title" => "ID",
//                    "orderable" => true,
//                    "visible" => true
//                ))
                ->add("username", "column", array(
                    "title" => "Usuario",
                    "orderable" => true,
                    "visible" => true
                ))
                ->add("fullname", "column", array(
                    "title" => "Nombre completo",
                    "searchable" => true,
                    "orderable" => true,
                    "visible" => true
                ))
                ->add("email", "column", array(
                     "title" => "Correo electronico",
                     "searchable" => true,
                     "orderable" => true,
                     "visible" => true
                    ))
                ->add("enabled", "boolean", array(
                    "title" => "Activo",
                    "searchable" => false,
                    "orderable" => false,
                    "true_label" => "Sí",
                    "false_label" => "No",
                    "true_icon" => "glyphicon glyphicon-ok",
                    "false_icon" => "glyphicon glyphicon-remove"
                ))
            ->add(null, "action", array(
                    "title" => "Acciones",
                    "actions" => array(
                        array(
                            "route" => "cambiar-estado-usuario",
                            "route_parameters" => array(
                                "user_id" => "id"
                            ),
                            "icon" => "fa fa-minus-square-o",
                            "attributes" => array(
                                "rel" => "tooltip",
                                "title" => "Desactivar",
                                "data-toggle" => "modal",
                                "data-target" => "#confirm-disable",
                                "class" => "disable-user",
                                "data-href" => "dh",
                                "disbaled" => "disabled",
                                "role" => "button"
                            ),
                            "role" => "ROLE_ADMIN",
                            "renderif" => array(
                                "enabled"
                            )
                        ),
//                        array(
//                            "route" => "cambiar-estado-usuario",
//                            "route_parameters" => array(
//                                "user_id" => "id",
//                                "estado_id" => "expired"
//                            ),
//                            "icon" => "fa fa-plus-square-o",
//                            "attributes" => array(
//                                "rel" => "tooltip",
//                                "title" => "Activar",
//                                "data-toggle" => "modal",
//                                "data-target" => "#confirm-enable",
//                                "data-href" => "dh",
//                                "disbaled" => "disabled",
//                                "role" => "button"
//                            ),
//                            "role" => "ROLE_ADMIN",
//                            "renderif" => array(
//                                "enabled" => true
//                            )
//                        ),
                        array(
                            "route" => "editar-usuario",
                            "route_parameters" => array(
                                "user_id" => "id"
                            ),
                            "icon" => "glyphicon glyphicon-edit",
                            "attributes" => array(
                                "rel" => "tooltip",
                                "title" => "Editar",
                                "data-toggle" => "tooltip",
                                "data-placement" => "top",
                                "role" => "button"
                            ),
                            "role" => "ROLE_ADMIN",
//                            "renderif" => array(
//                                "enabled"
//                            )
                        ),
                        array(
                            "route" => "eliminar-usuario",
                            "route_parameters" => array(
                                "user_id" => "id"
                            ),
                            "icon" => "glyphicon glyphicon-remove",
                            "attributes" => array(
                                "data-toggle" => "modal",
                                "data-target" => "#confirm-delete",
                                "data-href" => "dh",
                                "disbaled" => "disabled",
                                "rel" => "tooltip",
                                "id" => "id",
                                "class" => "delete-user",
                                "title" => "Eliminar",
                                "data-placement" => "top",
                                "role" => "button"
                            )
//                            "renderif" => array(
//                                ""
//                            )
                        )
                    )
                ));
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity()
    {
        return "UserBundle:SysUsuario";
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return "user_datatable";
    }

}
