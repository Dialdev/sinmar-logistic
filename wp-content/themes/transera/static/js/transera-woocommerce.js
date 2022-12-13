jQuery(function($) {
    "use strict";

    var transeraWoo = window.transeraWoo || {};

    transeraWoo.woocommerce = function() {
        var flag_rtl = true;
        if (!$('body').hasClass("rtl")) {
            flag_rtl = false;
        }
        $(window).load(function() {
            // Customize woo button
            $('.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button').each(function() {
                var find_parent = $(this).parent();
                if (!find_parent.hasClass('slz-woocommerce-button')) {
                    $(this).wrap('<div class="slz-woocommerce-button"></div>');
                }
            });

            // Customize checkbox
            $('.woocommerce .form-row:not(.create-account) input[type="checkbox"]').each(function() {
                $(this).parent().append('<span class="slz-woocommerce-label-for"></span>');
            });

            // Customize table_shop
            $('.woocommerce table.shop_table.cart th.product-name').attr('colspan', 3);

            // Customize quantity input

            $(".quantity input").each(function() {
                if ($(".quantity .minus, .quantity .plus").length == 0) {
                    $(".quantity input[type='number']").before('<input type="button" value="-" class="minus button is-form">');
                    $(".quantity input[type='number']").after('<input type="button" value="+" class="plus button is-form">');
                }
            });
            
            $("body").on("click", ".quantity .minus, .quantity .plus", function() {
                var $button = $(this);
                var oldValue = $button.parent().find("input[type='number']").val();

                if ($button.attr('value') == "+") {
                    var newVal = parseFloat(oldValue) + 1;
                } else {
                    // Don't allow decrementing below zero
                    if (oldValue > 0) {
                        var newVal = parseFloat(oldValue) - 1;
                    } else {
                        newVal = 0;
                    }
                }

                $button.parent().find("input[type='number']").val(newVal);
                $('.woocommerce table.cart td.actions .button[name="update_cart"]').attr("disabled", false);
            });

            // Customize add to wishlist popup
            $('.yith-wcwl-add-to-wishlist .yith-wcwl-add-button').append('<div class="wishlist-popup dark">Add to Wishlist</div>');
            $('.yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse, .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse').append('<div class="wishlist-popup dark">Browse Wishlist</div>');
            
            var related_item = $('.slz-woocommerce-setting').attr('data-show');
            related_item = parseInt(related_item);
            if( related_item == undefined || related_item == '' || isNaN(related_item) ) {
            	related_item = 4;
            }
            // Customize related product
            $('.woocommerce .cart-collaterals .cart_totals').insertBefore('.woocommerce .cart-collaterals .cross-sells');
            
            if($('.col-md-8 .woocommerce .cart-collaterals .cross-sells .products,.woocommerce-page .col-md-8 .cart-collaterals .cross-sells .products, .slz-woocommerce .col-md-8 .type-product .upsells > .products, .slz-woocommerce .col-md-8 .type-product .related > .products').length > 0){
                var owlthumbnails_1 = $('.col-md-8 .woocommerce .cart-collaterals .cross-sells .products,.woocommerce-page .col-md-8 .cart-collaterals .cross-sells .products, .slz-woocommerce .col-md-8 .type-product .upsells > .products, .slz-woocommerce .col-md-8 .type-product .related > .products').slick({
                    slidesToShow: related_item -1,
                    infinite: true,
                    rtl: flag_rtl,
                    responsive: [{
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2,
                        }
                    }, {
                        breakpoint: 481,
                        settings: {
                            slidesToShow: 1,
                        }
                    }]
                }); 
            }
            if($('.col-md-12 .woocommerce .cart-collaterals .cross-sells .products, .col-md-12 .woocommerce-page .cart-collaterals .cross-sells .products, .slz-woocommerce .col-md-12 .type-product .upsells > .products, .slz-woocommerce .col-md-12 .type-product .related > .products').length > 0){
                 var owlthumbnails_2 = $('.col-md-12 .woocommerce .cart-collaterals .cross-sells .products, .col-md-12 .woocommerce-page .cart-collaterals .cross-sells .products, .slz-woocommerce .col-md-12 .type-product .upsells > .products, .slz-woocommerce .col-md-12 .type-product .related > .products').slick({
                    slidesToShow: related_item,
                    infinite: true,
                    rtl: flag_rtl,
                    responsive: [{
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 3,
                        }
                    }, {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2,
                        }
                    }, {
                        breakpoint: 481,
                        settings: {
                            slidesToShow: 1,
                        }
                    }]
                });
            }
        });
    }

    /*======================================
    =            INIT FUNCTIONS            =
    ======================================*/

    $(document).ready(function() {
    	transeraWoo.woocommerce();
    });
    $(document).ajaxComplete(function() {
        // Customize woo button
        $('.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button:not(.minus, .plus)').each(function() {
            var find_parent = $(this).parent();
            if (!find_parent.hasClass('slz-woocommerce-button')) {
                $(this).wrap('<div class="slz-woocommerce-button"></div>');
            }
        });
        // Customize table_shop
        $('.woocommerce table.shop_table.cart th.product-name').attr('colspan', 3);

        // Customize quantity input
        if ($(".quantity .minus, .quantity .plus").length == 0) {
            $(".quantity input[type='number']").before('<input type="button" value="-" class="minus button is-form">');
            $(".quantity input[type='number']").after('<input type="button" value="+" class="plus button is-form">');
        };
    });

    /*=====  End of INIT FUNCTIONS  ======*/


});
