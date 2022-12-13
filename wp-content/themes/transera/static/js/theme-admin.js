jQuery(document).ready(function($) {
    "use strict";

    if ( typeof slzEvents !== 'undefined') {
        // advanced styling button
        slzEvents.on('slz:options:init', function (data) {
            // for advanced button styling
            data.$elements.find('.slz-option-type-popup[data-advanced-for]:not(.advanced-initialized)').each(function () {
                var $optionWithAdvanced = data.$elements.find('.' + $(this).attr('data-advanced-for'));
                var $buttonLabel = $(this).find('.button').html();

                if (!$optionWithAdvanced.length) {
                    console.warn('Option with advanced not found', $(this).attr('data-advanced-for'));
                    return;
                }

                var $advancedButton = $('<button type="button" class="button slz-advanced-button">' + $buttonLabel + '</button>'),
                    $popupButton = $(this).find('.button:first');

                $advancedButton.on('click', function () {
                    $popupButton.trigger('click');
                });

                $advancedButton.insertAfter(
                    $optionWithAdvanced.closest('.slz-backend-option-input').find('> .slz-inner')
                );

                $popupButton.closest('.slz-backend-option').addClass('slz-hidden');
            }).addClass('advanced-initialized');
        });
        // end advanced styling button
    }
    
});
