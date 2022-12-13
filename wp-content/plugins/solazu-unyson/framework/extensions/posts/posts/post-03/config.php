<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$posts_extension = slz_ext( 'posts' )->get_post('post_03');

$cfg['general'] = array(
	'name' 			 => __( 'Post 03', 'slz' ),
	'description'    => __( 'Post 03', 'slz' ),
	'small_img'  	 => array(
        'height' => 70,
        'src'    => $posts_extension->locate_URI('/static/img/thumbnail.png')
    ),
    'large_img'  	 => array(
        'height' => 214,
        'src'    => $posts_extension->locate_URI('/static/img/thumbnail.png')
    )
);
// set blank to get post-thumnail
$cfg ['image_size'] = array (
	//'large' => '800x500',
);
$cfg ['related_image_size'] = array (
	'large' => '370x180',
);

$cfg['title_length'] = 15;

$cfg['excerpt_length'] = 30;
