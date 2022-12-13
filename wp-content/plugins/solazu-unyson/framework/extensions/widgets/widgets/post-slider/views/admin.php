<?php 
$sort_arr   = SLZ_Params::get('sort-blog');
?>

<!-- title -->
<p>
	<label for="<?php echo  esc_attr( $wp_widget->get_field_id('title') ); ?>"><?php esc_html_e( 'Title', 'slz' );?></label>
	<input class="widefat" type="text" id="<?php echo esc_attr( $wp_widget->get_field_id('title') ); ?>" name="<?php echo esc_attr( $wp_widget->get_field_name('title') ); ?>" value="<?php echo esc_attr( $data['title'] ); ?>" />
</p>
<!-- limit post -->
<p>
	<label for="<?php echo  esc_attr( $wp_widget->get_field_id('limit_post') ); ?>"><?php esc_html_e( 'Number Post', 'slz' );?></label>
	<input class="widefat" type="text" id="<?php echo esc_attr( $wp_widget->get_field_id('limit_post') ); ?>" name="<?php echo esc_attr( $wp_widget->get_field_name('limit_post') ); ?>" value="<?php echo esc_attr( $data['limit_post'] ); ?>" />
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