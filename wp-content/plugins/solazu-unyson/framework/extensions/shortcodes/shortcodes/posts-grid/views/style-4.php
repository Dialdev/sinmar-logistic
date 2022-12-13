<?php
$post_count = 1;
echo '<div class="slz-block-grid style-4 '. esc_attr( $class_position ) .'">';
	if( !empty( $block->query->posts ) ){
		foreach ($block->query->posts as $post) {
			$module = new SLZ_Block_Module($post, $block->attributes);
			echo slz_render_view( $instance->locate_path( '/views/basic_module.php' ), compact('module', 'post_count'));
			$post_count++;
		}
	}
	echo '<div class="clearfix"></div>';
echo '</div>';