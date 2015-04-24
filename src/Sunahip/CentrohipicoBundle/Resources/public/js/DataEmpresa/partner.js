jQuery(document).ready(function () {

    $("#addPartner").click(function () {
        window.childValidate = 0;
        $(".dataPartner").show();
        $("#btnPartner").show();
        $("#rifNumberPartner").val(" ");
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
    //$("#zone_select_partner").html(partnerRif);
    $("#rifNumberPartner").val(" ");
    $("#btnPartner").show();
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

    $(".sociosTable").show();
    $("#btnAddMore").show();
    $("#form_btn").removeAttr('disabled');
}


var valid = false;
var formFirst = $('#form_dch');
var focusError = null;
var tabError = null;

function validateForm() {
    if ($("#rifNumberPartner").val().length < 1) {
        console.info("rif", $("#sunahip_centrohipicobundle_dataempresa_rif").val().length);
        $("#myMessage").html("El rif de la empresa no puede estar vacio");
        $("#myModal").modal("show");
        $("#buttonCloseModal").show();
        window.focusError = "#sunahip_centrohipicobundle_dataempresa_rif";
        window.tabError = "#ui-id-1";
        return true;
    } else {
        var rifType = $("#rifTypePartner").val();
        var rifNumber = $("#rifNumberPartner").val();


        var url = Routing.generate('empresa_verificar_rif', {'rifType': rifType, 'rifNumber': rifNumber});
        $.get(url, function (data) {
            if (data.status == true) {
                $("#myMessage").html("El rif:" + rifType + "-" + rifNumber + " <br/> ya se encuentra registrado en nuestro sistema");
                $("#myModal").modal("show");
                $("#buttonCloseModal").show();
            }
            else{
                $("#myMessage").html("Esto proceso puede tardar un poco <br/> Por favor espere un momento mientras se guardan los datos");
                $("#myModal").modal("show");
                $("#buttonCloseModal").hide();
                var form = formFirst.serialize();
                var p_id = 0;
                var company_id = $("#company_id").val();

                if (forms.length > 0) {
                    $.each(forms, function (key, value) {
                        console.info("key", key, " value", value);
                        var url = Routing.generate('data_empresa_partner_save');
                        $.post(url, value + "&p_id=" + window.p_id, function (response) {
                            window.p_id = response.p_id;
                        })
                    });
                }

                var url = Routing.generate('data_empresa_list');
                window.location = url;
            return valid;
            }

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

    $("#form_btn").click(function () {
        console.info("validando");
        validateForm();
    });

});

