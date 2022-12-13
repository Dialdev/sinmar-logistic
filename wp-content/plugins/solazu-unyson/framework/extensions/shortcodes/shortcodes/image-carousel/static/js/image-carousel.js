jQuery(function($) {
    "use strict";

    var SLZ = window.SLZ || {};

    SLZ.slz_image_slider_layout_1 = function() {
        // effect hover
        $('.sc-image-carousel-layout-1 .slz-carousel .item').directionalHover();

        $(".sc-image-carousel-layout-1 .slz-carousel").each( function(e, val) {
            var carousel_item = parseInt($(this).attr('data-slidestoshow'));
            var dots = $(this).attr('data-dotshow');
            var arrow = $(this).attr('data-arrowshow');
            var autoplay = $(this).attr('data-autoplay');
            var loop = $(this).attr('data-infinite');
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
            if ( autoplay == '1' ) {
                autoplay = true;
            }else{
                autoplay = false;
            }
            if ( loop == '1' ) {
                loop = true;
            }else{
                loop = false;
            }

            if (carousel_item == 1) {
                $(this).slick({
                    infinite: loop,
                    autoplay: autoplay,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: dots,
                    arrows: arrow,
                    appendArrows: $(this).parents('.slz-image-carousel'),
                    prevArrow: '<button class="btn btn-prev"><i class="icons fa"></i><span class="text">Previous</span></button>',
                    nextArrow: '<button class="btn btn-next"><span class="text">Next</span> <i class="icons fa"></i></button>'
                });
            }
            if (carousel_item == 2) {
                $(this).slick({
                    infinite: loop,
                    autoplay: autoplay,
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    dots: dots,
                    arrows: arrow,
                    appendArrows: $(this).parents('.slz-image-carousel'),
                    prevArrow: '<button class="btn btn-prev"><i class="icons fa"></i><span class="text">Previous</span></button>',
                    nextArrow: '<button class="btn btn-next"><span class="text">Next</span> <i class="icons fa"></i></button>',
                    responsive: [{
                        breakpoint: 415,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 2,
                        }
                    }]
                });
            }
            if (carousel_item == 3) {
                $(this).slick({
                    infinite: loop,
                    autoplay: autoplay,
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    dots: dots,
                    arrows: arrow,
                    appendArrows: $(this).parents('.slz-image-carousel'),
                    prevArrow: '<button class="btn btn-prev"><i class="icons fa"></i><span class="text">Previous</span></button>',
                    nextArrow: '<button class="btn btn-next"><span class="text">Next</span> <i class="icons fa"></i></button>',
                    responsive: [{
                        breakpoint: 769,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2,
                        }
                    }, {
                        breakpoint: 415,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                        }
                    }]
                });
            }
            if (carousel_item >= 4) {
                $(this).slick({
                    infinite: loop,
                    autoplay: autoplay,
                    slidesToShow: carousel_item,
                    slidesToScroll: carousel_item,
                    dots: dots,
                    arrows: arrow,
                    appendArrows: $(this).parents('.slz-image-carousel'),
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
                        breakpoint: 415,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }]
                });
            }
        });

    };
    
    SLZ.slz_image_slider_layout_2 = function() {
    	$('.sc-image-carousel-layout-2').each(function() {
    		var dots = $(this).find('.slz-carousel-mockup').attr('data-dotshow');
            var arrow = $(this).find('.slz-carousel-mockup').attr('data-arrowshow');
            var autoplay = $(this).find('.slz-carousel-mockup').attr('data-autoplay');
            var loop = $(this).find('.slz-carousel-mockup').attr('data-infinite');
            var sliderMock = $(this).find('.slz-slick-slider-mockup');
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
            if ( autoplay == '1' ) {
                autoplay = true;
            }else{
                autoplay = false;
            }
            if ( loop == '1' ) {
                loop = true;
            }else{
                loop = false;
            }
            sliderMock.on('init', function(){
                $(window).load(function(){
                    $(this).find(".slider-mockup").css("width", $(this).find('img.img-slider-item').width() + 30);
                });
                $(window).resize(function(){
                    $(this).find(".slider-mockup").css("width", $(this).find('img.img-slider-item').width() + 30);
                });
            });
            sliderMock.slick({
                infinite: loop,
                autoplay: autoplay,
                dots: dots,
                arrows: arrow,
                slidesToShow: 3,
                slidesToScroll: 1,
                centerMode: true,
                centerPadding: '160px',
                focusOnSelect: true,
                autoplaySpeed: 2000,
                appendArrows: $(this).find('.slz-carousel-mockup'),
                prevArrow: '<button class="btn btn-prev"><i class="icons fa"></i><span class="text">Previous</span></button>',
                nextArrow: '<button class="btn btn-next"><span class="text">Next</span> <i class="icons fa"></i></button>',
                responsive: [
                    {
                        breakpoint: 1025,
                        settings: {
                            centerPadding: '100px',
                        }
                    },
                    {
                        breakpoint: 769,
                        settings: {
                            centerPadding: '0',
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            centerPadding: '200px',
                        }
                    },
                    {
                        breakpoint: 601,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            centerPadding: '120px',
                        }
                    },
                    {
                        breakpoint: 481,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            centerPadding: '80px',
                            arrows: false,
                        }
                    },
                    {
                        breakpoint: 415,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            centerPadding: '30px',
                            arrows: false,
                        }
                    }
                ]
            })
    	});
    }

    SLZ.slz_image_slider_layout_3 = function() {
        $(".sc-image-carousel-layout-3 .slz-carousel-syncing").each(function() {
            var carousel_item = parseInt($(this).find('.slider-nav').attr('data-slidestoshow'));
            var dots = $(this).find('.slider-nav').attr('data-dotshow');
            var loop = $(this).find('.slider-nav').attr('data-infinite');
            var arrow = $(this).find('.slider-for').attr('data-arrowshow');
            var autoplay = $(this).find('.slider-for').attr('data-autoplay');
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
            if ( autoplay == '1' ) {
                autoplay = true;
            }else{
                autoplay = false;
            }
            if ( loop == '1' ) {
                loop = true;
            }else{
                loop = false;
            }

            //$(this).find('.slider-for').slick( 'unslick' );
            $(this).find('.slider-for').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: arrow,
                fade: true,
                adaptiveHeight: true,
                asNavFor: $(this).find('.slider-nav'),
                prevArrow: '<button class="btn btn-prev"><i class="icons fa"></i><span class="text">Previous</span></button>',
                nextArrow: '<button class="btn btn-next"><span class="text">Next</span> <i class="icons fa"></i></button>',
            });

            //$(this).find('.slider-nav').slick( 'unslick' );
            $(this).find('.slider-nav').slick({
                slidesToShow: carousel_item,
                slidesToScroll: 1,
                asNavFor: $(this).find('.slider-for'),
                focusOnSelect: true,
                arrows: false,
                infinite: loop,
                dots: dots,
                centerMode: true,
                centerPadding: '0px',
                responsive: [{
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 4
                        }
                    }, {
                    breakpoint: 769,
                    settings: {
                        slidesToShow: 4
                        }
                    }, {
                    breakpoint: 601,
                    settings: {
                        slidesToShow: 4
                        }
                    }, {
                    breakpoint: 415,
                    settings: {
                        slidesToShow: 3
                        }
                    }, {
                    breakpoint: 381,
                    settings: {
                        slidesToShow: 2
                    }
                }]
            });
        });
    }

    $(document).ready(function() {
        SLZ.slz_image_slider_layout_1();
        SLZ.slz_image_slider_layout_2();
        SLZ.slz_image_slider_layout_3();
    });
});
