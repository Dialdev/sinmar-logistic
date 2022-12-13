<?php
$html_render = array();
$html_raise_goal_block = '';
if ( $data['show_goal_raised2'] == 'yes' ) {
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
					%6$s'.$html_raise_goal_block.'
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

echo '<div class="slz-shortcode sc_causes sc_causes_block_layout_2 '. esc_attr( $data['block_cls'] ) .'">';
	echo ( $data['model']->render_category_tabs() );
	echo '<div class="slz-list-block slz-column-1">';
		$data['model']->render_causes_block( $html_render );
	echo '</div>';
    if( ! empty( $data['show_donation_button'] ) && $data['show_donation_button'] == 'yes' ) {
        echo $data['modal_html'];
    }
echo '</div>';