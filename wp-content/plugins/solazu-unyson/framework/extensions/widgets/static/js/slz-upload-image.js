jQuery(document).ready(function($) {
	
//upload image
	var slz_upload_frame;
	var slz_btn_upload;
	$('.slz-btn-upload').live('click', function(e){
		// Prevents the default action from occuring.
		e.preventDefault();

		slz_btn_upload = $(this);
		// If the frame already exists, re-open it.
		if ( slz_upload_frame ) {
			slz_upload_frame.open();
			return;
		}

		// Sets up the media library frame
		slz_upload_frame = wp.media.frames.meta_image_frame = wp.media({
			title: 'Choose or Upload an Image',
			button: { text:  'Use this image' },
			library: { type: 'image' },
		});

		// Runs when an image is selected.
		slz_upload_frame.on('select', function(){
			// Grabs the attachment selection and creates a JSON representation of the model.
			var media_attachment = slz_upload_frame.state().get('selection').first().toJSON();

			// Container
			var rel = slz_btn_upload.attr('data-rel');
			var self_parent = slz_btn_upload.parent();
			// Sends the attachment URL to our custom image input field.
			var med_url = media_attachment.sizes && media_attachment.sizes.medium ? media_attachment.sizes.medium.url : media_attachment.url;
			$('#' + rel + '_name').val(media_attachment.url);
			var result = JSON.stringify({ ID: media_attachment.id,alt:media_attachment.alt,title:media_attachment.title });
			$('#' + rel + '_id').val(result);
			self_parent.find('img').attr('src', med_url);
			self_parent.find('.slz-image-upload-wrapper').removeClass('hide');
			self_parent.find('.slz-no-image').addClass('hide');
			slz_btn_upload.next().removeClass('hide');
		});

		// Opens the media library frame.
		slz_upload_frame.open();
	});
	$('.slz-btn-remove').live('click', function(e) {
		// Prevents the default action from occuring.
		e.preventDefault();

		var self = $(this);
		var rel = self.attr('data-rel');
		var self_parent = self.parent();

		$('#' + rel + '_name').val('');
		$('#' + rel + '_id').val('');
		self_parent.find('.slz-image-upload-wrapper').addClass('hide');
		self_parent.find('.slz-no-image').removeClass('hide');
		self.addClass('hide');
	});
});
