
<script type='text/html' id='slz-custom-widget'>
	<form class='slz-add-widget' method='POST'>
		<h3><?php echo esc_html__('Custom Widgets', 'slz'); ?></h3>
		<input class='slz_style_wrap' type='text' value='' placeholder = '<?php echo esc_html__('Enter Name of the new Widget Area here', 'slz'); ?>' name='slz-add-widget[name]' />
		<input class='slz_style_wrap' type='text' value='' placeholder = '<?php echo esc_html__('Enter class display on front-end', 'slz'); ?>' name='slz-add-widget[class]' />
		<input class='slz_button' type='submit' value='<?php echo esc_html__('Add Widget Area', 'slz'); ?>' />
		<input type="hidden" name="slz-delete-sidebar-nonce" value="<?php echo esc_attr( $nonce ); ?>" />
	</form>
</script>