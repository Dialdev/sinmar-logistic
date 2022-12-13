<p>
	<label for="<?php echo esc_attr( $wp_widget->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'slz' ); ?> </label>
	<input type="text" name="<?php echo esc_attr( $wp_widget->get_field_name( 'title' ) ); ?>"
	       value="<?php echo esc_attr( $data['title'] ); ?>" class="widefat"
	       id="<?php esc_attr( $wp_widget->get_field_id( 'title' ) ); ?>"/>
</p>
<!-- choose style -->
<?php if($p_style):?>
<p>
	<label for="<?php echo esc_attr( $wp_widget->get_field_id('style') ); ?>"><?php esc_html_e( 'Choose Style', 'slz' );?></label>
	<select class="widefat" id="<?php echo esc_attr( $wp_widget->get_field_id('style') ); ?>" name="<?php echo esc_attr( $wp_widget->get_field_name('style') ); ?>" >
	<?php
		foreach( $p_style as $key=>$value ){
			$selected = '';
			if( $data['style'] == $key ){
				$selected = 'selected';
			}
			printf('<option value="%1$s" %2$s>%3$s</option>', $key, $selected, $value);
		}
	?>
	</select>
</p>
<?php endif;?>
<!-- limit post -->
<p>
	<label for="<?php echo esc_attr( $wp_widget->get_field_id( 'limit' ) ); ?>"><?php esc_html_e( 'Limit', 'slz' ); ?> </label>
	<input type="text" name="<?php echo esc_attr( $wp_widget->get_field_name( 'limit' ) ); ?>"
	       value="<?php echo esc_attr( $data['limit'] ); ?>" class="widefat"
	       id="<?php esc_attr( $wp_widget->get_field_id( 'limit' ) ); ?>"/>
</p>
<!-- choose taxonomy -->
<?php if( $p_taxonomy ):?>
<p>
	<label for="<?php echo esc_attr( $wp_widget->get_field_id('taxonomy') ); ?>"><?php esc_html_e( 'Choose Taxonomy', 'slz' );?></label>
	<select class="widefat" id="<?php echo esc_attr( $wp_widget->get_field_id('taxonomy') ); ?>" name="<?php echo esc_attr( $wp_widget->get_field_name('taxonomy') ); ?>" >
	<?php
		foreach( $p_taxonomy as $key=>$value ){
			$selected = '';
			if( $data['taxonomy'] == $key ){
				$selected = 'selected';
			}
			printf('<option value="%1$s" %2$s>%3$s</option>', $key, $selected, $value);
		}
	?>
	</select>
</p>
<?php endif;?>
<!-- show count -->
<p>
	<input class="checkbox" type="checkbox" <?php echo checked($data['show_post_count'], 'on', false )?> id="<?php echo esc_attr( $wp_widget->get_field_id('show_post_count') )?>" name="<?php echo esc_attr( $wp_widget->get_field_name('show_post_count') )?>" />
	<label for="<?php echo esc_attr( $wp_widget->get_field_id('show_post_count') )?>"><?php esc_html_e( 'Show Count?', 'slz' );?></label>
</p>