<?php if ( ! defined( 'SLZ' ) ) {
	die( 'Forbidden' );
}


$article_ext = slz_ext('articles');

$default = array(
	'default'	=>	array(
		'small' => array(
			'height' => 70,
			'src'    => TRANSERA_OPTION_IMG_URI . '/default.png'
		),
		'large' => array(
			'height' => 214,
			'src'    => TRANSERA_OPTION_IMG_URI . '/default.png'
		),
	)
);

$regist_sidebars = array_merge( array( '' => esc_html__('-- Default --', 'transera') ), SLZ_Com::get_regist_sidebars() );

$options = array(

	'category-article-style' => array(
		'label' => esc_html__( 'Article Style', 'transera' ),
		'type'    => 'image-picker',
		'choices' => array_merge( $default, $article_ext->get_article_choices() ),
		'value' => 'default'
	),
	'category-sidebar-layout'    => array(
		'label' => esc_html__( 'Sidebar Layout', 'transera' ),
		'desc'  => esc_html__( 'Set how to display blog sidebar.', 'transera' ),
		'type'  => 'image-picker',
		'choices' => array_merge( $default, array(
			'left' => array(
				'small' => array(
					'height' => 50,
					'src'    => TRANSERA_OPTION_IMG_URI . '/sidebar/left.png'
				)
			),
			'right' => array(
				'small' => array(
					'height' => 50,
					'src'    => TRANSERA_OPTION_IMG_URI . '/sidebar/right.png'
				)
			),
			'none' => array(
				'small' => array(
					'height' => 50,
					'src'    => TRANSERA_OPTION_IMG_URI . '/sidebar/full.png'
				)
			),
		) ),
		'value' => 'default'
	),
	'category-sidebar'  =>  array(
		'type'  => 'select',
		'label' => esc_html__('Choose Sidebar', 'transera'),
		'desc'  => esc_html__('You can create new sidebar in','transera').' <br><a href="' . esc_url( admin_url( 'widgets.php' ) ) . '" >'.esc_html__('Appearance','transera').' > '.esc_html__('Widgets','transera').'</a>',
		'choices' => $regist_sidebars,
		'value' => 'default'
	),

);