<?php

$item_class = 'style-' . $block->attributes['style'];

echo '<div class="slz-carousel-wrapper">';

echo '<div class="carousel-overflow"><div data-slidestoshow="' . esc_attr( $block->attributes['column'] ) . '" class="slz-carousel slz-carousel-global">';

if (!empty($block)) {

	foreach ($block->query->posts as $post) {

		$module = new SLZ_Block_Module($post, $block->attributes);

		echo slz_render_view( $instance->locate_path( '/views/large_module.php' ), compact('module', 'item_class'));

	}

}

echo '</div></div>';

echo '</div>';

?>