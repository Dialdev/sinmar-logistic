<?php

$unique_id = SLZ_Com::make_id();

echo '<div class="slz-carousel-syncing">';
echo '<div class="slz-carousel-wrapper">';

if (!empty($block)) {
	
	echo '<div data-slidesToshow="'.esc_attr($block->attributes['column']).'" class="slider-nav">';

	foreach ($block->query->posts as $post) {

		$module = new SLZ_Block_Module($post, $block->attributes);

		?>

		<div class="item">
			<div class="thumbnail-image">
				<?php echo ( $module->get_featured_image('large', array( 'thumb_class' => 'img-responsive' )) ); ?>
			</div>
		</div>

		<?php

	}

	echo '</div>';

	$show_dots = 1;
	if ( !empty($block->attributes['show_dots']) && $block->attributes['show_dots'] != 'yes' ) {
		$show_dots = 0;
	}
	echo '<div data-dots="'.esc_attr($show_dots).'" class="slider-for">';

	foreach ($block->query->posts as $post) {

		$module = new SLZ_Block_Module($post, $block->attributes);

		?>

		<div class="item">
			<div class="image-gallery-wrapper">
				<a href="<?php echo ( $module->permalink ); ?>" class="images">
					<?php echo ( $module->get_featured_image('large', array( 'thumb_class' => 'img-responsive' )) ); ?>
				</a>
				<div class="content">
					<div class="description"><?php echo esc_html( $module->get_excerpt() ); ?></div>
				</div>
			</div>
		</div>

		<?php

	}

	echo '</div>';

}

echo '</div>';
echo '</div>';

?>