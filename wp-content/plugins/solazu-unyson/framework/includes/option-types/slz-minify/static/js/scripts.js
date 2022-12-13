jQuery(function($){

	slzEvents.on('slz:options:init', function (data) {

		var option_class = '.slz-backend-option-type-slz-minify';

		var parent_class = '#slz-option-' + slz_minify_id;

		var $elements = data.$elements.find(option_class +':not(.slz-option-initialized)');

		$elements.on('click', parent_class + '-minify-event-button', function(){

			var title = 'Cleaning';
			var description =
				'We are currently Cleaning your minify files' +
				'<br />' + 
				'This may take a few moments';

			slz.soleModal.show(
				'slz-options-ajax-minify-loading',
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
					action: 'slz_backend_clear_minify_files',
				},
				method: 'post',
				dataType: 'json'
			}).done(function (r) {
				if (r.success) {
					slz.soleModal.show(
						'slz-options-ajax-import-success',
						'<h2 class="slz-text-muted">Clean Successfully</h2>',
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
				slz.soleModal.hide('slz-options-ajax-minify-loading');
			});
			
		});

		$elements.addClass('slz-option-initialized');

	});

});