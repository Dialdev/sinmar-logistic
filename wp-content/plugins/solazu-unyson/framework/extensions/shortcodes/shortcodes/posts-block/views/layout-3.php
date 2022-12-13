<?php 
$post_count = 1;
$main_layout = '';
$list_layout = '';
$column = '';
$right_left = '';
if( $block->attributes['list_layout_3'] == 'list-layout-2' ) {
	if( $block->attributes['list_show_left_right_3'] == 'yes' ){
		$right_left = 'block-right-left';
	}
}
$layout_class = $block->attributes['layout'] . ' ' . $block->attributes['list_layout_3'];
?>
<div class="slz-template-03 <?php echo esc_attr( $right_left ) . ' ' . esc_attr($layout_class); ?>">
	<?php
	if( $block->query->posts ) {
		foreach ($block->query->posts as $post) {
			$module = new SLZ_Block_Module($post, $block->attributes);
			switch ( $block->attributes['list_layout_3'] ) {
				case 'list-layout-1':
					$list_layout .= '<div class="item">';
					$list_layout .= slz_render_view( $instance->locate_path('/views/list-layout-1.php'), compact('module'));
					$list_layout .= '</div>';
					break;
				case 'list-layout-2':
					$list_layout .= '<div class="item">';
					$list_layout .= slz_render_view( $instance->locate_path('/views/list-layout-2.php'), compact('module'));
					$list_layout .= '</div>';
					break;
				case 'list-layout-3':
					$list_layout .= '<div class="item">';
					$list_layout .= slz_render_view( $instance->locate_path('/views/list-layout-3.php'), compact('module'));
					$list_layout .= '</div>';
					break;
				default:
					$list_layout .= '<div class="item">';
					$list_layout .= slz_render_view( $instance->locate_path('/views/list-layout-1.php'), compact('module'));
					$list_layout .= '</div>';
					break;
			}
		}
		if( $block->attributes['list_layout_3'] == 'list-layout-2' ) {
			$column = '1';
		}else{
			$column = $module->attributes['list_column_3'];
		}
		echo '<div class="slz-list-block slz-column-'. esc_attr( $column ) .'">';
			echo ( $list_layout );
		echo '</div>';
	}
	?>	
</div>