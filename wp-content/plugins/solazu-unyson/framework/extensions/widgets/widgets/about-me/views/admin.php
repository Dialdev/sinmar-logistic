<?php

$widget_color_picker_id = SLZ_Com::make_id();

$social_list = SLZ_Params::get('social-icons');

extract( $instance );

$model = new SLZ_Image();

$image_id = '';
if(!empty($image)){
	$image_id = json_decode($image)->ID;
}
?>
<p>
	<label for="<?php echo  esc_attr( $object->get_field_id('title') ); ?>"><?php esc_html_e('Title', 'slz');?></label>
	<input class="widefat" type="text" id="<?php echo esc_attr( $object->get_field_id('title') ); ?>" name="<?php echo esc_attr( $object->get_field_name('title') ); ?>" value="<?php echo esc_attr( $title ); ?>" />
</p>
<div>
	<label for="<?php echo esc_attr( $object->get_field_id('block_title_color') ); ?>"><?php esc_html_e( 'Title Color:', 'slz' ); ?></label>
	<input data-slz-w-color="<?php echo esc_attr( $widget_color_picker_id ); ?>" class="widefat slz-color-picker-field" id="<?php echo esc_attr( $object->get_field_id('block_title_color') ); ?>"
		   name="<?php echo esc_attr( $object->get_field_name('block_title_color') ); ?>" type="text"
		   value="<?php echo esc_attr( $block_title_color ); ?>" />
	<br><div id="<?php echo esc_attr( $widget_color_picker_id ); ?>" class="slz-color-picker-widget" rel="<?php echo esc_attr( $object->get_field_id('block_title_color') ); ?>"></div>
	<br><div class="slz-widget-description"><?php echo esc_html__('Optional - Choose a custom title text color for this block', 'slz'); ?></div>
</div>
<p>
	<label for="<?php echo  esc_attr( $object->get_field_id('name') ); ?>"><?php esc_html_e('Name', 'slz');?></label>
	<input class="widefat" type="text" id="<?php echo esc_attr( $object->get_field_id('name') ); ?>" name="<?php echo esc_attr( $object->get_field_name('name') ); ?>" value="<?php echo esc_attr( $name ); ?>" />
</p>
<p>
	<label for="<?php echo esc_attr($object->get_field_id('image') ); ?>"><?php esc_html_e('Avatar:', 'slz');?>
	</label>
	<?php echo ( $model->upload_single_image(esc_attr($object->get_field_name('image') ),$image_id,array(
		'class'=>'wiget-upload-image',
		'data-rel' => esc_attr($object->get_field_id('image')),
		'id'=> esc_attr($object->get_field_id('image').'_id' ) ) ))?>
</p>

<p>
	<label for="<?php echo  esc_attr( $object->get_field_id('detail') ); ?>"><?php esc_html_e('Detail', 'slz');?></label>
	<textarea class="widefat" id="<?php echo esc_attr( $object->get_field_id('detail') ); ?>" name="<?php echo esc_attr( $object->get_field_name('detail') ); ?>"><?php echo esc_html( $detail ); ?></textarea>
</p>

<?php foreach ($social_list as $social => $icon) {
	
	$social = str_replace('-', '_', $social);

	?>
	<p>
		<label for="<?php echo esc_attr( $object->get_field_id($social) ); ?>"><?php esc_html_e('Social Profile : ', 'slz');?><?php echo esc_html( ucfirst( $social ) ); ?></label>
		<input class="widefat" type="text" id="<?php echo esc_attr( $object->get_field_id($social) ); ?>" name="<?php echo esc_attr( $object->get_field_name($social) ); ?>" value="<?php echo esc_attr( $$social ); ?>" />
	</p>

<?php } ?>

<p>
	<label for="<?php echo  esc_attr( $object->get_field_id('extra_class') ); ?>"><?php esc_html_e('Extra Class', 'slz');?></label>
	<input class="widefat" type="text" id="<?php echo esc_attr( $object->get_field_id('extra_class') ); ?>" name="<?php echo esc_attr( $object->get_field_name('extra_class') ); ?>" value="<?php echo esc_attr( $extra_class ); ?>" />
</p>

<script>
	slz_color_picker();
</script>