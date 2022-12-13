<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
		'title' => __ ( 'SLZ Ads Banner', 'slz' ),
		'description' => __ ( 'Show the banner in your page', 'slz' ),
		'tab' => slz()->theme->manifest->get('name'),
		'icon' => 'icon-slzcore-ads-banner slz-vc-slzcore',
		'tag' => 'slz_ads_banner' 
);

$cfg ['default_value'] = array (
		'block_title'		 	=> '',
		'block_title_color'		=> '',
		'block_title_class'		=> 'slz-title-shortcode',
		'adspot'				=> '',
		'extra_class'			=> ''
);