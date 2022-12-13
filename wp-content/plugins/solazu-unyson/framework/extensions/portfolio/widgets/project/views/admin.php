<?php 
	$sort_arr   = SLZ_Params::get('sort-blog');
	$all_page   = get_pages();
	$empty      = esc_html__("-All pages-", 'slz');
?>

<!-- title -->
<p>
	<label for="<?php echo  esc_attr( $wp_widget->get_field_id('title') ); ?>"><?php esc_html_e( 'Title', 'slz' );?></label>
	<input class="widefat" type="text" id="<?php echo esc_attr( $wp_widget->get_field_id('title') ); ?>" name="<?php echo esc_attr( $wp_widget->get_field_name('title') ); ?>" value="<?php echo esc_attr( $data['title'] ); ?>" />
</p>
<!-- limit post -->
<p>
	<label for="<?php echo  esc_attr( $wp_widget->get_field_id('limit_post') ); ?>"><?php esc_html_e( 'Limit Posts', 'slz' );?></label>
	<input class="widefat" type="text" id="<?php echo esc_attr( $wp_widget->get_field_id('limit_post') ); ?>" name="<?php echo esc_attr( $wp_widget->get_field_name('limit_post') ); ?>" value="<?php echo esc_attr( $data['limit_post'] ); ?>" />
</p>
<!-- limit post -->
<p>
	<label for="<?php echo  esc_attr( $wp_widget->get_field_id('offset_post') ); ?>"><?php esc_html_e( 'Offset Post', 'slz' );?></label>
	<input class="widefat" type="text" id="<?php echo esc_attr( $wp_widget->get_field_id('limit_post') ); ?>" name="<?php echo esc_attr( $wp_widget->get_field_name('offset_post') ); ?>" value="<?php echo esc_attr( $data['offset_post'] ); ?>" />
</p>
<!-- sort by -->
<p>
	<label for="<?php echo  esc_attr( $wp_widget->get_field_id('sort_by') ); ?>"><?php esc_html_e( 'Sort By', 'slz' );?></label>
	<select class="widefat" id="<?php echo esc_attr( $wp_widget->get_field_id('sort_by') ); ?>" name="<?php echo esc_attr( $wp_widget->get_field_name('sort_by') ); ?>" >
		<?php foreach( $sort_arr  as $k => $v ){?>
			<option value="<?php echo esc_attr($v); ?>"<?php if( $data['sort_by'] == $v ) echo " selected"; ?>><?php echo esc_html($k); ?></option>
		<?php } ?>
	</select>
</p>
<!-- categories -->
<p>
	<label for="<?php echo esc_attr($wp_widget->get_field_id( 'cat_id' )); ?>"><?php esc_html_e( 'Project Category ID', 'slz' ) ?>
	<input type="text" name="<?php echo esc_attr($wp_widget->get_field_name ( 'cat_id' )); ?>" id="<?php echo esc_attr($wp_widget->get_field_id ( 'cat_id' )); ?>" value="<?php echo esc_attr( $data['cat_id'] ); ?>" class="widefat"/></label>
	<span><?php esc_html_e( 'Enter categories ID of project(Ex 1,2,3)', 'slz'); ?></span>
</p>
<!-- image type -->
<p>
	<label for="<?php echo  esc_attr( $wp_widget->get_field_id('image_type') ); ?>"><?php esc_html_e( 'Image Type', 'slz' );?></label>
	<select class="widefat" id="<?php echo esc_attr( $wp_widget->get_field_id('image_type') ); ?>" name="<?php echo esc_attr( $wp_widget->get_field_name('image_type') ); ?>" >
		<?php foreach( $image_type  as $k => $v ){?>
			<option value="<?php echo esc_attr($v); ?>"<?php if( $data['image_type'] == $v ) echo " selected"; ?>><?php echo esc_html($k); ?></option>
		<?php } ?>
	</select>
</p>
<!-- button text -->
<p>
	<label for="<?php echo esc_attr($wp_widget->get_field_id( 'button_text' )); ?>"><?php esc_html_e( 'Button Content', 'slz' ) ?>
	<input type="text" name="<?php echo esc_attr($wp_widget->get_field_name ( 'button_text' )); ?>" id="<?php echo esc_attr($wp_widget->get_field_id ( 'button_text' )); ?>" value="<?php echo esc_attr( $data['button_text'] ); ?>" class="widefat"/></label>
</p>
<p>
	<label for="<?php echo esc_attr($wp_widget->get_field_id( 'button_custom_link' )); ?>"><?php esc_html_e( 'Button Link (Custom)', 'slz' ) ?>
	<input type="text" name="<?php echo esc_attr($wp_widget->get_field_name ( 'button_custom_link' )); ?>" id="<?php echo esc_attr($wp_widget->get_field_id ( 'button_custom_link' )); ?>" value="<?php echo esc_attr( $data['button_custom_link'] ); ?>" class="widefat"/></label>
</p>
<!-- check box -->
<?php
	$format = '
		<p>
			<input class="checkbox" type="checkbox" %1$s id="%2$s" name="%3$s" />
			<label for="%4$s">%5$s</label>
		</p>';
	foreach( $check_box as $field => $text ) {
		printf( $format,
				checked($data[$field], 'on', false ),
				esc_attr( $wp_widget->get_field_id($field) ),
				esc_attr( $wp_widget->get_field_name($field) ),
				esc_attr( $wp_widget->get_field_id($field) ),
				$text
			);
	}