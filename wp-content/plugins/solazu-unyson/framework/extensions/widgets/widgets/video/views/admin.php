<?php
$model = new SLZ_Image();
$image_id = '';
if(!empty($data['bg_image'])){
	$image_id = json_decode($data['bg_image'])->ID;
}

$video_type = array(
	esc_html__('Youtube', 'slz')         => 'youtube',
	esc_html__('Vimeo', 'slz')           => 'vimeo'
);
$type = esc_attr( $data['type'] );

$video_align = array(
	esc_html__( 'Left', 'slz' )      => 'text-l',
	esc_html__( 'Right', 'slz' )     => 'text-r',
	esc_html__( 'Center', 'slz' )    => 'text-c',
);
$align = esc_attr( $data['align'] );

?>
<!-- Video Title -->
<p>
	<label for="<?php echo  esc_attr( $wp_widget->get_field_id('title') ); ?>"><?php esc_html_e('Title', 'slz');?></label>
	<input class="widefat" type="text" id="<?php echo esc_attr( $wp_widget->get_field_id('title') ); ?>" name="<?php echo esc_attr( $wp_widget->get_field_name('title') ); ?>" value="<?php echo esc_attr( $data['title'] ); ?>" />
</p>
<!-- Description -->
<p>
	<label for="<?php echo esc_attr( $wp_widget->get_field_id('content') ); ?>"><?php esc_html_e('Description', 'slz');?></label>
	<textarea class="widefat" rows="2" id="<?php echo esc_attr( $wp_widget->get_field_id('content') ); ?>" name="<?php echo esc_attr( $wp_widget->get_field_name('content') ); ?>" ><?php echo esc_textarea( $data['content'] ); ?></textarea>
</p>
<!-- Video Height -->
<p>
	<label for="<?php echo  esc_attr( $wp_widget->get_field_id('height') ); ?>"><?php esc_html_e('Video Height', 'slz');?></label>
	<input class="widefat" type="text" id="<?php echo esc_attr( $wp_widget->get_field_id('height') ); ?>" name="<?php echo esc_attr( $wp_widget->get_field_name('height') ); ?>" value="<?php echo esc_attr( $data['height'] ); ?>" />
	<br><div class="slz-widget-description"><?php echo esc_html__('Set height for video. Example: 75% - means video height by 75% video width.', 'slz'); ?></div>
</p>
<!-- Background Image -->
<p>
	<label for="<?php echo  esc_attr( $wp_widget->get_field_id('bg_image') ); ?>"><?php esc_html_e('Background Image', 'slz');?></label>
	<?php echo ( $model->upload_single_image(esc_attr($wp_widget->get_field_name('bg_image') ), $image_id, array(
		'class'=>'wiget-upload-image',
		'data-rel' => esc_attr($wp_widget->get_field_id('bg_image')),
		'id'=> esc_attr($wp_widget->get_field_id('bg_image').'_id' ) ) ))?>
</p>
<!-- Type -->
<p>
	<label for="<?php echo esc_attr( $wp_widget->get_field_id('content') ); ?>"><?php esc_html_e('Video Type', 'slz');?></label>
	<select class="widefat" id="<?php echo esc_attr( $wp_widget->get_field_id('type') ); ?>" name="<?php echo esc_attr( $wp_widget->get_field_name('type') ); ?>">
		<?php
		foreach ( $video_type as $key => $item ) {
			?>
			<option value="<?php echo esc_attr( $item ); ?>" <?php if( $type == $item ) { echo "selected"; } ?>><?php echo $key;?></option>
		<?php } ?>
	</select>
</p>
<!-- Align -->
<p>
	<label for="<?php echo esc_attr( $wp_widget->get_field_id('align') ); ?>"><?php esc_html_e('Align', 'slz'); ?></label>
	<select class="widefat" id="<?php echo esc_attr( $wp_widget->get_field_id('align') ); ?>" name="<?php echo esc_attr( $wp_widget->get_field_name('align') ); ?>">
		<?php
		foreach ( $video_align as $key => $item ) {
			?>
			<option value="<?php echo esc_attr( $item ); ?>" <?php if( $align == $item ) { echo "selected"; } ?>><?php echo $key;?></option>
		<?php } ?>
	</select>
</p>
<!-- Video Id -->
<p>
	<label for="<?php echo  esc_attr( $wp_widget->get_field_id('video_id') ); ?>"><?php esc_html_e('Video ID', 'slz');?></label>
	<input class="widefat" type="text" id="<?php echo esc_attr( $wp_widget->get_field_id('video_id') ); ?>" name="<?php echo esc_attr( $wp_widget->get_field_name('video_id') ); ?>" value="<?php echo esc_attr( $data['video_id'] ); ?>" />
	<br><div class="slz-widget-description"><?php echo esc_html__('Example: the Video ID for https://www.youtube.com/watch?v=PDWvcsTloJo is PDWvcsTloJo', 'slz'); ?></div>
</p>
