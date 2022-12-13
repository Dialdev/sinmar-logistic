<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }
$class_style = $class_icon = '';
//get taxonomy
if( empty($taxonomy) ) {
	$taxonomy = 'category';
}
$query_args = array();
if( !empty($limit)) {
	$query_args['number'] = $limit;
}
$categories = get_terms($taxonomy, $query_args);

//get style
if(empty($style)){
	$class_style = 'slz-widget-categories';
	$class_icon = 'fa-angle-right';
}else{
	$class_style = 'slz-widget-categories2';
	$class_icon = 'fa-cube';
}
echo $before_widget;?>
	<div class="<?php echo esc_attr($class_style);?>">
		<?php echo wp_kses_post($title); ?>
		<?php if( $categories && ! is_wp_error($categories)){?>
			<div class="widget-content"><?php
				foreach($categories as $key => $value){
					$category_id = $value->term_id;
					$category_link = get_term_link( $category_id );
					$str_count = '';
					if(empty($style)){
						if( $show_count ) {
							$str_count = '<span class="badge">'.esc_html($value->count).'</span>';
						}
					}
					else{
						if( $show_count ) {
							$str_count = '<div class="label-right">'.esc_html($value->count).'</div>';
						}
					}
					echo '<a href="'.esc_url( $category_link ).'" class="link"> <i class="icons fa '.esc_attr($class_icon).'"></i><span class="text">'.esc_attr( $value->name ).'</span>'.wp_kses_post($str_count).'</a>';
				}?>
			</div>
		<?php } ?>
	</div>
<?php echo $after_widget;?>