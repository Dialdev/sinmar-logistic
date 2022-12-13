jQuery(function ($) {
	var optionTypeClass = '.slz-option-type-icon';

	slzEvents.on('slz:options:init', function (data) {

		var $options = data.$elements.find(optionTypeClass +':not(.initialized)');

		// handle click on an icon
		$options.find('.js-option-type-icon-item').on('click', function () {
			var $this = $(this);

			if ($this.hasClass('active')) {
				$this.removeClass('active');
				$this.closest(optionTypeClass).find('input[type="hidden"]').val('').trigger('change');
			} else {
				$this.addClass('active').siblings().removeClass('active');
				$this.closest(optionTypeClass).find('input[type="hidden"]').val($this.data('value')).trigger('change');
			}
		});

		// handle changing active category
		$options.find('.js-option-type-icon-dropdown')
			.on('change', function () {
				var $this = $(this);
				var group = $this.val();
				$this.closest(optionTypeClass).find('.js-option-type-icon-item').each(function () {
					var group_id = $(this).data('group-id');
					$(this).toggle( group == group_id  || group == $(this).data('group') );
				});
			})
			.trigger('change');

		// handle searching icon
		$options.find('.js-option-type-icon-search')
			.on('input', function () {
				var $this = $(this);
				var text = $this.val();
				var group = $this.closest(optionTypeClass).find('.js-option-type-icon-dropdown').val();
				$this.closest(optionTypeClass).find('.js-option-type-icon-item').each(function () {
					var value = $(this).data('value');
					var group_id = $(this).data('group-id');
					var show = false;
					if ( ( $(this).data('value').indexOf(text) >= 0 ) && ( group == group_id  || group == $(this).data('group') )){
						show = true;
					}
					$(this).toggle( show );
				});
			})
			.trigger('input');

		$options.addClass('initialized');

	});

});
