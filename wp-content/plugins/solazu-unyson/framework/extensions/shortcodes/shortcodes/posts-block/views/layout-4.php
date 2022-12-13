<?php 
$post_count = 1;
$main_layout = '';
$list_layout = '';
$layout_class = $block->attributes['layout'] . ' ' .$block->attributes['style_4'];
?>
<div class="slz-template-04 <?php echo esc_attr($layout_class) ?>">
	<?php
	if( $block->query->posts ) {
		if( $block->attributes['style_4'] == 'style-1' || $block->attributes['style_4'] == 'style-2' ) {
			echo '<div class="slz-recent-post">';
		}else{
			echo '<div class="slz-top-news">';
				echo '<div class="top-news-wrapper">';
		}
		foreach ($block->query->posts as $post) {
			$module = new SLZ_Block_Module($post, $block->attributes);

			switch ( $block->attributes['style_4'] ) {
				case 'style-1':
					echo slz_render_view( $instance->locate_path('/views/block-item-1.php'), compact('module'));
					break;
				case 'style-2':
					echo slz_render_view( $instance->locate_path('/views/block-item-2.php'), compact('module'));
					break;
				case 'style-3':
					echo slz_render_view( $instance->locate_path('/views/block-item-3.php'), compact('module', 'post_count'));
					break;
				default:
					echo slz_render_view( $instance->locate_path('/views/block-item-1.php'), compact('module'));
					break;
			}

			$post_count++;
		} // end foreach
		echo '</div>';
		if( $block->attributes['style_4'] == 'style-3' ) {
			echo '</div>';
		}
	}
	?>	
</div>