jQuery(function($) {
    "use strict";

    var SLZ = window.SLZ || {};

    SLZ.slz_portfolio_category = function() {

        $(".sc_project_category .slz-carousel").each(function() {
            var carousel_item = parseInt( $(this).attr('data-slidesToShow') );
            var slidetoscroll = parseInt( $(this).attr('data-slidetoscroll') );
            var arrow = true;
            var dots = true;
            if( $(this).attr('data-arrow') == 'no' ) {
            	arrow = false;
            }
            if( $(this).attr('data-dots') == 'no' ) {
            	dots = false;
            }
            
            // alert(carousel_item);
            if (carousel_item == 1) {
                $(this).slick({
                    infinite: true,
                    slidesToShow: 1,
                    slidesToScroll: slidetoscroll,
                    speed: 600,
                    dots: dots,
                    arrows: arrow,
                    appendArrows: $(this).parents('.slz-carousel-wrapper'),
                    prevArrow: '<button class="btn btn-prev"><i class="icons fa"></i><span class="text">Previous</span></button>',
                    nextArrow: '<button class="btn btn-next"><span class="text">Next</span> <i class="icons fa"></i></button>',
                });
            }
            if (carousel_item == 2) {
                $(this).slick({
                    infinite: true,
                    slidesToShow: carousel_item,
                    slidesToScroll: slidetoscroll,
                    speed: 600,
                    dots: dots,
                    arrows: arrow,
                    appendArrows: $(this).parents('.slz-carousel-wrapper'),
                    prevArrow: '<button class="btn btn-prev"><i class="icons fa"></i><span class="text">Previous</span></button>',
                    nextArrow: '<button class="btn btn-next"><span class="text">Next</span> <i class="icons fa"></i></button>',
                    responsive: [{
                        breakpoint: 481,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                        }
                    }]
                });
            }
            if (carousel_item == 3) {
                $(this).slick({
                    infinite: true,
                    slidesToShow: carousel_item,
                    slidesToScroll: slidetoscroll,
                    speed: 600,
                    dots: dots,
                    arrows: arrow,
                    appendArrows: $(this).parents('.slz-carousel-wrapper'),
                    prevArrow: '<button class="btn btn-prev"><i class="icons fa"></i><span class="text">Previous</span></button>',
                    nextArrow: '<button class="btn btn-next"><span class="text">Next</span> <i class="icons fa"></i></button>',
                    responsive: [{
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
                    }]
                });
            }
            if (carousel_item >= 4) {
                $(this).slick({
                    infinite: true,
                    slidesToShow: carousel_item,
                    slidesToScroll: slidetoscroll,
                    speed: 600,
                    dots: dots,
                    arrows: arrow,
                    appendArrows: $(this).parents('.slz-carousel-wrapper'),
                    prevArrow: '<button class="btn btn-prev"><i class="icons fa"></i><span class="text">Previous</span></button>',
                    nextArrow: '<button class="btn btn-next"><span class="text">Next</span> <i class="icons fa"></i></button>',
                    responsive: [{
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
                    }]
                });
            }
        });
	
    };

    $(document).ready(function() {
        SLZ.slz_portfolio_category();
    });

});
