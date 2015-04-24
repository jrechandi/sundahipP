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

    $("#extra_user_profile").validate({

      rules: {
            'extra_user_profile[estado]': {
                required: true,
             },
             'extra_user_profile[municipio]': {
                required: true,
                notEqualTo: ['#validaCiudMunParro']
             },
             'extra_user_profile[ciudad]': {
                required: true,
             },
             'extra_user_profile[parroquia]': {
                required: true,
                notEqualTo: ['#validaCiudMunParro'],
                },
              'extra_user_profile[calle]':{
                 required: true, 
                },
              'extra_user_profile[apartamento]':{
                  required: true,
                },
                
              'extra_user_profile[apartamento_no]':{
                  required: true, 
                },
              'extra_user_profile[cod_telefono_local]':{
                  required: true,  
                  minlength: 3,
                  maxlength: 4
                },
              'extra_user_profile[telefono_local]':{
                   required: true,
                   minlength: 7,
                   maxlength: 7
                },
              'extra_user_profile[cod_telefono_movil]':{
                  required: false,  
                  minlength: 3,
                  maxlength: 4
                },
              'extra_user_profile[telefono_movil]':{
                   required: false,
                   minlength: 7,
                   maxlength: 7
                }
             
        },
 });
