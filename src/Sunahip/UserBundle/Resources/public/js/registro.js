$(document).ready(function() {
    $(".fancybox").fancybox({
        openEffect: 'elastic',
        closeEffect: 'elastic',
        autoSize: false,
        beforeLoad: function() {
            this.width = parseInt(this.element.data('fancybox-width'));
            this.height = parseInt(this.element.data('fancybox-height'));
        },
        padding: 3,
        scrolling: false,
        closeClick: false,
        dataType: 'html',
        headers: {'X-fancyBox': true},
        helpers: {
            overlay: {
                css: {
                    'background': 'rgba(58, 42, 45, 0.95)'
                }
            }
        }
    });

    $(".numeric").keydown(function(e) {
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 || (e.keyCode == 65 && e.ctrlKey === true) || (e.keyCode >= 35 && e.keyCode <= 39)) {
            return;
        }

        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

   

    var $labels = $('.form-datos-basicos label');
    $labels.each(function() {
        $(this).removeClass('col-sm-3');
    });
});
