jQuery(function($){
    "use strict";


    $.slz_approve_btn = function() {
    	$('.slz-approve-btn').on('click', function() {
    		var post_id = $(this).attr('data-post-id');
    		var data = {
    			"post_id": post_id,
        	}
    		var status = $(this).parents('.type-slz-donation').find('td.status.column-status');
    		var btn = $(this).parent();
    		
    		$.fn.Form.ajax(['donation', 'ajax_approve_btn_admin'], [data], function(res) {
    			res = jQuery.parseJSON(res);
    			status.html(res.status);
    			btn.html( res.btn );
    			jQuery.slz_cancel_btn();
    		});
    	});
    };
    
    $.slz_cancel_btn = function() {
    	$('.slz-cancel-btn').on('click', function() {
    		var post_id = $(this).attr('data-post-id');
    		var data = {
    			"post_id": post_id,
        	}
    		var status = $(this).parents('.type-slz-donation').find('td.status.column-status');
    		var btn = $(this).parent();
    		
    		$.fn.Form.ajax(['donation', 'ajax_cancel_btn_admin'], [data], function(res) {
    			res = jQuery.parseJSON(res);
    			status.html(res.status);
    			btn.html( res.btn );
    			jQuery.slz_approve_btn();
    		});
    	});
    };


    $(document).ready(function(){
        jQuery.slz_approve_btn();
        jQuery.slz_cancel_btn();
    });
});