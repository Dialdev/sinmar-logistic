function slz_color_picker(){
	jQuery('.slz-color-picker-widget').hide();

	jQuery('.widgets-php .slz-color-picker-widget').each(function(){
		var $this = jQuery(this);
		var id = $this.attr('rel');
		$this.farbtastic('#' + id);
	});

	jQuery('.slz-color-picker-field').click(function(){
		var id = jQuery(this).data('slz-w-color');
		

		jQuery('div[id="' + id + '"]').each(function(){
			jQuery(this).fadeIn();
		});

	});

	jQuery(document).mousedown(function() {
		jQuery('.slz-color-picker-widget').each(function() {
			var display = jQuery(this).css('display');
			if ( display == 'block' )
				jQuery(this).fadeOut();
		});
	});

}
