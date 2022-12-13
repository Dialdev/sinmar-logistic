<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}
$block_cls = 'material_download-'.SLZ_Com::make_id().' '.$data['extra_class'];
$custom_css = '';
if ( is_plugin_active( 'js_composer/js_composer.php' ) ):
?>

<div class="slz-shortcode sc_material_download <?php echo esc_attr($block_cls); ?>">
	<?php if(!empty($data['title'])): ?>
		<h2 class="slz-title-shortcode"><?php echo esc_html($data['title']); ?></h2>
		<?php
		if ( !empty( $data['title_color'] ) ) {
			$css = '
				.%1$s .slz-title-shortcode {
					color: %2$s;
				}
			';
			$custom_css .= sprintf( $css, esc_attr( $block_cls ), esc_attr( $data['title_color'] ) );
		}
		?>
	<?php endif; ?>
	<?php if(!empty($data['files'])):
        $files = array();
	    if( preg_match( '/`{`(.*?)`}`/' , $data['files'], $matches ) )
        {
            if( !empty( $matches[1] ) ) {
                $files = explode(',', $matches[1] );
            }
        }
		foreach ($files as $value):
			$file_url = wp_get_attachment_url($value);
			if( empty($file_url)) continue;
			$info = pathinfo($file_url);
			$name = $info['filename'].'.'.$info['extension'];
			$file_type = wp_check_filetype($file_url);
	?>
		<a download="<?php echo esc_attr($name); ?>" href="<?php echo esc_url($file_url); ?>" class="slz-btn">
			<?php echo SLZ_Util::get_icon_for_extension($file_type['ext']); ?>
			<span class="btn-text"><?php echo esc_html(get_the_title($value)); ?></span>
			<span class="btn-icon fa fa-download"></span>
		</a>
	<?php
		endforeach;
	endif;
	?>

	<?php
	if ( !empty( $custom_css ) )
		do_action('slz_add_inline_style', $custom_css);
	?>
</div>

<?php
else:
echo esc_html__('Please Active Visual Composer', 'slz');
endif;