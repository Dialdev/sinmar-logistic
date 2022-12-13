(function($) {
    "use strict";

    // fancybox function
   $.fancybox_function= function(){
        if($('.wg-causes').length){
            $('.wg-causes').each(function(index, el) {
                var id_class = $(this).attr('data-block-class');
                $(this).find('.fancybox-thumb').attr('data-fancybox-group','group-.'+id_class);
            });
        }
    }

})(jQuery);
jQuery(document).ready(function() {
    jQuery.fancybox_function();
})