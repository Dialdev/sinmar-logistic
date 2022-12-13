<!-- title -->
<p>
	<label for="<?php echo esc_attr($wp_widget->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title', 'slz' ) ?>
	<input type="text" name="<?php echo esc_attr($wp_widget->get_field_name ( 'title' )); ?>" id="<?php echo esc_attr($wp_widget->get_field_id ( 'title' )); ?>" value="<?php echo esc_attr( $data['title'] ); ?>" class="widefat"/></label>
</p>
<!-- choose post type -->
<?php if( !empty($post_type) ):?>
<p>
	<label for="<?php echo esc_attr( $wp_widget->get_field_id('post_type') ); ?>"><?php esc_html_e( 'Choose Post Type', 'slz' );?></label>
	<select class="widefat" id="<?php echo esc_attr( $wp_widget->get_field_id('post_type') ); ?>" name="<?php echo esc_attr( $wp_widget->get_field_name('post_type') ); ?>" >
		<?php foreach ($post_type as $key => $value) {?>
			<option value="<?php echo esc_attr($key)?>"<?php if( $data['post_type'] == $key ) echo " selected"; ?>><?php echo esc_attr($value);?>
			</option>
		<?php }?>
	</select>
</p>
<?php endif;?>
<!-- limit post -->
<p>
	<label for="<?php echo esc_attr($wp_widget->get_field_id( 'limit_post' )); ?>"><?php esc_html_e( 'Limit Posts', 'slz' ) ?>
	<input type="text" name="<?php echo esc_attr($wp_widget->get_field_name ( 'limit_post' )); ?>" id="<?php echo esc_attr($wp_widget->get_field_id ( 'limit_post' )); ?>" value="<?php echo esc_attr( $data['limit_post'] ); ?>" class="widefat"/></label>
</p>
<!-- categories -->
<p>
	<label for="<?php echo esc_attr($wp_widget->get_field_id( 'cat_id' )); ?>"><?php esc_html_e( 'Category ID', 'slz' ) ?>
	<input type="text" name="<?php echo esc_attr($wp_widget->get_field_name ( 'cat_id' )); ?>" id="<?php echo esc_attr($wp_widget->get_field_id ( 'cat_id' )); ?>" value="<?php echo esc_attr( $data['cat_id'] ); ?>" class="widefat"/></label>
	<span><?php esc_html_e( 'Enter categories ID of gallery (Ex 1,2,3)', 'slz'); ?></span>
</p>
<!-- column -->
<p>
	<label for="<?php echo esc_attr( $wp_widget->get_field_id('column') ); ?>"><?php esc_html_e( 'Choose Column', 'slz' );?></label>
	<select class="widefat" id="<?php echo esc_attr( $wp_widget->get_field_id('column') ); ?>" name="<?php echo esc_attr( $wp_widget->get_field_name('column') ); ?>" >
		<option value="three-column"<?php if( $data['column'] == 'three-column' ) echo " selected"; ?>><?php esc_html_e( '3 Column', 'slz' );?>
		</option>
		<option value="four-column"<?php if( $data['column'] == 'four-column' ) 
			echo " selected"; ?>><?php esc_html_e( '4 Column', 'slz' );?>
		</option>
	</select>
</p>