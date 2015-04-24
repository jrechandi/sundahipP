var partnerRif = "<td><label>Rif *</label></td><td><select onchange='addFormPartner()' id='rifTypePartner' class='input-mini'><option value='J'>J</option>";
partnerRif += "<option value='G'>G</option><option value='V'>V</option><option value='E'>E</option></select>- ";
partnerRif += "<input type='text' id='rifNumberPartner' required='required' maxlength='9' onkeypress='return isNumericInteger(event)'>&nbsp;<a href='#' class='btn btn-primary btn-sm' id='btnPartner' onclick='addFormPartner()'>Agregar</a></td>";


jQuery(document).ready(function () {

    $("#addPartner").click(function () {
        $("#zone_select_partner").html(partnerRif);
        $(".dataPartner").show();
        window.childValidate = 0;
    });
    var form = $('#partnerAddForm');
    form.on('submit', function (event) {
        event.stopPropagation();
        event.preventDefault();
        validateFormPartner(form);
        $("#partnerCountForm").val(1);
    });
});

var countPartner = 1;
var childValidate = 0;

function addFormPartner() {

    var rifNumberPartner = $("#rifNumberPartner").val();
    var rifTypePartner = $("#rifTypePartner").val();


    if (rifNumberPartner.length > 1) {

        var url = Routing.generate('empresa_verificar_rif', {'rifType': rifTypePartner, 'rifNumber': rifNumberPartner});
        $.get(url, function (data) {
            if (data.status == true) {
                $("#myMessage").html("El rif del socio: " + rifTypePartner + "-" + rifNumberPartner + " <br/>   ya se encuentra registrado en nuestro sistema");
                $("#myModal").modal("show");
                $("#buttonCloseModal").show();
            } else {
                if (rifTypePartner == 'J' || rifTypePartner == 'G')
                    var type = 1;
                else
                    var type = 2;

                var url = Routing.generate('empresa_agregar_form_socio', {'type': type});
                $.get(url, function (data) {
                    $("#btnPartner").hide();
                    $("#zone_form_partner").html(data);
                    $("#zone_form_partner").show();
                    $("#pers_juridicaPartner").val(rifTypePartner);
                    $("#rifPartner").val(rifNumberPartner);

                    if (window.childValidate == 1) {
                        $("#parentIdField").val(window.countPartner);
                    } else {
                        window.countPartner = window.countPartner++;
                        $("#partnerIdField").val(window.countPartner);
                    }

                });
            }
        });
    }

}


function addChildPartner() {
    $("#zone_select_partner").html(partnerRif);
    $(".dataPartner").show();
    window.childValidate = 1;
}


var forms = [];

function validateFormPartner(form) {
    forms.push(form.serialize());
    var numRowName = "count-" + window.countPartner;

    if (window.childValidate == 1) {
        var cnt = $("#" + numRowName).text();
        var newIdCnt = parseInt(cnt) + 1;
        $("#" + numRowName).text(newIdCnt);
    } else {
        var name = "sunahip_centrohipicobundle_dataempresa_partner_denominacionComercial";
        if ($("#" + name).length > 0) {
            var nameRow = $("#" + name).val();
            var rifTypePartner = $("#rifTypePartner").val();
            if (rifTypePartner == 'J') {
                var typeRow = 'Juridico';
                var numRow = "<span id='" + numRowName + "'>0</span>&nbsp;";
                numRow += "<a href='#' class='btn btn-primary btn-sm' onclick='addChildPartner()'> + </a>";
            } else {
                var typeRow = 'Gobierno';
                var numRow = 'N/A';
            }
        } else {
            var nameRow = $("#sunahip_centrohipicobundle_datalegal_partner_nombre").val();
            nameRow += $("#sunahip_centrohipicobundle_datalegal_partner_apellido").val();
            var rifTypePartner = $("#rifTypePartner").val();
            var typeRow = 'Natural';
            var numRow = 'N/A';
        }

        var html = "<tr><td>" + nameRow + "</td>";
        html += "<td>" + typeRow + "</td>";
        html += "<td>" + numRow + "</td></tr>";

        $(html).insertAfter("#rowPartner");
    }

    $(".dataPartner").hide();
    $("#zone_form_partner").fadeOut("slow", function () {
        $("#zone_form_partner").html(' ');
    });
    console.info("forms ---", forms);
    window.childValidate = 0;
}


var valid = false;
var formFirst = $('#form_dch');
var focusError = null;
var tabError = null;

function validateForm() {
    var validator = $("#form_dch").validate();
    validator.element("#sunahip_centrohipicobundle_dataempresa_denominacionComercial");

    if ($("#sunahip_centrohipicobundle_dataempresa_rif").val().length < 2) {
        console.info("rif", $("#sunahip_centrohipicobundle_dataempresa_rif").val().length);
        $("#myMessage").html("El rif de la empresa no puede estar vacio");
        $("#myModal").modal("show");
        $("#buttonCloseModal").show();
        window.focusError = "#sunahip_centrohipicobundle_dataempresa_rif";
        window.tabError = "#ui-id-1";
        return true;
    } else {
        var rifType = $("#sunahip_centrohipicobundle_dataempresa_persJuridica").val();
        var rifNumber = $("#sunahip_centrohipicobundle_dataempresa_rif").val();


        var url = Routing.generate('empresa_verificar_rif', {'rifType': rifType, 'rifNumber': rifNumber});
        $.get(url, function (data) {
            if (data.status == true) {
                $("#myMessage").html("El rif:" + rifType + "-" + rifNumber + " <br/> ya se encuentra registrado en nuestro sistema");
                $("#myModal").modal("show");
                $("#buttonCloseModal").show();
            }
            else {
                var d1 = false;
                var d2 = false;
                var d3 = false;
                var d4 = false;
                var d5 = false;
                var d6 = false;
                var d7 = false;
                var d8 = false;
                var d9 = false;
                var d10 = false;
                var d11 = false;
                var d12 = false;
                var d13 = false;


                if ($('#sunahip_centrohipicobundle_dataempresa_denominacionComercial').valid()) {
                    d1 = true;
                } else {
                    window.focusError = "#sunahip_centrohipicobundle_dataempresa_denominacionComercial";
                    window.tabError = "#ui-id-1";
                    $(window.tabError).trigger("click");
                    return true;
                }


                if ($('#sunahip_centrohipicobundle_dataempresa_rif').valid()) {
                    d2 = true;
                } else {
                    window.focusError = "#sunahip_centrohipicobundle_dataempresa_rif";
                    window.tabError = "#ui-id-1";
                    $(window.tabError).trigger("click");
                    return true;
                }

                if ($('#sunahip_centrohipicobundle_dataempresa_estado').valid()) {
                    d3 = true;
                } else {
                    window.focusError = "#sunahip_centrohipicobundle_dataempresa_estado";
                    window.tabError = "#ui-id-1";
                    $(window.tabError).trigger("click");
                    return true;
                }

                if ($('#sunahip_centrohipicobundle_dataempresa_ciudad').valid()) {
                    d4 = true;
                } else {
                    window.focusError = "#sunahip_centrohipicobundle_dataempresa_ciudad";
                    window.tabError = "#ui-id-1";
                    $(window.tabError).trigger("click");
                    return true;
                }

                if ($('#sunahip_centrohipicobundle_dataempresa_municipio').valid()) {
                    d5 = true;
                } else {
                    window.focusError = "#sunahip_centrohipicobundle_dataempresa_municipio";
                    window.tabError = "#ui-id-1";
                    $(window.tabError).trigger("click");
                    return true;
                }

                if ($('#sunahip_centrohipicobundle_dataempresa_parroquia').valid()) {
                    d6 = true;
                } else {
                    window.focusError = "#sunahip_centrohipicobundle_dataempresa_parroquia";
                    window.tabError = "#ui-id-1";
                    $(window.tabError).trigger("click");
                    return true;
                }

                if ($('#sunahip_centrohipicobundle_dataempresa_avCalleCarrera').valid()) {
                    d7 = true;
                } else {
                    window.focusError = "#sunahip_centrohipicobundle_dataempresa_avCalleCarrera";
                    window.tabError = "#ui-id-1";
                    $(window.tabError).trigger("click");
                    return true;
                }

                if ($('#sunahip_centrohipicobundle_dataempresa_urbanSector').valid()) {
                    d8 = true;
                } else {
                    window.focusError = "#sunahip_centrohipicobundle_dataempresa_urbanSector";
                    window.tabError = "#ui-id-1";
                    $(window.tabError).trigger("click");
                    return true;
                }

                if ($('#sunahip_centrohipicobundle_dataempresa_edifCasa').valid()) {
                    d9 = true;
                } else {
                    window.focusError = "#sunahip_centrohipicobundle_dataempresa_edifCasa";
                    window.tabError = "#ui-id-1";
                    $(window.tabError).trigger("click");
                    return true;
                }

                if ($('#sunahip_centrohipicobundle_dataempresa_puntoReferencia').valid()) {
                    d10 = true;
                } else {
                    window.focusError = "#sunahip_centrohipicobundle_dataempresa_puntoReferencia";
                    window.tabError = "#ui-id-1";
                    $(window.tabError).trigger("click");
                    return true;
                }

                if ($('#sunahip_centrohipicobundle_dataempresa_email').valid()) {
                    d11 = true
                } else {
                    window.focusError = "#sunahip_centrohipicobundle_dataempresa_email";
                    window.tabError = "#ui-id-1";
                    $(window.tabError).trigger("click");
                    return true;
                }

                if ($('#sunahip_centrohipicobundle_dataempresa_ofcAptoNum').valid()) {
                    d12 = true;
                } else {
                    window.focusError = "#sunahip_centrohipicobundle_dataempresa_ofcAptoNum";
                    window.tabError = "#ui-id-1";
                    $(window.tabError).trigger("click");
                    return true;
                }

                /*if ($('#sunahip_centrohipicobundle_dataempresa_codigoPostal').valid()) {
                    d13 = true;
                } else {
                    window.focusError = "#sunahip_centrohipicobundle_dataempresa_codigoPostal";
                    window.tabError = "#ui-id-1";
                    $(window.tabError).trigger("click");
                    return true;
                }*/


                // Representante legal

                var l1 = false;
                var l2 = false;
                var l3 = false;
                var l4 = false;
                var l5 = false;
                var l6 = false;
                var l7 = false;
                var l8 = false;
                var l9 = false;
                var l10 = false;
                var l11 = false;
                var l12 = false;

                if ($('#sunahip_centrohipicobundle_datalegal_nombre').valid()) {
                    l1 = true;
                } else {
                    window.focusError = "#sunahip_centrohipicobundle_datalegal_nombre";
                    window.tabError = "#ui-id-2";
                    $(window.tabError).trigger("click");
                    return true;
                }

                if ($('#sunahip_centrohipicobundle_datalegal_apellido').valid()) {
                    l2 = true;
                } else {
                    window.focusError = "#sunahip_centrohipicobundle_datalegal_apellido";
                    window.tabError = "#ui-id-2";
                    $(window.tabError).trigger("click");
                    return true;
                }

                if ($('#sunahip_centrohipicobundle_datalegal_tipoci').valid()) {
                    l3 = true;
                } else {
                    window.focusError = "#sunahip_centrohipicobundle_datalegal_tipoci";
                    window.tabError = "#ui-id-2";
                    $(window.tabError).trigger("click");
                    return true;
                }

                if ($('#sunahip_centrohipicobundle_datalegal_ci').valid()) {
                    l4 = true;
                } else {
                    window.focusError = "#sunahip_centrohipicobundle_datalegal_ci";
                    window.tabError = "#ui-id-2";
                    $(window.tabError).trigger("click");
                    return true;
                }

                if ($('#sunahip_centrohipicobundle_datalegal_persJuridica').valid()) {
                    l5 = true;
                } else {
                    window.focusError = "#sunahip_centrohipicobundle_datalegal_persJuridica";
                    window.tabError = "#ui-id-2";
                    $(window.tabError).trigger("click");
                    return true;
                }

                if ($('#sunahip_centrohipicobundle_datalegal_rif').valid()) {
                    l6 = true;
                } else {
                    window.focusError = "#sunahip_centrohipicobundle_datalegal_rif";
                    window.tabError = "#ui-id-2";
                    $(window.tabError).trigger("click");
                    return true;
                }

                if ($('#sunahip_centrohipicobundle_datalegal_estado').valid()) {
                    l7 = true;
                } else {
                    window.focusError = "#sunahip_centrohipicobundle_datalegal_estado";
                    window.tabError = "#ui-id-2";
                    $(window.tabError).trigger("click");
                    return true;
                }

                if ($('#sunahip_centrohipicobundle_datalegal_ciudad').valid()) {
                    l8 = true;
                } else {
                    window.focusError = "#sunahip_centrohipicobundle_datalegal_ciudad";
                    window.tabError = "#ui-id-2";
                    $(window.tabError).trigger("click");
                    return true;
                }

                if ($('#sunahip_centrohipicobundle_datalegal_municipio').valid()) {
                    l9 = true;
                } else {
                    window.focusError = "#sunahip_centrohipicobundle_datalegal_municipio";
                    window.tabError = "#ui-id-2";
                    $(window.tabError).trigger("click");
                    return true;
                }

                if ($('#sunahip_centrohipicobundle_datalegal_parroquia').valid()) {
                    l10 = true;
                } else {
                    window.focusError = "#sunahip_centrohipicobundle_datalegal_parroquia";
                    window.tabError = "#ui-id-2";
                    $(window.tabError).trigger("click");
                    return true;
                }

                if ($('#sunahip_centrohipicobundle_datalegal_email').valid()) {
                    l11 = true;
                } else {
                    window.focusError = "#sunahip_centrohipicobundle_datalegal_email";
                    window.tabError = "#ui-id-2";
                    $(window.tabError).trigger("click");
                    return true;
                }

                /*if ($('#sunahip_centrohipicobundle_datalegal_codigoPostal').valid()) {
                    l12 = true;
                } else {
                    window.focusError = "#sunahip_centrohipicobundle_datalegal_codigoPostal";
                    window.tabError = "#ui-id-2";
                    $(window.tabError).trigger("click");
                    return true;
                }*/

                if (d1 && d2 && d3 && d4 && d5 && d6 && d7 && d8 && d9 && d10 && d11 && d12 &&
                    l1 && l2 && l3 && l4 && l5 && l6 && l7 && l8 && l9 && l10 && l11) {
                    $("#myMessage").html("Esto proceso puede tardar un poco <br/> Por favor espere un momento mientras se guardan los datos");
                    $("#myModal").modal("show");
                    $("#buttonCloseModal").hide();
                    // form.unbind().submit();
                    var url = Routing.generate('data_empresa_save');
                    var form = formFirst.serialize();
                    var p_id = 0;
                    $.post(url, form, function (data) {

                        if (forms.length > 0) {
                            $.each(forms, function (key, value) {
                                console.info("key", key, " value", value);
                                var url = Routing.generate('data_empresa_partner_save');
                                $.post(url, value + "&c_id=" + data.company_id + "&p_id=" + window.p_id, function (response) {
                                    window.p_id = response.p_id;
                                })
                            });
                        }

                        var url = Routing.generate('data_empresa_list');
                        window.location = url;
                    });

                } else {
//                                $("#myMessage").html("Existen campos obligatorios vacios <br/> Debe rellenar todos los campos requeridos");
//                                $("#myModal").modal("show");
//                                $("#buttonCloseModal").show();
                }

            }

            return valid;
        });
    }
//  }
}


jQuery(document).ready(function () {
    $('#buttonCloseModal').click(function () {
        setTimeout(function () {
            $(window.tabError).trigger("click");
            setTimeout(function () {
                $(window.focusError).focus();
            }, 600);
        }, 1000);

    });
    $("#ui-id-1").click(function () {
        $('#divBtnSubmit').show();
        $('#divBtnSubmitPartner').hide();
    });
    $("#ui-id-2").click(function () {
        $('#divBtnSubmit').show();
        $('#divBtnSubmitPartner').hide();
    });
    $("#ui-id-3").click(function () {
        $('#divBtnSubmitPartner').show();
        $('#divBtnSubmit').hide();
    });

//    $("#form_btn").click(function () {
//        console.info("validando");
//        validateForm();
//    });

});

