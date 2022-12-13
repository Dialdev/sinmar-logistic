<?php
$post_count = 1;
echo '<div class="slz-block-grid style-7 '. esc_attr( $class_position ) .'">';
	if( !empty( $block->query->posts ) ){
		foreach ($block->query->posts as $post) {
			$module = new SLZ_Block_Module($post, $block->attributes);
			if( $post_count == 1 || $post_count == 2 || $post_count == 3 ) {
				echo slz_render_view( $instance->locate_path( '/views/medium_module.php' ), compact('module', 'post_count','block' ));
			}else{
				echo slz_render_view( $instance->locate_path( '/views/small_module.php' ), compact('module', 'post_count', 'block'));
			}
			$post_count++;
		}
	}
	echo '<div class="clearfix"></div>';
echo '</div>';