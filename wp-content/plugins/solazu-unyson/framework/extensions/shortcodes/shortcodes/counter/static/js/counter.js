jQuery(function($) {
    "use strict";

    var SLZ = window.SLZ || {};
    /*=======================================
    =            counter style 1            =
    =======================================*/
    SLZ.count_style_1 = function() {
        $('.slz-counter-item-1 .number').countTo();
    }
    SLZ.count_style_2 = function() {
        $('.slz-counter-item-2 .number').countTo();
    }


    /*=====  End of counter style 1  ======*/
    
    $(window).on('scroll load', function() {
        $(".sc_counter .number").each(function() {
            var isOnView = isElementVisible($(this));
            if (isOnView && !$(this).hasClass('Starting')) {
                $(this).addClass('Starting');
                startTimer($(this));
            }
        });
    });

    function isElementVisible($elementToBeChecked) {
        var TopView = $(window).scrollTop();
        var BotView = TopView + $(window).height();
        var TopElement = $elementToBeChecked.offset().top;
        var BotElement = TopElement + $elementToBeChecked.height();
        return ((BotElement <= BotView) && (TopElement >= TopView));
    }

    function startTimer($this) {
        setTimeout(function() {
            $this.countTo({
                speed: 2000,
                refreshInterval: 90
            });
        }, 300);
    }
    /*=====  End of jquery appear  ======*/



    $(document).ready(function() {
    });
});
