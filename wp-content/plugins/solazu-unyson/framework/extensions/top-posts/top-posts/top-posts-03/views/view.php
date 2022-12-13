<?php
$post_count = 1;
$style = 'top-posts-03';
echo '<div class="slz-block-grid style-3 top-post-03">';
	if( !empty( $posts ) ){
		foreach ($posts as $post) {
			$module = new SLZ_Block_Module($post, $attr);
			if( $post_count == 1 ) {
				echo slz_render_view(slz_get_template_customizations_directory( '/theme/views/top-posts/large_module.php' ), compact( 'module', 'post_count' ));
			}elseif($post_count == 2) {
				echo slz_render_view(slz_get_template_customizations_directory( '/theme/views/top-posts/medium_module.php' ), compact( 'module', 'post_count', 'style' ));
			}else{
				echo slz_render_view(slz_get_template_customizations_directory( '/theme/views/top-posts/small_module.php' ), compact( 'module', 'post_count' ));
			}
			if( $post_count == 4 ) {
				break;
			}
			$post_count++;
		}
	}
	echo '<div class="clearfix"></div>';
echo '</div>';