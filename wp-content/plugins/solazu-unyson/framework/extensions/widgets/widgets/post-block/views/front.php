<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

$model = new SLZ_Block($instance);
$model->set_attributes($instance);

$class_layout = 'widget-post-block-'.$instance['layout'];

echo $before_widget;
	echo wp_kses_post($title);
	echo '<div class="widget-content '. esc_attr( $class_layout ) .'">';
		if( $instance['layout'] == 'layout-2' ) {
			echo slz_render_view( $view_path . '/layout-2.php', compact('model', 'view_path'));
		}else{
			echo slz_render_view( $view_path . '/layout-1.php', compact('model', 'view_path'));
		}
		
	echo '</div>';
echo $after_widget;