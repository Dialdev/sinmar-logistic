<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$params = array(
	'shortcode_filter' => array(
		array(
			'type'       => 'param_group',
			'heading'    => esc_html__( 'Category', 'slz' ),
			'param_name' => 'category_list',
			'params'     => array(
				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Add Category', 'slz' ),
					'param_name'  => 'category_slug',
					'value'       => SLZ_Com::get_category2slug_array(),
					'description' => esc_html__( 'Choose special category to filter', 'slz'  )
				),
			),
			'value'       => '',
			'description' => esc_html__( 'Default no filter by category.', 'slz' ),
			'group'       => esc_html__('Filter', 'slz')
		),
		array(
			'type'       => 'param_group',
			'heading'    => esc_html__( 'Tag', 'slz' ),
			'param_name' => 'tag_list',
			'params'     => array(
				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Add Tag', 'slz' ),
					'param_name'  => 'tag_slug',
					'value'       => SLZ_Com::get_tax_options2slug( 'post_tag', array('empty' => esc_html__( '-All tags-', 'slz' )) ),
					'description' => esc_html__( 'Choose special tag to filter', 'slz'  )
				),
			),
			'value'       => '',
			'description' => esc_html__( 'Default no filter by tag.', 'slz' ),
			'group'       => esc_html__('Filter', 'slz')
		),
		
		array(
			'type'       => 'param_group',
			'heading'    => esc_html__( 'Author', 'slz' ),
			'param_name' => 'author_list',
			'params'     => array(
				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Add Author', 'slz' ),
					'param_name'  => 'author',
					'value'       => SLZ_Com::get_user_login2id(array(), array('empty' => esc_html__( '-All authors-', 'slz' )) ),
					'description' => esc_html__( 'Choose special author to filter', 'slz'  )
				),
			),
			'value'       => '',
			'description' => esc_html__( 'Default no filter by author.', 'slz' ),
			'group'       => esc_html__('Filter', 'slz')
		),
		array(
			'type'       => 'param_group',
			'heading'    => esc_html__( 'Post format', 'slz' ),
			'param_name' => 'post_format',
			'params'     => array(
				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Add post format', 'slz' ),
					'param_name'  => 'format_type',
					'value'       => array( 
										esc_html__( '- No filter -', 'slz' )   => '',
										esc_html__( 'Video', 'slz' ) 			=> 'post-format-video',
										esc_html__( 'Image', 'slz' ) 			=> 'post-format-image'
									),
					'description' => esc_html__( 'Choose special post format to filter', 'slz'  )
				),
			),
			'value'       => '',
			'description' => esc_html__( 'Default no filter by post format.', 'slz' ),
			'group'       => esc_html__('Filter', 'slz')
		),
	),
	'shortcode_paging' => array(
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Pagination', 'slz' ),
			'param_name'  => 'pagination',
			'value'       => array(
				esc_html__( '-No paging-', 'slz' )          => '',
				esc_html__( 'Ajax Paging', 'slz' )          => 'ajax',
				esc_html__( 'Next Prev Paging', 'slz' )     => 'next-prev',
				esc_html__( 'Load More Button', 'slz' )     => 'load_more',
				esc_html__( 'Paging ( Load Page )', 'slz' ) => 'yes'
			),
			'description' => esc_html__( 'Show pagination.', 'slz' ),
			'group'       => esc_html__('Pagination', 'slz')
		)
	),
	'shortcode_paging_no_load_more' => array(
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Pagination', 'slz' ),
			'param_name'  => 'pagination',
			'value'       => array(
				esc_html__( '-No paging-', 'slz' )          => '',
				esc_html__( 'Ajax Paging', 'slz' )          => 'ajax',
				esc_html__( 'Next Prev Paging', 'slz' )     => 'next-prev',
				esc_html__( 'Paging ( Load Page )', 'slz' ) => 'yes'
			),
			'description' => esc_html__( 'Show pagination.', 'slz' ),
			'group'       => esc_html__('Pagination', 'slz')
		)
	),
	'shortcode_ajax_filter' => array(
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Ajax Dropdown - Filter default text', 'slz' ),
			'param_name'  => 'category_filter_text',
			'value'       => esc_html__('All', 'slz'),
			'dependency' => array(
				'element' => 'pagination',
				'value_not_equal_to' => array( 'yes' ),
			),
			'description' => esc_html__( 'The default text for first item.', 'slz' ),
			'group'       => esc_html__('Ajax Filter', 'slz')
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Show Ajax Dropdown - Filter type', 'slz' ),
			'param_name'  => 'category_filter',
			'value'       => array(
								esc_html__( '- No filter -', 'slz' )         => '',
								esc_html__( 'Filter by categories', 'slz' )  => 'category',
								esc_html__( 'Filter by authors', 'slz' )     => 'author',
								esc_html__( 'Filter by tag slug', 'slz' )    => 'tag_slug'
							),
			'dependency' => array(
				'element' => 'pagination',
				'value_not_equal_to' => array( 'yes' ),
			),
			'description' => esc_html__( 'Show the ajax dropdown filter. If no items are seleted in "Filter" tab, the ajax dropdown filter will show all items ( ex: all categories, all tags, all author )', 'slz' ),
			'group'       => esc_html__('Ajax Filter', 'slz')
		)
	),
	'sort_blog'		=> array(
		esc_html__( '- Latest -', 'slz' )               => '',
		esc_html__( 'A to Z', 'slz' )                   => 'az_order',
		esc_html__( 'Z to A', 'slz' )                   => 'za_order',
		esc_html__( 'Random posts today', 'slz' )       => 'random_today',
		esc_html__( 'Random posts a week ago', 'slz' )  => 'random_7_day',
		esc_html__( 'Random posts a month ago', 'slz' ) => 'random_month',
		esc_html__( 'Random Posts', 'slz' )             => 'random_posts',
		esc_html__( 'Most Commented', 'slz' )           => 'comment_count',
		esc_html__( 'Popular', 'slz' )                  => 'popular',
	),
	'meta_icon' => array(
		'date'    => 'fa fa-clock-o',
		'author'  => 'fa fa-user',
		'view'    => 'fa fa-eye',
		'comment' => 'fa fa-comments',
		'like'    => 'fa fa-thumbs-o-up',
	),
);