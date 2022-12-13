<?php 

$html_format = '
	<div class="grid-item item">
		<div class="block-image">
			<a href="%2$s" class="link fancybox" data-fancybox-group="%5$s"><img src="%3$s" class="img-responsive img-full" alt=""></a>
			<span class="dh-overlay"></span>
		</div>
	</div>
';
$html_render['html_format'] = $html_format;
$html_render['tab_content_format'] = '<div id="tab-%2$s" class="tab-pane  %3$s" role="tabpanel">
										<div class="gallery-list slz-image-carousel">%1$s</div>
									</div>';

list($filter_tab, $output_grid ) = $data['model']->render_filter_tab($data['model']->attributes, $html_render );

$autoplay     = 1;
$arrows       = 1;
$dots         = 1;
$infinite     = 1;

if ( !empty($data['slide_autoplay']) && $data['slide_autoplay'] != 'yes' ) {
	$autoplay = 0;
}
if ( !empty($data['slide_dots']) && $data['slide_dots'] != 'yes' ) {
	$dots = 0;
}
if ( !empty($data['slide_arrows']) && $data['slide_arrows'] != 'yes' ) {
	$arrows = 0;
}
if ( !empty($data['slide_infinite']) && $data['slide_infinite'] != 'yes' ) {
	$infinite = 0;
}
if ( empty($data['slide_speed']) ) {
	$data['slide_speed'] = 600;
}
if ( empty($data['number_slide']) ) {
	$data['number_slide'] = 5;
}
?>
<div class="slz-shortcode slz-gallery-tab-01 <?php echo esc_attr( $data['block_cls'] );?>"
	data-slidestoshow="<?php echo esc_attr( $data['number_slide'] )?>"
	data-arrows="<?php echo esc_attr( $arrows )?>"
	data-dots="<?php echo esc_attr( $dots )?>"
	data-autoplay="<?php echo esc_attr( $autoplay ) ?>"
	data-speed="<?php echo esc_attr( $data['slide_speed'] ); ?>"
	data-infinite="<?php echo esc_attr( $infinite ); ?>"
	data-animation="<?php echo esc_attr( $data['animation'] ); ?>" >
	<div class="slz-tab">
		<?php 
			printf('<div class="tab-list-wrapper">
				<ul class="tab-list tab-filter" role="tablist">%1$s</ul></div>',
				$filter_tab);
		?>
		<div class="tab-content">
			<?php printf($output_grid); ?>
		</div>
	</div>
</div>

<?php 
/*---------------custom css------------*/
$css = $custom_css = '';
// arrows
	if ( !empty( $data['arrows_color'] ) ) {
		$css = '
			.%1$s .gallery-list .slick-arrow:before{
				color: %2$s;
			}
		';
		$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['arrows_color'] ) );
	}
	if ( !empty( $data['arrows_hv_color'] ) ) {
		$css = '
			.%1$s .gallery-list .slick-arrow:hover:before{
				color: %2$s;
			}
		';
		$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['arrows_hv_color'] ) );
	}
// dots
	if ( !empty( $data['dots_color'] ) ) {
		$css = '
			.%1$s .gallery-list .slick-dots li button:before{
				color: %2$s;
			}
		';
		$custom_css .= sprintf( $css, esc_attr( $data['uniq_id'] ), esc_attr( $data['dots_color'] ) );
	}
	
if ( !empty( $custom_css ) ) {
	do_action('slz_add_inline_style', $custom_css);
}