<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Forbidden' ); }

$model = new SLZ_Team();
$model->init( $data );
$class_col = '';
$css = $custom_css = '';
$uniq_id = $model->attributes['uniq_id'];
$block_cls = $model->attributes['extra_class'] . ' ' . $uniq_id;

$btn_content = '';
if(!empty($data['btn_content'])){
	$btn_content = '<a class="read-more link" href="%9$s">'.esc_attr($data['btn_content']).'</a>';
}

$html_format = '
		<div class="item team-%7$s">
			<div class="slz-block-team-01">
				<div class="team-img">
					%1$s
				</div>
				<div class="team-body">
					<div class="main-info">
						%2$s
						%3$s
					</div>
					<div class="description-wrapper">
						%4$s
						%5$s
						'. $btn_content .'
					</div>
					%6$s
				</div>
			</div>
		</div>
	';

$html_render['html_format'] = $html_format;

list($filter_tab, $output_grid ) = $model->render_filter_tab($model->attributes,$html_render );
?>

<div class="slz-shortcode slz-team-tab <?php echo esc_attr( $block_cls );?>">
	<div class="slz-tab">
		<?php 
			printf('<div class="tab-list-wrapper">
				<ul class="tab-filter" role="tablist">%1$s</ul></div>',
				$filter_tab);
		?>
		<div class="tab-content">
			<?php printf($output_grid); ?>
		</div>
	</div>
</div>
<?php 
// custom css

$custom_css = '';

if( !empty($model->attributes['color_cat']) ) {
	$custom_css .= sprintf('.%1$s .tab_item.active a{ color: %2$s !important;}',
		$model->attributes['uniq_id'], $model->attributes['color_cat']
	);
}
if( $custom_css ) {
	do_action('slz_add_inline_style', $custom_css);
}

