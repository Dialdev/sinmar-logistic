jQuery(function($){
    "use strict";

    $.slz_sc_countdown = function () {
        if( $('.slz-count-down').length > 0 ) {
            $('.slz-count-down').each(function(idx, dom ){
                var expire = $( dom ).data( 'expire' );
                if( expire ) {
                    expire = new Date( expire ).getTime();
                    var days    = $( dom ).find('.days span');
                    var hours   = $( dom ).find('.hours span');
                    var minutes = $( dom ).find('.minutes span');
                    var seconds = $( dom ).find('.seconds span');
                    var itv_id = window.setInterval(function () {
                        var current = new Date().getTime();
                        var seconds_left = ( expire - current ) / 1000;
                        if( seconds_left <= 0 ) {
                            window.clearInterval( itv_id );
                            return;
                        }
                        days.text( parseInt( seconds_left / 86400 ) );
                        seconds_left %= 86400;
                        hours.text( parseInt( seconds_left / 3600 ) );
                        seconds_left %= 3600;
                        minutes.text( parseInt( seconds_left / 60 ) );
                        seconds.text( parseInt( seconds_left % 60 ) );
                    }, 1000);
                }
            });
        }
    };

    $(document).ready(function(){
        jQuery.slz_sc_countdown();
    });
});