<?php

$btn_content = '';
if(!empty($data['btn_content'])){
	$btn_content = '<a class="read-more link" href="%9$s">'.esc_attr($data['btn_content']).'</a>';
}

$html_render = array();
$html_format = '
	<div class="item item-%7$s '.$data['classInlineBlock'].' slz-block-team-05">
		<div class="slz-block-team-05">
			%1$s
			<div class="team-content">
				<div class="team-content-wrapper">
					<div class="sub-content">
						%6$s
					</div>
					<div class="main-content">
						%2$s
						%3$s
						%5$s
						<a href="%9$s" class="btn">
							<span class="btn-icon fa fa-long-arrow-right"></span>
							<span class="btn-text">view profile</span>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	';
$html_render['html_format']  = $html_format;
$html_render['thumb_class']  = 'img-responsive img-full';
$html_render['image_format'] =
	'<div class="team-image">%1$s
		<a href="%2$s" tabindex="1" class="link"></a>
	</div>';
$html_render['position_format'] = '<div class="team-position">%1$s</div>';
$html_render['excerpt_format']  = '<p class="team-text mCustomScrollbar">%1$s</p>';
$html_render['social_format']   = '<a href="%2$s" class="social-item"><i class="icons %1$s fa fa-%1$s"></i></a>';
?>

<div class="layout-5 sc_team_list slz-shortcode <?php echo esc_attr( $data['block_cls'] ); ?>" data-item="<?php echo esc_attr($data['uniq_id']); ?>">
	<?php
	echo ($data['classRowBegin']);
	$data['model']->render_team_list_sc( $html_render );
	echo ($data['classRowEnd']);
	?>
</div>