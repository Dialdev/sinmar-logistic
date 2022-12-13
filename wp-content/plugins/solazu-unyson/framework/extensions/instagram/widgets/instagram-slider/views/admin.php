<?php

$widget_color_picker_id = SLZ_Com::make_id();

extract( $instance );

?>

<p>
	<label for="<?php echo  esc_attr( $object->get_field_id('block_title') ); ?>"><?php esc_html_e( 'Block Title', 'slz' );?></label>
	<input class="widefat" type="text" id="<?php echo esc_attr( $object->get_field_id('block_title') ); ?>" name="<?php echo esc_attr( $object->get_field_name('block_title') ); ?>" value="<?php echo esc_attr( $block_title ); ?>" />
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
	<label for="<?php echo  esc_attr( $object->get_field_id('instagram_id') ); ?>"><?php esc_html_e( 'Instagram ID', 'slz' );?></label>
	<input class="widefat" type="text" id="<?php echo esc_attr( $object->get_field_id('instagram_id') ); ?>" name="<?php echo esc_attr( $object->get_field_name('instagram_id') ); ?>" value="<?php echo esc_attr( $instagram_id ); ?>" />
</p>
<p>
	<label for="<?php echo  esc_attr( $object->get_field_id('limit_image') ); ?>"><?php esc_html_e( 'Number images', 'slz' );?></label>
	<input class="widefat" type="text" id="<?php echo esc_attr( $object->get_field_id('limit_image') ); ?>" name="<?php echo esc_attr( $object->get_field_name('limit_image') ); ?>" value="<?php echo esc_attr( $limit_image ); ?>" />
</p>
<p>
	<label for="<?php echo  esc_attr( $object->get_field_id('number_items') ); ?>"><?php esc_html_e( 'Number Items', 'slz' );?></label>
	<input class="widefat" type="text" id="<?php echo esc_attr( $object->get_field_id( 'number_items' ) ); ?>" name="<?php echo esc_attr( $object->get_field_name('number_items') ); ?>" value="<?php echo esc_attr( $number_items ); ?>" />
</p>

<script>
	slz_color_picker();
</script>