(function ($, slzEvents) {
	var defaults = {
		grid: true
	};

	slzEvents.on('slz:options:init', function (data) {
		data.$elements.find('.slz-option-type-slider:not(.initialized)').each(function () {
			var options = JSON.parse($(this).attr('data-slz-irs-options'));
			var slider = $(this).find('.slz-irs-range-slider').ionRangeSlider(_.defaults(options, defaults));
		}).addClass('initialized');
	});

})(jQuery, slzEvents);