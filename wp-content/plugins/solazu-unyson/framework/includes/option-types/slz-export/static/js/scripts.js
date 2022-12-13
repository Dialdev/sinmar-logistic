jQuery(function($){

	slzEvents.on('slz:options:init', function (data) {

		var option_class = '.slz-backend-option-type-slz-export';

		var parent_class = '#slz-option-' + slz_export_id;

		var $elements = data.$elements.find(option_class +':not(.slz-option-initialized)');

		/** Init Import button */
		$elements.on('click', parent_class + '-copy-data', function(){
			$(parent_class + '-txt-copy-data').removeClass('slz-hidden');
			$(parent_class + '-txt-copy-url').addClass('slz-hidden');
		});

		$elements.on('click', parent_class + '-copy-url', function(){
			$(parent_class + '-txt-copy-url').removeClass('slz-hidden');
			$(parent_class + '-txt-copy-data').addClass('slz-hidden');
		});

		$elements.addClass('slz-option-initialized');
	});

});