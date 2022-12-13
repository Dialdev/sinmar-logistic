<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
		'title' => esc_html__ ( 'SLZ Author List', 'slz' ),
		'description' => esc_html__ ( 'List of WP post authors', 'slz' ),
		'tab' => slz()->theme->manifest->get('name'),
		'icon' => 'icon-slzcore-author-list slz-vc-slzcore',
		'tag' => 'slz_author_list'
);

$cfg['sort-author'] = array(
	esc_html__( 'Name', 'slz' )          => 'name',
	esc_html__( 'Post Number', 'slz' )   => 'post_count',
	esc_html__( 'ID Author', 'slz' )     => 'id'
);

$cfg['show_options'] = array(
	esc_html__( 'One Author', 'slz' )       => 'one',
	esc_html__( 'Multiple Author', 'slz' )  => 'multiple'
);

$cfg['yes_no'] = array(
	esc_html__( 'Yes', 'slz' )    => 'yes',
	esc_html__( 'No', 'slz' )     => 'no'
);

$cfg['order-sort'] = array(
	esc_html__( 'ASC', 'slz' )        => 'ASC',
	esc_html__( 'DESC', 'slz' )       => 'DESC'
);

$cfg['role-author'] = array(
	esc_html__( 'None', 'slz' )            => '',
	esc_html__( 'Subscriber', 'slz' )      => 'subscriber',
	esc_html__( 'Contributor', 'slz' )     => 'contributor',
	esc_html__( 'Author', 'slz' )          => 'author',
	esc_html__( 'Editor', 'slz' )          => 'editor',
	esc_html__( 'Administrator', 'slz' )   => 'administrator',
);

$cfg ['default_value'] = array (
	'show_options'          => 'one',
	'user_id'               => '',
	'limit_author'          => '6',
	'sort_by'               => '',
	'order_sort'            => '',
	'role_author'           => '',
	'show_pagination'       => 'yes',
	'extra_class'           => '',
);