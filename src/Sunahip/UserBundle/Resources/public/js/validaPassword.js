
    function validatePassword(passId)
{
    var val = $("#"+passId.id).val();
     if (val.length < 6 && $("#password-error").length == 0)
    {

        var messagge = "La contraseña debe ser por lo menos de 6 dígitos.";
        var html = "<span style='color:#D56161;font-size: 11px; line-height:15px; font-style: normal' id='password-error' \n\
                    for='password' class='invalid'>" + messagge + "</span>";
        $(html).insertAfter("#"+passId.id);

    } else if (val.length >= 6) {
        $("#password-error").remove();
    }

}