jQuery(function($){
    "use strict";
    
    $.slz_default_loadpage = function() {
    	var default_load_page =  $("#post-formats-select input:radio[name=post_format]:checked").val();

    	switch( default_load_page ){

			case 'video':
				show_all_format();
				slz_hide_audio_format();
				slz_hide_gallery_format();
				slz_hide_quote_format();
			break;
	
			case 'audio':
				show_all_format();
				slz_hide_video_format();
				slz_hide_gallery_format();
				slz_hide_quote_format();
			break;
	
			case 'gallery':
				show_all_format();
				slz_hide_video_format();
				slz_hide_audio_format();
				slz_hide_quote_format();
			break;

			case 'quote':
				show_all_format();
				slz_hide_video_format();
				slz_hide_audio_format();
				slz_hide_gallery_format();
			break;
	
			default:
				slz_hide_video_format();
				slz_hide_audio_format();
				slz_hide_gallery_format();
				slz_hide_quote_format();
			break;
	
		}
    }

    $.slz_post_format_options = function() {
    	
        $('#post-formats-select input:radio[name=post_format]').change(function() {
        	 
            var post_format_change = $("#post-formats-select input:radio[name=post_format]:checked").val();

        	switch( post_format_change ){
            
    			case 'video':
    				show_all_format();
    				slz_hide_audio_format();
    				slz_hide_gallery_format();
    				slz_hide_quote_format();
    			break;
    	
    			case 'audio':
    				show_all_format();
    				slz_hide_video_format();
    				slz_hide_gallery_format();
    				slz_hide_quote_format();
    			break;
    	
    			case 'gallery':
    				show_all_format();
    				slz_hide_video_format();
    				slz_hide_audio_format();
    				slz_hide_quote_format();
    			break;
    
    			case 'quote':
    				show_all_format();
    				slz_hide_video_format();
    				slz_hide_audio_format();
    				slz_hide_gallery_format();
    			break;
    	
    			default:
    				slz_hide_video_format();
    				slz_hide_audio_format();
    				slz_hide_gallery_format();
    				slz_hide_quote_format();
    			break;
            	
            }
     
        });
        
    };


    /* HIDE */
    function slz_hide_video_format() {
    	$('li.ui-state-default.ui-corner-top[aria-controls=slz-options-tab-feature-video]').hide();
    	$('#slz-options-tab-feature-video').hide();
    }
    function slz_hide_audio_format() {
    	$('li.ui-state-default.ui-corner-top[aria-controls=slz-options-tab-feature-audio]').hide();
    	$('#slz-options-tab-feature-audio').hide();
    }
    function slz_hide_gallery_format() {
    	$('li.ui-state-default.ui-corner-top[aria-controls=slz-options-tab-feature-gallery]').hide();
    	$('#slz-options-tab-feature-gallery').hide();
    }
    function slz_hide_quote_format() {
    	$('li.ui-state-default.ui-corner-top[aria-controls=slz-options-tab-feature-quote]').hide();
    	$('#slz-options-tab-feature-quote').hide();
    }


    /* SHOW */
    function slz_show_video_format() {
    	$('li.ui-state-default.ui-corner-top[aria-controls=slz-options-tab-feature-video]').show();
    	$('#slz-options-tab-feature-video').show();
    }
    function slz_show_audio_format() {
    	$('li.ui-state-default.ui-corner-top[aria-controls=slz-options-tab-feature-audio]').show();
    	$('#slz-options-tab-feature-audio').show();
    }
    function slz_show_gallery_format() {
    	$('li.ui-state-default.ui-corner-top[aria-controls=slz-options-tab-feature-gallery]').show();
    	$('#slz-options-tab-feature-gallery').show();
    }
    function slz_show_quote_format() {
    	$('li.ui-state-default.ui-corner-top[aria-controls=slz-options-tab-feature-quote]').show();
    	$('#slz-options-tab-feature-quote').show();
    }
    
    function show_all_format() {
    	slz_show_video_format();
    	slz_show_audio_format();
    	slz_show_gallery_format();
    	slz_show_quote_format();
    }



    $(document).ready(function(){
        jQuery.slz_post_format_options();
    });
    
    $(window).load( function() {
    	jQuery.slz_default_loadpage();
    });
});