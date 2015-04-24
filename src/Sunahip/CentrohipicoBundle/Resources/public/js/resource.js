 function getSelect(route, Id, display){
    $(Id).attr('disabled', 'disabled');
     $.get(route).success(function(data) {
            if (data.message) {
                message = data.message;
            } else {
                $(Id).removeAttr('disabled');
                $(Id).empty().append('<option value="">Seleccione '+display+' </option>');
                $.each(data.entities, function(i, d) {
                    $(Id).append('<option value="' + d.id + '">' + d.nombre + '</option>');
                });
                if($(Id).data('selected')){
                    $(Id).val($(Id).data('selected'));
                    if(!$(Id).val())$(Id).val('');
                    $(Id).data('selected', null);
                }
            }
        }).error(function(data, status, headers, config) {
            if (status === '500') {
                message = "No hay conexión con el servidor";
            }
        });
 }
 