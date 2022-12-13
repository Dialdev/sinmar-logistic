<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'slz_post_featured_video' ) ) :
	/**
	 * Display an optional post thumbnail or featured video.
	*
	*/
	function slz_post_featured_video() {
		if ( post_password_required() || is_attachment() ) {
			return;
		}
		$show_video = false;
		if( get_post_format() == 'video'){
			$post_id = get_the_ID();
			//video
			$video_url = '';
			$video = SLZ_Post_Feature_Video::get_feature_video_iframe($video_url, $post_id, '');
			$image_url= '';
			if( $video ){
				$show_video = true;
				if( has_post_thumbnail() ) {
					$image_url = get_the_post_thumbnail_url();
				}
		?>
			<div class="slz-block-video slz-featured-block">
				<div class="block-video">
					<div class="btn-play">
						<i class="icons fa fa-play"></i>
					</div>
					<div class="btn-close" data-src="<?php esc_url($video_url)?>"><i class="icons fa fa-times"></i></div>
					<?php if($image_url):?>
					<img src="<?php echo esc_url( $image_url ); ?>" alt="" class="img-full"/>
					<?php endif;?>
					<?php echo $video ?>
				</div>
				<?php echo slz_post_ribbon_date();?>
			</div><?php
			}
		}
		if( !$show_video ) {
			slz_post_thumbnail();
		}
	}
endif;
if ( ! function_exists( 'slz_post_thumbnail' ) ) :
/**
 * Display an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 *
 */
function slz_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}
	?>
	<div class="slz-featured-block">
		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
			<?php
				the_post_thumbnail( 'post-thumbnail', array( 'alt' => get_the_title(), 'class' => 'img-responsive' ) );
			?>
		</a><?php
		echo slz_post_ribbon_date();?>
	</div><?php 
}
endif;
if ( ! function_exists( 'slz_tags_meta' ) ) :

	function slz_post_tags_meta( $container = true, &$res = false, $sep = ', ' ) {
		if( slz_get_db_settings_option('blog-post-tags', '') == 'yes' ){
	
			$tags_list = get_the_tag_list( '', $sep );
			if ( $tags_list ) {
				$format = '<li>%1$s%2$s</li>';
				if( $container ) {
					$format = '<ul class="tags-list tags-links"><li>%1$s%2$s</li></ul>';
				}
				$res = true;
				printf( $format,
						esc_html_x( 'Tags:', 'Used before tag names.', 'slz' ),
						$tags_list
				);
			}
		}
	
	}
endif;
if ( ! function_exists( 'slz_post_post_date' ) ) :

	function slz_post_normal_date( $container = true ) {
	
		$post_info = slz_get_db_settings_option('post-info', array());
		if( empty( $post_info['show_date'] ) || $post_info['show_date'] != 'hide' ) {
			$format = '<li><a href="%1$s" rel="bookmark" class="date">%2$s</a></li>';
			printf( $format,
					esc_url( slz_post_get_link_url() ),
					esc_html(get_the_date())
			);
		}
	
	}
endif;
if ( ! function_exists( 'slz_post_get_link_url' ) ) :
	/**
	 * Return the post URL.
	*
	* @uses get_url_in_content() to get the URL in the post meta (if it exists) or
	* the first link found in the post content.
	*
	* Falls back to the post permalink if no URL is found in the post.
	*
	*
	* @return string The Link format URL.
	*/
	function slz_post_get_link_url() {
		$has_url = '';
		if( get_post_format() == 'link') {
			$content = get_the_content();
			$has_url = get_url_in_content( $content );
		}
		return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
	}
endif;
if ( ! function_exists( 'slz_post_ribbon_date' ) ) :
	function slz_post_ribbon_date( $format = null ) {
	
		$out = '';
	
		if( $format == null ) $format = '<div class="block-label">
												<div class="text big">%2$s</div>
												<div class="text"><span>%3$s</span><span>%4$s</span></div>
												<a href="%1$s" class="link-label"></a>
											</div>';
		$post_info = slz_get_db_settings_option('post-info', array());
		if( empty( $post_info['show_date'] ) || $post_info['show_date'] != 'hide' ) {
			$date_type = slz_get_db_settings_option('blog-post-date-type', '');
			if( $date_type == 'ribbon' ) {
				$default = array(
					'day'   => esc_html_x('d','daily posts date format', 'slz'),
					'month' => esc_html_x('M','daily posts date format', 'slz'),
					'year'  => esc_html_x('Y','daily posts date format', 'slz'),
				);
				$date_format = array_merge( $default, slz()->theme->get_config('ribbon_date_format', array()) );
				$day    = get_the_date($date_format['day']);
				$month  = get_the_date($date_format['month']);
				$year   = get_the_date($date_format['year']);
	
				$out = sprintf( $format, esc_url( get_the_permalink()), esc_html( $day ), esc_html( $month ), esc_html( $year ) );
			}
	
		}
	
		return $out;
	}
endif;
if ( ! function_exists( 'slz_get_post_view' ) ) :
	function slz_get_post_view( $post_id ) {

		$count_key = slz()->theme->manifest->get('post_view_name');

		$count = get_post_meta( $post_id, $count_key, true );

		$res = '';

		if($count == '') {

			delete_post_meta( $post_id, $count_key );

			add_post_meta( $post_id, $count_key, '0' );

			$res = 0;

		} else {

			$res = $count;

		}

		return $res;

	}
endif;

if ( ! function_exists( 'slz_categories_meta' ) ) :

	function slz_post_categories_meta( $container = true, $seperator = ', ' ) {
	
		if( slz_get_db_settings_option('blog-post-categories', '') == 'yes' ){
			$categories_list = get_the_category_list( $seperator );
		
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

if ( ! function_exists( 'slz_post_nav' ) ) :
	function slz_post_nav() {
		if( slz_get_db_settings_option('blog-post-post-navigation', '') == 'yes' ){
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
endif;
		
