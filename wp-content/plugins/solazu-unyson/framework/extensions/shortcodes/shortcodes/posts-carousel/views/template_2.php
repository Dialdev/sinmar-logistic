<?php

$item_class = 'style-2';

echo '<div class="slz-carousel-wrapper">';

echo '<div data-slidestoshow="1" class="slz-carousel-vertical">';

if (!empty($block)) {

	foreach ($block->query->posts as $post) {

		$module = new SLZ_Block_Module($post, $block->attributes);

		echo slz_render_view( $instance->locate_path( '/views/large_module.php' ), compact('module', 'item_class'));

	}

}

echo '</div>';

echo '</div>';

?>