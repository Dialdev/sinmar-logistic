jQuery(document).ready(function ($) {
	var optionTypeClass = 'slz-option-type-background-image';
	var eventNamePrefix = 'slz:option-type:background-image:';

	slzEvents.on('slz:options:init', function (data) {
		var $options = data.$elements.find('.'+ optionTypeClass +':not(.initialized)');

		$options.find('.slz-option-type-radio').on('change', function (e) {
			var $predefined = jQuery(this).closest('.slz-inner').find('.predefined');
			var $custom = jQuery(this).closest('.slz-inner').find('.custom');

			if (e.target.value === 'custom') {
				$predefined.hide();
				$custom.show();
			} else {
				$predefined.show();
				$custom.hide();
			}
		});

		// route inner image-picker events as this option events
		{
			$options.on('slz:option-type:image-picker:clicked', '.slz-option-type-image-picker', function(e, data) {
				jQuery(this).trigger(eventNamePrefix +'clicked', data);
			});

			$options.on('slz:option-type:image-picker:changed', '.slz-option-type-image-picker', function(e, data) {
				jQuery(this).trigger(eventNamePrefix +'changed', data);
			});
		}

		$options.addClass('initialized');
	});

});