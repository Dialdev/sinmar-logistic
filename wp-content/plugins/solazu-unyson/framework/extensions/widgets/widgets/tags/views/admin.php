<?php
$widget_color_picker_id = SLZ_Com::make_id();
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
	<label for="<?php echo  esc_attr( $object->get_field_id('number') ); ?>"><?php esc_html_e('Number', 'slz');?></label>
	<input class="widefat" type="text" id="<?php echo esc_attr( $object->get_field_id('number') ); ?>" name="<?php echo esc_attr( $object->get_field_name('number') ); ?>" value="<?php echo esc_attr( $number ); ?>" />
</p>

<p>
	<label for="<?php echo  esc_attr( $object->get_field_id('extra_class') ); ?>"><?php esc_html_e('Extra Class', 'slz');?></label>
	<input class="widefat" type="text" id="<?php echo esc_attr( $object->get_field_id('extra_class') ); ?>" name="<?php echo esc_attr( $object->get_field_name('extra_class') ); ?>" value="<?php echo esc_attr( $extra_class ); ?>" />
</p>

<script>
	slz_color_picker();
</script>