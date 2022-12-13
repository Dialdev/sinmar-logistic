<?php 

$html_format = '
	<div class="grid-item %1$s %4$s">
		<div class="slz-block-gallery-01 style-1">
			<div class="block-image">
				<a href="%2$s" class="link fancybox-thumb"><img src="%3$s" class="img-responsive img-full" alt=""></a>
				<span class="dh-overlay"></span>
			</div>
		</div>
	</div>';

$html_render['html_format'] = $html_format;

$arr_limit = array(
	'style-1' => 7,
	'style-2' => 7,
	'style-3' => 9,
	'style-4' => 10,
	'style-5' => 8,
	'style-6' => 8,
	'style-7' => 5,
	'style-8' => 9,
	'style-9' => 8
);

$btn_load_more = '';

if( !empty( $data['model']->attributes['load_more_btn_text'] ) ) {
	$btn_load_more = sprintf('<div class="btn-loadmore-wrapper">
				<a href="javascript:void(0)" class="slz-btn btn-loadmore" data-number="%2$s">%1$s</a>
			</div>', esc_html( $data['model']->attributes['load_more_btn_text'] ),
					 esc_attr( $arr_limit[$data['style']]) );
}
$html_render['tab_content_format'] = '<div id="tab-%2$s" class="tab-pane  %3$s" role="tabpanel">
										<div class="gallery-list grid-main  %4$s">%1$s</div>
										'. $btn_load_more .'
									</div>';

list($filter_tab, $output_grid ) = $data['model']->render_filter_tab($data['model']->attributes, $html_render );
?>

<div class="slz-shortcode sc_gallery_tab <?php echo esc_attr( $data['block_cls'] );?>" data-block-class=".<?php echo esc_attr( $data['uniq_id']);?>" data-number="<?php echo esc_attr( $arr_limit[$data['style']]);?>">
	<?php 
	printf('<div class="tab-list-wrapper slz-isotope-nav">
		<ul class="tab-list tab-filter" role="tablist">%1$s</ul></div>',
			$filter_tab);
	?>
	<div class="tab-content">
	<?php 
		printf($output_grid);	
	?>
	</div>
</div>