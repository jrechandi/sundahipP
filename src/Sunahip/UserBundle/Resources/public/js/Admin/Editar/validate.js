    // Validation
    $('em').addClass("errorMessage");
        
    jQuery.validator.addMethod("notEqualTo",
        function(value, element, param) {
        var notEqual = true;
        value = $.trim(value);
        for (i = 0; i < param.length; i++) {
            if (value == $.trim($(param[i]).val())) { notEqual = false; }
        }
        return this.optional(element) || notEqual;
    },
    "Este campo es obligatorio."
    );

    $("#form-user_edit").validate({

      rules: {
            'user_profile_edit[roleType]': {
                required: true,
             },
             'user_profile_edit[persJuridica]': {
                required: true
             },
             'user_profile_edit[rif]': {
                required: true,
             },
             'user_profile_edit[nombre]': {
                required: true,
                },
              'user_profile_edit[apellido]':{
                 required: true, 
                },
              'user_edit[email]':{
                  required: true,
                    email: true
                },
                
              'user_edit[password]':{ 
                  minlength: 6,
                  maxlength: 8
                },
              'user_edit[confirm]':{  
                  minlength: 6,
                  maxlength: 8,
                  equalTo: '#user_edit_password]'
                }             
        },
 });
