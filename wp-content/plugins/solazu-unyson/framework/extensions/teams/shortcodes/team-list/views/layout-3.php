<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Forbidden' ); }


$html_render = array();

$classRowBegin = $classRowEnd = $html_format = $html_nav_format = '';
$classInlineBlock = '%8$s inline_block';
$slick_json = $data['model']->get_atts_option_slick_slide($data['model']->attributes);
$classCarousel = 'no-carousel';

if ( !empty($data['model']->attributes['is_slide']) && $data['model']->attributes['is_slide'] == 'yes' ) {
	$classRowBegin = '<div class="slz-carousel-wrapper"><div class="carousel-overflow"><div class="slz-team-slide-slick slz-block-slide-slick" data-slick-json="'.esc_attr($slick_json).'">';
	$classRowEnd = '</div></div></div>';
	$classInlineBlock = '';
	$classCarousel = '';
}

$btn_content = '';
if(!empty($data['btn_content'])){
	$btn_content = '<a class="read-more link" href="%11$s">'.esc_attr($data['btn_content']).'</a>';
}

$html_format = '
		<div class="slz-block-team-03">
			<div class="row">
				<div class="col-left">
					<div class="slz-block-team-02">
						<div class="block-image">
							<div class="team-border-box"></div>
							<div class="team-img">
								%1$s
							</div>
							%6$s
						</div>
						<div class="team-body">
							<div class="main-info">
								%2$s
								%3$s
							</div>
							%4$s
							%5$s
							'. $btn_content .'
						</div>
					</div>
				</div>
				<div class="col-right">
					<div class="description">
						%7$s
						%8$s
					</div>
				</div>
			</div>
		</div>
	';

	$html_nav_format = '
		<div class="team-img nav-team-%2$s">
			%1$s
		</div>
	';

	$html_nav_render = array(
		'image_format'	=> '<a href="javascript:void(0)">%1$s</a>',
		'html_format'	=> $html_nav_format
	);

	$classCarousel = '';


$block_cls = $data['model']->attributes['extra_class'] . ' ' . $data['uniq_id'] . ' ' . $classCarousel;
$html_render['html_format'] = $html_format;
?>
<div class="layout-3 slz-shortcode sc_team_list <?php echo esc_attr( $block_cls ); ?>" data-item="<?php echo esc_attr($data['uniq_id']); ?>">
	<div class="slz-carousel-wrapper slz-team-wrapper-03">
		<div class="carousel-overflow">
			<div class="slz-team-slider-03">
				<?php $data['model']->render_team_carousel_sc( $html_render ); ?>
			</div>
		</div>
		<div class="col-md-7 col-md-offset-5 slide-nav">
			<div class="carousel-overflow">
				<div class="slz-team-nav-03">
					<?php $data['model']->render_team_carousel_nav_sc( $html_nav_render ); ?>
				</div>
			</div>
		</div>
	</div>
</div>
