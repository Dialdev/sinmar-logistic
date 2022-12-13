<!-- Title -->
<p>
	<label for="<?php echo  esc_attr( $wp_widget->get_field_id('title') ); ?>"><?php esc_html_e('Title', 'slz');?></label>
	<input class="widefat" type="text" id="<?php echo esc_attr( $wp_widget->get_field_id('title') ); ?>" name="<?php echo esc_attr( $wp_widget->get_field_name('title') ); ?>" value="<?php echo esc_attr( $data['title'] ); ?>" />
</p>
<!-- Address -->
<p>
	<label for="<?php echo  esc_attr( $wp_widget->get_field_id('address_title') ); ?>"><?php esc_html_e('Address Title', 'slz');?></label>
	<input class="widefat" type="text" id="<?php echo esc_attr( $wp_widget->get_field_id('address_title') ); ?>" name="<?php echo esc_attr( $wp_widget->get_field_name('address_title') ); ?>" value="<?php echo esc_attr( $data['address_title'] ); ?>" />
</p>
<p>
	<label for="<?php echo esc_attr( $wp_widget->get_field_id('address') ); ?>"><?php esc_html_e('Address', 'slz');?></label>
	<textarea class="widefat" rows="2" id="<?php echo esc_attr( $wp_widget->get_field_id('address') ); ?>" name="<?php echo esc_attr( $wp_widget->get_field_name('address') ); ?>" ><?php echo esc_textarea(  $data['address'] ); ?></textarea>
</p>
<!-- Phone -->
<p>
	<label for="<?php echo  esc_attr( $wp_widget->get_field_id('phone_title') ); ?>"><?php esc_html_e('Phone Title', 'slz');?></label>
	<input class="widefat" type="text" id="<?php echo esc_attr( $wp_widget->get_field_id('phone_title') ); ?>" name="<?php echo esc_attr( $wp_widget->get_field_name('phone_title') ); ?>" value="<?php echo esc_attr( $data['phone_title'] ); ?>" />
</p>
<p>
	<label for="<?php echo esc_attr( $wp_widget->get_field_id('phone') ); ?>"><?php esc_html_e('Phone', 'slz');?></label>
	<textarea class="widefat" rows="2" id="<?php  echo esc_attr( $wp_widget->get_field_id('phone') ); ?>" name="<?php echo esc_attr( $wp_widget->get_field_name('phone') ); ?>" ><?php echo esc_textarea(  $data['phone'] ); ?></textarea>
</p>
<!-- Mail -->
<p>
	<label for="<?php echo  esc_attr( $wp_widget->get_field_id('mail_title') ); ?>"><?php esc_html_e('Mail Title', 'slz');?></label>
	<input class="widefat" type="text" id="<?php echo esc_attr( $wp_widget->get_field_id('mail_title') ); ?>" name="<?php echo esc_attr( $wp_widget->get_field_name('mail_title') ); ?>" value="<?php echo esc_attr( $data['mail_title'] ); ?>" />
</p>
<p>
	<label for="<?php echo esc_attr( $wp_widget->get_field_id('mail') ); ?>"><?php esc_html_e('Email', 'slz');?></label>
	<textarea class="widefat" rows="2" id="<?php echo esc_attr( $wp_widget->get_field_id('mail') ); ?>" name="<?php echo esc_attr( $wp_widget->get_field_name('mail') ); ?>" ><?php echo esc_textarea(  $data['mail'] );?></textarea>
</p>
<!-- web -->
<p>
	<label for="<?php echo  esc_attr( $wp_widget->get_field_id('website_title') ); ?>"><?php esc_html_e('Website Title', 'slz');?></label>
	<input class="widefat" type="text" id="<?php echo esc_attr( $wp_widget->get_field_id('website_title') ); ?>" name="<?php echo esc_attr( $wp_widget->get_field_name('website_title') ); ?>" value="<?php echo esc_attr( $data['website_title'] ); ?>" />
</p>
<p>
	<label for="<?php echo esc_attr( $wp_widget->get_field_id('website') ); ?>"><?php esc_html_e('Website', 'slz');?></label>
	<input class="widefat" type="text" id="<?php echo esc_attr( $wp_widget->get_field_id('website') ); ?>" name="<?php echo esc_attr( $wp_widget->get_field_name('website') ); ?>" value="<?php echo esc_attr( $data['website'] ); ?>" />
</p>