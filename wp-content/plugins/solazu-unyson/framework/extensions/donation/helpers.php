<?php
if( !function_exists('') ) {
	function slz_donation_get_post_navigation () {
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

if ( ! function_exists( 'slz_donation_extra_get_social_share' ) ) :
	function slz_donation_extra_get_social_share( $post_key = 'social-cause-in-post' , $echo = false) {
		$options = slz_get_db_settings_option($post_key, '');
		$show_social =  slz_akg( 'enable-cause-social-share', $options, '' );
        if($show_social != 'enable'){
            return;
        }

        $social_enable  = slz_akg( 'enable/social-cause-share-info', $options, array() );
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

if ( ! function_exists( 'slz_donation_post_categories_meta' ) ) :

	function slz_donation_post_categories_meta( $container = true, $seperator = ', ' ) {
		if( slz_get_db_settings_option('blog-cause-post-categories', '') == 'yes' ){
			$categories_list = get_the_term_list( get_the_ID(), 'slz-causes-cat', '', $seperator, '' );
		
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
