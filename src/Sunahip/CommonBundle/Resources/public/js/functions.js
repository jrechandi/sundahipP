/*
 NUMEROS ENTEROS
 */
function isNumericInteger(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31
        && (charCode < 48 || charCode > 57))
        return false;

    return true;
}

/*
 NUMEROS FLOTANTES
 */
function isNumericFloat(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;

    //Chequear solo un punto (.)
    if (charCode == 46 && $(evt.target).val().lastIndexOf('.') !== -1)
        return false;

    if (charCode != 46 && charCode > 31
        && (charCode < 48 || charCode > 57))
        return false;

    return true;
}

/*
 MONETARIO
 */
function isNumericCurrency(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;

    //Chequear solo un punto (.)
    if (charCode == 46 && $(evt.target).val().lastIndexOf('.') !== -1)
        return false;

    //Solo 2 lugares decimales
    if ($(evt.target).val().lastIndexOf('.') !== -1 && $(evt.target).val().length - $(evt.target).val().lastIndexOf('.') >= 3)
        return false;

    if (charCode != 46 && charCode > 31
        && (charCode < 48 || charCode > 57))
        return false;

    return true;
}

/*
 DIMENSIONES
 */
function isNumericMeasurement(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;

    //Chequear solo una coma (,)
    if (charCode == 44 && $(evt.target).val().lastIndexOf(',') !== -1)
        return false;

    //Solo 2 lugares decimales
    if ($(evt.target).val().lastIndexOf(',') !== -1 && $(evt.target).val().length - $(evt.target).val().lastIndexOf(',') >= 3) {
        return false;
    }

    if (charCode != 44 && charCode > 31
        && (charCode < 48 || charCode > 57))
        return false;

    return true;
}

/*
 SOLO LETRAS
 */
function isAlpha(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    console.info(charCode)
    // SI ES SEPARADORES O                MAYUSCULAS              O                 LETRAS NORMALES       O CARACTERES TILDADOS
    if (charCode < 33 || ( charCode >= 65 && charCode <= 90 ) || ( charCode >= 97 && charCode <= 122 ) || ( charCode >= 192 && charCode <= 255 ))
        return true;

    return false;
}

/*
 SOLO LETRAS CON CARACTERES ESPECIALES Y COMAS
 */
function isAlphaSpecialKeys(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    console.info(charCode)
    // SI ES SEPARADORES O                MAYUSCULAS              O                 LETRAS NORMALES       O CARACTERES TILDADOS                     O COMA
    if (charCode < 33 || ( charCode >= 65 && charCode <= 90 ) || ( charCode >= 97 && charCode <= 122 ) || ( charCode >= 192 && charCode <= 255 ) || charCode == 44)
        return true;

    return false;
}

/*
 SKU
 */
function isSKU(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;

    // SI ES SEPARADORES O                NUMEROS              O               MAYUSCULAS              O                 LETRAS NORMALES        O    GUIÓN
    if (charCode < 33 || ( charCode >= 48 && charCode <= 57 ) || ( charCode >= 65 && charCode <= 90 ) || ( charCode >= 97 && charCode <= 122 ) || charCode == 45)
        return true;

    return false;
}

/*
 ALFANUMERICO
 */
function isAlphaNumeric(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode

    // SI ES SEPARADORES O                NUMEROS              O               MAYUSCULAS              O                 LETRAS NORMALES
    if (charCode < 33 || ( charCode >= 48 && charCode <= 57 ) || ( charCode >= 65 && charCode <= 90 ) || ( charCode >= 97 && charCode <= 122 ))
        return true;

    return false;
}

/*
 ALFANUMERICO CON CON CARACTERES ESPECIALES Y COMAS
 */
function isAlphaNumericSpecialKeys(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode

    // SI ES SEPARADORES O                NUMEROS              O               MAYUSCULAS              O                 LETRAS NORMALES            O CARACTERES TILDADOS                     O COMA
    if (charCode < 33 || ( charCode >= 48 && charCode <= 57 ) || ( charCode >= 65 && charCode <= 90 ) || ( charCode >= 97 && charCode <= 122 ) || ( charCode >= 192 && charCode <= 255 ) || charCode == 44)
        return true;

    return false;
}

/*
 ALFANUMERICO CAMBIANDO ESTACIO POR UNDERSCORE
 */
function isAlphaNumericChange(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode

    //Espacio
    if (charCode == 32 || charCode == 95) {
        var value = $(evt.target).val();
        var last_ = value.lastIndexOf('_');
        var lastSpace = value.lastIndexOf(' ');
        if (last_ == value.length - 1 || lastSpace == value.length - 1)
            return false;
    }

    // SI ES SEPARADORES O                NUMEROS              O               MAYUSCULAS              O                 LETRAS NORMALES
    if (charCode < 33 || charCode == 95 || ( charCode >= 48 && charCode <= 57 ) || ( charCode >= 65 && charCode <= 90 ) || ( charCode >= 97 && charCode <= 122 ))
        return true;

    return false;
}

/*
 ALFANUMERICO CAMBIANDO ESTACIO POR UNDERSCORE
 */
function isAlphaNumericNoSpace(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode

    // SI ES SEPARADORES O                NUMEROS              O               MAYUSCULAS              O                 LETRAS NORMALES
    if ((charCode < 33 && charCode != 32) || charCode == 95 || ( charCode >= 48 && charCode <= 57 ) || ( charCode >= 65 && charCode <= 90 ) || ( charCode >= 97 && charCode <= 122 ))
        return true;

    return false;
}

/* validar telefonos*/
    function validatePhone(telId)
    {

    var val = $("#"+telId.id).val();
    var required =   $("#"+telId.id).attr("required");
        if(required || val.length > 0){
                if (val.length < 7 && $("#phone"+telId.id).length == 0)
                {
                    var messagge = "El valor debe ser de 7 dígitos.";
                    var html = "<span style='color:#D56161;font-size: 11px; line-height:15px; font-style: normal' \n\
                                id='phone"+telId.id+"'\n\
                                for="+telId.id+" class='invalid'>" + messagge + "</span>";
                    $(html).insertAfter("#"+telId.id);

                } else if (val.length == 7) {
                    $("#phone"+telId.id).remove();
                }
        }
    }
/*fin validar telefonos*/

/*validar codigo de area de los telefonos*/
    function validatePhoneCode(codId)
{
    var val = $("#"+codId.id).val();
    var required =   $("#"+codId.id).attr("required");
    if(required || val.length > 0){
        if (val.length < 3 && $("#code"+codId.id).length == 0)
        {

            var messagge = "El valor debe ser minimo 3 dígitos.";
            var html = "<span style='color:#D56161;font-size: 11px; line-height:15px; font-style: normal' \n\
                        id='code"+codId.id+"' for="+codId.id+" class='invalid'>" + messagge + "</span>";
            $(html).insertAfter("#"+codId.id);

        } else if (val.length >= 3) {
            $("#code"+codId.id).remove();
        }
    }
    /* fin validar codigo de area de los telefonos*/
}

/* validar cedulas*/
    function validateCi(ciId)
    {

        var val = $("#"+ciId.id).val();
        var required =   $("#"+ciId.id).attr("required");
        if(required || val.length > 0){
                if (val.length < 6 && $("#ci"+ciId.id).length == 0)
                {
                    var messagge = "El valor debe ser de al menos 6 dígitos.";
                    var html = "<span style='color:#D56161;font-size: 11px; line-height:15px; font-style: normal' \n\
                                id='ci"+ciId.id+"' for="+ciId.id+" class='invalid'>" + messagge + "</span>";
                    $(html).insertAfter("#"+ciId.id);

                } else if (val.length >= 6) {
                    $("#ci"+ciId.id).remove();
                }
        }   
    }
/*fin validar cedulas*/

/* validar Rif*/
    function validateRif(riId)
    {

        var val = $("#"+riId.id).val();
        var required =   $("#"+riId.id).attr("required");
        if(required || val.length > 0){
                if (val.length < 7 && $("#rif"+riId.id).length == 0)
                {
                    var messagge = "El valor debe ser entre 7 y 9 dígitos.";
                    var html = "<span style='color:#D56161;font-size: 11px; line-height:15px; font-style: normal' \n\
                                id='rif"+riId.id+"' for="+riId.id+" class='invalid'>" + messagge + "</span>";
                    $(html).insertAfter("#"+riId.id);

                } else if (val.length >= 7) {
                    $("#rif"+riId.id).remove();
                }
        }
    }
/*fin validar rif*/

/* validar Nombre*/
    function validateNombre(nombreId)
    {

        var val = $("#"+nombreId.id).val();
        var required =   $("#"+nombreId.id).attr("required");
        if(required || val.length > 0){
                if (val.length < 2 && $("#nombre"+nombreId.id).length == 0)
                {
                    var messagge = "El nombre debe poseer entre 2 y 30 caracteres.";
                    var html = "<span style='color:#D56161;font-size: 11px; line-height:15px; font-style: normal' \n\
                                id='nombre"+nombreId.id+"' for="+nombreId.id+" class='invalid'>" + messagge + "</span>";
                    $(html).insertAfter("#"+nombreId.id);

                } else if (val.length >= 2) {
                    $("#nombre"+nombreId.id).remove();
                }
        }
    }
/*fin validar Nombre*/

/* validar Apellido*/
    function validateApellido(apellidoId)
    {

        var val = $("#"+apellidoId.id).val();
        var required =   $("#"+apellidoId.id).attr("required");
        if(required || val.length > 0){
                if (val.length < 2 && $("#apellido"+apellidoId.id).length == 0)
                {
                    var messagge = "El apellido debe poseer entre 2 y 30 caracteres.";
                    var html = "<span style='color:#D56161;font-size: 11px; line-height:15px; font-style: normal' \n\
                                id='apellido"+apellidoId.id+"' for="+apellidoId.id+" class='invalid'>" + messagge + "</span>";
                    $(html).insertAfter("#"+apellidoId.id);

                } else if (val.length >= 2) {
                    $("#apellido"+apellidoId.id).remove();
                }
        }
    }
/*fin validar Apellido*/

/* validar email*/
    function validateEmail(emailId)
    {

        var val = $("#"+emailId.id).val();
        var required =   $("#"+emailId.id).attr("required");
        if(required || val.length > 0){
                if (val.length < 10 && $("#email"+emailId.id).length == 0)
                {
                    var messagge = "El mail debe poseer entre 10 y 50 caracteres.";
                    var html = "<span style='color:#D56161;font-size: 11px; line-height:15px; font-style: normal' \n\
                                id='email"+emailId.id+"' for="+emailId.id+" class='invalid'>" + messagge + "</span>";
                    $(html).insertAfter("#"+emailId.id);

                } else if (val.length >= 10) {
                    $("#email"+emailId.id).remove();
                }
        }
    }
/*fin validar email*/

//Cambiar los mensajes a castellano
$(document).ready(function() {
    jQuery.extend(jQuery.validator.messages, {
      required: "Este campo es obligatorio.",
      remote: "Por favor, rellena este campo.",
      email: "Por favor, escribe una dirección de correo válida",
      url: "Por favor, escribe una URL válida.",
      date: "Por favor, escribe una fecha válida.",
      dateISO: "Por favor, escribe una fecha (ISO) válida.",
      number: "Por favor, escribe un número entero válido.",
      digits: "Por favor, escribe sólo dígitos.",
      creditcard: "Por favor, escribe un número de tarjeta válido.",
      equalTo: "Por favor, escribe el mismo valor de nuevo.",
      accept: "Por favor, escribe un valor con una extensión aceptada.",
      maxlength: jQuery.validator.format("Por favor, no escribas más de {0} caracteres."),
      minlength: jQuery.validator.format("Por favor, no escribas menos de {0} caracteres."),
      rangelength: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
      range: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1}."),
      max: jQuery.validator.format("Por favor, escribe un valor menor o igual a {0}."),
      min: jQuery.validator.format("Por favor, escribe un valor mayor o igual a {0}.")
    });
});

