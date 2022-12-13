<?php

$showemedia = SLZ_Params::get('yes-no');
$show_re_tweet = SLZ_Params::get('yes-no');
$yes_no = array(
    esc_html__( 'Yes', 'slz' ) => 'yes',
    esc_html__( 'No', 'slz' ) =>  'no'
);

$vc_options = array(
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Block Title', 'slz' ),
		'param_name'  => 'block_title',
		'value'       => '',
		'description' => esc_html__( 'Block title. If it blank the block will not have a title', 'slz' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Block Title Color', 'slz' ),
		'param_name'  => 'block_title_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom title text color.', 'slz' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Number Tweets', 'slz' ),
		'param_name'  => 'limit_tweet',
		'value'       => '6',
		'description' => esc_html__( 'The number of tweets to display.', 'slz' )
	),
    array(
        'type'        => 'dropdown',
        'heading'     => esc_html__( "Show Tweet's media", 'slz' ),
        'param_name'  => 'show_media',
        'value'       => $showemedia,
        'description' => esc_html__( "Choose if you want to show Tweet's media or not.", 'slz' )
    ),
    array(
        'type'        => 'dropdown',
        'heading'     => esc_html__( "Show Re-Tweet", 'slz' ),
        'param_name'  => 'show_re_tweet',
        'value'       => $show_re_tweet,
        'description' => esc_html__( "Choose if you want to show Re-Tweet.", 'slz' )
    ),
    array(
        'type'        => 'dropdown',
        'heading'     => esc_html__( 'Is Carousel?', 'slz' ),
        'param_name'  => 'is_carousel',
        'value'       => $yes_no,
        'std'         => 'no',
        'description' => esc_html__( 'Choose if you want display tweets list as carousel.', 'slz' )
    ),
    array(
        'type'        => 'textfield',
        'heading'     => esc_html__( 'Number Tweets per Slide', 'slz' ),
        'param_name'  => 'tweet_per_slide',
        'value'       => '1',
        'dependency'  => array(
            'element' => 'is_carousel',
            'value'   => array( 'yes' ),
        ),
        'description' => esc_html__( 'The number of tweets per slide to display.', 'slz' )
    ),
    array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Extra Class', 'slz' ),
		'param_name'  => 'extra_class',
		'value'       => '',
		'description' => esc_html__( 'Add extra class to block', 'slz' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Account Name', 'slz' ),
		'param_name'  => 'screen_name',
		'value'       => '',
		'description' => esc_html__( 'Enter the ID as it appears after the twitter url (ex. https://twitter.com/myID).', 'slz' ),
		'group'       => esc_html__('Channel', 'slz')
	),
);