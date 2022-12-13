jQuery(function($) {
	"use strict";

	var SLZ = window.SLZ || {};
	/*===========================================
	=			Testimonial style 1	     		=
	===========================================*/
	SLZ.Testimonial_st_1 = function() {
		$('.slz-testimonial-01').each(function() {
			var cont = $(this).attr('data-id');
			if( cont == undefined || cont == '' ) {
				return;
			}
			cont = '.' + cont;
			var client_wrapper_slidesToShow = parseInt($(cont).attr('data-slidesToShow'));
			var show_dots = $(cont).attr('data-dots');
			var show_arrow = $(cont).attr('data-show-arrow');
			var v_speed = $(cont).attr('data-speed');
			var v_autoplay = $(cont).attr('data-autoplay');
			var v_infinite = $(cont).attr('data-infinite');
            var v_animation = $(cont).attr('data-animation');
			var centerMode = true;
			if( v_speed == 0 || v_speed == '' || v_speed == undefined){
				v_speed = 500;
			}
			if( v_autoplay == '1' ){
				v_autoplay = true;
			} else {
				v_autoplay = false;
			}
			if( v_infinite == '1' ){
				v_infinite = true;
			} else {
				v_infinite = false;
			}
			if ( show_dots == '1' ) {
				show_dots = true;
			}else{
				show_dots = false;
			}
			if ( show_arrow == '1' ) {
				show_arrow = true;
			}else{
				show_arrow = false;
			}
            if ( v_animation == '1' ) {
                v_animation = true;
            }else{
                v_animation = false;
            }
			$(cont).find('.client-wrapper').slick({
				slidesToShow: client_wrapper_slidesToShow,
                slidesToScroll: 1,
				centerMode:  true,
				centerPadding: '0',
				arrows: show_arrow,
				focusOnSelect: true,
                useTransform:true,
                pauseOnHover:true,
                autoplay: v_autoplay,
                infinite: v_infinite,
                speed: v_speed,
				asNavFor: $(cont).find('.quote-wrapper'),
				prevArrow:'<button class="btn btn-prev"><i class=" icons fa fa-angle-left"><i></button>',
				nextArrow:'<button class="btn btn-next"><i class=" icons fa fa-angle-right"><i></button>',
				responsive: [
                    {
                      breakpoint: 1025,
                      settings: {
                        slidesToShow: 3,
                      }
                    },{
                      breakpoint: 768,
                      settings: {
                        arrows: false,
                        dots: true,
                        slidesToShow: 3
                      }
                    },{
                      breakpoint: 480,
                      settings: {
                        arrows: false,
                        dots: true,
                        slidesToShow: 1
                      }
                    }
                ]
			});
			$(cont).find('.quote-wrapper').slick({
				slidesToShow: 1,
				slidesToScroll: 1,
                fade: v_animation,
				asNavFor: $(cont).find('.client-wrapper'),
				dots: show_dots,
				arrows: show_arrow,
				adaptiveHeight: true,
                prevArrow:'<button class="btn btn-prev"><i class=" icons fa fa-angle-left"><i></button>',
                nextArrow:'<button class="btn btn-next"><i class=" icons fa fa-angle-right"><i></button>',
                responsive: [
                    {
                      breakpoint: 768,
                      settings: {
                        arrows: false,
                        dots: true,
                      }
                    }
                ]
			});
		});
	}
	/*=====  End of Testimonial style 1  ======*/
    /*===========================================
    =            Testimonial style 2            =
    ===========================================*/
	SLZ.Testimonial_st_2 = function() {
		$('.slz-testimonial-02').each(function() {
            var cont = $(this).attr('data-id');
            if( cont == undefined || cont == '' ) {
                return;
            }
            cont = '.' + cont;
            var client_wrapper_slidesToShow = 1;
			var attr = $(cont).attr('data-slidesToShow');
            if( typeof attr !== typeof undefined && attr !== false){
                client_wrapper_slidesToShow = parseInt(attr);
            }
            var show_dots = $(cont).attr('data-dots');
            var show_arrow = $(cont).attr('data-show-arrow');
            var v_speed = $(cont).attr('data-speed');
            var v_autoplay = $(cont).attr('data-autoplay');
            var v_infinite = $(cont).attr('data-infinite');
            var v_animation = $(cont).attr('data-animation');
            if( v_speed == 0 || v_speed == '' || v_speed == undefined){
                v_speed = 500;
            }
            if( v_autoplay == '1' ){
                v_autoplay = true;
            } else {
                v_autoplay = false;
            }
            if( v_infinite == '1' ){
                v_infinite = true;
            } else {
                v_infinite = false;
            }
            if ( show_dots == '1' ) {
                show_dots = true;
            }else{
                show_dots = false;
            }
            if ( show_arrow == '1' ) {
                show_arrow = true;
            }else{
                show_arrow = false;
            }
            if ( v_animation == '1' ) {
                v_animation = true;
            }else{
                v_animation = false;
            }
            $(cont).find('.slick-wrapper').slick({
                slidesToShow: client_wrapper_slidesToShow,
                slidesToScroll: client_wrapper_slidesToShow,
                adaptiveHeight: true,
                focusOnSelect: true,
                pauseOnHover:true,
                useTransform:true,
                dots: show_dots,
                arrows: show_arrow,
                autoplay: v_autoplay,
                infinite: v_infinite,
                speed: v_speed,
                fade: v_animation,
                prevArrow:'<button class="btn btn-prev"><i class="icons fa fa-angle-left"><i></button>',
                nextArrow:'<button class="btn btn-next"><i class="icons fa fa-angle-right"><i></button>',
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            dots: true,
                            arrows: false,
                            slidesToShow: 2,
                            slidesToScroll: 1,
                        }
                    },{
                        breakpoint: 601,
                        settings: {
                            dots: true,
                            arrows: false,
                            slidesToShow: 1,
                            slidesToScroll: 1,
                        }
                    }
                ]
            });
    	});
    }
    /*=====  End of Testimonial style 2  ======*/
    /*===========================================
    =            Testimonial style 3            =
    ===========================================*/
    SLZ.Testimonial_st_3 = function() {
    	$('.slz-testimonial-03').each( function() {
    		var client_wrapper_slidesToShow = parseInt($(this).find('.client-wrapper').attr('data-slidesToShow'));
    		var v_animation = $(this).attr('data-animation');
    		var v_autoplay = $(this).attr('data-autoplay');
    		if ( v_animation == '1' ) {
    			v_animation = true;
    		}else{
    			v_animation = false;
    		}
    		if ( v_autoplay == '1' ) {
    			v_autoplay = true;
    		}else{
    			v_autoplay = false;
    		}
    		$(this).find('.client-wrapper').slick({
    			slidesToShow: client_wrapper_slidesToShow,
    			slidesToScroll: 1,
    			infinite: true,
    			arrows: false,
    			autoplay: v_autoplay,
    			autoplaySpeed: 10000,
    			vertical: true,
    			verticalSwiping: true,
    			focusOnSelect: true,
    			adaptiveHeight: true,
    			pauseOnHover:true,
                useTransform:true,
    			asNavFor: $(this).find('.quote-wrapper'),
    			prevArrow: '<button class="btn btn-prev"><i class="icons fa fa-angle-left"><i></button>',
    			nextArrow: '<button class="btn btn-next"><i class="icons fa fa-angle-right"><i></button>',
    			responsive: [
	                {
                        breakpoint: 481,
                        settings: {
                            vertical: false,
                            verticalSwiping: false,
                            slidesToShow: 3,
                            centerMode: true,
                            centerPadding: '0px',
                        }
	                }
                ]
    		});
    		$(this).find('.quote-wrapper').slick({
    			slidesToShow: 1,
    			slidesToScroll: 1,
    			fade: v_animation,
    			pauseOnHover:true,
                useTransform:true,
    			asNavFor: $(this).find('.client-wrapper'),
    			adaptiveHeight: true,
    			dots: false,
    			arrows: false,
    			responsive: [
                    {
                        breakpoint: 481,
                        settings: {
                            dots: true,
                        }
                    }
                ]
    		});
    		
    	});
    }


	$(document).ready(function() {
		SLZ.Testimonial_st_1();
		SLZ.Testimonial_st_2();
		SLZ.Testimonial_st_3();
	});
});
