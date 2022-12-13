jQuery(function($){

	slzEvents.on('slz:options:init', function (data) {

		var option_class = '.slz-backend-option-type-slz-import';

		var parent_class = '#slz-option-' + slz_import_id;

		var $elements = data.$elements.find(option_class +':not(.slz-option-initialized)');

		/** Init Import button */
		$elements.on('click', parent_class + '-btn-import-file', function(){
			$(parent_class + '-btn-import-file').addClass('button-primary');
			$(parent_class + '-btn-import-url').removeClass('button-primary');
			$(parent_class + '-import-file').removeClass('slz-hidden');
			$(parent_class + '-import-url').addClass('slz-hidden');
			$(parent_class + '-btn-import-submit').attr('import-from', 'file');
		});

		$elements.on('click', parent_class + '-btn-import-url', function(){
			$(parent_class + '-btn-import-url').addClass('button-primary');
			$(parent_class + '-btn-import-file').removeClass('button-primary');
			$(parent_class + '-import-url').removeClass('slz-hidden');
			$(parent_class + '-import-file').addClass('slz-hidden');
			$(parent_class + '-btn-import-submit').attr('import-from', 'url');
		});

		$elements.on('click', parent_class + '-btn-import-submit', function(){

			var error = false;
			var data = '';

			if ( $(parent_class + '-btn-import-submit').attr('import-from') == 'url' ){
				if ( $(parent_class + '-import-url').val() == '' )
					error = true;
				else
					data = $(parent_class + '-import-url').val();
			}
			else if ( $(parent_class + '-btn-import-submit').attr('import-from') == 'file' ){
				if ( $(parent_class + '-import-file').val() == '' )
					error = true;
				else
					data = $(parent_class + '-import-file').val();
			}
			else 
				error = true;

			if ( !error ) {
				var title = 'Importing';
				var description =
					'We are currently importing your settings' +
					'<br />' + 
					'This may take a few moments';

				slz.soleModal.show(
					'slz-options-ajax-import-loading',
					'<h2 class="slz-text-muted">'+
						'<img src="'+ slz.img.loadingSpinner +'" alt="Loading" class="wp-spinner" /> '+
						title +
					'</h2>'+
					'<p class="slz-text-muted"><em>'+ description +'</em></p>',
					{
						autoHide: 60000,
						allowClose: false
					}
				);

				$.ajax({
					url: ajaxurl,
					data: {
						action: 'slz_backend_options_import',
						type: $(parent_class + '-btn-import-submit').attr('import-from'),
						data: data
					},
					method: 'post',
					dataType: 'json'
				}).done(function (r) {
					if (r.success) {
						slz.soleModal.show(
							'slz-options-ajax-import-success',
							'<h2 class="slz-text-muted">Import Successfully</h2>',
							{
								autoHide: 1000,
								showCloseButton: false,
								hidePrevious: false,
								afterClose: function(){ location.reload(); }
							}
						);
					} else {
						try {
							alert(r.data.message);
						} catch (e) {
							alert('Request failed');
						}
					}
				}).fail(function (jqXHR, textStatus, errorThrown) {
					alert('AJAX error: '+ String(errorThrown));
				}).always(function () {
					slz.soleModal.hide('slz-options-ajax-import-loading');
				});
			}
			else
				alert('Please input import data');
			
		});

		$elements.addClass('slz-option-initialized');

	});

});