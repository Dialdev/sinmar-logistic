(function($) {
	"use strict";
	$.slz_scroll_to = function( element ){
		if( element.length ){
			$('body,html').animate({
				scrollTop: element.offset().top - 100
			}, 900);
		}
		return false;
	}
	$.slz_pagination_with_ajax = function() {
		$('.slz-shortcode div.pagination_with_ajax a').unbind("click");
		$('.slz-shortcode div.pagination_with_ajax a').on('click', function(e) {
			e.preventDefault();
			var $this = $(this);
			var page = $(this).attr('href');
			var container = $(this).closest('.slz-shortcode');
			$.slz_scroll_to( container );
			$this.closest('.slz-shortcode').append('<div class="mask"></div>');
			$this.closest('.slz-shortcode').find('.mask').fadeIn(500);
			var block_atts = jQuery.parseJSON($(this).closest('.slz-pagination').find('input.block_atts').val());
			var data = {
				"page": page,
				"atts": block_atts,
				"block": block_atts['shortcode']
			}  
			$.fn.Form.ajax(['shortcodes', 'ajax_response'], [data], function(res) {
				$this.closest('.slz-shortcode').find('.mask').fadeOut();
				$this.closest('.slz-shortcode').replaceWith(res);
				$.slz_pagination_with_ajax();
				$.slz_pagination_with_category();
				$('.' +block_atts['block-class']  + ' .first_video .carousel-inner > .item:first-child').addClass('active');
				// reload post js
				slz_reload_post_format_js();
			});
		});
	};
	$.slz_pagination_next_prev = function() {
		$('.slz-shortcode .pagination_next_prev a').unbind("click");
		$('.slz-shortcode .pagination_next_prev a').on('click', function(e) {
			e.preventDefault();
			var $this = $(this);
			var page = $(this).attr('href');
			var container = $(this).closest('.slz-shortcode');
			$.slz_scroll_to( container );
			$this.closest('.slz-shortcode').append('<div class="mask"></div>');
			$this.closest('.slz-shortcode').find('.mask').fadeIn(500);
			var block_atts = jQuery.parseJSON($(this).closest('.slz-pagination-02').find('input.block_atts').val());
			var data = {
				"page": page,
				"atts": block_atts,
				"block": block_atts['shortcode']
			}  
			$.fn.Form.ajax(['shortcodes', 'ajax_response'], [data], function(res) {
				$this.closest('.slz-shortcode').find('.mask').fadeOut();
				$this.closest('.slz-shortcode').replaceWith(res);
				$.slz_pagination_with_ajax();
				$.slz_pagination_next_prev();
				$.slz_pagination_with_category();
				$('.' +block_atts['block-class']  + ' .first_video .carousel-inner > .item:first-child').addClass('active');
			});
		});
	};
	$.slz_pagination_with_load_more = function() {
		$('.slz-shortcode .pagination_with_load_more').unbind("click");
		$('.slz-shortcode .pagination_with_load_more').on('click', function(e) {
			e.preventDefault();
			var $this = $(this);
			$this.closest('.slz-shortcode').append('<div class="mask"></div>');
			$this.closest('.slz-shortcode').find('.mask').fadeIn(500);
			var block_atts = jQuery.parseJSON($(this).parent().find('input.block_atts').val());
			var block = block_atts['shortcode'];
			var data = {
				"atts": block_atts,
				"block": block
			}
			$.fn.Form.ajax(['shortcodes', 'ajax_response'], [data], function(res) {
				$this.closest('.slz-shortcode').find('.mask').fadeOut();
				$this.closest('.slz-shortcode').replaceWith(res);
				$.slz_pagination_with_load_more();
				$.slz_pagination_with_category();
			});
		});
	};
    
	$.slz_pagination_with_category = function() {
		$('.slz-shortcode ul.block_category_tabs li a').unbind("click");
		$('.slz-shortcode ul.block_category_tabs li a').on('click', function(e) {
			e.preventDefault();
			var $this = $(this);
			if ($this.attr('href') == "#") return;
			$this.closest('.slz-shortcode').append('<div class="slz-loading-mask"></div>');
			$this.closest('.slz-shortcode').find('.slz-loading-mask').fadeIn(500);
			var block_atts = jQuery.parseJSON($this.closest('.slz-shortcode').find('input.cat_block_atts').val());
			var block = block_atts['shortcode'];
			var all_tab;
			if ($this.attr('href') == "") all_tab = 1;
			var data = {
				"atts": block_atts,
				"block": block,
				"cat": $this.attr('href'),
				"all_tab": all_tab
			};
			data["page"] = 1;
			$.fn.Form.ajax(['shortcodes', 'ajax_response_category'], [data], function(res) {
				$this.closest('.slz-shortcode').find('.slz-loading-mask').fadeOut();
				$this.closest('.slz-shortcode').replaceWith(res);
				$.slz_pagination_with_category();
				$.slz_pagination_with_load_more();
				$.slz_pagination_with_ajax();
				
				SLZ_MAIN.init();
			});
		});
	};
	function slz_reload_post_format_js() {
		if( $('audio').length ){
			$('audio').mediaelementplayer();
		}
		if( $('.slz-gallery-format .slz-carousel').length ){
	        $('.slz-gallery-format .slz-carousel').each( function(e, val) {
	            $(this).slick({
	                infinite: true,
	                autoplay: true,
	                slidesToShow: 1,
	                slidesToScroll: 1,
	                dots: false,
	                arrows: true,
	                appendArrows: $(this).parents('.slz-image-carousel'),
	                prevArrow: '<button class="btn btn-prev"><i class="icons fa"></i><span class="text">Previous</span></button>',
	                nextArrow: '<button class="btn btn-next"><span class="text">Next</span> <i class="icons fa"></i></button>'
	            });
	        });
		}
	}
	
	$.slz_sc_postblock_like = function () {
        $('.block-info .like').click(function () {
            var like_view = $( this );
            var postid = like_view.attr( 'data-postid' );
            var data = {
                'postid': postid,
            };
            $.fn.Form.ajax(['shortcodes', 'ajax_postlike'], [data], function(res) {
            	res = JSON.parse( res );
                like_view.html( res.count );
                like_view.attr('class', res.class );
                like_view.attr('title', res.title );
            });
        });
    }

})(jQuery);

jQuery(document).ready(function() {
	jQuery.slz_pagination_with_ajax();
	jQuery.slz_pagination_next_prev();
	jQuery.slz_pagination_with_load_more();
	jQuery.slz_pagination_with_category();
	jQuery.slz_sc_postblock_like();
})