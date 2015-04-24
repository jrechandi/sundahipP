$('ul li').addClass('color-error')
    // Validation
    $(function() {
        // Validation
        $("#form-change-password").validate({
            // Rules for form validation
            rules: {
                'fos_user_change_password_form[current_password]': {
                    required: true,
                    minlength: 6,
                    maxlength: 8
                },
                'fos_user_change_password_form[plainPassword][first]': {
                    required: true,
                    minlength: 6,
                    maxlength: 8
                },
                'fos_user_change_password_form[plainPassword][second]': {
                    required: true,
                    minlength: 6,
                    maxlength: 8,
                    equalTo: '#fos_user_change_password_form_plainPassword_first'
                }
            },
// Do not change code below
            errorPlacement: function(error, element) {
                error.insertAfter(element.parent());
            }
        });

    });

//function validateNewPassword()
//{
//    var validated = true;
//    var val = $("#fos_user_change_password_form_plainPassword_first").val();
//
//    if (/[a-zA-Z].*\d|\d.*[a-zA-Z]/.test(val))
//        var validated = false;
//
//
////    console.info('afuera',$("#password-error").length );
////    console.info('valor', validated );
//
//    if (validated && $("#password-error").length == 0)
//    {
//        console.info('entro');
//
//        var messagge = "Your password is not secure. At least 6 characters. Letters and numbers are required";
//        var html = "<span style='color:#D56161;font-size: 11px; line-height:15px; font-style: normal' id='password-error' for='fos_user_change_password_form_plainPassword_first' class='invalid'>" + messagge + "</span>";
//        $("#fos_user_change_password_form_plainPassword_first").css('background', '#fff0f0');
//        $("#fos_user_change_password_form_plainPassword_first").css('border-color', '#A90329');
//        $(html).insertAfter("#fos_user_change_password_form_plainPassword_first");
//
//    } else if (!validated) {
//        $("#fos_user_change_password_form_plainPassword_first").css('background', '#f0fff0');
//        $("#fos_user_change_password_form_plainPassword_first").css('border-color', '#7DC27D');
//        $("#password-error").remove();
//    }
//
//    // $('div').text(validated ? "pass" : "fail");
//    // use DOM traversal to select the correct div for this input above
//}