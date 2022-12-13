jQuery(function($) {
    "use strict";

	$(document).on('change', '.newsletter-options select', function() {
		var status = $(this).val();
		if( status == 'show' ) {
			$(this).parents('p.newsletter-options').next().removeClass('hidden');
		}else{
			$(this).parents('p.newsletter-options').next().addClass('hidden');
		}
	});

});
