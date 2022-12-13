<?php 
$post_count = 1;
$main_layout = '';
$list_layout = '';
$class_no_img = '';
if( $block->attributes['list_show_image_2'] == 'no' ) {
	$class_no_img = 'style-no-image';
}
$layout_class = $block->attributes['layout'] . ' ' .$block->attributes['main_layout'] . ' ' . $block->attributes['list_layout_2'];
?>
<div class="slz-template-02 <?php echo esc_attr( $class_no_img ) . ' ' . esc_attr($layout_class); ?>">
	<?php
	if( $block->query->posts ) {
		foreach ($block->query->posts as $post) {
			$module = new SLZ_Block_Module($post, $block->attributes);
			if( $post_count == 1 ) {
				$main_layout .= slz_render_view( $instance->locate_path('/views/main-layout-1.php'), compact('module'));
			}else{
				switch ( $block->attributes['list_layout_2'] ) {
					case 'list-layout-1':
						$list_layout .= '<div class="element">';
						$list_layout .= slz_render_view( $instance->locate_path('/views/list-layout-1.php'), compact('module'));
						$list_layout .= '</div>';
						break;
					case 'list-layout-2':
						$list_layout .= '<div class="element">';
						$list_layout .= slz_render_view( $instance->locate_path('/views/list-layout-2.php'), compact('module'));
						$list_layout .= '</div>';
						break;
					default:
						$list_layout .= '<div class="element">';
						$list_layout .= slz_render_view( $instance->locate_path('/views/list-layout-1.php'), compact('module'));
						$list_layout .= '</div>';
						break;
				}
			}
			$post_count++;
		}
		echo '<div class="main-layout">';
			echo ( $main_layout );
		echo '</div>';
		if( $block->attributes['list_layout_2'] == 'list-layout-1' ) {
			echo '<div class="list-layout column-2">';
		}else{
			echo '<div class="list-layout column-1">';
		}
				echo ( $list_layout );
		echo '</div>';
	}
	?>	
</div>