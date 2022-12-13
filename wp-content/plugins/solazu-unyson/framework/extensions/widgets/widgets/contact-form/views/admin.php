<?php
$widget_color_picker_id = SLZ_Com::make_id();

$model = new SLZ_Image();

$image_id = '';
if(!empty($data['bg_image'])){
	$image_id = json_decode($data['bg_image'])->ID;
}

$bg_color = '#';
if ( !empty( $data['bg_color'] ) ) {
	$bg_color = esc_attr( $data['bg_color'] );
}

$contact_form_arr = array( esc_html__( '-None-', 'slz' ) => '' );
$args = array (
	'post_type'     => 'wpcf7_contact_form',
	'post_per_page' => -1,
	'status'        => 'publish',
);
$post_arr = get_posts( $args );
foreach( $post_arr as $post ){
	$title = ( !empty( $post->post_title ) )? $post->post_title : $post->post_name;
	$contact_form_arr[$title] = $post->ID ;
}

$style = esc_attr( $data['ctf'] );

?>

<!-- Title -->
<p>
	<label for="<?php echo  esc_attr( $wp_widget->get_field_id('title') ); ?>"><?php esc_html_e('Title', 'slz');?></label>
	<input class="widefat" type="text" id="<?php echo esc_attr( $wp_widget->get_field_id('title') ); ?>" name="<?php echo esc_attr( $wp_widget->get_field_name('title') ); ?>" value="<?php echo esc_attr( $data['title'] ); ?>" />
</p>
<!-- Type -->
<p>
	<label for="<?php echo  esc_attr( $wp_widget->get_field_id('ctf') ); ?>"><?php esc_html_e('Choose Style', 'slz');?></label>
	<select class="widefat" id="<?php echo esc_attr( $wp_widget->get_field_id( 'ctf' ) ); ?>" name="<?php echo esc_attr( $wp_widget->get_field_name('ctf') ); ?>" >
		<?php
		foreach ( $contact_form_arr as $key => $item ) {
		?>
		<option value="<?php echo esc_attr( $item ); ?>" <?php if( $style == $item ) { echo "selected"; } ?>><?php echo $key;?></option>
		<?php } ?>
	</select>
</p>
<!-- Background Color !-->
<div>
	<label for="<?php echo esc_attr( $wp_widget->get_field_id('bg_color') ); ?>"><?php esc_html_e( 'Background Color:', 'slz' ); ?></label>
	<input data-slz-w-color="<?php echo esc_attr( $widget_color_picker_id ); ?>" class="widefat slz-color-picker-field" id="<?php echo esc_attr( $wp_widget->get_field_id('bg_color') ); ?>"
		   name="<?php echo esc_attr( $wp_widget->get_field_name('bg_color') ); ?>" type="text"
		   value="<?php echo esc_attr( $bg_color ); ?>" />
	<br><div id="<?php echo esc_attr( $widget_color_picker_id ); ?>" class="slz-color-picker-widget" rel="<?php echo esc_attr( $wp_widget->get_field_id('bg_color') ); ?>"></div>
	<br><div class="slz-widget-description"><?php echo esc_html__('Choose a custom background color for this block', 'slz'); ?></div>
</div>
<!-- Background Image !-->
<p>
	<label for="<?php echo  esc_attr( $wp_widget->get_field_id('bg_image') ); ?>"><?php esc_html_e('Background Image', 'slz');?></label>
	<?php echo ( $model->upload_single_image(esc_attr($wp_widget->get_field_name('bg_image') ), $image_id, array(
		'class'=>'wiget-upload-image',
		'data-rel' => esc_attr($wp_widget->get_field_id('bg_image')),
		'id'=> esc_attr($wp_widget->get_field_id('bg_image').'_id' ) ) ))?>
</p>
<script>
	slz_color_picker();
</script>
