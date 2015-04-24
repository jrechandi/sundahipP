$(document).ready(function() {
    $("#tabs").tabs();

    function centrar() {
        alto = $(window).height() - $("#cinta_gob").height() - $("#footer").height();
        $(".inicio").outerHeight(alto);
        alto2 = $(".inicio").height() - $("#header").height();
        $(".inicio #cuerpo").css({"height": alto2});
        $("#login").animate({"margin-top": (alto2 - $("#login").height()) / 2, "margin-left": ($("#cuerpo").width() - $("#login").width()) / 2});
    }

    $(".numeric").keydown(function(e) {
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 || (e.keyCode == 65 && e.ctrlKey === true) || (e.keyCode >= 35 && e.keyCode <= 39)) {
            return;
        }

        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    centrar();
});