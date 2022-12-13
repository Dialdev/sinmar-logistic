<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

$model = new SLZ_Block($instance);
$model->set_attributes($instance);


echo $before_widget;
	echo wp_kses_post($title);
	echo '<div class="widget-content">';
		echo '<div class="slz-carousel-wrapper">';
			echo '<div class="carousel-overflow"><div class="slz-carousel slz-carousel-global">';
				if ( !empty( $model->query->posts ) ) {
					foreach ( $model->query->posts as $post ) {
						$module = new SLZ_Block_Module( $post, $model->attributes );
						echo slz_render_view( $view_path . '/large_module.php', compact('module'));
					}
				}
			echo '</div></div>';
		echo '</div>';
	echo '</div>';
echo $after_widget;