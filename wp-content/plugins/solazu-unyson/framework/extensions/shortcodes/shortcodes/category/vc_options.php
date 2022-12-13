<?php
// Get shortcode instance
$shortcode = slz_ext( 'shortcodes' )->get_shortcode( 'category' );
// Extension array
$ext = array(
    'slz_posts'     => slz_ext('posts'),
    'slz_portfolio' => slz_ext('portfolio'),
    'slz_service'   => slz_ext('services'),
    'slz_team'      => slz_ext('teams'),
    'slz_causes'    => slz_ext('donation'),
);
// Get Active Extension Posttype from shortcode config
$active_posttype_ext = $shortcode->get_config( 'active_posttype_ext' );
$posttype_arr = array();
$filter = array();
foreach ($active_posttype_ext as $k => $v) {
    // Check Extension is activated
    if( ! $ext[str_replace( '-', '_', $k )] ) {
        continue;
    }
    $posttype_arr[esc_html($v)] = $k;
    $taxonomy = ( $k == 'slz-posts' ) ? 'category' : $k.'-cat';
    $all_cat = array('empty'   => esc_html__( '-All '.$v.' Categories-', 'slz' ) );
    $list_cat = SLZ_Com::get_tax_options2slug( $taxonomy, $all_cat );
    $filter[] = array(
        'type'       => 'param_group',
        'heading'    => esc_html__( $v, 'slz' ),
        'param_name' => str_replace( '-', '_', $k ).'_list_choose',
        'params'     => array(
            array(
                'type'        => 'dropdown',
                'admin_label' => true,
                'heading'     => esc_html__( 'Add Category', 'slz' ),
                'param_name'  => 'category_slug',
                'value'       => $list_cat,
                'description' => esc_html__( 'Choose category to show.', 'slz'  ),
            ),
        ),
        'value'       => '',
        'dependency'  => array(
            'element'   => 'posttype_slug',
            'value'     => array( $k ),
        ),
        'description' => esc_html__( 'Choose category.', 'slz' ),
        'group'       => esc_html__('Filter', 'slz'),
    );
}
$filter = array_merge(array(
    array(
        'type'        => 'dropdown',
        'admin_label' => true,
        'heading'     => esc_html__( 'Choose Posttype', 'slz' ),
        'param_name'  => 'posttype_slug',
        'value'       => $posttype_arr,
        'description' => esc_html__( 'Choose posttype to filter category.', 'slz'  ),
        'group'       => esc_html__('Filter', 'slz'),
    ),
), $filter);
$sort_cat= SLZ_Params::get('sort-cat');
$order_sort= SLZ_Params::get('order-sort');
$hide_empty= SLZ_Params::get('yes-no');

$params = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Style', 'slz' ),
		'param_name'  => 'style',
		'value'       => $shortcode->get_styles(),
		'std'         => '1',
		'description' => esc_html__( 'Choose style to view category', 'slz' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Title', 'slz' ),
		'param_name'  => 'block_title',
		'value'       => '',
		'description' => esc_html__( 'Title. If it blank the slider will not have a title', 'slz' ),
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Title Color', 'slz' ),
		'param_name'  => 'block_title_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom title text color.', 'slz' ),
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Sort by', 'slz' ),
		'param_name'  => 'sort_by',
		'value'       => $sort_cat,
		'description' => esc_html__( 'Sort category list.', 'slz' )
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Order Sort', 'slz' ),
		'param_name'  => 'order_sort',
		'value'       => $order_sort,
		'description' => esc_html__( 'Order Sort category.', 'slz' ),
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Number', 'slz' ),
		'param_name'  => 'number',
		'value'       => 20,
		'description' => esc_html__( 'Enter number to display.If it blank  the number of category have default value', 'slz' ),
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Offset ', 'slz' ),
		'param_name'  => 'offset_cat',
		'value'       => '',
		'description' => esc_html__( 'Enter offset to display. If you want to start on record 6, using offset 5', 'slz' ),
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Extra Class', 'slz' ),
		'param_name'  => 'extra_class',
		'value'       => '',
		'description' => esc_html__( 'Add extra class to category', 'slz' )
	)
);

$vc_options = array_merge( $params, $filter);