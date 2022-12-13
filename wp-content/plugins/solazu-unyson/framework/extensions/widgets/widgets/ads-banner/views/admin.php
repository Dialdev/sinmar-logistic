<?php

$widget_color_picker_id = SLZ_Com::make_id();

$adspot_list = SLZ_Com::get_advertisement_list();
extract( $instance );
?>
<p>
	<label for="<?php echo  esc_attr( $object->get_field_id('title') ); ?>"><?php esc_html_e('Title', 'slz');?></label>
	<input class="widefat" type="text" id="<?php echo esc_attr( $object->get_field_id('title') ); ?>" name="<?php echo esc_attr( $object->get_field_name('title') ); ?>" value="<?php echo esc_attr( $title ); ?>" />
</p>
<div>
	<label for="<?php echo esc_attr( $object->get_field_id('block_title_color') ); ?>"><?php esc_html_e( 'Title Color:', 'slz' ); ?></label>
	<input data-slz-w-color="<?php echo esc_attr( $widget_color_picker_id ); ?>" class="widefat slz-color-picker-field" id="<?php echo esc_attr( $object->get_field_id('block_title_color') ); ?>"
		   name="<?php echo esc_attr( $object->get_field_name('block_title_color') ); ?>" type="text"
		   value="<?php echo esc_attr( $block_title_color ); ?>" />
	<br><div id="<?php echo esc_attr( $widget_color_picker_id ); ?>" class="slz-color-picker-widget" rel="<?php echo esc_attr( $object->get_field_id('block_title_color') ); ?>"></div>
	<br><div class="slz-widget-description"><?php echo esc_html__('Optional - Choose a custom title text color for this block', 'slz'); ?></div>
</div>
<p>
	<label for="<?php echo  esc_attr( $object->get_field_id('adspot') ); ?>"><?php esc_html_e('Choose Adspot', 'slz');?></label>
	<select class="widefat" id="<?php echo esc_attr( $object->get_field_id( 'adspot' ) ); ?>" name="<?php echo esc_attr( $object->get_field_name('adspot') ); ?>" >
		<?php foreach( $adspot_list  as $k => $v ){?>
			<option value="<?php echo esc_attr($v); ?>"<?php if( $adspot == $v ) echo " selected"; ?>><?php echo esc_html($k); ?></option>
		<?php } ?>
	</select>
</p>
<div>
	<label for="<?php echo esc_attr( $object->get_field_name( 'extra_class' ) ); ?>"><?php esc_html_e( 'Extra Class:', 'slz' ); ?></label>
	<input name="<?php echo esc_attr ( $object->get_field_name( 'extra_class' ) ); ?>" id="<?php echo esc_attr ( $object->get_field_id( 'extra_class' ) ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_attr( $extra_class ); ?>" />
	<br><br><div class="slz-widget-description"><?php echo esc_html__('Optional - a extra class for this block, if you leave it blank the block will not have a extra class', 'slz'); ?></div>
</div>
<script>
	slz_color_picker();
</script>