jQuery(function($) {
    "use strict";

    $.slz_team_carousel_sc = function() {
        if((".slz-block-team-05").length){
            $(".slz-block-team-05 .team-content .sub-content").mCustomScrollbar({
                theme:"minimal-dark"
            });
        };

        $('.sc_team_carousel .slz-carousel').each(function() {
            var carousel_item = parseInt($(this).attr('data-slidestoshow')),
                dots = $(this).attr('data-dotshow'),
                arrow = $(this).attr('data-arrowshow'),
                speed = $(this).attr('data-speed'),
                autoplay = $(this).attr('data-autoplay'),
                infinite = $(this).attr('data-infinite'),
                animation = $(this).attr('data-animation');

            if( speed == 0 || speed == '' || speed == undefined){
                speed = 600;
            }
            if( autoplay == '1' ){
                autoplay = true;
            } else {
                autoplay = false;
            }
            if( infinite == '1' ){
                infinite = true;
            } else {
                infinite = false;
            }
            if ( dots == '1' ) {
                dots = true;
            }else{
                dots = false;
            }
            if ( arrow == '1' ) {
                arrow = true;
            }else{
                arrow = false;
            }
            if ( animation == '1' ) {
                animation = true;
            }else{
                animation = false;
            }

            if (carousel_item == 1) {
                $(this).slick({
                    infinite: infinite,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    speed: speed,
                    dots: dots,
                    arrows: arrow,
                    autoplay: autoplay,
                    fade: animation,
                    adaptiveHeight: true,
                    appendArrows: $(this).parents('.slz-carousel-wrapper'),
                    prevArrow: '<button class="btn btn-prev"><i class="icons fa"></i><span class="text">Previous</span></button>',
                    nextArrow: '<button class="btn btn-next"><span class="text">Next</span> <i class="icons fa"></i></button>',
                    responsive: [
                        {
                            breakpoint: 769,
                            settings: {
                                arrows: false,
                                dots: true
                            }
                        }
                    ]
                });
            }
            else if (carousel_item == 2) {
                $(this).slick({
                    infinite: infinite,
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    speed: speed,
                    dots: dots,
                    arrows: arrow,
                    autoplay: autoplay,
                    fade: animation,
                    adaptiveHeight: true,
                    appendArrows: $(this).parents('.slz-carousel-wrapper'),
                    prevArrow: '<button class="btn btn-prev"><i class="icons fa"></i><span class="text">Previous</span></button>',
                    nextArrow: '<button class="btn btn-next"><span class="text">Next</span> <i class="icons fa"></i></button>',
                    responsive: [
                        {
                            breakpoint: 769,
                            settings: {
                                arrows: false,
                                dots: true
                            }
                        }, {
                            breakpoint: 415,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                arrows: false,
                                dots: true
                            }
                        }
                    ]
                });
            }
            else if (carousel_item == 3) {
                $(this).slick({
                    infinite: infinite,
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    speed: speed,
                    dots: dots,
                    arrows: arrow,
                    autoplay: autoplay,
                    fade: animation,
                    adaptiveHeight: true,
                    appendArrows: $(this).parents('.slz-carousel-wrapper'),
                    prevArrow: '<button class="btn btn-prev"><i class="icons fa"></i><span class="text">Previous</span></button>',
                    nextArrow: '<button class="btn btn-next"><span class="text">Next</span> <i class="icons fa"></i></button>',
                    responsive: [
                        {
                            breakpoint: 769,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2,
                                arrows: false,
                                dots: true
                            }
                        }, {
                            breakpoint: 415,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                arrows: false,
                                dots: true
                            }
                        }
                    ]
                });
            }
            else if (carousel_item >= 4) {
                $(this).slick({
                    infinite: infinite,
                    slidesToShow: carousel_item,
                    slidesToScroll: carousel_item,
                    speed: speed,
                    dots: dots,
                    arrows: arrow,
                    autoplay: autoplay,
                    fade: animation,
                    adaptiveHeight: true,
                    appendArrows: $(this).parents('.slz-carousel-wrapper'),
                    prevArrow: '<button class="btn btn-prev"><i class="icons fa"></i><span class="text">Previous</span></button>',
                    nextArrow: '<button class="btn btn-next"><span class="text">Next</span> <i class="icons fa"></i></button>',
                    responsive: [
                        {
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
                                arrows: false,
                                dots: true
                            }
                        }, {
                            breakpoint: 415,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                arrows: false,
                                dots: true
                            }
                        }
                    ]
                });
            }
        });
    };

    $.slz_team_carousel_sc_layout3 = function(){
        if ( $('.sc_team_carousel .slz-team-wrapper-03').length ) {
            $('.sc_team_carousel.layout-3').each(function() {
                var item = $(this).attr('data-item');
                var block = '.' + item + ' ';
                $(block + ".slz-team-slider-03").slick({
                    infinite: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    speed: 600,
                    dots: false,
                    arrows: false,
                    asNavFor: block + '.slz-team-nav-03',
                    fade:true,
                    responsive: [
                    {
                        breakpoint: 991,
                        settings: {
                            dots: true,
                            adaptiveHeight: true
                        }
                    }]
                });
                $(block + ".slz-team-nav-03").slick({
                    infinite: true,
                    slidesToShow: 5,
                    speed: 600,
                    dots: true,
                    focusOnSelect:true,
                    asNavFor: block + '.slz-team-slider-03',
                    prevArrow: '<span class="btn btn-prev"><i class="fa fa-angle-left"></i></span>',
                    nextArrow: '<span class="btn btn-next"><i class="fa fa-angle-right"></i></span>',
                    responsive: [
                    {
                        breakpoint: 1025,
                        settings: {
                            slidesToShow: 4,
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 3,
                        }
                    }]
                });

            });
        }
    };
    
    $.slz_team_carousel_sc_layout6 = function () {
    	if( $('.sc_team_carousel.layout-6 .slz-carousel-img').length ) {
    		$('.sc_team_carousel.layout-6').each(function() {
                var item = $(this).attr('data-item');
                var block = '.' + item + ' ';

                $( block + " .slz-carousel-wrapper-02 .slz-carousel-info").slick({
                    infinite: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 2000,
                    speed: 600, 
                    dots: true,
                    arrows: false,
                    fade: true,
                    asNavFor: block + " .slz-carousel-wrapper-02 .slz-carousel-img"
                });
                $( block + " .slz-carousel-wrapper-02 .slz-carousel-img").slick({
                    infinite: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    speed: 600, 
                    dots: false,
                    arrows: false,
                    fade: true,
                    asNavFor: block + " .slz-carousel-wrapper-02 .slz-carousel-info"
                });
    		});
    	}
    }

    $.slz_team_carousel_sc_layout7 = function () {
        $('.sc_team_carousel.layout-7 ').each(function() {
            var dots = $(this).find('.team-center-slick').attr('data-dotshow'),
                arrow = $(this).find('.team-center-slick').attr('data-arrowshow'),
                infinite = $(this).find('.team-center-slick').attr('data-infinite'),
                autoplay = $(this).find('.team-center-slick').attr('data-autoplay');

            if ( dots == '1' ) {
                dots = true;
            }else{
                dots = false;
            }
            if ( arrow == '1' ) {
                arrow = true;
            }else{
                arrow = false;
            }
            if( infinite == '1' ){
                infinite = true;
            } else {
                infinite = false;
            }
            if( autoplay == '1' ){
                autoplay = true;
            } else {
                autoplay = false;
            }
            $(this).find('.team-center-slick').slick({
                arrows: arrow,
                dots: dots,
                infinite: infinite,
                centerMode: true,
                slidesToShow: 3,
                slidesToScroll: 3,
                autoplay : autoplay,
            });
        })

    }
    
    $(document).ready(function() {
        jQuery.slz_team_carousel_sc();
        jQuery.slz_team_carousel_sc_layout3();
        jQuery.slz_team_carousel_sc_layout6();
        jQuery.slz_team_carousel_sc_layout7();
    });
});
