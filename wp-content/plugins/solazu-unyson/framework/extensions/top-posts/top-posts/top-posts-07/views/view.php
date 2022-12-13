<?php
$post_count = 1;
$style = 'top-posts-07';
echo '<div class="slz-block-grid style-7 top-post-07">';
	if( !empty( $posts ) ){
		foreach ($posts as $post) {
			$module = new SLZ_Block_Module($post, $attr);
			if( $post_count == 1 || $post_count == 2 || $post_count == 3 ) {
				echo slz_render_view(slz_get_template_customizations_directory( '/theme/views/top-posts/medium_module.php' ), compact( 'module', 'post_count', 'style' ));
			}else{
				echo slz_render_view(slz_get_template_customizations_directory( '/theme/views/top-posts/small_module.php' ), compact( 'module', 'post_count', 'style' ));
			}
			if( $post_count == 7 ) {
				break;
			}
			$post_count++;
		}
	}
	echo '<div class="clearfix"></div>';
echo '</div>';