<!-- title -->
<p>
	<label for="<?php echo esc_attr($wp_widget->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title', 'slz' ) ?>
	<input type="text" name="<?php echo esc_attr($wp_widget->get_field_name ( 'title' )); ?>" id="<?php echo esc_attr($wp_widget->get_field_id ( 'title' )); ?>" value="<?php echo esc_attr( $data['title'] ); ?>" class="widefat"/></label>
</p>
<!-- limit post -->
<p>
	<label for="<?php echo esc_attr($wp_widget->get_field_id( 'limit_post' )); ?>"><?php esc_html_e( 'Number Item', 'slz' ) ?>
	<input type="text" name="<?php echo esc_attr($wp_widget->get_field_name ( 'limit_post' )); ?>" id="<?php echo esc_attr($wp_widget->get_field_id ( 'limit_post' )); ?>" value="<?php echo esc_attr( $data['limit_post'] ); ?>" class="widefat"/></label>
</p>
<!-- Slides to show -->
<p>
	<label for="<?php echo esc_attr($wp_widget->get_field_id( 'slides_to_show' )); ?>"><?php esc_html_e( 'Slides To Show', 'slz' ) ?>
	<input type="text" name="<?php echo esc_attr($wp_widget->get_field_name ( 'slides_to_show' )); ?>" id="<?php echo esc_attr($wp_widget->get_field_id ( 'slides_to_show' )); ?>" value="<?php echo esc_attr( $data['slides_to_show'] ); ?>" class="widefat"/></label>
</p>
<!-- categories -->
<p>
	<label for="<?php echo esc_attr($wp_widget->get_field_id( 'cat_id' )); ?>"><?php esc_html_e( 'Category ID', 'slz' ) ?>
	<input type="text" name="<?php echo esc_attr($wp_widget->get_field_name ( 'cat_id' )); ?>" id="<?php echo esc_attr($wp_widget->get_field_id ( 'cat_id' )); ?>" value="<?php echo esc_attr( $data['cat_id'] ); ?>" class="widefat"/></label>
	<span><?php esc_html_e( 'Enter categories ID of gallery (Ex 1,2,3)', 'slz'); ?></span>
</p>