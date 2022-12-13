<?php 
$post_count = 1;
$main_layout = '';
$list_layout = '';
$layout_class = $block->attributes['layout'] . ' ' .$block->attributes['main_layout'] . ' ' . $block->attributes['list_layout'];
?>
<div class="slz-template-01 <?php echo esc_attr($layout_class);?>">
	<?php
	if( $block->query->posts ) {
		foreach ($block->query->posts as $post) {
			$module = new SLZ_Block_Module($post, $block->attributes);
			if( $post_count == 1 ) {
				switch ( $block->attributes['main_layout'] ) {
					case 'main-layout-1':
						$main_layout .= slz_render_view( $instance->locate_path('/views/main-layout-1.php'), compact('module'));
						break;
					case 'main-layout-2':
						$main_layout .= slz_render_view( $instance->locate_path('/views/main-layout-2.php'), compact('module'));
						break;
					case 'main-layout-3':
						$main_layout .= slz_render_view( $instance->locate_path('/views/main-layout-3.php'), compact('module'));
						break;
					default:
						$main_layout .= slz_render_view( $instance->locate_path('/views/main-layout-1.php'), compact('module'));
						break;
				}
			}else{
				switch ( $block->attributes['list_layout'] ) {
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
					case 'list-layout-3':
						$list_layout .= '<div class="element">';
						$list_layout .= slz_render_view( $instance->locate_path('/views/list-layout-3.php'), compact('module'));
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
		echo '<div class="list-layout column-'. esc_attr( $module->attributes['list_column'] ) .'">';
				echo ( $list_layout );
		echo '</div>';
	}
	?>	
</div>