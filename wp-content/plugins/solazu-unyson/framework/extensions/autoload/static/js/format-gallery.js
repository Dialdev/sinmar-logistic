jQuery(function($) {
    "use strict";


    $.carouselFunction = function(){
        $('.slz-gallery-format .slz-carousel').each( function() {
            $(this).slick({
                infinite: true,
                autoplay: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: false,
                arrows: true,
                appendArrows: $(this).parents('.slz-image-carousel'),
                prevArrow: '<button class="btn btn-prev"><i class="icons fa"></i><span class="text">Previous</span></button>',
                nextArrow: '<button class="btn btn-next"><span class="text">Next</span> <i class="icons fa"></i></button>'
            });
        });
    }
    /*======================================
    =            INIT FUNCTIONS            =
    ======================================*/

    $(document).ready(function() {
        jQuery.carouselFunction();
    });
    /*=====  End of INIT FUNCTIONS  ======*/

});
