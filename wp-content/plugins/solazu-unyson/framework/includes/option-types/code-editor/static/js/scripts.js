jQuery(function($){

	slzEvents.on('slz:options:init', function (data) {

		var option_class = '.slz-backend-option-input-type-code-editor';

		var $elements = data.$elements.find(option_class +':not(.slz-option-initialized)');

		jQuery.each( $elements.find( '.code-editor' ), function( index, element ) {

			var area = element;

			var editor = ace.edit($( element ).attr('data-editor'));

			var theme = 'chrome';

			var mode = 'html';

			var param = { "minLines": 20, "maxLines": 30 };

			if ( $( element ).attr('data-theme') != undefined )
				theme = $( element ).attr('data-theme');

			if ( $( element ).attr('data-mode') != undefined )
				mode = $( element ).attr('data-mode');

			if ( $( element ).attr('data-min-line') != undefined )
				param.minLines = $( element ).attr('data-min-line');

			if ( $( element ).attr('data-max-line') != undefined )
				param.maxLines = $( element ).attr('data-max-line');

			editor.setTheme("ace/theme/" + theme);
			editor.getSession().setMode("ace/mode/" + mode);
			editor.setOptions( param );

			editor.on(
				'change', function( e ) {
					$( '#' + area.id ).val( editor.getSession().getValue() );
					editor.resize();
				}
			);

			$(this).addClass('slz-option-initialized');

		});
		
	});

});