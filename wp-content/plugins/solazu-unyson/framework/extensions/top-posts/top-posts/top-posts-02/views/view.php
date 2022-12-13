<?php
$post_count = 1;
echo '<div class="slz-block-grid style-2 top-post-02">';
	if( !empty( $posts ) ){
		foreach ($posts as $post) {
			$module = new SLZ_Block_Module($post, $attr);
			if( $post_count == 1 ) {
				echo slz_render_view(slz_get_template_customizations_directory( '/theme/views/top-posts/large_module.php' ), compact( 'module', 'post_count' ));
			}else{
				echo slz_render_view(slz_get_template_customizations_directory( '/theme/views/top-posts/small_module.php' ), compact( 'module', 'post_count' ));
			}
			if( $post_count == 3 ) {
				break;
			}
			$post_count++;
		}
	}
	echo '<div class="clearfix"></div>';
echo '</div>';