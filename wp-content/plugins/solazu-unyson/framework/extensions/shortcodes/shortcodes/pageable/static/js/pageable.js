jQuery(function($) {
    "use strict";

    var SLZ = window.SLZ || {};
    
    SLZ.setWidthHorizontalItem =function(){
        if( $('.slz_shortcode.slz-pageable .slz-horizontal-scroll').length ){
            $('.slz_shortcode.slz-pageable .slz-horizontal-scroll').each(function(){
                $(this).find('.horizontal-wrapper .vc_tta-panel-heading').remove();
                $(this).find('.horizontal-wrapper').children().children().unwrap().wrap('<div class="item"></div>');
                $(this).find('.horizontal-wrapper >.item').css({
                    "width": $(this).width(),
                    'height': 'auto'
                });
            });
            $('.slz-horizontal-scroll').mCustomScrollbar({
                axis: "x",
                theme: "3d",
                scrollButtons: true,
                settop: "100px",
                mouseWheel:{ enable: false }
            });
        }
    };

    $(document).ready(function() {
        SLZ.setWidthHorizontalItem();
    });
    $(window).load(function() {
         SLZ.setWidthHorizontalItem();
    });
    $(window).resize(function() {
        SLZ.setWidthHorizontalItem();
    });

});