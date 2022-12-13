	var SLZ_MAIN = function ( ) {
		//initial wow
		var wow_function = function() {
			new WOW().init();
		}
		
		var carousel_function = function() {
			
			/*----------  layout united states  ----------*/
			jQuery(".sc_carousel_posts .slz-carousel-global").each(function() {
	
				if ( jQuery(this).hasClass('slz-initial') == true )
					return true;

				var cont = jQuery(this).parents('.sc_carousel_posts')
	
				var carousel_item = parseInt( jQuery(this).attr('data-slidesToShow')),
				    dots = jQuery(cont).attr('data-dots'),
            	    arrow = jQuery(cont).attr('data-arrow'),
            	    speed = jQuery(cont).attr('data-speed'),
	                autoplay = jQuery(cont).attr('data-autoplay'),
	                infinite = jQuery(cont).attr('data-infinite'),
	                animation = jQuery(cont).attr('data-animation');
                if( speed == 0 || speed == '' || speed == undefined){
	                speed = 600;
	            }
	            if( autoplay == '1' ){
	                autoplay = true;
	            } else {
	                autoplay = false;
	            }
	            if( infinite == '1' ){
	                infinite = true;
	            } else {
	                infinite = false;
	            }
	            if ( dots == '1' ) {
	                dots = true;
	            }else{
	                dots = false;
	            }
	            if ( arrow == '1' ) {
	                arrow = true;
	            }else{
	                arrow = false;
	            }
	            if ( animation == '1' ) {
	                animation = true;
	            }else{
	                animation = false;
	            }

				if (carousel_item == 1) {
					jQuery(this).slick({
						infinite: infinite,
						slidesToShow: 1,
						slidesToScroll: 1,
						speed: speed,
						dots: dots,
						arrows: arrow,
                		autoplay: autoplay,
						fade: animation,
						adaptiveHeight: true,
						appendArrows: jQuery(this).parents('.slz-carousel-wrapper'),
						prevArrow: '<button class="btn btn-prev"><i class="icons fa"></i><span class="text">Previous</span></button>',
						nextArrow: '<button class="btn btn-next"><span class="text">Next</span> <i class="icons fa"></i></button>',
						responsive: [
							{
								breakpoint: 769,
								settings: {
									arrows: false,
									dots: true
								}
							}
						]
					});
				}else if (carousel_item == 2) {
					jQuery(this).slick({
						infinite: infinite,
						slidesToShow: 2,
						slidesToScroll: 2,
						speed: speed,
						dots: dots,
						arrows: arrow,
                		autoplay: autoplay,
						fade: animation,
						adaptiveHeight: true,
						appendArrows: jQuery(this).parents('.slz-carousel-wrapper'),
						prevArrow: '<button class="btn btn-prev"><i class="icons fa"></i><span class="text">Previous</span></button>',
						nextArrow: '<button class="btn btn-next"><span class="text">Next</span> <i class="icons fa"></i></button>',
						responsive: [
							{
								breakpoint: 769,
								settings: {
									arrows: false,
									dots: true
								}
							}, {
								breakpoint: 415,
								settings: {
									slidesToShow: 1,
									slidesToScroll: 1,
									arrows: false,
									dots: true
								}
							}
						]
					});
				}else if (carousel_item == 3) {
					jQuery(this).slick({
						infinite: infinite,
						slidesToShow: 3,
						slidesToScroll: 3,
						speed: speed,
						dots: dots,
						arrows: arrow,
                		autoplay: autoplay,
						fade: animation,
						adaptiveHeight: true,
						appendArrows: jQuery(this).parents('.slz-carousel-wrapper'),
						prevArrow: '<button class="btn btn-prev"><i class="icons fa"></i><span class="text">Previous</span></button>',
						nextArrow: '<button class="btn btn-next"><span class="text">Next</span> <i class="icons fa"></i></button>',
						responsive: [
							{
								breakpoint: 769,
								settings: {
									slidesToShow: 2,
									slidesToScroll: 2,
									arrows: false,
									dots: true
								}
							}, {
								breakpoint: 415,
								settings: {
									slidesToShow: 1,
									slidesToScroll: 1,
									arrows: false,
									dots: true
								}
							}
						]
					});
				}else if (carousel_item == 4) {
					jQuery(this).slick({
						infinite: infinite,
						slidesToShow: 4,
						slidesToScroll: 4,
						speed: speed,
						dots: dots,
						arrows: arrow,
                		autoplay: autoplay,
						fade: animation,
						adaptiveHeight: true,
						appendArrows: jQuery(this).parents('.slz-carousel-wrapper'),
						prevArrow: '<button class="btn btn-prev"><i class="icons fa"></i><span class="text">Previous</span></button>',
						nextArrow: '<button class="btn btn-next"><span class="text">Next</span> <i class="icons fa"></i></button>',
						responsive: [
							{
								breakpoint: 1025,
								settings: {
									slidesToShow: 3,
									slidesToScroll: 3,
								}
							}, {
								breakpoint: 769,
								settings: {
									slidesToShow: 2,
									slidesToScroll: 2,
									arrows: false,
									dots: true
								}
							}, {
								breakpoint: 415,
								settings: {
									slidesToShow: 1,
									slidesToScroll: 1,
									arrows: false,
									dots: true
								}
							}
						]
					});
				}else if (carousel_item >= 5) {
					jQuery(this).slick({
						infinite: infinite,
						slidesToShow: carousel_item,
						slidesToScroll: carousel_item,
						speed: speed,
						dots: dots,
						arrows: arrow,
                		autoplay: autoplay,
						fade: animation,
						adaptiveHeight: true,
						appendArrows: jQuery(this).parents('.slz-carousel-wrapper'),
						prevArrow: '<button class="btn btn-prev"><i class="icons fa"></i><span class="text">Previous</span></button>',
						nextArrow: '<button class="btn btn-next"><span class="text">Next</span> <i class="icons fa"></i></button>',
						responsive: [
							{
								breakpoint: 1025,
								settings: {
									slidesToShow: 4,
									slidesToScroll: 4,
								}
							}, {
								breakpoint: 769,
								settings: {
									slidesToShow: 3,
									slidesToScroll: 3,
									arrows: false,
									dots: true
								}
							}, {
								breakpoint: 601,
								settings: {
									slidesToShow: 2,
									slidesToScroll: 2,
									arrows: false,
									dots: true
								}
							}, {
								breakpoint: 415,
								settings: {
									slidesToShow: 1,
									slidesToScroll: 1,
									arrows: false,
									dots: true
								}
							}
						]
					});
				}
				
				jQuery(this).addClass('slz-initial');
			});


			/*----------  layout india  ----------*/
			jQuery(".sc_carousel_posts .slz-carousel-vertical").each(function() {
				
				if ( jQuery(this).hasClass('slz-initial') == true )
					return true;

				var cont = jQuery(this).parents('.sc_carousel_posts')

				var carousel_item = parseInt( jQuery(this).attr('data-slidesToShow')),
				    dots = jQuery(cont).attr('data-dots'),
            	    arrow = jQuery(cont).attr('data-arrow'),
            	    speed = jQuery(cont).attr('data-speed'),
	                autoplay = jQuery(cont).attr('data-autoplay'),
	                infinite = jQuery(cont).attr('data-infinite'),
	                animation = jQuery(cont).attr('data-animation');
                if( speed == 0 || speed == '' || speed == undefined){
	                speed = 500;
	            }
	            if( autoplay == '1' ){
	                autoplay = true;
	            } else {
	                autoplay = false;
	            }
	            if( infinite == '1' ){
	                infinite = true;
	            } else {
	                infinite = false;
	            }
	            if ( dots == '1' ) {
	                dots = true;
	            }else{
	                dots = false;
	            }
	            if ( arrow == '1' ) {
	                arrow = true;
	            }else{
	                arrow = false;
	            }
	            if ( animation == '1' ) {
	                animation = true;
	            }else{
	                animation = false;
	            }
				
				jQuery(this).slick({
					slidesToShow: carousel_item,
					slidesToScroll: carousel_item,
					vertical: true,
					verticalSwiping: true,
					infinite: infinite,
					speed: speed,
					dots: dots,
					arrows: arrow,
            		autoplay: autoplay,
					fade: animation,
					adaptiveHeight: true,
					appendArrows: jQuery(this).parents('.slz-carousel-wrapper'),
					prevArrow: '<button class="btn btn-prev"><i class="icons fa"></i><span class="text">Previous</span></button>',
					nextArrow: '<button class="btn btn-next"><span class="text">Next</span> <i class="icons fa"></i></button>',
					responsive: [
						{
							breakpoint: 768,
							settings: {
								vertical: false,
								verticalSwiping: false,
							}
						}
					]
				});
	
				jQuery(this).addClass('slz-initial');
			});


			/*----------  layout kingdom  ----------*/
			jQuery('.sc_carousel_posts .slz-block-slider-01').each(function(){

        		if ( jQuery(this).hasClass('slick-initialized') == true )
					return true;

				var cont = jQuery(this).parents('.sc_carousel_posts')
	
				var carousel_item = parseInt( jQuery(this).find('.block-slider-nav-01').attr('data-slidesToShow')),
				    dots = jQuery(cont).attr('data-dots'),
            	    arrow = jQuery(cont).attr('data-arrow'),
            	    speed = jQuery(cont).attr('data-speed'),
	                autoplay = jQuery(cont).attr('data-autoplay'),
	                infinite = jQuery(cont).attr('data-infinite'),
	                animation = jQuery(cont).attr('data-animation');
                if( speed == 0 || speed == '' || speed == undefined){
	                speed = 500;
	            }
	            if( autoplay == '1' ){
	                autoplay = true;
	            } else {
	                autoplay = false;
	            }
	            if( infinite == '1' ){
	                infinite = true;
	            } else {
	                infinite = false;
	            }
	            if ( dots == '1' ) {
	                dots = true;
	            }else{
	                dots = false;
	            }
	            if ( arrow == '1' ) {
	                arrow = true;
	            }else{
	                arrow = false;
	            }
	            if ( animation == '1' ) {
	                animation = true;
	            }else{
	                animation = false;
	            }

                jQuery(this).find('.block-slider-main-01').slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    speed: speed,
                    dots: dots,
            		autoplay: autoplay,
                    arrows: arrow,
                    infinite: infinite,
                    fade: animation,
                    asNavFor: jQuery(this).find('.block-slider-nav-01'),
					appendArrows: jQuery(this).parents('.slz-carousel-wrapper'),
					prevArrow: '<button class="btn btn-prev"><i class="icons fa"></i><span class="text">Previous</span></button>',
					nextArrow: '<button class="btn btn-next"><span class="text">Next</span> <i class="icons fa"></i></button>',
					responsive: [{
	                    breakpoint: 768,
	                    settings: {
                        	arrows: false,
                        }
	                }]
                });

                jQuery(this).find('.block-slider-nav-01').slick({
                    infinite: infinite,
                    slidesToShow: carousel_item,
                    slidesToScroll: 1,
                    speed: speed,
                    dots: false,
                    arrows: false,
                    focusOnSelect: true,
                    asNavFor: jQuery(this).find('.block-slider-main-01'),
                    responsive: [{
	                    breakpoint: 768,
	                    settings: {
                        	dots: true,
                        	}
	                    }, {
	                    breakpoint: 381,
	                    settings: {
                        	dots: true,
                        	slidesToShow: 2
                        }
	                }]
                });
            });


			/*----------  layout turkey + brazil ----------*/
			jQuery(".sc_carousel_posts .slz-carousel-syncing").each(function() {
	
				if ( jQuery(this).hasClass('slz-initial') == true )
					return true;

				var cont = jQuery(this).parents('.sc_carousel_posts')
	
				var carousel_item = parseInt( jQuery(this).find('.slider-nav').attr('data-slidesToShow')),
				    dots1 = jQuery(this).find('.slider-nav').attr('data-dots'),
				    dots2 = jQuery(this).find('.slider-for').attr('data-dots'),
            	    arrow = jQuery(cont).attr('data-arrow'),
            	    speed = jQuery(cont).attr('data-speed'),
	                autoplay = jQuery(cont).attr('data-autoplay'),
	                infinite = jQuery(cont).attr('data-infinite'),
	                animation = jQuery(cont).attr('data-animation');
                if( speed == 0 || speed == '' || speed == undefined){
	                speed = 500;
	            }
	            if( autoplay == '1' ){
	                autoplay = true;
	            } else {
	                autoplay = false;
	            }
	            if( infinite == '1' ){
	                infinite = true;
	            } else {
	                infinite = false;
	            }
	            if ( dots1 == '1' ) {
	                dots1 = true;
	            }else{
	                dots1 = false;
	            }
	            if ( dots2 == '1' ) {
	                dots2 = true;
	            }else{
	                dots2 = false;
	            }
	            if ( arrow == '1' ) {
	                arrow = true;
	            }else{
	                arrow = false;
	            }
	            if ( animation == '1' ) {
	                animation = true;
	            }else{
	                animation = false;
	            }
	
				jQuery(this).find('.slider-for').slick({
					slidesToShow: 1,
	                slidesToScroll: 1,
	                dots: dots2,
	                arrows: arrow,
					speed: speed,
	                fade: animation,
            		autoplay: autoplay,
	                adaptiveHeight: true,
	                asNavFor: jQuery(this).find('.slider-nav'),
	                prevArrow: '<button class="btn btn-prev"><i class="icons fa"></i><span class="text">Previous</span></button>',
	                nextArrow: '<button class="btn btn-next"><span class="text">Next</span> <i class="icons fa"></i></button>',
	
				});
	
				jQuery(this).find('.slider-nav').slick({
					slidesToShow: carousel_item,
	                slidesToScroll: 1,
	                dots: dots1,
	                arrows: false,
					speed: speed,
            		autoplay: autoplay,
	                infinite: infinite,
                	centerMode: true,
                	centerPadding: '0px',
	                focusOnSelect: true,
	                asNavFor: jQuery(this).find('.slider-for'),
	                responsive: [{
	                    breakpoint: 1025,
	                    settings: {
	                        slidesToShow: 4
	                        }
	                    }, {
	                    breakpoint: 769,
	                    settings: {
	                        slidesToShow: 4
	                        }
	                    }, {
	                    breakpoint: 601,
	                    settings: {
	                        slidesToShow: 4
	                        }
	                    }, {
	                    breakpoint: 415,
	                    settings: {
	                        slidesToShow: 3
	                        }
	                    }, {
	                    breakpoint: 381,
	                    settings: {
	                        slidesToShow: 2
	                    }
	                }]
				});
				jQuery(this).addClass('slz-initial');
			});
	

			/*----------  layout Germany ----------*/
			jQuery(".sc_carousel_posts .slz-carousel-vertical-02").each(function() {
	
				if ( jQuery(this).hasClass('slz-initial') == true )
					return true;

				var cont = jQuery(this).parents('.sc_carousel_posts'),
					carousel_item = jQuery('.slz-carousel-vertical-02 .slider-nav .item');
	
				var dots = jQuery(cont).attr('data-dots'),
            	    arrow = jQuery(cont).attr('data-arrow'),
            	    speed = jQuery(cont).attr('data-speed'),
	                autoplay = jQuery(cont).attr('data-autoplay'),
	                infinite = jQuery(cont).attr('data-infinite'),
	                animation = jQuery(cont).attr('data-animation');
                if( speed == 0 || speed == '' || speed == undefined){
	                speed = 500;
	            }
	            if( autoplay == '1' ){
	                autoplay = true;
	            } else {
	                autoplay = false;
	            }
	            if( infinite == '1' ){
	                infinite = true;
	            } else {
	                infinite = false;
	            }
	            if ( dots == '1' ) {
	                dots = true;
	            }else{
	                dots = false;
	            }
	            if ( arrow == '1' ) {
	                arrow = true;
	            }else{
	                arrow = false;
	            }
	            if ( animation == '1' ) {
	                animation = true;
	            }else{
	                animation = false;
	            }
	
				jQuery(this).find('.slider-for').slick({
					slidesToShow: 1,
					slidesToScroll: 1,
					infinite: infinite,
					arrows: arrow,
					fade: animation,
					autoplay: autoplay,
					speed: speed,
	                asNavFor: jQuery(this).find('.slider-nav'),
	                prevArrow: '<button class="btn btn-prev"><i class="icons fa"></i><span class="text">Previous</span></button>',
	                nextArrow: '<button class="btn btn-next"><span class="text">Next</span> <i class="icons fa"></i></button>',
				});
	
				jQuery(this).find('.slider-nav').slick({
					slidesToShow: carousel_item.length,
					vertical: true,
					infinite: infinite,
					speed: speed,
					slidesToScroll: 1,
					focusOnSelect: true,
					arrows: false,
	                asNavFor: jQuery(this).find('.slider-for'),
				});
	
				jQuery(".slz-carousel-vertical-02 .slider-nav").css("height", jQuery(".slz-carousel-vertical-02 .slider-for").height());
				jQuery(this).addClass('slz-initial');
			});
			
			/*----------  layout Spain ----------*/
			jQuery(".sc_carousel_posts .slz-carousel-center").each(function() {
	
				if ( jQuery(this).hasClass('slz-initial') == true )
					return true;
				
				var cont = jQuery(this).parents('.sc_carousel_posts')

				var dots = jQuery(cont).attr('data-dots'),
            	    arrow = jQuery(cont).attr('data-arrow'),
            	    speed = jQuery(cont).attr('data-speed'),
	                autoplay = jQuery(cont).attr('data-autoplay'),
	                infinite = jQuery(cont).attr('data-infinite'),
	                animation = jQuery(cont).attr('data-animation');
                if( speed == 0 || speed == '' || speed == undefined){
	                speed = 500;
	            }
	            if( autoplay == '1' ){
	                autoplay = true;
	            } else {
	                autoplay = false;
	            }
	            if( infinite == '1' ){
	                infinite = true;
	            } else {
	                infinite = false;
	            }
	            if ( dots == '1' ) {
	                dots = true;
	            }else{
	                dots = false;
	            }
	            if ( arrow == '1' ) {
	                arrow = true;
	            }else{
	                arrow = false;
	            }
	            if ( animation == '1' ) {
	                animation = true;
	            }else{
	                animation = false;
	            }
				
				jQuery(this).slick({
					infinite: infinite,
	                autoplay: autoplay,
	                dots: dots,
	                arrows: arrow,
					speed: speed,
	                fade: animation,
	                centerMode: true,
	                slidesToShow: 1,
	                centerPadding: '22%',
	                prevArrow: '<button class="btn btn-prev"><i class="icons fa"></i><span class="text">Previous</span></button>',
	                nextArrow: '<button class="btn btn-next"><span class="text">Next</span><i class="icons fa"></i></button>',
	                responsive: [
	                    {
	                        breakpoint: 1025,
	                        settings: {
	                            centerPadding: '15%',
	                        }
	                    },
	                    {
	                        breakpoint: 769,
	                        settings: {
	                            centerPadding: '70px',
	                        }
	                    },
	                    {
	                        breakpoint: 481,
	                        settings: {
	                            arrows: false,
	                            centerPadding: '15px',
	                        }
	                    }
	                ]
				});
			});

			/*----------  Related Article  ----------*/
			jQuery(".slz_single_relate_post .slz-carousel").each(function() {
	            var carousel_item = parseInt(jQuery(this).attr('data-slidestoshow'));
	            if (carousel_item == 1) {
	                jQuery(this).slick({
	                    infinite: true,
	                    slidesToShow: 1,
	                    slidesToScroll: 1,
	                    speed: 600,
	                    adaptiveHeight: true,
	                    dots: false,
	                    arrows: true,
	                    appendArrows: jQuery(this).parents('.slz-carousel-wrapper'),
	                    prevArrow: '<button class="btn btn-prev"><i class="fa fa-long-arrow-left"></i><span class="text">Previous</span></button>',
	                    nextArrow: '<button class="btn btn-next"><span class="text">Next</span> <i class="fa fa-long-arrow-right"></i></button>'
	                });
	            }
	            if (carousel_item == 2) {
	                jQuery(this).slick({
	                    infinite: true,
	                    slidesToShow: carousel_item,
	                    slidesToScroll: 1,
	                    speed: 600,
	                    dots: false,
	                    arrows: true,
	                    adaptiveHeight: true,
	                    appendArrows: jQuery(this).parents('.slz-carousel-wrapper'),
	                    prevArrow: '<button class="btn btn-prev"><i class="fa fa-long-arrow-left"></i><span class="text">Previous</span></button>',
	                    nextArrow: '<button class="btn btn-next"><span class="text">Next</span> <i class="fa fa-long-arrow-right"></i></button>',
	                    responsive: [{
	                        breakpoint: 481,
	                        settings: {
	                            slidesToShow: 1,
	                            slidesToScroll: 1,
	                        }
	                    }]
	                });
	            }
	            if (carousel_item == 3) {
	                jQuery(this).slick({
	                    infinite: true,
	                    slidesToShow: carousel_item,
	                    slidesToScroll: 1,
	                    speed: 600,
	                    adaptiveHeight: true,
	                    dots: false,
	                    arrows: true,
	                    appendArrows: jQuery(this).parents('.slz-carousel-wrapper'),
	                    prevArrow: '<button class="btn btn-prev"><i class="fa fa-long-arrow-left"></i><span class="text">Previous</span></button>',
	                    nextArrow: '<button class="btn btn-next"><span class="text">Next</span> <i class="fa fa-long-arrow-right"></i></button>',
	                    responsive: [{
	                        breakpoint: 769,
	                        settings: {
	                            slidesToShow: 2,
	                            slidesToScroll: 2,
	                        }
	                    }, {
	                        breakpoint: 481,
	                        settings: {
	                            slidesToShow: 1,
	                            slidesToScroll: 1,
	                        }
	                    }]
	                });
	            }
	            if (carousel_item >= 4) {
	                jQuery(this).slick({
	                    infinite: true,
	                    slidesToShow: carousel_item,
	                    slidesToScroll: 1,
	                    speed: 600,
	                    adaptiveHeight: true,
	                    dots: false,
	                    arrows: true,
	                    appendArrows: jQuery(this).parents('.slz-carousel-wrapper'),
	                    prevArrow: '<button class="btn btn-prev"><i class="fa fa-long-arrow-left"></i><span class="text">Previous</span></button>',
	                    nextArrow: '<button class="btn btn-next"><span class="text">Next</span> <i class="fa fa-long-arrow-right"></i></button>',
	                    responsive: [{
	                        breakpoint: 1025,
	                        settings: {
	                            slidesToShow: 3,
	                            slidesToScroll: 3,
	                        }
	                    }, {
	                        breakpoint: 769,
	                        settings: {
	                            slidesToShow: 2,
	                            slidesToScroll: 2,
	                        }
	                    }, {
	                        breakpoint: 481,
	                        settings: {
	                            slidesToShow: 1,
	                            slidesToScroll: 1,
	                        }
	                    }]
	                });
	            }
	        });

			/*----------  Post slider Widgets  ----------*/
			jQuery(".slz-widget-post-slider .slz-carousel-global").each(function() {
	
				if ( jQuery(this).hasClass('slz-initial') == true )
					return true;
	
				jQuery(this).slick({
					infinite: true,
					slidesToShow: 1,
					slidesToScroll: 1,
					dots: false,
					arrows: true,
            		autoplay: true,
					adaptiveHeight: true,
					appendArrows: jQuery(this).parents('.slz-carousel-wrapper'),
					prevArrow: '<button class="btn btn-prev"><i class="icons fa"></i><span class="text">Previous</span></button>',
					nextArrow: '<button class="btn btn-next"><span class="text">Next</span> <i class="icons fa"></i></button>',
				});
				
				jQuery(this).addClass('slz-initial');
			});

		}
	
		var video_function = function(){
			if (jQuery(".slz-block-video .block-video .video-embed").length) {
				jQuery(".slz-block-video .block-video .btn-play").on('click', function(event) {
					jQuery(this).parent().find(".video-embed").addClass('show-video');
					jQuery(this).parent().find(".btn-close").addClass('show-video');
					jQuery(this).parent().find(".video-embed")[0].src += "&autoplay=1";
					if( jQuery(this).parents('.block-video').prev().length ) {
						jQuery(this).parents('.block-video').prev().addClass('hidden');
					}
					jQuery(this).parent().find('.title').addClass('hidden');
					event.preventDefault();
				});
				jQuery(".slz-block-video .block-video .btn-close").on('click', function(event) {
					jQuery(this).parent().find(".video-embed")[0].src = jQuery(this).attr('data-src');
					jQuery(this).parent().find(".video-embed").removeClass('show-video');
					jQuery(this).parent().find(".btn-close").removeClass('show-video');
					if( jQuery(this).parents('.block-video').prev().length ) {
						jQuery(this).parents('.block-video').prev().removeClass('hidden');
					}
					jQuery(this).parent().find('.title').removeClass('hidden');
				});

				/*
                jQuery('.slz-block-video .modal').on('shown.bs.modal', function () {
                    var modal = jQuery(this);
                    jQuery('body').on('click', function(e) {
                        modal.parents('.block-video').find('.btn-close')[0].click();
                    });
                });
                */
			}
		}

		var comment_rating = function() {
	        jQuery('.comment-form-rating .stars a').on('click', function(e){
	            e.preventDefault();
	            jQuery('.comment-form-rating .stars').find('a').removeClass('active');
	            jQuery(this).addClass('active');
	            jQuery(this).closest('.comment-form-rating').find('input[name="rating"]').val( jQuery(this).html() );
	        });
	    }
	    
	    // project carousel shortcode
	    var portfolio_carousel_sc = function() {
	    	if ( jQuery('.sc_portfolio_list .portfolio_slide_slick').length ) {
				jQuery('.sc_portfolio_list').each(function() {
					var item = jQuery(this).attr('data-item');
					var block = '.' + item + ' ';
					var slick_block = jQuery(block + ".portfolio_slide_slick");
					if ( slick_block.length && !slick_block.hasClass('slick-initialized') ) {
						var slick_json = jQuery(slick_block).data('slick-json');
						if (typeof slick_json !== 'undefined') {
							var centerMode = {centerMode:false}
							jQuery.extend( slick_json, centerMode );
							slick_block.slick( slick_json );
						}
					}
				});
			}
	    }
	    
	    var sc_causes_progressbar = function () {
	        if ( jQuery('.sc_causes_block_layout_1 .slz-progress-bar-01').length || jQuery('.sc_causes_block_layout_2 .slz-progress-bar-01').length ) {
	        	jQuery(".progress-bar").each(function() {
	                var unit = jQuery(this).attr('data-unit');
	                var each_bar_width = jQuery(this).attr('aria-valuenow');
	                jQuery(this).width(each_bar_width + '%');
	                jQuery(this).parent().parent().find('.percent').attr('data-to', each_bar_width);
	                jQuery(this).parent().parent().find('.percent').countTo({
	                    onUpdate: function(value) {
	                		jQuery(this).append(unit);
	                    }
	                });
	            });
	        }
	    }

		return {
			//main function to initiate the module
			init: function () {

				wow_function();
				carousel_function();
				video_function();
				comment_rating();
				portfolio_carousel_sc();
				sc_causes_progressbar();
			}
		}

	}();
	
	jQuery(document).ready(function() {
		SLZ_MAIN.init();
        jQuery('audio.audio-format').mediaelementplayer();
        jQuery(window).on('resize', function() {
        	jQuery('audio.audio-format').mediaelementplayer();
        });
	});

