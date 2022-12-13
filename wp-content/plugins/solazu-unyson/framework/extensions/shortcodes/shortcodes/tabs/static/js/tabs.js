jQuery(function($) {
    "use strict";

    var SLZ = window.SLZ || {};
    var tabListHeigth;
    SLZ.tab = function() {

        $('.sc_tabs').each( function() {
            $(this).find('.vc_tta-panel-heading').remove();
            $(this).find('.tab-content .vc_tta-panel:first').addClass('tab-pane fade in active');
            $(this).find('.tab-content .vc_tta-panel:not(:first)').addClass('tab-pane fade');
            $(this).find('.tab-content .vc_tta-panel').attr('role','tabpanel');
            $(this).find('.tab-content .vc_tta-panel').each(function(){
                var id = $(this).attr('id');
                $(this).attr('id', 'tab-' + id);
            });
        });

    };

    SLZ.tab_vertical = function() {
        // old one
        // if ( $('.sc_tabs.slz-tab-vertical').length ) {
        //     $(".slz-tab-vertical .tab-list").height(0);
        //     var contentHeight = $(".slz-tab-vertical .tab-content").height();
        //     $(".slz-tab-vertical .tab-list").height(contentHeight);
        // }
        if ($(window).width() > 767) {
            if ($(".sc_tabs.slz-tab-vertical").length) {
                // get origin height of tab list
                tabListHeigth = $(".slz-tab-vertical .tab-list").height();
                if($(".slz-tab-vertical .tab-list").height() <= $(".slz-tab-vertical .tab-content .tab-pane.active").height()) {
                    // set height 0 to counter table-cell calculate height
                    $(".slz-tab-vertical .tab-list").height(0);
                    var contentHeight = $(".slz-tab-vertical .tab-content .tab-pane.active")[0].clientHeight;
                    $(".slz-tab-vertical .tab-list").height(contentHeight);
                }
                // Cut off a bit equal with height of the last item.
                var lastItemHeight = $(".slz-tab-vertical .tab-list-wrapper .tab-list li:last-child").height();
                $("head").append("<style>.slz-tab-vertical .tab-list-wrapper:before { height: calc(100% - " + lastItemHeight + "px) } </style>");

                // set height when tabs have different height
                $('.slz-tab-vertical .tab-list li .link').on("click", function() {
                    setTimeout( function() {
                        if($(".slz-tab-vertical .tab-content .tab-pane.active").height() >= tabListHeigth) {
                            $(".slz-tab-vertical .tab-list").height(0);
                            var contentHeight = $(".slz-tab-vertical .tab-content .tab-pane.active")[0].clientHeight;
                            $(".slz-tab-vertical .tab-list").height(contentHeight);
                        }
                        else {
                            $(".slz-tab-vertical .tab-list").height(tabListHeigth);
                        }
                    }, 300);
                });
            }
        }
    };

    $(document).ready(function() {
        SLZ.tab();
        SLZ.tab_vertical();
    });
    $(window).on('resize', function() {
        if ($(window).width() > 767) {
            if ($(".sc_tabs.slz-tab-vertical").length) {
                // reset height when window resize
                setTimeout( function() {
                    $(".slz-tab-vertical .tab-list").height(0);
                    $(".slz-tab-vertical .tab-list").height(tabListHeigth);
                    if($(".slz-tab-vertical .tab-content .tab-pane.active").height() >= tabListHeigth) {
                        $(".slz-tab-vertical .tab-list").height(0);
                        var contentHeight = $(".slz-tab-vertical .tab-content .tab-pane.active")[0].clientHeight;
                        $(".slz-tab-vertical .tab-list").height(contentHeight);
                    }
                    else {
                        $(".slz-tab-vertical .tab-list").height(tabListHeigth);
                    }
                }, 300);
                // SLZ.tab_vertical();
            }
        }
    });
});