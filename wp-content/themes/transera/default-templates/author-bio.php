<?php
$author_id = get_the_author_meta( 'ID' );
if(empty($author_id)) {
	$author_id = get_query_var('author');
}
if( empty($author_id) ) return;

$author_url = get_author_posts_url( $author_id );
$author_desc = get_the_author_meta( 'description', $author_id );
?>
<div class="slz-blog-author media">
	<div class="media-left">
		<a href="<?php echo esc_url( $author_url )?>" class="media-image thumb"><?php echo get_avatar($author_id, 100); ?></a>
	</div>
	<div class="media-right">
		<a href="<?php echo esc_url( $author_url )?>" title="" class="author"><?php echo get_the_author_meta('display_name', $author_id); ?></a>
		<div class="des"><?php echo nl2br( esc_textarea( $author_desc ) ) ?></div>
	</div>
</div>
