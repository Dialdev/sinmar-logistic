<?php
	$widget_color_picker_id = SLZ_Com::make_id();
	extract( $instance );
?>
<div>
	<label for="<?php echo esc_attr( $object->get_field_name( 'block_title' ) ); ?>"><?php esc_html_e( 'Title:', 'slz' ); ?></label>
	<input name="<?php echo esc_attr ( $object->get_field_name( 'block_title' ) ); ?>" id="<?php echo esc_attr ( $object->get_field_id( 'block_title' ) ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_attr( $block_title ); ?>" />
	<br><br><div class="slz-widget-description"><?php echo esc_html__('Optional - a title for this block, if you leave it blank the block will not have a title', 'slz'); ?></div>
</div>

<div>
	<label for="<?php echo esc_attr( $object->get_field_id('block_title_color') ); ?>"><?php esc_html_e( 'Title Color:', 'slz' ); ?></label>
	<input data-slz-w-color="<?php echo esc_attr( $widget_color_picker_id ); ?>" class="widefat slz-color-picker-field" id="<?php echo esc_attr( $object->get_field_id('block_title_color') ); ?>"
		   name="<?php echo esc_attr( $object->get_field_name('block_title_color') ); ?>" type="text"
		   value="<?php echo esc_attr( $block_title_color ); ?>" />
	<br><div id="<?php echo esc_attr( $widget_color_picker_id ); ?>" class="slz-color-picker-widget" rel="<?php echo esc_attr( $object->get_field_id('block_title_color') ); ?>"></div>
	<br><div class="slz-widget-description"><?php echo esc_html__('Optional - Choose a custom title text color for this block', 'slz'); ?></div>
</div>
<p>
	<label for="<?php echo esc_attr( $object->get_field_name( 'style' ) ); ?>"><?php esc_html_e( 'Style:', 'slz' ); ?></label>
	<select class="widefat" id="<?php echo esc_attr( $object->get_field_id( 'style' ) ); ?>" name="<?php echo esc_attr( $object->get_field_name('style') ); ?>" >
		<option value="1"<?php if( $style == 1 ) { echo " selected"; } ?>><?php esc_html_e('Show icon only', 'slz');?></option>
		<option value="2"<?php if( $style == 2 ) { echo " selected"; } ?>><?php esc_html_e('Show text and icon', 'slz');?></option>
	</select>
</p>
<p>
	<label for="<?php echo esc_attr( $object->get_field_name( 'facebook' ) ); ?>"><?php esc_html_e( 'Facebook User:', 'slz' ); ?></label>
	<input name="<?php echo esc_attr ( $object->get_field_name( 'facebook' ) ); ?>" id="<?php echo esc_attr ( $object->get_field_id( 'facebook' ) ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_attr( $facebook ); ?>" />
</p>
<p>
	<label for="<?php echo esc_attr( $object->get_field_name( 'twitter' ) ); ?>"><?php esc_html_e( 'Twitter User:', 'slz' ); ?></label>
	<input name="<?php echo esc_attr ( $object->get_field_name( 'twitter' ) ); ?>" id="<?php echo esc_attr ( $object->get_field_id( 'twitter' ) ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_attr( $twitter ); ?>" />
</p>

<p>
	<label for="<?php echo esc_attr( $object->get_field_name( 'google' ) ); ?>"><?php esc_html_e( 'Google Plus ID:', 'slz' ); ?></label>
	<input name="<?php echo esc_attr ( $object->get_field_name( 'google' ) ); ?>" id="<?php echo esc_attr ( $object->get_field_id( 'google' ) ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_attr( $google ); ?>" />
</p>

<p>
	<label for="<?php echo esc_attr( $object->get_field_name( 'instagram' ) ); ?>"><?php esc_html_e( 'Instagram User:', 'slz' ); ?></label>
	<input name="<?php echo esc_attr ( $object->get_field_name( 'instagram' ) ); ?>" id="<?php echo esc_attr ( $object->get_field_id( 'instagram' ) ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_attr( $instagram ); ?>" />
</p>

<p>
	<label for="<?php echo esc_attr( $object->get_field_name( 'vimeo' ) ); ?>"><?php esc_html_e( 'Vimeo ID:', 'slz' ); ?></label>
	<input name="<?php echo esc_attr ( $object->get_field_name( 'vimeo' ) ); ?>" id="<?php echo esc_attr ( $object->get_field_id( 'vimeo' ) ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_attr( $vimeo ); ?>" />
</p>

<p>
	<label for="<?php echo esc_attr( $object->get_field_name( 'soundcloud' ) ); ?>"><?php esc_html_e( 'Soundcloud User:', 'slz' ); ?></label>
	<input name="<?php echo esc_attr ( $object->get_field_name( 'soundcloud' ) ); ?>" id="<?php echo esc_attr ( $object->get_field_id( 'soundcloud' ) ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_attr( $soundcloud ); ?>" />
</p>

<div>
	<label for="<?php echo esc_attr( $object->get_field_name( 'extra_class' ) ); ?>"><?php esc_html_e( 'Extra Class:', 'slz' ); ?></label>
	<input name="<?php echo esc_attr ( $object->get_field_name( 'extra_class' ) ); ?>" id="<?php echo esc_attr ( $object->get_field_id( 'extra_class' ) ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_attr( $extra_class ); ?>" />
	<br><div class="slz-widget-description"><?php echo esc_html__('Optional - a extra class for this block, if you leave it blank the block will not have a extra class', 'slz'); ?></div>
</div>

<script>
	slz_color_picker();
</script>