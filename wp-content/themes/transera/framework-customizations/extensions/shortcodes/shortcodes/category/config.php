<?php

if (! defined ( 'SLZ' )) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
		'title' => esc_html__ ( 'SLZ Category', 'transera' ),
		'description' => esc_html__ ( 'Show list of category.', 'transera' ),
		'tab' => slz()->theme->manifest->get('name'),
		'icon' => 'icon-slzcore-category slz-vc-slzcore',
		'tag' => 'slz_category'
);

$cfg ['styles'] = array (
	'1'  => esc_html__( 'Style 1', 'transera' ),
	'2'  => esc_html__( 'Style 2', 'transera' ),
	'3'  => esc_html__( 'Style 3', 'transera' )
);

$cfg['active_posttype_ext'] = array(
    'slz-posts'       => 'Posts',
    'slz-portfolio'   => 'Portfolio',
    'slz-team'        => 'Team',
    'slz-service'     => 'Service',
    'slz-causes'      => 'Cause',
);

$cfg ['default_value'] = array (
		'style'        				=> '1',
		'block_title' 	    		=> '',
		'block_title_color'     	=> '',
		'block_title_class'			=> 'slz-title-shortcode',
		'sort_by'					=> '',
		'order_sort'        		=> 'ASC',
		'number'   					=> 20,
		'offset_cat'        		=> '',
		'category_list_choose'  	=> '',
		'extra_class'    			=> '',
        'posttype_slug'             => 'slz-posts',
);

foreach ( $cfg['active_posttype_ext'] as $k => $v ) {
    $cfg ['default_value'][str_replace( '-', '_', $k ).'_list_choose'] = '';
}