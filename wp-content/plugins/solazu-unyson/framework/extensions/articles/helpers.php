<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'slz_theme_sticky_ribbon' ) ) :
	/**
	 * Display sticky ribbon.
	*/
	function slz_theme_sticky_ribbon(){
		if ( is_sticky() && is_home() && ! is_paged() ) {
			echo '<div class="slz-sticky"><div class="inner"></div></div>';
		}
	}
endif;

if ( ! function_exists( 'slz_theme_post_thumbnail' ) ) :
/**
 * Display an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 *
 */
function slz_theme_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}
	?>

	<div class="block-image">

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">

			<?php
				the_post_thumbnail( 'post-thumbnail', array( 'alt' => get_the_title(), 'class' => 'img-responsive img-full' ) );
			?>

		</a>

	</div>

	<?php
}
endif;


if ( ! function_exists( 'slz_theme_entry_meta' ) ) :

function slz_theme_entry_meta() {

	$format = get_post_format();
	if ( current_theme_supports( 'post-formats', $format ) ) {
		printf( '<li>%1$s<a href="%2$s">%3$s</a></li>',
			_x( 'Format', 'Used before post format.', 'slz' ),
			esc_url( get_post_format_link( $format ) ),
			get_post_format_string( $format )
		);
	}

	$categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'slz' ) );

	if ( $categories_list ) {
		printf( '<li>%1$s: %2$s</li>',
			_x( 'Categories', 'Used before category names.', 'slz' ),
			$categories_list
		);
	}

	if ( is_singular() || is_multi_author() ) {
		printf( '<li>%1$s <a href="%2$s">%3$s</a></li>',
			_x( 'Author', 'Used before post author name.', 'slz' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			get_the_author()
		);
	}

	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		get_the_date(),
		esc_attr( get_the_modified_date( 'c' ) ),
		get_the_modified_date()
	);

	printf( '<li>%1$s </span><a href="%2$s" rel="bookmark">%3$s</a></li>',
		_x( 'Posted on', 'Used before publish date.', 'slz' ),
		esc_url( get_permalink() ),
		$time_string
	);

	printf( _nx( '<li>One Comment</li>', '<li>%1$s Comments</li>', get_comments_number(), 'comments title', 'slz' ), number_format_i18n( get_comments_number() ) );

	$tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'slz' ) );
	if ( $tags_list ) {
		printf( '<li>%1$s: %2$s</li>',
			_x( 'Tags', 'Used before tag names.', 'slz' ),
			$tags_list
		);
	}

}
endif;
