jQuery(function($) {
    "use strict";

    var SLZ = window.SLZ || {};

    SLZ.slz_event_carousel = function() {
    	if( $('.slz-new-tweet .slz-carousel').length > 0 ) {
	        $(".slz-new-tweet .slz-carousel").each(function() {
	            var carousel_item = iParse( $(this).attr('data-slidesToShow') );
	            var autoplay = $(this).attr( 'data-autoplay' ) === 'yes';
	            var dots = $(this).attr( 'data-isdot' ) === 'yes';
	            var arrows = $(this).attr( 'data-isarrow' ) === 'yes';
	            var infinite = $(this).attr( 'data-infinite' ) === 'yes';
	            var speed = iParse( $(this).attr( 'data-speed' ) );
	
	            var responsive = null;
	
	            if( carousel_item == 2) {
	                responsive = [{
	                    breakpoint: 481,
	                    settings: {
	                        slidesToShow: 1,
	                        slidesToScroll: 1,
	                    }
	                }];
	            }
	
	            if( carousel_item == 3) {
	                responsive = [{
	                    breakpoint: 769,
	                    settings: {
	                        slidesToShow: 2,
	                        slidesToScroll: 2,
	                    }
	                }, {
	                    breakpoint: 481,
	                    settings: {
	                        slidesToShow: 1,
	                        slidesToScroll: 1,
	                    }
	                }];
	            }
	
	            if( carousel_item == 4) {
	                responsive = [{
	                    breakpoint: 1025,
	                    settings: {
	                        slidesToShow: 3,
	                        slidesToScroll: 3,
	                    }
	                }, {
	                    breakpoint: 769,
	                    settings: {
	                        slidesToShow: 2,
	                        slidesToScroll: 2,
	                    }
	                }, {
	                    breakpoint: 481,
	                    settings: {
	                        slidesToShow: 1,
	                        slidesToScroll: 1,
	                    }
	                }];
	            }
	
	            $(this).slick({
	                infinite: infinite,
	                slidesToShow: carousel_item,
	                slidesToScroll: 1,
	                speed: speed,
	                dots: dots,
	                arrows: arrows,
	                appendArrows: $(this).parents('.slz-carousel-wrapper'),
	                prevArrow: '<button class="btn btn-prev"><i class="fa fa-long-arrow-left"></i><span class="text">Previous</span></button>',
	                nextArrow: '<button class="btn btn-next"><span class="text">Next</span> <i class="fa fa-long-arrow-right"></i></button>',
	                responsive: responsive
	            });
	        });
    	}
    };

    $(document).ready(function() {
        SLZ.slz_event_carousel();
    });

    function iParse( string ) {
        var res = parseInt( string );
        return isNaN( res ) ? 0 : res;
    }
});
