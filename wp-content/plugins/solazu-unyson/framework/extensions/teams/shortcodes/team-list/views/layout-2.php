<?php

$btn_content = '';
if(!empty($data['btn_content'])){
	$btn_content = '<a class="read-more link" href="%9$s">'.esc_attr($data['btn_content']).'</a>';
}

$html_render = array();
$html_format = '
		<div class="item team-%7$s '.$data['classInlineBlock'].'">
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
					<div class="description-wrapper">
						%5$s
						'. $btn_content .'
					</div>
				</div>
			</div>
		</div>
	';
$html_render['html_format'] = $html_format;
?>

<div class="layout-2 slz-shortcode sc_team_list <?php echo esc_attr( $data['block_cls'] ); ?>" data-item="<?php echo esc_attr($data['uniq_id']); ?>">
	<?php
		echo ($data['classRowBegin']);
		$data['model']->render_team_list_sc( $html_render ); 
		echo ($data['classRowEnd']);
	?>
</div>