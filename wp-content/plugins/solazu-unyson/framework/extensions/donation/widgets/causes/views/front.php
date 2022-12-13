<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }
$column_class = (empty($column))?'':$column;


$atts = array(
		'limit_post'  			=> $limit_post,
		'offset_post' 			=> $offset_post,
		'method'  	  			=> $method,
		'image_size'  			=> $image_size,
		'category_slug' 		=> '',
		'show_social_share_2' 	=> '',
		'show_progress_bar'  	=> 'yes'
);
if ($method == 'cat') {
	if( !empty( $category_slug ) ) {
		$arr = explode(',', $category_slug);
		$atts['category_slug'] = array();
		for ($i=0; $i < count($arr); $i++) { 
			$atts['category_slug'][] = $arr[$i]; 
		}
	}
}

$model = new SLZ_Causes();
$model->init($atts);

$id = $model->uniq_id;
$html_render = array();
$html_format = '<div class="item">
		<div class="slz-block-item-06 style-1">
			%1$s
			<div class="block-content">
				<div class="block-content-wrapper">
					%2$s
					%9$s
					%6$s
			</div>
		</div>
		</div>
		</div>
';

$html_render['html_format'] = $html_format;
$html_render['thumb_class'] = 'img-full';
$html_render['btn_more_format'] = '<a href="%2$s" class="slz-btn btn-block-donate">%1$s</a>';

$model->html_format = $html_render;
$thumb_size = 'large';
$html_options = $model->html_format;

echo $before_widget;?>
	<div class="wg-causes wg-causes-<?php echo esc_attr($id);?>" data-block-class="wg-causes-<?php echo esc_attr($id);?>">
	<?php if ( !empty($instance['title']) ):
			echo wp_kses_post($title); 
		endif;
	?>
	<div class="widget-content">
		<?php 
			echo '<div class="slz-list-block slz-column-1">';
				$model->render_causes_block($html_options);
			echo '</div>';
		?>
	</div>
	</div>
<?php echo $after_widget;?>