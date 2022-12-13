jQuery(function($) {
    "use strict";

    var SLZ = window.SLZ || {};

    SLZ.slz_posts_mansory_layout2 = function() {
    	if( $('.slz-post-mansory-layout-2 .slz-isotope-grid-2').length ) {
    		$('.slz-post-mansory-layout-2 .slz-isotope-grid-2').each(function() {
                var $grid = $(this).isotope({
                    itemSelector: '.grid-item',
                    percentPosition: true,
                    masonry: {
                        columnWidth: '.grid-item'
                    }
                });
    		});
    	}
    };

    $(document).ready(function() {
        SLZ.slz_posts_mansory_layout2();
    });
});
