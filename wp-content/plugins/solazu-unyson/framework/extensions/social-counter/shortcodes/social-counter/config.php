<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
		'title' => __ ( 'SLZ Social Counter', 'slz' ),
		'description' => __ ( 'Social Counter', 'slz' ),
		'tab' => slz()->theme->manifest->get('name'),
		'icon' => 'icon-slzcore-social-counter slz-vc-slzcore',
		'tag' => 'slz_social_counter' 
);

$cfg ['default_value'] = array (
		'block_title_class' 	=> 'slz-title-shortcode',
		'block_title'           => '',
		'block_title_color'     => '',
		'extra_class'           => '',
		'facebook'				=> '',
		'facebook_appid'        => '',
		'facebook_secretkey'    => '',
		'twitter'				=> '',
		'google'				=> '',
		'vimeo'					=> '',
		'instagram'				=> '',
		'soundcloud'			=> '',
		'style'					=> 1
);
