<?php
if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
	'title'			=> esc_html__ ( 'SLZ Project Category', 'slz' ),
	'description'	=> esc_html__ ( 'Slider of Category Project Number', 'slz' ),
	'tab'			=> slz()->theme->manifest->get('name'),
	'icon'			=> 'icon-slzcore-portfolio-category slz-vc-slzcore',
	'tag'			=> 'slz_portfolio_category' 
);

$cfg['yes_no'] = array(
	esc_html__('Yes', 'slz') => 'yes',
	esc_html__('No', 'slz')  => 'no',
);

$cfg ['default_value'] = array(
	'extension'               => 'portfolio',
	'shortcode'               => 'portfolio_category',
	'post_type'               => 'slz-portfolio',
	'list_category'           => '',
	'extra_class'             => '',
	'slide_to_show'           => '5',
	'slide_to_scroll'         => '1',
	'dots'                    => 'yes',
	'arrow'                   => 'yes',
	'project_name_color'      => '',
	'project_number_color'    => '',
);