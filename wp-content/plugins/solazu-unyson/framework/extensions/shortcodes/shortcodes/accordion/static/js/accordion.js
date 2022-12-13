jQuery(function($) {
    "use strict";

    var SLZ = window.SLZ || {};

    SLZ.slz_accordion = function() {
        $('.sc_accordion .check-data-collapsed').on('click', function() {
            $('.sc_accordion .panel-heading').removeClass('active_panel');
            $(this).parent().addClass('active_panel');
        })
    };


    $(document).ready(function() {
        SLZ.slz_accordion();
    });
});
