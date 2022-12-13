<?php
$post_count = 1;
$style = 'top-posts-04';
echo '<div class="slz-block-grid style-4 top-post-04">';
	if( !empty( $posts ) ){
		foreach ($posts as $post) {
			$module = new SLZ_Block_Module($post, $attr);
			echo slz_render_view(slz_get_template_customizations_directory( '/theme/views/top-posts/basic_module.php' ), compact( 'module', 'post_count', 'style' ));
			if( $post_count == 2 ) {
				break;
			}
			$post_count++;
		}
	}
	echo '<div class="clearfix"></div>';
echo '</div>';