<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$top_posts_extension = slz_ext( 'top-posts' )->get_top_post('top_posts_04');

$cfg['general'] = array(
    'name'           => __( 'Top Post 04', 'slz' ),
    'description'    => __( 'Top Post 04', 'slz' ),
    'small_img'      => array(
        'height' => 70,
        'src'    => $top_posts_extension->locate_URI('/static/img/thumbnail.png')
    ),
    'large_img'      => array(
        'height' => 214,
        'src'    => $top_posts_extension->locate_URI('/static/img/thumbnail.png')
    )
);

// default image-size = 'post-thumbnail', else extension on theme
$cfg ['image_size'] = array (
	'large'          => '770x460',
	'no-image-large' => '770x460',
	'small'          => '800x400',
	'no-image-small' => '800x400',
);
$cfg['title_length'] = 15;

$cfg['excerpt_length'] = 30;
