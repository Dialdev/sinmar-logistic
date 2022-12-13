jQuery(function($){
    "use strict";

    // Click button approve of All Doantion of Events in admin
    $.slz_donation_approve_btn = function() {
        $('.slz-ed-approve-btn').on('click', function() {
            var post_id = $(this).attr('data-post-id');
            var data = {
                "post_id": post_id,
            }
            var status = $(this).parents('.type-slz-event-donation').find('td.status.column-status');
            var btn = $(this).parent();
            
            $.fn.Form.ajax(['events', 'ajax_ed_approve_btn_admin'], [data], function(res) {
                res = jQuery.parseJSON(res);
                status.html(res.status);
                btn.html( res.btn );
                jQuery.slz_donation_cancel_btn();
            });
        });
    };
    
    // Click button unapprove of All Doantion of Events in admin
    $.slz_donation_cancel_btn = function() {
        $('.slz-ed-cancel-btn').on('click', function() {
            var post_id = $(this).attr('data-post-id');
            var data = {
                "post_id": post_id,
            }
            var status = $(this).parents('.type-slz-event-donation').find('td.status.column-status');
            var btn = $(this).parent();
            
            $.fn.Form.ajax(['events', 'ajax_ed_cancel_btn_admin'], [data], function(res) {
                res = jQuery.parseJSON(res);
                status.html(res.status);
                btn.html( res.btn );
                jQuery.slz_donation_approve_btn();
            });
        });
    };

    $(document).ready(function(){
        jQuery.slz_donation_approve_btn();
        jQuery.slz_donation_cancel_btn();
    });
});