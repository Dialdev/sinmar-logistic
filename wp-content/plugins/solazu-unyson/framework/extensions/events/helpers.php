<?php
if( !function_exists('slz_events_get_post_navigation') ) {
	function slz_events_get_post_navigation () {
		global $post;
		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );
		if ( ! $next && ! $previous )
			return;
		?>
		<nav class="post-navigation row" >
			<div class="col-md-12">
				<div class="nav-links">
					<div class="pull-left prev-post">
					<?php previous_post_link( '%link', _x( '<span class="meta-nav">&larr;</span> Previous Post', 'Previous post link', 'slz' ) ); ?>
					</div>
					<div class="pull-right next-post">
					<?php next_post_link( '%link', _x( 'Next Post <span class="meta-nav">&rarr;</span>', 'Next post link', 'slz' ) ); ?>
					</div>
				</div><!-- .nav-links -->
			</div>
		</nav><!-- .navigation -->
		<?php
	}
}

if ( ! function_exists( 'slz_events_extra_get_social_share' ) ) :
	function slz_events_extra_get_social_share( $post_key = 'social-event-in-post' , $echo = false) {
		$options = slz_get_db_settings_option($post_key, '');
		$show_social =  slz_akg( 'enable-event-social-share', $options, '' );

		if($show_social != 'enable'){
			return;
		}
		
		$social_enable  = slz_akg( 'enable/social-event-share-info', $options, array() );
		$share_format ='<a href="%1$s" class="link %3$s" target="_blank">%2$s</a>';
		$obj = new SLZ_Social_Sharing();
		$share_link = $obj->renders( $social_enable, false, $share_format);
		
		if( $share_link ){
			$out = '<div class="slz-social-share">
				<span class="title">'. esc_html('Share to ','slz').'</span>
				<div class="social">'. wp_kses_post( $share_link ) .'</div>
			</div>';
			if( $echo ) {
				return $out;
			}
			echo $out;
		}// has share links
	}
endif;

if ( ! function_exists( 'slz_events_post_categories_meta' ) ) :
	function slz_events_post_categories_meta( $container = true, $seperator = ', ' ) {
		if( slz_get_db_settings_option('blog-event-post-categories', '') == 'yes' ){
			$categories_list = get_the_term_list( get_the_ID(), 'slz-event-cat', '', $seperator, '' );
		
			if ( $categories_list ) {
				$format = '<li>%1$s%2$s</li>';
				if( $container ) {
					$format = '<ul class="categories-list"><li>%1$s%2$s</li></ul>';
				}
				printf( $format,
						esc_html_x( 'Categories:', 'Used before category names.', 'slz' ),
						$categories_list
				);
			}
		}
	}
endif;

if( !function_exists( 'slz_events_encode_data' ) ) {
	function slz_events_encode_data( $data = '' ) {
		$out = '';
		if( !empty( $data ) ) {
			$out .= base64_encode( $data );
		}
		return $out;
	}
}

if ( ! function_exists( 'slz_get_post_hide_event_expired' ) ) :
    function slz_get_post_hide_event_expired( ) {
        $args = array(
            'post_type' => 'slz-event',
            'post_status' => 'publish',
            'meta_query'  => array(
                array(
                    'key' => 'slz_option:hide_event_expired',
                    'value' => '1',
                    'compare' => '='
                ),
                array(
                    'key' => 'slz_option:from_date',
                    'value' => date( 'Y/m/d'),
                    'compare' => '<'
                ),
            )
        );

        $query = new WP_Query( $args );
        $arr = $query->get_posts();
        $arr_post_hide = array(
        );

        if (is_array($arr) && count($arr) > 0) {
            for ($i=0; $i<count($arr); $i++) {
                $arr_post_hide[] = $arr[$i]->ID;
            }
        }
        return $arr_post_hide;
    }
endif;