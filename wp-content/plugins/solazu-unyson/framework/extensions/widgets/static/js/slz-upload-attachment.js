jQuery(document).ready(function($) {

//upload image
    //slz-upload-attachment - js custom by Quang VT
    var slz_upload_frame_attachment;
    var slz_btn_upload_attachment;
    $('.slz-btn-upload-attachment').live('click', function(e){
        // Prevents the default action from occuring.
        e.preventDefault();

        slz_btn_upload_attachment = $(this);
        // If the frame already exists, re-open it.
        if ( slz_upload_frame_attachment ) {
            slz_upload_frame_attachment.open();
            return;
        }

        // Sets up the media library frame
        slz_upload_frame_attachment = wp.media.frames.meta_image_frame = wp.media({
            title: 'Choose or Upload an Files',
            button: { text:  'Choose files' },
            multiple: false
        });

        // Runs when an image is selected.
        slz_upload_frame_attachment.on('select', function(){
            // Grabs the attachment selection and creates a JSON representation of the model.
            var media_attachment = slz_upload_frame_attachment.state().get('selection').first().toJSON();

            // Container
            var rel = slz_btn_upload_attachment.attr('data-rel');
            var name = slz_btn_upload_attachment.attr('data-name');
            var self_parent = slz_btn_upload_attachment.parent();
            // Sends the attachment URL to our custom image input field.
            var count = self_parent.find('.slz-attachment-upload-wrapper').find("input[data-form='"+name+"']").length;
            var current = 'attachment-' + count;
            self_parent.find('.slz-attachment-upload-wrapper').append('<div class="slz-attachment-preview" id="'+ current +'"></div>');
            self_parent.find('.slz-attachment-upload-wrapper #'+current).append('<input type="hidden" value="'+ media_attachment.id +'" name="'+ name +'['+ count +']" data-form="'+name+'">');
            self_parent.find('.slz-attachment-upload-wrapper #'+current).append('<a href="'+ media_attachment.url + '">'+ media_attachment.name +'</a>');
            self_parent.find('.slz-attachment-upload-wrapper #'+current).append('<input type="button" style="float: right;" class="button slz-image-upload-btn slz-btn-remove-file" value="Remove" />');
            self_parent.find('.slz-attachment-upload-wrapper #'+current).append('<div style="clear: both;"></div>');
            slz_btn_upload_attachment.next().removeClass('hide');
        });

        // Opens the media library frame.
        slz_upload_frame_attachment.open();
    });
    $('.slz-btn-remove-attachment').live('click', function(e) {
        // Prevents the default action from occuring.
        e.preventDefault();

        var self = $(this);
        var self_parent = self.parent();

        self_parent.find('.slz-attachment-upload-wrapper').empty();
        self_parent.find('.slz-btn-remove-attachment').addClass('hide');
    });
    $('.slz-btn-remove-file').live('click', function (e) {
        e.preventDefault();

        var self = $(this);
        var self_parent = self.parent().parent().parent();
        var name = self_parent.find('.slz-btn-upload-attachment').attr('data-name');
        self.parent().remove();
        var count = self_parent.find('.slz-attachment-upload-wrapper').find("input[data-form='"+name+"']").length;
        if (count == 0)
            self_parent.find('.slz-btn-remove-attachment').addClass('hide');
    })
});
