
<?php

$btn_content = '';
if(!empty($data['btn_content'])){
	$btn_content = '<a class="read-more link" href="%9$s">'.esc_attr($data['btn_content']).'</a>';
}

$html_render = array();
$html_format = '
		<div class="item item-%7$s">
			<div class="slz-block-team-04">
				%1$s
                %6$s
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
	';
$html_render['html_format'] = $html_format;
$html_render['thumb_class'] = 'img-responsive img-full';
$html_render['social_format']= '<li class="social-item">
									<a href="%2$s" class="%1$s">
										<i class="slz-icon fa fa-%1$s"></i>
									</a>
								</li>';
$html_render['image_format'] = '<div class="team-img">%1$s
									<a href="%2$s" tabindex="1" class="link"></a>
								</div>';
?>
<div class="layout-4 sc_team_list slz-shortcode <?php echo esc_attr( $data['block_cls'] ); ?>" data-item="<?php echo esc_attr($data['uniq_id']); ?>">
	<?php 
		echo ($data['classRowBegin']);
		$data['model']->render_team_list_sc( $html_render ); 
		echo ($data['classRowEnd']);?>
</div>