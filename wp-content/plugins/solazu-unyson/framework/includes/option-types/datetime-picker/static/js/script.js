(function($, slze) {
	jQuery.datetimepicker.setLocale(jQuery('html').attr('lang').split('-').shift());

	var init = function() {
		var $container = $(this),
			$input = $container.find('.slz-option-type-text'),
			data = {
				options: $container.data('datetime-attr'),
				el: $input,
				container: $container
			};

		slze.trigger('slz:options:datetime-picker:before-init', data);
		$input.datetimepicker(data.options);
	};

	slze.on('slz:options:init', function(data) {
		data.$elements
			.find('.slz-option-type-datetime-picker').each(init)
			.addClass('slz-option-initialized');
	});

})(jQuery, slzEvents);
