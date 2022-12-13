jQuery(function($){
    "use strict";

    $.slz_cause_block_donation_button = function () {
        $('.slz-shortcode.sc_causes .slz-btn.btn-block-donate').click(function () {
            var post_id = $(this).attr('data-id');
            $(this).parents('.slz-shortcode.sc_causes').find('input[name="slz_causes_post_id"]').val(post_id);
        });
    };

    $.slz_event_block_donation_button = function () {
        $('.slz-shortcode.sc_event_block .slz-btn.slz-event-donate, .slz-shortcode.sc_event_carousel .slz-btn.slz-event-donate').click(function () {
            var post_id = $(this).attr('data-id');
            var model_id = $(this).attr('data-target');
            $(model_id).find('input[name="slz_event_post_id"]').val(post_id);
        });
    };
    
    $.slz_cause_submit_ajax = function() {
    	$('.label-check.another-donation').on('click', function() {
    		$(this).find('.form-control').focus();
    	});
    	if( $( '.slz-form-donate input.slz_causes_post_id' ).length > 0 ) {
        	$('.slz-form-donate button.slz_money_donate_btn').on('click', function() {

        		var slz_money_donate = '';
        		$(this).parents('.slz-form-donate').find('.donate-item').each( function() {
        			if( $(this).find('input[name="valueDonation"]').is(':checked') && $(this).find('input[name="valueDonation"]').hasClass('donation-other-price') ) {
        				if( !isNaN( $(this).find('input[name="anotherAmount"]').val() ) ) {
        					slz_money_donate = parseInt( $(this).find('input[name="anotherAmount"]').val() );
        				}
        			}else if( $(this).find('input[name="valueDonation"]').is(':checked') ) {
        				if( !isNaN( $(this).find('input[name="valueDonation"]').val() ) ) {
        					slz_money_donate = parseInt( $(this).find('input[name="valueDonation"]').val() );
        				}
        			}
        		});
        		var slz_causes_post_id = $(this).parents('.slz-form-donate').find('.slz_causes_post_id').val();
        		
        		if( slz_money_donate != '' ) {
        			var data = {
        					"money": slz_money_donate,
        					"post_id": slz_causes_post_id,
        				}

    				$.fn.Form.ajax(['donation', 'ajax_add_donate'], [data], function(res) {
    					res = jQuery.parseJSON(res);
                        if( res != undefined ) {
                        	top.location.href = res.url;
                        }
    				});
        		}
        	});
    	}
    };
 
    $.slz_causes_single_progress_bar = function() {
        if ($('.slz-progress-bar-01').length) {
            $(".progress-bar").each(function() {
                var unit = $(this).attr('data-unit');
                var each_bar_width = $(this).attr('aria-valuenow');
                $(this).width(each_bar_width + '%');
                $(this).parent().parent().find('.percent').attr('data-to', each_bar_width);
                $(this).parent().parent().find('.percent').countTo({
                    onUpdate: function(value) {
                        $(this).append(unit);
                    }
                });
            });
        }
    }

    $.slz_donation_paypal_form = function() {
        if ($('.slz-form-donate select[name="t3"]').length) {
            $('.slz-form-donate input[name="anotherAmount"]').keyup(function () {
                var value = $(this).val();
                $(this).parent().parent().find('input[type="radio"]').val(value);
            });

            $('.slz-form-donate select[name="t3"]').change(function () {
                var t3 = $(this).val();
                var option_p3 = '';
                var count = 0;
                if (t3 == 'W') {
                    count=7;
                }
                if (t3 == 'M') {
                    count=12;
                }
                if (t3 == 'Y') {
                    count=6;
                }
                for (var i=2; i<=count; i++) {
                    option_p3 += '<option value="'+i+'">'+ i+'</option>';
                }
                var p3 = $(this).parent().find('select[name="p3"]');
                p3.html(option_p3);
                if (count == 0) {
                    p3.parent().hide(500);
                } else {
                    p3.parent().show(500);
                }
            });
            $('.slz-form-donate').submit(function () {
                var first_name = $(this).find('input[name="first_name"]').val().trim();
                if (first_name == '') {
                    alert('First Name is a required field');
                    $(this).find('input[name="first_name"]').focus();
                    return false;
                }

                var last_name = $(this).find('input[name="last_name"]').val().trim();
                if (last_name == '') {
                    alert('Last Name is a required field');
                    $(this).find('input[name="last_name"]').focus();
                    return false;
                }

                var email = $(this).find('input[name="email"]').val().trim();
                if (email == '') {
                    alert('Email Address is a required field');
                    $(this).find('input[name="email"]').focus();
                    return false;
                }
                return true;
            });
        }
    }

    $(document).ready(function(){
        jQuery.slz_cause_submit_ajax();
        jQuery.slz_causes_single_progress_bar();
        jQuery.slz_donation_paypal_form();
        jQuery.slz_cause_block_donation_button();
        jQuery.slz_event_block_donation_button();
    });
});