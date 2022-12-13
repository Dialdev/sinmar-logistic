jQuery(function($){
    "use strict";

    $.slz_events_submit_ajax = function() {
    	if( $( '.slz_buy_ticket_event_btn.slz-buy-ticket-method' ).length > 0 ) {
        	$('.slz_buy_ticket_event_btn.slz-buy-ticket-method').on('click', function() {

        		var slz_event_post_id = $(this).parents('.slz-form-buy-ticket').find('.slz_event_post_id').val();
                var pricing_column = $(this).parents('.slz-form-buy-ticket').find('.pricing_column').val();

                var data = {
    					"post_id": slz_event_post_id,
                        "pricing_column": pricing_column,
                }
    			
				$.fn.Form.ajax(['events', 'ajax_buy_ticket'], [data], function(res) {
					res = jQuery.parseJSON(res);
                    if( res != undefined ) {
                    	top.location.href = res.url;
                    }
				});
        	});
    	}

        // Donate Now button js
        if( $( '.slz-form-event-donate button.slz_money_donate_btn' ).length > 0 ) {
            $('.slz-form-event-donate button.slz_money_donate_btn').on('click', function() {

                var slz_money_donate = '';
                $(this).parents('.slz-form-event-donate').find('.donate-item').each( function() {
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
                var slz_event_post_id = $(this).parents('.slz-form-event-donate').find('.slz_event_post_id').val();
                
                if( slz_money_donate != '' ) {
                    var data = {
                            "money": slz_money_donate,
                            "post_id": slz_event_post_id,
                        }

                    $.fn.Form.ajax(['events', 'ajax_donate_event'], [data], function(res) {
                        res = jQuery.parseJSON(res);
                        if( res != undefined ) {
                            top.location.href = res.url;
                        }
                    });
                }
            });
        }
    };

    $.slz_events_countdown = function () {
        if( $('.count-down').length > 0 ) {
            $('.count-down').each(function(idx, dom ){
                var expire = $( dom ).data( 'expire' );
                if( expire ) {
                    expire = new Date( expire ).getTime();
                    var days    = $( dom ).find('.days span');
                    var hours   = $( dom ).find('.hours span');
                    var minutes = $( dom ).find('.minutes span');
                    var seconds = $( dom ).find('.seconds span');
                    var itv_id = window.setInterval(function () {
                        var current = new Date().getTime();
                        var seconds_left = ( expire - current ) / 1000;
                        if( seconds_left <= 0 ) {
                            window.clearInterval( itv_id );
                            return;
                        }
                        days.text( parseInt( seconds_left / 86400 ) );
                        seconds_left %= 86400;
                        hours.text( parseInt( seconds_left / 3600 ) );
                        seconds_left %= 3600;
                        minutes.text( parseInt( seconds_left / 60 ) );
                        seconds.text( parseInt( seconds_left % 60 ) );
                    }, 1000);
                }
            });
        }
    };

    $.slz_events_submit_donation_ajax  = function() {
        $('.label-check.another-donation').on('click', function() {
            $(this).find('.form-control').focus();
        });
        if( $( '.slz-form-donate input.slz_events_post_id' ).length > 0 ) {
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
                var slz_post_id = $(this).parents('.slz-form-donate').find('.slz_events_post_id').val();

                if( slz_money_donate != '' ) {
                    var data = {
                        "money": slz_money_donate,
                        "post_id": slz_post_id,
                    }

                    $.fn.Form.ajax(['events', 'ajax_donate_event'], [data], function(res) {
                        res = jQuery.parseJSON(res);
                        if( res != undefined ) {
                            top.location.href = res.url;
                        }
                    });
                }
            });
        }
    };

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
        jQuery.slz_events_submit_ajax();
        jQuery.slz_events_submit_donation_ajax();
        jQuery.slz_events_countdown();
        jQuery.slz_donation_paypal_form();
    });
});