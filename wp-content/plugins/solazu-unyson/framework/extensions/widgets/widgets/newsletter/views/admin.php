<p>
	<label for="<?php echo esc_attr( $wp_widget->get_field_id('style') ) ?>"><?php esc_html_e( 'Style:', 'slz' ); ?></label>
	<select class="widefat" id="<?php echo esc_attr( $wp_widget->get_field_id('style') ) ?>" name="<?php echo esc_attr( $wp_widget->get_field_name('style') ) ?>">
		<?php
			foreach ($style as $key => $value) {
				$selected = '';
				if( $data['style'] == $key ){
					$selected = 'selected';
				}
				echo '<option value="'. esc_attr( $key ) .'" '. esc_attr( $selected ) .'>'.  esc_attr( $value ) . '</option>';
			}
		?>
	</select>
</p>
<p>
	<label for="<?php echo esc_attr( $wp_widget->get_field_id('title') ) ?>"><?php esc_html_e( 'Title:', 'slz' ); ?>
		<input type="text" class="widefat" id="<?php echo esc_attr( $wp_widget->get_field_id('title') ) ?>" name="<?php echo esc_attr( $wp_widget->get_field_name('title') ) ?>" value="<?php echo esc_attr( $data['title'] ); ?>" />
	</label>
</p>
<p>
	<label for="<?php echo esc_attr( $wp_widget->get_field_id('description') ) ?>"><?php esc_html_e( 'Description:', 'slz' ); ?>
		<textarea class="widefat" rows="3" id="<?php echo esc_attr( $wp_widget->get_field_id('description') ) ?>" name="<?php echo esc_attr( $wp_widget->get_field_name('description') ) ?>"><?php echo esc_textarea( $data['description'] ); ?></textarea>
	</label>
	<?php esc_html_e( 'Enter description to display on newsletter form.', 'slz' ); ?>
</p>
<p>
	<label for="<?php echo esc_attr( $wp_widget->get_field_id('email_placeholder') ) ?>"><?php esc_html_e( 'Email Placeholder:', 'slz' ); ?>
		<input type="text" class="widefat" id="<?php echo esc_attr( $wp_widget->get_field_id('email_placeholder') ) ?>" name="<?php echo esc_attr( $wp_widget->get_field_name('email_placeholder') ) ?>" value="<?php echo esc_attr( $data['email_placeholder'] ); ?>" />
	</label>
</p>
<p class="newsletter-options">
	<label for="<?php echo esc_attr( $wp_widget->get_field_id('show_hide') ) ?>"><?php esc_html_e( 'Show Field Name:', 'slz' ); ?></label>
	<select class="widefat" id="<?php echo esc_attr( $wp_widget->get_field_id('show_hide') ) ?>" name="<?php echo esc_attr( $wp_widget->get_field_name('show_hide') ) ?>">
		<?php
			foreach ($show_hide as $key => $value) {
				$selected = '';
				if( $data['show_hide'] == $key ){
					$selected = 'selected';
				}
				echo '<option value="'. esc_attr( $key ) .'" '. esc_attr( $selected ) .'>'.  esc_attr( $value ) . '</option>';
			}
		?>
	</select>
</p>
<p class="<?php if( $data['show_hide'] == 'hide' ) { echo 'hidden'; } ?>">
	<label for="<?php echo esc_attr( $wp_widget->get_field_id('name_placeholder') ) ?>"><?php esc_html_e( 'Name Placeholder:', 'slz' ); ?>
		<input type="text" class="widefat" id="<?php echo esc_attr( $wp_widget->get_field_id('name_placeholder') ) ?>" name="<?php echo esc_attr( $wp_widget->get_field_name('name_placeholder') ) ?>" value="<?php echo esc_attr( $data['name_placeholder'] ); ?>" />
	</label>
</p>
<p>
	<label for="<?php echo esc_attr( $wp_widget->get_field_id('button_text') ) ?>"><?php esc_html_e( 'Button Text:', 'slz' ); ?>
		<input type="text" class="widefat" id="<?php echo esc_attr( $wp_widget->get_field_id('button_text') ) ?>" name="<?php echo esc_attr( $wp_widget->get_field_name('button_text') ) ?>" value="<?php echo esc_attr( $data['button_text'] ); ?>" />
	</label>
</p>