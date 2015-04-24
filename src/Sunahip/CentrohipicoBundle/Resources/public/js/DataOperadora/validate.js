// Validation
$('em').addClass("errorMessage");

jQuery.validator.addMethod("notEqualTo",
        function(value, element, param) {
            var notEqual = true;
            value = $.trim(value);
            for (i = 0; i < param.length; i++) {
                if (value == $.trim($(param[i]).val())) {
                    notEqual = false;
                }
            }
            return this.optional(element) || notEqual;
        },
        "Este campo es obligatorio."
        );

//$("#form_doper").validate({
$("form[name=sunahip_centrohipicobundle_dataoperadora]").validate({
   highlight : function(label) {
            $(label).closest('.form-group').addClass('has-error');

            var tab_content= $(label).parent().parent().parent().parent().parent().parent().parent();
 
            if ($(tab_content).find("fieldset.tab-pane.active:has(div.has-error)").length == 0) { 
                //alert(tab_content);
                 $(tab_content).find("fieldset.tab-pane:has(div.has-error)").each(function (index, tab) {
                    var id = $(tab).attr("id");
                    $('a[href="#' + id + '"]').tab('show');
                 });
             }
          },

        ignore : [],
    rules: {
        'sunahip_centrohipicobundle_dataoperadora[legal][nombre]': {
            required: true,
            minlength: 2,
            maxlength: 30
        },
        'sunahip_centrohipicobundle_dataoperadora[legal][apellido]': {
            required: true,
            minlength: 2,
            maxlength: 30            
        },
        'sunahip_centrohipicobundle_dataoperadora[legal][ci]': {
            required: true,
            minlength: 6,
            maxlength: 8
        },
        'sunahip_centrohipicobundle_dataoperadora[legal][rif]': {
            required: true,
            minlength: 7,
            maxlength: 9
        },
        'sunahip_centrohipicobundle_dataoperadora[legal][estado]': {
            required: true,
        },
        
        'dlmunicipio': {
            required: true,
            notEqualTo: ['#validaCiudMunParro']
        },
        'dlciudad': {
            required: true,
            notEqualTo: ['#validaCiudMunParro']
        },
        'dlparroquia': {
            required: true,
            notEqualTo: ['#validaCiudMunParro'],
        },
        'sunahip_centrohipicobundle_dataoperadora[legal][calle]': {
            required: true,
        },
        'sunahip_centrohipicobundle_dataoperadora[legal][apartamento]': {
            required: true,
        },
        'sunahip_centrohipicobundle_dataoperadora[legal][apartamento_no]': {
            required: true,
        },
        'sunahip_centrohipicobundle_dataoperadora[legal][codTlfFijo]': {
            required: false,
            minlength: 3,
            maxlength: 4
        },
        'sunahip_centrohipicobundle_dataoperadora[legal][tflFijo]': {
            required: false,
            minlength: 7,
            maxlength: 7
        },
        'sunahip_centrohipicobundle_dataoperadora[legal][codTlfCelular]': {
            required: false,
            minlength: 3,
            maxlength: 4
        },
        'sunahip_centrohipicobundle_dataoperadora[legal][tflCelular]': {
            required: false,
            minlength: 7,
            maxlength: 7
        },
       'sunahip_centrohipicobundle_dataoperadora[legal][codigoPostal]': {
            required: true,
        },
        'sunahip_centrohipicobundle_dataoperadora[legal][email]': {
                email: true,
                minlength: 10,
                maxlength: 50                
        },
        'sunahip_centrohipicobundle_dataoperadora[denominacionComercial]':{
        required: true, 
        },
        'sunahip_centrohipicobundle_dataoperadora[estatusLocal]':{
        required: true, 
        },
        'sunahip_centrohipicobundle_dataoperadora[propietarioLocal]':{
        required: true, 
        },
        'sunahip_centrohipicobundle_dataoperadora[nombre]': {
            required: true,
            minlength: 2,
            maxlength: 30            
        },
        'sunahip_centrohipicobundle_dataoperadora[apellido]': {
            required: true,
            minlength: 2,
            maxlength: 30            
        },
        'sunahip_centrohipicobundle_dataoperadora[ci]': {
            required: true,
            minlength: 6,
            maxlength: 8
        },
        'sunahip_centrohipicobundle_dataoperadora[rif]': {
            required: true,
            minlength: 7,
            maxlength: 9
        },
        'sunahip_centrohipicobundle_dataoperadora[estado]': {
            required: true,
        },
        
        'domunicipio': {
            required: true,
            notEqualTo: ['#validaCiudMunParro']
        },
        'dociudad': {
            required: true,
            notEqualTo: ['#validaCiudMunParro']
        },
        'doparroquia': {
            required: true,
            notEqualTo: ['#validaCiudMunParro'],
        },
        'sunahip_centrohipicobundle_dataoperadora[calle]': {
            required: true,
        },
        'sunahip_centrohipicobundle_dataoperadora[apartamento]': {
            required: true,
        },
        'sunahip_centrohipicobundle_dataoperadora[apartamento_no]': {
            required: true,
        },
        'sunahip_centrohipicobundle_dataoperadora[codTlfFijo]': {
            required: false,
            minlength: 3,
            maxlength: 4
        },
        'sunahip_centrohipicobundle_dataoperadora[tflFijo]': {
            required: false,
            minlength: 7,
            maxlength: 7
        },
        'sunahip_centrohipicobundle_dataoperadora[codTlfCelular]': {
            required: false,
            minlength: 3,
            maxlength: 4
        },
        'sunahip_centrohipicobundle_dataoperadora[tflCelular]': {
            required: false,
            minlength: 7,
            maxlength: 7
        },
       'sunahip_centrohipicobundle_dataoperadora[codigoPostal]': {
            required: true,
        },
        'sunahip_centrohipicobundle_dataoperadora[email]': {
                email: true,
                minlength: 10,
                maxlength: 50                
        }

    },
});
