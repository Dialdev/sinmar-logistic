jQuery(document).ready(function ($) {
	setTimeout(function(){
		slzEvents.trigger('slz:options:init', {
			$elements: $(document.body)
		});
	}, 30);
});