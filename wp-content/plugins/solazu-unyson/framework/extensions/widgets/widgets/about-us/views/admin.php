<?php 
$image_id = '';
if(!empty($data['image'])){
	$image_id = json_decode($data['image'])->ID;
}
$model = new SLZ_Image();
?>
<p>
	<label for="<?php echo esc_attr( $wp_widget->get_field_id('title_type') ); ?>"><?php esc_html_e( 'Choose Type of Title', 'slz' );?></label>
	<select class="widefat" id="<?php echo esc_attr( $wp_widget->get_field_id('title_type') ); ?>" name="<?php echo esc_attr( $wp_widget->get_field_name('title_type') ); ?>" >
		<option value=""<?php if( $data['title_type'] == '' ) echo " selected"; ?>><?php esc_html_e( 'Logo Image', 'slz' );?>
		</option>
		<option value="text"<?php if( $data['title_type'] == 'text' ) 
			echo " selected"; ?>><?php esc_html_e( 'Text', 'slz' );?>
		</option>
	</select>
</p>
<!-- updaload image -->
<p>
	<label for="<?php echo esc_attr($wp_widget->get_field_id('image') ); ?>"><?php esc_html_e('Logo:', 'slz');?>
	</label>
	<?php echo ( $model->upload_single_image(esc_attr($wp_widget->get_field_name('image') ),$image_id,array(
		'class'=>'wiget-upload-image',
		'data-rel' => esc_attr($wp_widget->get_field_id('image')),
		'id'=> esc_attr($wp_widget->get_field_id('image').'_id' ) ) ))?>
</p>
<!-- title -->
<p>
	<label for="<?php echo esc_attr($wp_widget->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title', 'slz' ) ?>
	<input type="text" name="<?php echo esc_attr($wp_widget->get_field_name ( 'title' )); ?>" id="<?php echo esc_attr($wp_widget->get_field_id ( 'title' )); ?>" value="<?php echo esc_attr( $data['title'] ); ?>" class="widefat"/></label>
</p>
<!-- description -->
<p>
	<label for="<?php echo esc_attr( $wp_widget->get_field_id('description') ); ?>"><?php esc_html_e('Description', 'slz');?></label>
	<textarea class="widefat" rows="5" id="<?php echo esc_attr( $wp_widget->get_field_id('description') ); ?>" name="<?php echo esc_attr( $wp_widget->get_field_name('description') ); ?>" ><?php echo esc_textarea( $data['description'] ); ?></textarea>
</p>
<!-- social -->
<?php
foreach( $social_default as $k => $v ){
	printf('<p><label for="%1$s">%2$s<input type="text" class="widefat" id="%1$s" name="%3$s" value="%4$s" /></label></p>',
		esc_attr( $wp_widget->get_field_id($k) ),
		esc_attr( ucfirst( str_replace('-', ' ', $k ) ) ),
		esc_attr( $wp_widget->get_field_name($k) ),
		esc_attr($data[$k])
	);
}