<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
		'title' => __ ( 'SLZ New Tweet', 'slz' ),
		'description' => __ ( 'Show twitter new tweet', 'slz' ),
		'tab' => slz()->theme->manifest->get('name'),
		'icon' => 'icon-slzcore-new-tweet slz-vc-slzcore',
		'tag' => 'slz_new_tweet' 
);

$cfg ['default_value'] = array (
		'block_title_class' 		=> 'slz-title-shortcode',
		'block_title'           	=> '',
		'block_title_color'     	=> '',
		'extra_class'           	=> '',
		'limit_tweet'				=> '6',
		'oauth_access_token' 		=> '',
	    'oauth_access_token_secret' => '',
	    'consumer_key' 				=> '',
	    'consumer_secret' 			=> '',
	    'screen_name' 				=> '',
	    'show_media'				=> 'yes',
        'show_re_tweet'             => 'yes',
        'is_carousel'               => 'no',
        'tweet_per_slide'           => '1',
);
