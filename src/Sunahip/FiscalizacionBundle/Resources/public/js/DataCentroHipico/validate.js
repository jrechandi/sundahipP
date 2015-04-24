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
$("form[name=sunahip_centrohipicobundle_datacentrohipico]").validate({
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
        
        'sunahip_centrohipicobundle_datacentrohipico[denominacionComercial]':{
            required: true,
            minlength: 2,
            maxlength: 50        
        },
        'sunahip_centrohipicobundle_datacentrohipico[estatusLocal]':{
            required: false,
        },
        'sunahip_centrohipicobundle_datacentrohipico[propietarioLocal]':{
            required: false,
            minlength: 2,
            maxlength: 30
        },
        'sunahip_centrohipicobundle_datacentrohipico[nombre]': {
            required: false,
            minlength: 2,
            maxlength: 30
        },
        'sunahip_centrohipicobundle_datacentrohipico[apellido]': {
            required: false,
            minlength: 2,
            maxlength: 30
        },
        'sunahip_centrohipicobundle_datacentrohipico[ci]': {
            required: false,
            minlength: 6,
            maxlength: 8
        },
        'sunahip_centrohipicobundle_datacentrohipico[rif]': {
            required: true,
            minlength: 7,
            maxlength: 9
        },
        'sunahip_centrohipicobundle_datacentrohipico[estado]': {
            required: false,
        },
        
        'sunahip_centrohipicobundle_datacentrohipico[municipio]': {
            required: false,
        },
        'sunahip_centrohipicobundle_datacentrohipico[ciudad]': {
            required: false,
            minlength: 3,
        },
        'sunahip_centrohipicobundle_datacentrohipico[parroquia]': {
            required: false,
        },
        'sunahip_centrohipicobundle_datacentrohipico[calle]': {
            required: false,
        },
        'sunahip_centrohipicobundle_datacentrohipico[apartamento]': {
            required: false,
        },
        'sunahip_centrohipicobundle_datacentrohipico[apartamento_no]': {
            required: false,
        },
        'sunahip_centrohipicobundle_datacentrohipico[codTlfFijo]': {
            required: false,
            minlength: 3,
            maxlength: 4
        },
        'sunahip_centrohipicobundle_datacentrohipico[tflFijo]': {
            required: false,
            minlength: 7,
            maxlength: 7
        },
        'sunahip_centrohipicobundle_datacentrohipico[codTlfCelular]': {
            required: false,
            minlength: 3,
            maxlength: 4
        },
        'sunahip_centrohipicobundle_datacentrohipico[tflCelular]': {
            required: false,
            minlength: 7,
            maxlength: 7
        },
       'sunahip_centrohipicobundle_datacentrohipico[codigoPostal]': {
            required: false,
        },
        'sunahip_centrohipicobundle_datacentrohipico[email]': {
            required: false,
            email: true
        },
    },
});
