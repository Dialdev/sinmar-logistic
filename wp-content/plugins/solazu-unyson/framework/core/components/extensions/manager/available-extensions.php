<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$thumbnails_uri = slz_get_framework_directory_uri( '/core/components/extensions/manager/static/img/thumbnails' );
$github_account = 'ThemeFuse';

$extensions = array(
	'wp-shortcodes' => array(
		'display'     => true,
		'parent'      => 'shortcodes',
		'name'        => __( 'WordPress Shortcodes', 'slz' ),
		'description' => __(
			'Lets you insert Unyson shortcodes inside any wp-editor',
			'slz'
		),
		'thumbnail'   => $thumbnails_uri . '/wp-shortcodes.jpg',
		'download'    => array(
			'source' => 'github',
			'opts' => array(
				'user_repo' => 'ThemeFuse/Unyson-WP-Shortcodes-Extension',
			),
		),
	),

	'backups' => array(
		'display'     => true,
		'parent'      => null,
		'name'        => __( 'Backup & Demo Content', 'slz' ),
		'description' => __( 'This extension lets you create an automated backup schedule, import demo content or even create a demo content archive for migration purposes.', 'slz' ),
		'thumbnail'   => $thumbnails_uri . '/backups.jpg',
		'download'    => array(
			'source' => 'github',
			'opts' => array(
				'user_repo' => $github_account . '/Unyson-Backups-Extension',
			),
		),
	),

	'slider' => array(
		'display'     => true,
		'parent'      => 'media',
		'name'        => __( 'Sliders', 'slz' ),
		'description' => __( 'Adds a sliders module to your website from where you\'ll be able to create different built in jQuery sliders for your homepage and rest of the pages.', 'slz' ),
		'thumbnail'   => $thumbnails_uri . '/sliders.jpg',
		'download'    => array(
			'source' => 'github',
			'opts' => array(
				'user_repo' => $github_account . '/Unyson-Sliders-Extension',
			),
		),
	),

	'portfolio' => array(
		'display'     => true,
		'parent'      => null,
		'name'        => __( 'Portfolio', 'slz' ),
		'description' => __( 'This extension will add a fully fledged portfolio module that will let you display your projects using the built in portfolio pages.', 'slz' ),
		'thumbnail'   => $thumbnails_uri . '/portfolio.jpg',
		'download'    => array(
			'source' => 'github',
			'opts' => array(
				'user_repo' => $github_account . '/Unyson-Portfolio-Extension',
			),
		),
	),

	'megamenu' => array(
		'display'     => true,
		'parent'      => null,
		'name'        => __( 'Mega Menu', 'slz' ),
		'description' => __( 'The Mega Menu extension adds a user-friendly drop down menu that will let you easily create highly customized menu configurations.', 'slz' ),
		'thumbnail'   => $thumbnails_uri . '/mega-menu.jpg',
		'download'    => array(
			'source' => 'github',
			'opts' => array(
				'user_repo' => $github_account . '/Unyson-MegaMenu-Extension',
			),
		),
	),

	'breadcrumbs' => array(
		'display'     => true,
		'parent'      => null,
		'name'        => __( 'Breadcrumbs', 'slz' ),
		'description' => __( 'Creates a simplified navigation menu for the pages that can be placed anywhere in the theme. This will make navigating the website much easier.', 'slz' ),
		'thumbnail'   => $thumbnails_uri . '/breadcrumbs.jpg',
		'download'    => array(
			'source' => 'github',
			'opts' => array(
				'user_repo' => $github_account . '/Unyson-Breadcrumbs-Extension',
			),
		),
	),

	'seo' => array(
		'display'     => true,
		'parent'      => null,
		'name'        => __( 'SEO', 'slz' ),
		'description' => __( 'This extension will enable you to have a fully optimized WordPress website by adding optimized meta titles, keywords and descriptions.', 'slz' ),
		'thumbnail'   => $thumbnails_uri . '/seo.jpg',
		'download'    => array(
			'source' => 'github',
			'opts' => array(
				'user_repo' => $github_account . '/Unyson-SEO-Extension',
			),
		),
	),

	'events' => array(
		'display'     => true,
		'parent'      => null,
		'name'        => __( 'Events', 'slz' ),
		'description' => __( 'This extension adds a fully fledged Events module to your theme. It comes with built in pages that contain a calendar where events can be added.', 'slz' ),
		'thumbnail'   => $thumbnails_uri . '/events.jpg',
		'download'    => array(
			'source' => 'github',
			'opts' => array(
				'user_repo' => $github_account . '/Unyson-Events-Extension',
			),
		),
	),

	'analytics' => array(
		'display'     => true,
		'parent'      => null,
		'name'        => __( 'Analytics', 'slz' ),
		'description' => __( 'Enables the possibility to add the Google Analytics tracking code that will let you get all the analytics about visitors, page views and more.', 'slz' ),
		'thumbnail'   => $thumbnails_uri . '/analytics.jpg',
		'download'    => array(
			'source' => 'github',
			'opts' => array(
				'user_repo' => $github_account . '/Unyson-Analytics-Extension',
			),
		),
	),

	'feedback' => array(
		'display'     => true,
		'parent'      => null,
		'name'        => __( 'Feedback', 'slz' ),
		'description' => __( 'Adds the possibility to leave feedback (comments, reviews and rating) about your products, articles, etc. This replaces the default comments system.', 'slz' ),
		'thumbnail'   => $thumbnails_uri . '/feedback.jpg',
		'download'    => array(
			'source' => 'github',
			'opts' => array(
				'user_repo' => $github_account . '/Unyson-Feedback-Extension',
			),
		),
	),

	'learning' => array(
		'display'     => true,
		'parent'      => null,
		'name'        => __( 'Learning', 'slz' ),
		'description' => __( 'This extension adds a Learning module to your theme. Using this extension you can add courses, lessons and tests for your users to take.', 'slz' ),
		'thumbnail'   => $thumbnails_uri . '/learning.jpg',
		'download'    => array(
			'source' => 'github',
			'opts' => array(
				'user_repo' => $github_account . '/Unyson-Learning-Extension',
			),
		),
	),

	'shortcodes' => array(
		'display'     => false,
		'parent'      => null,
		'name'        => __( 'Shortcodes', 'slz' ),
		'description' => '',
		'thumbnail'   => 'about:blank',
		'download'    => array(
			'source' => 'github',
			'opts' => array(
				'user_repo' => $github_account . '/Unyson-Shortcodes-Extension',
			),
		),
	),

	'builder' => array(
		'display'     => false,
		'parent'      => null,
		'name'        => __( 'Builder', 'slz' ),
		'description' => '',
		'thumbnail'   => 'about:blank',
		'download'    => array(
			'source' => 'github',
			'opts' => array(
				'user_repo' => $github_account . '/Unyson-Builder-Extension',
			),
		),
	),

	'forms' => array(
		'display'     => false,
		'parent'      => null,
		'name'        => __( 'Forms', 'slz' ),
		'description' => __( 'This extension adds the possibility to create a contact form. Use the drag & drop form builder to create any contact form you\'ll ever want or need.', 'slz' ),
		'thumbnail'   => $thumbnails_uri . '/forms.jpg',
		'download'    => array(
			'source' => 'github',
			'opts' => array(
				'user_repo' => $github_account . '/Unyson-Forms-Extension',
			),
		),
	),

	'mailer' => array(
		'display'     => false,
		'parent'      => null,
		'name'        => __( 'Mailer', 'slz' ),
		'description' => __( 'This extension will let you set some global email options and it is used by other extensions (like Forms) to send emails.', 'slz' ),
		'thumbnail'   => $thumbnails_uri . '/mailer.jpg',
		'download'    => array(
			'source' => 'github',
			'opts' => array(
				'user_repo' => $github_account . '/Unyson-Mailer-Extension',
			),
		),
	),

	'social' => array(
		'display'     => true,
		'parent'      => null,
		'name'        => __( 'Social', 'slz' ),
		'description' => __( 'Use this extension to configure all your social related APIs. Other extensions will use the Social extension to connect to your social accounts.', 'slz' ),
		'thumbnail'   => $thumbnails_uri . '/social.jpg',
		'download'    => array(
			'source' => 'github',
			'opts' => array(
				'user_repo' => $github_account . '/Unyson-Social-Extension',
			),
		),
	),

	'backup' => array(
		'display'     => true,
		'parent'      => null,
		'name'        => __( 'Backup', 'slz' ),
		'description' => __( 'This extension lets you set up daily, weekly or monthly backup schedule. You can choose between a full backup or a data base only backup.', 'slz' ),
		'thumbnail'   => $thumbnails_uri . '/backup.jpg',
		'download'    => array(
			'source' => 'github',
			'opts' => array(
				'user_repo' => $github_account . '/Unyson-Backup-Extension',
			),
		),
	),

	'media' => array(
		'display'     => false,
		'parent'      => null,
		'name'        => __( 'Media', 'slz' ),
		'description' => '',
		'thumbnail'   => 'about:blank',
		'download'    => array(
			'source' => 'github',
			'opts' => array(
				'user_repo' => $github_account . '/Unyson-Empty-Extension',
			),
		),
	),

	'population-method' => array(
		'display'     => false,
		'parent'      => 'media',
		'name'        => __( 'Population method', 'slz' ),
		'description' => '',
		'thumbnail'   => 'about:blank',
		'download'    => array(
			'source' => 'github',
			'opts' => array(
				'user_repo' => $github_account . '/Unyson-PopulationMethods-Extension',
			),
		),
	),

	'styling' => array(
		'display'     => true,
		'parent'      => null,
		'name'        => __( 'Styling', 'slz' ),
		'description' => __( 'This extension lets you control the website visual style. Starting from predefined styles to changing specific fonts and colors across the website.', 'slz' ),
		'thumbnail'   => $thumbnails_uri . '/styling.jpg',
		'download'    => array(
			'source' => 'github',
			'opts' => array(
				'user_repo' => $github_account . '/Unyson-Styling-Extension',
			),
		),
	),

	'translation' => array(
		'display'     => true,
		'parent'      => null,
		'name'        => __( 'Translations', 'slz' ),
		'description' => __( 'This extension lets you translate your website in any language or even add multiple languages for your users to change at their will from the front-end.', 'slz' ),
		'thumbnail'   => $thumbnails_uri . '/translation.jpg',
		'download'    => array(
			'source' => 'github',
			'opts' => array(
				'user_repo' => $github_account . '/Unyson-Translation-Extension',
			)
		),
	),
);

