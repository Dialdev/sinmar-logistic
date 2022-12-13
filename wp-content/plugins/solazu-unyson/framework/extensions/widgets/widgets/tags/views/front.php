<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

echo wp_kses_post($before_widget);

$image_url = '';

if(!empty($instance['image'])){
	$image_arr = json_decode($instance['image']);
	$image_id = $image_arr->ID;
}

if( !empty( $image_id ) ){
	$image_url = wp_get_attachment_url( $image_id );
}
		
extract( $instance );

?>
<div class="widget <?php echo esc_attr( $extra_class ); ?> slz-tag slz-widget-tags-<?php echo esc_attr( $unique_id ); ?>">
	<?php echo wp_kses_post( $title ); ?>
	<div class="widget-content">
		<?php
			if( !empty( $number ) && is_numeric( $number ) && $number != 0 ) {
				$tags = get_tags(array('number'=>$number,'orderby' =>'term_id', 'order' => 'DESC'));
				echo '<ul class="list-unstyled list-inline">';
					if( !empty( $tags ) ) {
						foreach ( $tags as $tag ) {
							$tag_link = get_tag_link( $tag->term_id );
							echo '<li><a href="'. esc_url( $tag_link ) .'" class="tag">'. esc_html( $tag->name ) .'</a></li>';
						}
					}
				echo '</ul>';
			}
		?>

	</div>
</div>

<?php 
echo wp_kses_post( $after_widget );

?>