<p>
	<label for="<?php echo esc_attr( $wp_widget->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'slz' ); ?> </label>
	<input type="text" name="<?php echo esc_attr( $wp_widget->get_field_name( 'title' ) ); ?>"
	       value="<?php echo esc_attr( $data['title'] ); ?>" class="widefat"
	       id="<?php esc_attr( $wp_widget->get_field_id( 'title' ) ); ?>"/>
</p>
<!-- limit post -->
<p>
	<label for="<?php echo esc_attr( $wp_widget->get_field_id( 'limit_post' ) ); ?>"><?php esc_html_e( 'Limit Post', 'slz' ); ?> </label>
	<input type="text" name="<?php echo esc_attr( $wp_widget->get_field_name( 'limit_post' ) ); ?>"
	       value="<?php echo esc_attr( $data['limit_post'] ); ?>" class="widefat"
	       id="<?php esc_attr( $wp_widget->get_field_id( 'limit_post' ) ); ?>"/>
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
<!-- choose taxonomy -->
<?php if( $post_type ):?>
<p>
	<label for="<?php echo esc_attr( $wp_widget->get_field_id('post_type') ); ?>"><?php esc_html_e( 'Choose Post Type', 'slz' );?></label>
	<select class="widefat" id="<?php echo esc_attr( $wp_widget->get_field_id('post_type') ); ?>" name="<?php echo esc_attr( $wp_widget->get_field_name('post_type') ); ?>" >
	<?php
		foreach( $post_type as $key=>$value ){
			$selected = '';
			if( $data['post_type'] == $key ){
				$selected = 'selected';
			}
			printf('<option value="%1$s" %2$s>%3$s</option>', $key, $selected, $value);
		}
	?>
	</select>
</p>
<?php endif;?>