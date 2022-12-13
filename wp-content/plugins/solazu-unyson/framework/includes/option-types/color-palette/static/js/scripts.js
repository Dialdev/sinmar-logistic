jQuery(function($){
	var optionTypeClass = '.slz-option-type-color-palette';
	var customRadioSelector = '.predefined .slz-option-type-radio > div:last-child input[type="radio"]';

	slzEvents.on('slz:options:init', function (data) {
		var $options = data.$elements.find(optionTypeClass +':not(.initialized)');

		$options.find('.slz-option-type-color-picker').on('focus', function () {
            $(this).closest(optionTypeClass).find('.slz-palette').removeClass('slz-palette-border')

			// check "custom" radio box
			$(this).closest(optionTypeClass).find(customRadioSelector).prop('checked', true);
		});

		$options.find(customRadioSelector).on('focus', function () {
			$(this).closest(optionTypeClass).find('.custom input').focus();
		});

		$options.addClass('initialized');

        var $predifined_container = $(optionTypeClass).children('.predefined');

        //add checked border to palette
        $predifined_container.find('.slz-palette').each(function(){
            if($(this).next().is(':checked'))
                $(this).addClass('slz-palette-border');
        });

        //if one of the palette's element is cliked
        $predifined_container.find('label').on('click',function(){
            $(this).parents('.slz-option.slz-option-type-radio').find('.slz-palette').removeClass('slz-palette-border');

            //add border to cicked element
            $(this).find('.slz-palette').addClass('slz-palette-border');
        });

        //if not a palette element clicked , then remove all borders
        $predifined_container.children('.slz-option.slz-option-type-radio').children('div:last-child').find('label').on('click',function(){
            $(this).parents('.slz-option.slz-option-type-radio').find('.slz-palette').removeClass('slz-palette-border');
        });
	});
});