jQuery(function($) {
    "use strict";

    var SLZ = window.SLZ || {};

    SLZ.slz_breaking_news_1 = function() {
        $(".slz-breaking-news-01.slz-carousel-wrapper .slz-carousel").each(function() {
            var carousel_item = $(this).attr('data-slidesToShow');
            // alert(carousel_item);
            if (carousel_item >= 4) {
                $(this).slick({
                    infinite: true,
                    slidesToShow: carousel_item,
                    slidesToScroll: 1,
                    speed: 600,
                    dots: false,
                    arrows: false,
                    appendArrows: $(this).parents('.slz-carousel-wrapper'),
                    prevArrow: '<button class="btn btn-prev"><i class="fa fa-long-arrow-left"></i><span class="text">Previous</span></button>',
                    nextArrow: '<button class="btn btn-next"><span class="text">Next</span> <i class="fa fa-long-arrow-right"></i></button>',
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
    
    SLZ.slz_breaking_news_2 = function() {
        $('.vticker').easyTicker({
            direction: 'up',
            easing: 'easeInOutBack',
            speed: 'slow',
            interval: 5000,
            height: 'auto',
            visible: 1,
            mousePause: 0,
            controls: {
                up: '.up',
                down: '.down',
                toggle: '.toggle',
                stopText: 'Stop !!!'
            }
        }).data('easyTicker');
    }

    $(document).ready(function() {
        SLZ.slz_breaking_news_1();
        SLZ.slz_breaking_news_2();
    });
});
