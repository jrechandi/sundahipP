$(function() {
    $(".show_detail").click(function(ev) {
        var identificador = $(this).attr("id");
        $.get(Routing.generate('datacentrohipico_show', {id: identificador}), function(data) {
            $('#datos_hipicos').html(data);// llenarel div llenar del body de la ventana modal
        });

    });
});