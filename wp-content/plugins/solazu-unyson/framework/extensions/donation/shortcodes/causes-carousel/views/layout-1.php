<?php
$html_render = array();
$html_raise_goal_block = '';
if ($data['show_goal_raised2'] == 'yes') {
    $html_raise_goal_block = '<div class="raise-goal-block">
							%5$s
							%4$s
						</div>';
}
$html_format = '
	<div class="item">
		<div class="slz-block-item-06 style-1">
			%1$s
			<div class="block-content">
				<div class="block-content-wrapper">
					%2$s
					%7$s
					%6$s' . $html_raise_goal_block . '
				%3$s
				%8$s
				</div>
			</div>
		</div>
	</div>
';

$html_render['html_format'] = $html_format;
$html_render['thumb_class'] = 'img-full';
$html_render['btn_more_format'] = '<a href="%2$s" class="slz-btn btn-block-donate">%1$s</a>';
$uid = $data['uniq_id'];
?>
<div class="slz-carousel-layout-1-<?php echo esc_attr($uid); ?> causes-slider">
    <div class="slz-carousel-wrapper" >
        <div class="carousel-overflow" >
            <div class="slz-carousel" data-slidestoshow="1" data-autoplay = "<?php echo esc_html( $data['slide_autoplay'] ); ?>" data-isdot = "<?php echo esc_html( $data['slide_dots'] ); ?>" data-isarrow = "<?php echo esc_html( $data['slide_arrows'] ); ?>" data-infinite = "<?php echo esc_html( $data['slide_infinite'] ); ?>" data-speed = "<?php echo esc_html( $data['slide_speed'] ); ?>" >
                <?php $data['model']->render_causes_block($html_render); ?>
            </div>
        </div>
    </div>
</div>