<?php if ( ! defined( 'SLZ' ) ) {
	die( 'Forbidden' );
}
/**
 * Theme config
 *
 * @var array $cfg Fill this array with configuration data
 */

$cfg = array();
$cfg['settings_form_side_tabs'] = true;

$cfg['posts_rating'] = array(
);

$cfg['sidebar_mapping'] = array(
	'post'          => 'blog-sidebar',
	'page'          => 'page-sidebar',
	'slz-portfolio' => 'portfolio-sidebar',
	'slz-team'      => 'team-sidebar',
	'slz-service'   => 'service-sidebar',
	'product'       => 'product-sidebar',
	'slz-recruitment'       => 'recruitment-sidebar',
	'archive_slz-portfolio' => 'portfolio-ac-sidebar',
	'archive_slz-service'   => 'service-ac-sidebar',
	'archive_slz-team'      => 'team-ac-sidebar',
	'archive_slz-recruitment' => 'recruitment-ac-sidebar'
);
// post
$cfg['post_template_default'] = array(
	'main-blog-article-style' => 'article_04',
	'archive-article-style'   => 'article_04',
	'category-article-style'  => 'article_04',
	'tag-article-style'       => 'article_04',
	'author-article-style'    => 'article_04',
	'search-article-style'    => 'article_04',
	'blog-layout'             => 'post_05',
);

$cfg['post_info'] = array(
	'hide_main_category'      => '',
);
$cfg['post_format_setting'] = array(
// 	'view'    => '<a href="%1$s" class="link view">' . esc_html__('View: ', 'transera') . '%2$s</a>',
// 	'comment' => '<a href="%1$s" class="link comment">' . esc_html__('Comment: ', 'transera') . '%2$s</a>',
// 	'author'  => '<a href="%1$s" class="link author">' . esc_html__('Posted By: ', 'transera') . '%2$s</a>',
);
$cfg['ribbon_date_format'] = array(
	'day'   => esc_html_x('d','daily posts date format', 'transera'),
	'month' => esc_html_x('M','daily posts date format', 'transera'),
	'year'  => esc_html_x('Y','daily posts date format', 'transera'),
);
$cfg['map_config'] = array(
	'color'    => array(
		array(
			"featureType" => "all",
			"elementType" => "labels.icon",
			"stylers" => array(
				array(
					"visibility" => "off"
				)
			)
		),
		array(
		    "featureType" => "administrative",
		    "elementType" => "all",
		    "stylers" => array(
		    	array(
		        	"visibility" => "simplified"
		        )
		    )
		),
		array(
		    "featureType" => "landscape",
		    "elementType" => "geometry",
		    "stylers" => array(
		    	array(
			        "visibility" => "simplified"
			    ),
			    array(
			        "color" => "#fcfcfc"
		        )
		    )
		),
		array(
		    "featureType" => "poi",
		    "elementType" => "geometry",
		    "stylers" => array(
		    	array(
			        "visibility" => "simplified"
			    ),
			    array(
			        "color" => "#fcfcfc"
			    )
		    )
		),
		array(
		    "featureType" => "road.highway",
		    "elementType" => "geometry",
		    "stylers" => array(
		    	array(
			        "visibility" => "simplified"
			    ),
			    array(
			        "color" => "#dddddd"
			    )
		    )
		),
		array(
		    "featureType" => "road.arterial",
		    "elementType" => "geometry",
		    "stylers" => array(
		    	array(
			        "visibility" => "simplified"
			    ),
			    array(
			        "color" => "#dddddd"
			    )
		    )
		),
		array(
		    "featureType" => "road.local",
		    "elementType" => "geometry",
		    "stylers" => array(
		    	array(
			        "visibility" => "simplified"
			    ),
			    array(
			        "color" => "#eeeeee"
			    )
		    )
		),
		array(
		    "featureType" => "water",
		    "elementType" => "geometry",
		    "stylers" => array(
		    	array(
			        "visibility" => "simplified"
			    ),
			    array(
			        "color" => "#dddddd"
			    )
		    )
		),
	)
);
// Typography & custom color config <<
$cfg['typography_settings'] = array(
	'typo-body' => 'body',
	'typo-paragraph' => 'p',
	'typo-h1' => 'h1, .entry-content h1',
	'typo-h2' => 'h2, .entry-content h2',
	'typo-h3' => 'h3, .entry-content h3',
	'typo-h4' => 'h4, .entry-content h4',
	'typo-h5' => 'h5, .entry-content h5',
	'typo-h6' => 'h6, .entry-content h6',
);
// Some of suggest colors for theme
$cfg['site_default_colors'] = array(
	'color_1' => '#db0f31',
	'color_2' => '#ffb400',
	'color_3' => '#f97220',
	'color_4' => '#ff6b6b',
	'color_5' => '#50b9ce',
	'color_6' => '#0b60a9',

);
// This config to setting color to theme ( key => default color, label, desc )
$cfg['site_custom_colors'] = array(
	'main-color'    => array('#db0f31', esc_html__( 'Main Color', 'transera' ), esc_html__( 'Select the main color', 'transera' ) ),
);
// >> Typography & custom color config