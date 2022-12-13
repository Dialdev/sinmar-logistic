jQuery(function($) {
    "use strict";

    var SLZ = window.SLZ || {};

    SLZ.autoPlayYouTubeModal = function() {
        $('.sc_video_carousel .item a').on('click', function() {
            var themodal = $(this).attr('data-target');
            var videourl = $(this).attr('data-thevideo');
            $(themodal + ' iframe').attr('src', videourl);
            $(themodal + ' button.close').click(function() {
                $(themodal + ' iframe').attr('src', '');
            });
            $('.slz-video-modal').click(function() {
                $(themodal + ' iframe').attr('src', '');
            });
        });
    }

    SLZ.video_carousel = function() {
        $(".sc_video_carousel .slz-carousel.sc-video-carousel-item").each(function() {
            var carousel_item = $(this).attr('data-slidesToShow'),
                number_parse = parseInt(carousel_item);
            $(this).slick({
                infinite: true,
                slidesToShow: number_parse,
                slidesToScroll: number_parse,
                speed: 600,
                dots: true,
                arrows: false
            });
        });
        $(".sc_video_carousel .slz-carousel-vertical.sc-video-carousel-item").each(function() {
            var carousel_item = $(this).attr('data-slidesToShow'),
                number_parse = parseInt(carousel_item);
            // alert(carousel_item);
            // $(this).slick('unslick');
            $(this).slick({
                infinite: true,
                slidesToShow: number_parse,
                slidesToScroll: number_parse,
                speed: 600,
                dots: true,
                arrows: true,
                vertical: true,
                verticalSwiping: true,
                centerMode: true,
                centerPadding: '25%',
                prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-up"></i></button>',
                nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-down"></i></button>',
                responsive: [{
                    breakpoint: 768,
                    settings: {
                        arrows: false,
                        dots: true,
                        centerMode: false,
                        centerPadding: '0'
                    }
                }]
            });
            if($(window).width() > 767) {
                 $(".sc_video_carousel .slz-carousel-vertical.sc-video-carousel-item").on('afterChange', function(event, slick, currentSlide) {
                    $(this).find('.slick-current').removeClass('slick-center slick-current slick-active').prev().addClass('slick-center slick-current slick-active');
                })
                $(this).find('.slick-current').removeClass('slick-center slick-current slick-active').prev().addClass('slick-center slick-current slick-active');
            };
        });
        $('.sc_video_carousel .slz-carousel-syncing').each(function (idx, dom) {
            var slide_for = $(dom).find('.slider-for');
            var slide_nav = $(dom).find('.slider-nav');
            var slideToShow = slide_nav.data('slidetoshow') ? slide_nav.data('slidetoshow') : 3 ;

            slide_for.slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: 1,
                fade: true,
                adaptiveHeight: true,
                asNavFor: $(this).find('.slider-nav'),
                prevArrow: '<button class="btn btn-prev"><i class="icons fa"></i><span class="text">Previous</span></button>',
                nextArrow: '<button class="btn btn-next"><span class="text">Next</span> <i class="icons fa"></i></button>',
            });

            slide_nav.slick({
                slidesToShow: slideToShow,
                slidesToScroll: 1,
                asNavFor: $(this).find('.slider-for'),
                focusOnSelect: true,
                arrows: false,
                infinite: 1,
                dots: 1,
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


    /*======================================
    =            INIT FUNCTIONS            =
    ======================================*/

    $(document).ready(function() {
        SLZ.autoPlayYouTubeModal();
        SLZ.video_carousel();
    });
    /*=====  End of INIT FUNCTIONS  ======*/
});
