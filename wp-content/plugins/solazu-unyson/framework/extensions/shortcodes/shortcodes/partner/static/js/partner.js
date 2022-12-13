jQuery(function($){
    "use strict";

    var SLZ = window.SLZ || {};

    $.slz_partner_carousel_sc = function() {
        if ( $('.sc_partner').length ) {
            $('.sc_partner').each(function() {
                var item = $(this).attr('data-item');
                var block = '.' + item + ' ';
                var slick_block = $(block + ".slz-partner-slide-slick");
                if ( slick_block.length ) {
                    var slick_json = $(slick_block).data('slick-json');
                    if (typeof slick_json !== 'undefined') {
                        var element = {
                            centerMode: false,
                            prevArrow: '<button class="btn btn-prev"><i class="icons fa"></i></button>',
                            nextArrow: '<button class="btn btn-next"><i class="icons fa"></i></button>',
                            responsive: [
                                {
                                    breakpoint: 769,
                                    settings: {
                                        slidesToShow: 4,
                                        slidesToScroll: 4
                                    }
                                },
                                {
                                    breakpoint: 600,
                                    settings: {
                                        slidesToShow: 3,
                                        slidesToScroll: 3
                                    }
                                },
                                {
                                    breakpoint: 415,
                                    settings: {
                                        slidesToShow: 2,
                                        slidesToScroll: 2
                                    }
                                }
                            ]
                        };
                        jQuery.extend( slick_json, element );
                        slick_block.slick( slick_json );
                    }                   
                }
            });
        }
    };

    /*======================================
    =            INIT FUNCTIONS            =
    ======================================*/

    $(document).ready(function(){
        jQuery.slz_partner_carousel_sc();
    });

    $(window).on('load', function() {
    });

    $(window).on('resize', function() {
    });
    /*======================================
    =          END INIT FUNCTIONS          =
    ======================================*/

});