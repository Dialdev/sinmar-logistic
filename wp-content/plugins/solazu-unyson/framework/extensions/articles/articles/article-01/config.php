<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$articles_extension = slz_ext( 'articles' )->get_article('article_01');

$cfg['general'] = array(
    'name'           => __( 'Article 01', 'slz' ),
    'description'    => __( 'Article 01', 'slz' ),
    'small_img'      => array(
        'height' => 70,
        'src'    => $articles_extension->locate_URI('/static/img/thumbnail.png')
    ),
    'large_img'      => array(
        'height' => 214,
        'src'    => $articles_extension->locate_URI('/static/img/thumbnail.png')
    )
);

// default image-size = 'post-thumbnail', else extension on theme
/**
 * $cfg ['image_size'] = array (
	    'large' => '1140x763',
	    'no-image-large' => '1140x763'
	);
 */
$cfg ['image_size'] = array ();
$cfg['title_length'] = 15;

$cfg['excerpt_length'] = 30;
