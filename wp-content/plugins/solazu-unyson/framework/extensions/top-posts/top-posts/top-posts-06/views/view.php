<?php
$post_count = 1;
$style = 'top-posts-06';
echo '<div class="slz-block-grid style-6 top-post-06">';
	if( !empty( $posts ) ){
		foreach ($posts as $post) {
			$module = new SLZ_Block_Module($post, $attr);
			if( $post_count == 1 || $post_count == 2 ) {
				echo slz_render_view(slz_get_template_customizations_directory( '/theme/views/top-posts/large_module.php' ), compact( 'module', 'post_count', 'style' ));
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