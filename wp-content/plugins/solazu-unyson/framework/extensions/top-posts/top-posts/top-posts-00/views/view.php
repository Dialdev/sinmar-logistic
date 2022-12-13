<?php
$post_count = 1;
echo '<div class="slz-block-grid style-1 top-post-00">';
	if( !empty( $posts ) ){
		foreach ($posts as $post) {
			$module = new SLZ_Block_Module( $post, $attr );
				echo slz_render_view(slz_get_template_customizations_directory( '/theme/views/top-posts/module_default.php' ), compact( 'module', 'post_count' ));
			if( $post_count == 1 ) {
				break;
			}
			$post_count++;
		}
	}
echo '</div>';