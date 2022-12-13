<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['general'] = array(
	'id'       		 => __( 'about-me', 'slz' ),
	'name' 			 => __( 'SLZ: About Me', 'slz' ),
	'description'    => __( 'About me block.', 'slz' ),
	'classname'		 => 'slz-widget-about-me'
);

$cfg['default_value'] = array(
	'title' 		=> esc_html__( 'About Me', 'slz' ),
	'block_title_color' => '#',
	'name'			=>	'',
	'image'		=>	'',
	'detail'		=>	'',
	'extra_class'	=>	'',
	'facebook'      => '',
	'twitter'       => '',
	'google_plus'   => '',
	'skype'         => '',
	'youtube'       => '',
	'rss'           => '',
	'delicious'     => '',
	'flickr'        => '',
	'lastfm'        => '',
	'linkedin'      => '',
	'vimeo'         => '',
	'tumblr'        => '',
	'pinterest'     => '',
	'deviantart'    => '',
	'git'           => '',
	'instagram'     => '',
	'soundcloud'    => '',
	'stumbleupon'   => '',
	'behance'       => '',
	'tripAdvisor'   => '',
	'vk'            => '',
	'foursquare'    => '',
	'xing'          => '',
	'weibo'         => '',
	'odnoklassniki' => '',
);