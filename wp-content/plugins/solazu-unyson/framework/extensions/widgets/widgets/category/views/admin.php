<?php

$category_slug = array();
if ( !empty( $instance['category_slug'] ) )
	$category_slug = $instance['category_slug'];

$block_title_color = '#';
if ( !empty( $instance['block_title_color'] ) )
	$block_title_color = esc_attr( $instance['block_title_color'] );


$title 		= esc_attr( $instance['title'] );
$style      = esc_attr( $instance['style'] );
$category_list 			= SLZ_Com::get_category2slug_array();
$widget_color_picker_id = SLZ_Com::make_id();

?>
<p>
	<label for="<?php echo  esc_attr( $object->get_field_id('title') ); ?>"><?php esc_html_e('Title', 'slz');?></label>
	<input class="widefat" type="text" id="<?php echo esc_attr( $object->get_field_id('title') ); ?>" name="<?php echo esc_attr( $object->get_field_name('title') ); ?>" value="<?php echo esc_attr( $title ); ?>" />
</p>
<p>
	<label for="<?php echo  esc_attr( $object->get_field_id('style') ); ?>"><?php esc_html_e('Choose Style', 'slz');?></label>
	<select class="widefat" id="<?php echo esc_attr( $object->get_field_id( 'style' ) ); ?>" name="<?php echo esc_attr( $object->get_field_name('style') ); ?>" >
		<option value="1"<?php if( $style == 1 ) { echo " selected"; } ?>><?php esc_html_e('Style 1', 'slz');?></option>
		<option value="2"<?php if( $style == 2 ) { echo " selected"; } ?>><?php esc_html_e('Style 2', 'slz');?></option>
		<option value="3"<?php if( $style == 3 ) { echo " selected"; } ?>><?php esc_html_e('Style 3', 'slz');?></option>
	</select>
</p>
<div>
	<label for="<?php echo esc_attr( $object->get_field_id('block_title_color') ); ?>"><?php esc_html_e( 'Title Color:', 'slz' ); ?></label>
	<input data-slz-w-color="<?php echo esc_attr( $widget_color_picker_id ); ?>" class="widefat slz-color-picker-field" id="<?php echo esc_attr( $object->get_field_id('block_title_color') ); ?>"
		   name="<?php echo esc_attr( $object->get_field_name('block_title_color') ); ?>" type="text"
		   value="<?php echo esc_attr( $block_title_color ); ?>" />
	<br><div id="<?php echo esc_attr( $widget_color_picker_id ); ?>" class="slz-color-picker-widget" rel="<?php echo esc_attr( $object->get_field_id('block_title_color') ); ?>"></div>
	<br><div class="slz-widget-description"><?php echo esc_html__('Optional - Choose a custom title text color for this block', 'slz'); ?></div>
</div>
<div>
	<label for="<?php echo  esc_attr( $object->get_field_id('category_slug') ); ?>"><?php esc_html_e( 'Category:', 'slz' );?></label>
	<select class="widefat multi-long-choice" id="<?php echo esc_attr( $object->get_field_id('category_slug') ); ?>" name="<?php echo esc_attr( $object->get_field_name('category_slug') ); ?>[]" multiple="true" >
	<?php foreach( $category_list  as $k => $v ){?>
		<option value="<?php echo esc_attr($v); ?>"<?php if( in_array ( $v, $category_slug ) ) echo " selected"; ?>><?php echo esc_html($k); ?></option>
	<?php } ?>
	</select>
	<br><br><div class="slz-widget-description"><?php echo esc_html__('Choose category to show', 'slz'); ?></div>
</div>
<script>
	slz_color_picker();
</script>