(function ($, slzEvents) {
	var defaults = {
		grid: true
	};

	slzEvents.on('slz:options:init', function (data) {
		data.$elements.find('.slz-option-type-range-slider:not(.initialized)').each(function () {
			var options = JSON.parse($(this).attr('data-slz-irs-options'));
			$(this).find('.slz-irs-range-slider').ionRangeSlider(_.defaults(options, defaults));
		}).addClass('initialized');
	});

})(jQuery, slzEvents);