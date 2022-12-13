<!-- title -->
<p>
	<label for="<?php echo esc_attr($wp_widget->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title', 'slz' ) ?>
	<input type="text" name="<?php echo esc_attr($wp_widget->get_field_name ( 'title' )); ?>" id="<?php echo esc_attr($wp_widget->get_field_id ( 'title' )); ?>" value="<?php echo esc_attr( $data['title'] ); ?>" class="widefat"/></label>
</p>

<!-- limit post -->
<p>
	<label for="<?php echo esc_attr($wp_widget->get_field_id( 'limit_post' )); ?>"><?php esc_html_e( 'Limit Posts', 'slz' ) ?>
	<input type="text" name="<?php echo esc_attr($wp_widget->get_field_name ( 'limit_post' )); ?>" id="<?php echo esc_attr($wp_widget->get_field_id ( 'limit_post' )); ?>" value="<?php echo esc_attr( $data['limit_post'] ); ?>" class="widefat"/></label>
</p>

<!-- offset post -->
<p>
	<label for="<?php echo esc_attr($wp_widget->get_field_id( 'offset_post' )); ?>"><?php esc_html_e( 'Offset Posts', 'slz' ) ?>
	<input type="text" name="<?php echo esc_attr($wp_widget->get_field_name ( 'offset_post' )); ?>" id="<?php echo esc_attr($wp_widget->get_field_id ( 'offset_post' )); ?>" value="<?php echo esc_attr( $data['offset_post'] ); ?>" class="widefat"/></label>
</p>

<!-- categories -->
<p>
	<label for="<?php echo esc_attr($wp_widget->get_field_id( 'category_slug' )); ?>"><?php esc_html_e( 'Category', 'slz' ) ?>
	<input type="text" name="<?php echo esc_attr($wp_widget->get_field_name ( 'category_slug' )); ?>" id="<?php echo esc_attr($wp_widget->get_field_id ( 'category_slug' )); ?>" value="<?php echo esc_attr( $data['category_slug'] ); ?>" class="widefat"/></label>
	<span><?php esc_html_e( 'Enter category slug', 'slz'); ?></span>
</p>