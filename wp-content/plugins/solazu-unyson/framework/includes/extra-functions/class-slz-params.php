<?php
/**
 * Core params class.
 * 
 * @author Swlabs
 * @since 1.0
 */
class SLZ_Params {
	/**
	 * Retrieve value from the params variable.
	 *
	 * @param string $name The key name of first level.
	 * @param string $field optional The key name of second level.
	 * @return mixed.
	 */
	public static function get( $name, $field = NULL ) {
		//get param from special function
		if ( method_exists( __CLASS__, $name ) ) {
			$params = call_user_func( array(__CLASS__, $name) );
			if( $field ) {
				return ( isset( $params[ $field ] ) ) ? $params[ $field ] : null;
			} else {
				return $params;
			}
		}
		//get param from setting function
		if ( method_exists( __CLASS__, 'setting' ) ) {
			$setting_params = call_user_func( array(__CLASS__, 'setting') );
			if(isset( $setting_params[ $name ] )  ) {
				if( $field ) {
					if( isset($setting_params[ $name ][ $field ]) ){
						return $setting_params[ $name ][ $field ];
					} else {
						return null;
					}
				} else {
					return $setting_params[ $name ];
				}
			}
		}
		return array();
	}


	public static function setting() {
		return array(
			//************* Theme Option << *************
			'option-bg-attachment' => array(
				''          => esc_html__('Initial','slz'),
				'fixed'     => esc_html__('Fixed','slz'),
			),
			'option-bg-size' => array(
				''          => esc_html__('Initial','slz'),
				'cover'     => esc_html__('Cover','slz'),
				'contain'   => esc_html__('Contain','slz'),
			),
			'option-bg-position'   => array(
				''                 => esc_html__('Initial','slz'),
				'left top'         => esc_html__('Left Top','slz'),
				'left center'      => esc_html__('Left Center','slz'),
				'left bottom'      => esc_html__('Left Bottom','slz'),
				'right top'        => esc_html__('Right Top','slz'),
				'right center'     => esc_html__('Right Center','slz'),
				'right bottom'     => esc_html__('Right Bottom','slz'),
				'center top'       => esc_html__('Center Top','slz'),
				'center center'    => esc_html__('Center Center','slz'),
				'center bottom'    => esc_html__('Center Bottom','slz'),
			),
			//************* Shortcode << ****************
			'animation' => array(
				esc_html__('None', 'slz')       => 'none',
				esc_html__('bounce', 'slz') => 'bounce',
				esc_html__('flash', 'slz')  => 'flash',
				esc_html__('pulse', 'slz')  => 'pulse',
				esc_html__('rubberBand', 'slz')  => 'rubberBand',
				esc_html__('shake', 'slz')        => 'shake',
				esc_html__('swing', 'slz')       => 'swing',
				esc_html__('tada', 'slz')         => 'tada',
				esc_html__('wobble', 'slz')       => 'wobble',
				esc_html__('jello', 'slz')        => 'jello',
				esc_html__('bounceIn', 'slz')     => 'bounceIn',
				esc_html__('bounceInDown', 'slz')    => 'bounceInDown',
				esc_html__('bounceInLeft', 'slz')     => 'bounceInLeft',
				esc_html__('bounceInRigth', 'slz')    => 'bounceInRigth',
				esc_html__('bounceInUp', 'slz')      => 'bounceInUp',
				esc_html__('bounceOut', 'slz')       => 'bounceOut',
				esc_html__('bounceOutDown', 'slz')   => 'bounceOutDown',
				esc_html__('bounceOutLeft', 'slz')  => 'bounceOutLeft',
				esc_html__('bounceOutRigth', 'slz') => 'bounceOutRigth',
				esc_html__('bounceOutUp', 'slz')    => 'bounceOutUp',
				esc_html__('faceIn', 'slz')         => 'faceIn',
				esc_html__('faceInDown', 'slz')     => 'faceInDown',
				esc_html__('faceInLeft', 'slz')      => 'faceInLeft',
				esc_html__('faceInRight', 'slz')     => 'faceInRight',
				esc_html__('faceInUp', 'slz')        => 'faceInUp',
				esc_html__('faceOut', 'slz')         => 'faceOut',
				esc_html__('faceOutDown', 'slz')     => 'faceOutDown',
				esc_html__('faceOutDownBig', 'slz')  => 'faceOutDownBig',
				esc_html__('faceOutLeft', 'slz')     => 'faceOutLeft',
				esc_html__('faceOutLeftBig', 'slz')  => 'faceOutLeftBig',
				esc_html__('faceOutRight', 'slz')    => 'faceOutRight',
				esc_html__('faceOutRightBig', 'slz') => 'faceOutRightBig',
				esc_html__('faceOutUp', 'slz')       => 'faceOutUp',
				esc_html__('faceOutUpBig', 'slz')    => 'faceOutUpBig',
				esc_html__('flip', 'slz')        => 'flip',
				esc_html__('flipInX', 'slz')     => 'flipInX',
				esc_html__('flipInY', 'slz')     => 'flipInY',
				esc_html__('flipOutX', 'slz')    => 'flipOutX',
				esc_html__('flipOutY', 'slz')    => 'flipOutY',
				esc_html__('lightSpeedIn', 'slz')    => 'lightSpeedIn',
				esc_html__('lightSpeedOut', 'slz')   => 'lightSpeedOut',
				esc_html__('rotateIn', 'slz')          => 'rotateIn',
				esc_html__('rotateInDownLeft', 'slz')  => 'rotateInDownLeft',
				esc_html__('rotateInDownRight', 'slz') => 'rotateInDownRight',
				esc_html__('rotateInUpLeft', 'slz')    => 'rotateInUpLeft',
				esc_html__('rotateInUpLeft', 'slz')    => 'rotateInUpLeft',
				esc_html__('rotateOut', 'slz')          => 'rotateOut',
				esc_html__('rotateOutDownLeft', 'slz')  => 'rotateOutDownLeft',
				esc_html__('rotateOutDownRight', 'slz') => 'rotateOutDownRight',
				esc_html__('rotateOutUpLeft', 'slz')    => 'rotateOutUpLeft',
				esc_html__('rotateOutUpLeft', 'slz')    => 'rotateOutUpLeft',
				esc_html__('slideInUp', 'slz') => 'slideInUp',
				esc_html__('slideInDown', 'slz') => 'slideInDown',
				esc_html__('slideInLeft', 'slz') => 'slideInLeft',
				esc_html__('slideInRight', 'slz') => 'slideInRight',
				esc_html__('slideOutUp', 'slz') => 'slideOutUp',
				esc_html__('slideOutDown', 'slz') => 'slideOutDown',
				esc_html__('slideOutLeft', 'slz') => 'slideOutLeft',
				esc_html__('slideOutRight', 'slz') => 'slideOutRight',
				esc_html__('zoomIn', 'slz') => 'zoomIn',
				esc_html__('zoomInDown', 'slz') => 'zoomInDown',
				esc_html__('zoomInLeft', 'slz') => 'zoomInLeft',
				esc_html__('zoomInRight', 'slz') => 'zoomInRight',
				esc_html__('zoomInUp', 'slz') => 'zoomInUp',
				esc_html__('zoomOut', 'slz') => 'zoomOut',
				esc_html__('zoomOutDown', 'slz') => 'zoomOutDown',
				esc_html__('zoomOutLeft', 'slz') => 'zoomOutLeft',
				esc_html__('zoomOutRight', 'slz') => 'zoomOutRight',
				esc_html__('zoomOutUp', 'slz') => 'zoomOutUp',
				esc_html__('hinge', 'slz') => 'hinge',
				esc_html__('rollln', 'slz') => 'rollln',
				esc_html__('rollOut', 'slz') => 'rollOut'
			),
			'icon-type-no-img' => array(
				esc_html__( 'Visual Composer', 'slz' )  => '',
				esc_html__( 'Font Flat Icon', 'slz' )   => '02',
			),

			'icon-type' => array(
				esc_html__( 'Visual Composer', 'slz' )  => '',
				esc_html__( 'Image Upload', 'slz')       => '02',
				esc_html__( 'Font Flat Icon', 'slz' )   => '03',
			),
			'h-tag'=>array(
				'H1'=>'h1',
				'H2'=>'h2',
				'H3'=>'h3',
				'H4'=>'h4',
				'H5'=>'h5',
				'H6'=>'h6',
			),
			'text-transform' => array(
				esc_html__('None', 'slz')       => 'none',
				esc_html__('Capitalize', 'slz') => 'capitalize',
				esc_html__('Uppercase', 'slz')  => 'uppercase',
				esc_html__('Lowercase', 'slz')  => 'lowercase',
				esc_html__('Initial', 'slz')    => 'initial',
				esc_html__('Inherit', 'slz')    => 'inherit',
			),
			'sort-blog' => array(
				esc_html__( '- Latest -', 'slz' )               => '',
				esc_html__( 'A to Z', 'slz')                    => 'az_order',
				esc_html__( 'Z to A', 'slz')                    => 'za_order',
				esc_html__( 'Random posts today', 'slz' )       => 'random_today',
				esc_html__( 'Random posts a week ago', 'slz' )  => 'random_7_day',
				esc_html__( 'Random posts a month ago', 'slz' ) => 'random_month',
				esc_html__( 'Random Posts', 'slz' )             => 'random_posts',
				esc_html__( 'Most Commented', 'slz' )           => 'comment_count',
			),
			'sort-custom' => array(
				esc_html__( '- Latest -', 'slz' )  => '',
				esc_html__('A to Z', 'slz')        => 'az_order',
				esc_html__('Z to A', 'slz')        => 'za_order',
				esc_html__('Random', 'slz')        => 'random_posts',
			),
			'sort-other' => array(
				esc_html__( '- Latest -', 'slz' )     => '',
				esc_html__('A to Z', 'slz')           => 'az_order',
				esc_html__('Z to A', 'slz')           => 'za_order',
				esc_html__('Post is selected', 'slz') => 'post__in',
				esc_html__('Random', 'slz')           => 'random_posts',
			),
			'align'=>array(
				esc_html__( 'Left', 'slz' )   => 'left',
				esc_html__( 'Right', 'slz' )  => 'right',
				esc_html__( 'Center', 'slz' ) => 'center',
			),
			'block_column'=>array(
				esc_html__('One', 'slz')   => '1',
				esc_html__('Two', 'slz')   => '2',
				esc_html__('Three', 'slz') => '3',
				esc_html__('Four', 'slz')  => '4',
			),
			'order-sort' =>array(
				esc_html__( 'ASC', 'slz' )          	 	 => 'ASC',
				esc_html__( 'DESC', 'slz' )           		 => 'DESC'
			),
			'yes-no'=>array(
				esc_html__( 'Yes', 'slz' )          	 	 => 1,
				esc_html__( 'No', 'slz' )           	     => 0
			),
			'sort-cat'=>array(
				esc_html__( 'Default', 'slz' )          	 => '',
				esc_html__( 'Name', 'slz' )          	 	 => 'name',
				esc_html__( 'Slug', 'slz' )         		 => 'slug',
				esc_html__( 'Term Group', 'slz' )           => 'term_group',
				esc_html__( 'Term ID', 'slz' )          	 => 'term_id',
				esc_html__( 'ID', 'slz' )         		 	 =>  'id',
				esc_html__( 'Description', 'slz' )          =>  'description'
			),
			'social-counter' => array(
				'facebook'		=> 'fa-facebook',
				'youtube'		=> 'fa fa-youtube',
				'twitter'		=> 'fa-twitter',
				'google'		=> 'fa-google-plus',
				'vimeo'			=> 'fa fa-vimeo',
				'soundcloud'	=> 'fa fa-soundcloud',
				'instagram'		=> 'fa fa-instagram',
				'rss'			=> 'fa fa-rss'
			),
			//************* Shortcode >> ****************
			'video-type' => array(
				''              => esc_html__( 'None', 'slz'),
				'vimeo'         => esc_html__( 'Vimeo', 'slz'),
				'youtube'       => esc_html__( 'Youtube', 'slz'),
			),
			// social icon
			'social-icons' =>array(
				'facebook'      => 'fa-facebook',
				'twitter'       => 'fa-twitter',
				'google-plus'   => 'fa-google-plus',
				'skype'         => 'fa-skype',
				'youtube'       => 'fa-youtube',
				'rss'           => 'fa-rss',
				'delicious'     => 'fa-delicious',
				'flickr'        => 'fa-flickr',
				'lastfm'        => 'fa-lastfm',
				'linkedin'      => 'fa-linkedin',
				'vimeo'         => 'fa-vimeo',
				'tumblr'        => 'fa-tumblr',
				'pinterest'     => 'fa-pinterest',
				'deviantart'    => 'fa-deviantart',
				'git'           => 'fa-git',
				'instagram'     => 'fa-instagram',
				'soundcloud'    => 'fa-soundcloud',
				'stumbleupon'   => 'fa-stumbleupon',
				'behance'       => 'fa-behance',
				'tripAdvisor'   => 'fa-tripadvisor',
				'vk'            => 'fa-vk',
				'foursquare'    => 'fa-foursquare',
				'xing'          => 'fa-xing',
				'weibo'         => 'fa-weibo',
				'odnoklassniki' => 'fa-odnoklassniki',
			),
		);
	}
	/**
	 * Using SLZ_Params::get('block_image_size', $field)
	 *
	 * @return array
	 */
	public static function block_image_size() {
		return array(
			// 'testimonial'			=> array( 'large' => '240x350', 'small' => '100x100' ),
			// 'team'					=> array( 'large' => '800x1215', 'small' => '270x410' ),
		);
	}
	/**
	 * Using SLZ_Params::get('params_social', $field)
	 *   or  SLZ_Params::params_social()
	 * 
	 * @return array
	 */
	public static function params_social () {
		return array(
			'facebook'      => 'Facebook',
			'twitter'       => 'Twitter',
			'google-plus'   => 'Google+',
			'skype'         => 'Skype',
			'youtube'       => 'YouTube',
			'rss'           => 'RSS',
			'delicious'     => 'Delicious',
			'flickr'        => 'Flickr',
			'lastfm'        => 'Lastfm',
			'linkedin'      => 'Linkedin',
			'vimeo'         => 'Vimeo',
			'tumblr'        => 'Tumblr',
			'pinterest'     => 'Pinterest',
			'deviantart'    => 'Deviantart',
			'git'           => 'Github',
			'instagram'     => 'Instagram',
			'stumbleupon'   => 'Stumbleupon',
			'behance'       => 'Behance',
			'tripadvisor'   => 'TripAdvisor',
			'vk'            => 'VK',
			'foursquare'    => 'Foursquare',
			'xing'          => 'XING',
			'weibo'         => 'Weibo',
			'odnoklassniki' => 'Odnoklassniki',
			//'500px'         => '500px',
		);
	}
	/**
	 * Using   SLZ_Params::get('font_flaticon', $field )
	 *      or SLZ_Params::font_flaticon()
	 * @return array
	 */
		public static function font_flaticon() {
			$flaticon = slz()->theme->get_config('flaticon', array());
			return $flaticon;
		}
	/**
	 * Using   SLZ_Params::get('font_awesome', $field )
	 *      or SLZ_Params::font_awesome()
	 * @return array
	 */
	public static function font_awesome(){
		return array(
			'' => 'none',
			'fa fa-adjust' => 'adjust',
			'fa fa-anchor' => 'anchor',
			'fa fa-archive' => 'archive',
			'fa fa-area-chart' => 'area-chart',
			'fa fa-arrows' => 'arrows',
			'fa fa-arrows-h' => 'arrows-h',
			'fa fa-arrows-v' => 'arrows-v',
			'fa fa-asterisk' => 'asterisk',
			'fa fa-at' => 'at',
			'fa fa-ban' => 'ban',
			'fa fa-bar-chart' => 'bar-chart',
			'fa fa-barcode' => 'barcode',
			'fa fa-bars' => 'bars',
			'fa fa-beer' => 'beer',
			'fa fa-bell' => 'bell',
			'fa fa-bell-o' => 'bell-o',
			'fa fa-bell-slash' => 'bell-slash',
			'fa fa-bell-slash-o' => 'bell-slash-o',
			'fa fa-bicycle' => 'bicycle',
			'fa fa-binoculars' => 'binoculars',
			'fa fa-birthday-cake' => 'birthday-cake',
			'fa fa-bolt' => 'bolt',
			'fa fa-bomb' => 'bomb',
			'fa fa-book' => 'book',
			'fa fa-bookmark' => 'bookmark',
			'fa fa-bookmark-o' => 'bookmark-o',
			'fa fa-briefcase' => 'briefcase',
			'fa fa-bug' => 'bug',
			'fa fa-building' => 'building',
			'fa fa-building-o' => 'building-o',
			'fa fa-bullhorn' => 'bullhorn',
			'fa fa-bullseye' => 'bullseye',
			'fa fa-bus' => 'bus',
			'fa fa-calculator' => 'calculator',
			'fa fa-calendar' => 'calendar',
			'fa fa-calendar-o' => 'calendar-o',
			'fa fa-camera' => 'camera',
			'fa fa-camera-retro' => 'camera-retro',
			'fa fa-car' => 'car',
			'fa fa-caret-square-o-down' => 'caret-square-o-down',
			'fa fa-caret-square-o-left' => 'caret-square-o-left',
			'fa fa-caret-square-o-right' => 'caret-square-o-right',
			'fa fa-caret-square-o-up' => 'caret-square-o-up',
			'fa fa-cc' => 'cc',
			'fa fa-certificate' => 'certificate',
			'fa fa-check' => 'check',
			'fa fa-check-circle' => 'check-circle',
			'fa fa-check-circle-o' => 'check-circle-o',
			'fa fa-check-square' => 'check-square',
			'fa fa-check-square-o' => 'check-square-o',
			'fa fa-child' => 'child',
			'fa fa-circle' => 'circle',
			'fa fa-circle-o' => 'circle-o',
			'fa fa-circle-o-notch' => 'circle-o-notch',
			'fa fa-circle-thin' => 'circle-thin',
			'fa fa-clock-o' => 'clock-o',
			'fa fa-cloud' => 'cloud',
			'fa fa-cloud-download' => 'cloud-download',
			'fa fa-cloud-upload' => 'cloud-upload',
			'fa fa-code' => 'code',
			'fa fa-code-fork' => 'code-fork',
			'fa fa-coffee' => 'coffee',
			'fa fa-cog' => 'cog',
			'fa fa-cogs' => 'cogs',
			'fa fa-comment' => 'comment',
			'fa fa-comment-o' => 'comment-o',
			'fa fa-comments' => 'comments',
			'fa fa-comments-o' => 'comments-o',
			'fa fa-compass' => 'compass',
			'fa fa-copyright' => 'copyright',
			'fa fa-credit-card' => 'credit-card',
			'fa fa-crop' => 'crop',
			'fa fa-crosshairs' => 'crosshairs',
			'fa fa-cube' => 'cube',
			'fa fa-cubes' => 'cubes',
			'fa fa-cutlery' => 'cutlery',
			'fa fa-database' => 'database',
			'fa fa-desktop' => 'desktop',
			'fa fa-dot-circle-o' => 'dot-circle-o',
			'fa fa-download' => 'download',
			'fa fa-ellipsis-h' => 'ellipsis-h',
			'fa fa-ellipsis-v' => 'ellipsis-v',
			'fa fa-envelope' => 'envelope',
			'fa fa-envelope-o' => 'envelope-o',
			'fa fa-envelope-square' => 'envelope-square',
			'fa fa-eraser' => 'eraser',
			'fa fa-exchange' => 'exchange',
			'fa fa-exclamation' => 'exclamation',
			'fa fa-exclamation-circle' => 'exclamation-circle',
			'fa fa-exclamation-triangle' => 'exclamation-triangle',
			'fa fa-external-link' => 'external-link',
			'fa fa-external-link-square' => 'external-link-square',
			'fa fa-eye' => 'eye',
			'fa fa-eye-slash' => 'eye-slash',
			'fa fa-eyedropper' => 'eyedropper',
			'fa fa-fax' => 'fax',
			'fa fa-female' => 'female',
			'fa fa-fighter-jet' => 'fighter-jet',
			'fa fa-file-archive-o' => 'file-archive-o',
			'fa fa-file-audio-o' => 'file-audio-o',
			'fa fa-file-code-o' => 'file-code-o',
			'fa fa-file-excel-o' => 'file-excel-o',
			'fa fa-file-image-o' => 'file-image-o',
			'fa fa-file-pdf-o' => 'file-pdf-o',
			'fa fa-file-powerpoint-o' => 'file-powerpoint-o',
			'fa fa-file-video-o' => 'file-video-o',
			'fa fa-file-word-o' => 'file-word-o',
			'fa fa-film' => 'film',
			'fa fa-filter' => 'filter',
			'fa fa-fire' => 'fire',
			'fa fa-fire-extinguisher' => 'fire-extinguisher',
			'fa fa-flag' => 'flag',
			'fa fa-flag-checkered' => 'flag-checkered',
			'fa fa-flag-o' => 'flag-o',
			'fa fa-flask' => 'flask',
			'fa fa-folder' => 'folder',
			'fa fa-folder-o' => 'folder-o',
			'fa fa-folder-open' => 'folder-open',
			'fa fa-folder-open-o' => 'folder-open-o',
			'fa fa-frown-o' => 'frown-o',
			'fa fa-futbol-o' => 'futbol-o',
			'fa fa-gamepad' => 'gamepad',
			'fa fa-gavel' => 'gavel',
			'fa fa-gift' => 'gift',
			'fa fa-glass' => 'glass',
			'fa fa-globe' => 'globe',
			'fa fa-graduation-cap' => 'graduation-cap',
			'fa fa-hdd-o' => 'hdd-o',
			'fa fa-headphones' => 'headphones',
			'fa fa-heart' => 'heart',
			'fa fa-heart-o' => 'heart-o',
			'fa fa-history' => 'history',
			'fa fa-home' => 'home',
			'fa fa-inbox' => 'inbox',
			'fa fa-info' => 'info',
			'fa fa-info-circle' => 'info-circle',
			'fa fa-key' => 'key',
			'fa fa-keyboard-o' => 'keyboard-o',
			'fa fa-language' => 'language',
			'fa fa-laptop' => 'laptop',
			'fa fa-leaf' => 'leaf',
			'fa fa-lemon-o' => 'lemon-o',
			'fa fa-level-down' => 'level-down',
			'fa fa-level-up' => 'level-up',
			'fa fa-life-ring' => 'life-ring',
			'fa fa-lightbulb-o' => 'lightbulb-o',
			'fa fa-line-chart' => 'line-chart',
			'fa fa-location-arrow' => 'location-arrow',
			'fa fa-lock' => 'lock',
			'fa fa-magic' => 'magic',
			'fa fa-magnet' => 'magnet',
			'fa fa-male' => 'male',
			'fa fa-map-marker' => 'map-marker',
			'fa fa-meh-o' => 'meh-o',
			'fa fa-microphone' => 'microphone',
			'fa fa-microphone-slash' => 'microphone-slash',
			'fa fa-minus' => 'minus',
			'fa fa-minus-circle' => 'minus-circle',
			'fa fa-minus-square' => 'minus-square',
			'fa fa-minus-square-o' => 'minus-square-o',
			'fa fa-mobile' => 'mobile',
			'fa fa-money' => 'money',
			'fa fa-moon-o' => 'moon-o',
			'fa fa-music' => 'music',
			'fa fa-newspaper-o' => 'newspaper-o',
			'fa fa-paint-brush' => 'paint-brush',
			'fa fa-paper-plane' => 'paper-plane',
			'fa fa-paper-plane-o' => 'paper-plane-o',
			'fa fa-paw' => 'paw',
			'fa fa-pencil' => 'pencil',
			'fa fa-pencil-square' => 'pencil-square',
			'fa fa-pencil-square-o' => 'pencil-square-o',
			'fa fa-phone' => 'phone',
			'fa fa-phone-square' => 'phone-square',
			'fa fa-picture-o' => 'picture-o',
			'fa fa-pie-chart' => 'pie-chart',
			'fa fa-plane' => 'plane',
			'fa fa-plug' => 'plug',
			'fa fa-plus' => 'plus',
			'fa fa-plus-circle' => 'plus-circle',
			'fa fa-plus-square' => 'plus-square',
			'fa fa-plus-square-o' => 'plus-square-o',
			'fa fa-power-off' => 'power-off',
			'fa fa-print' => 'print',
			'fa fa-puzzle-piece' => 'puzzle-piece',
			'fa fa-qrcode' => 'qrcode',
			'fa fa-question' => 'question',
			'fa fa-question-circle' => 'question-circle',
			'fa fa-quote-left' => 'quote-left',
			'fa fa-quote-right' => 'quote-right',
			'fa fa-random' => 'random',
			'fa fa-recycle' => 'recycle',
			'fa fa-refresh' => 'refresh',
			'fa fa-reply' => 'reply',
			'fa fa-reply-all' => 'reply-all',
			'fa fa-retweet' => 'retweet',
			'fa fa-road' => 'road',
			'fa fa-rocket' => 'rocket',
			'fa fa-rss' => 'rss',
			'fa fa-rss-square' => 'rss-square',
			'fa fa-search' => 'search',
			'fa fa-search-minus' => 'search-minus',
			'fa fa-search-plus' => 'search-plus',
			'fa fa-share' => 'share',
			'fa fa-share-alt' => 'share-alt',
			'fa fa-share-alt-square' => 'share-alt-square',
			'fa fa-share-square' => 'share-square',
			'fa fa-share-square-o' => 'share-square-o',
			'fa fa-shield' => 'shield',
			'fa fa-shopping-cart' => 'shopping-cart',
			'fa fa-sign-in' => 'sign-in',
			'fa fa-sign-out' => 'sign-out',
			'fa fa-signal' => 'signal',
			'fa fa-sitemap' => 'sitemap',
			'fa fa-sliders' => 'sliders',
			'fa fa-smile-o' => 'smile-o',
			'fa fa-sort' => 'sort',
			'fa fa-sort-alpha-asc' => 'sort-alpha-asc',
			'fa fa-sort-alpha-desc' => 'sort-alpha-desc',
			'fa fa-sort-amount-asc' => 'sort-amount-asc',
			'fa fa-sort-amount-desc' => 'sort-amount-desc',
			'fa fa-sort-asc' => 'sort-asc',
			'fa fa-sort-desc' => 'sort-desc',
			'fa fa-sort-numeric-asc' => 'sort-numeric-asc',
			'fa fa-sort-numeric-desc' => 'sort-numeric-desc',
			'fa fa-space-shuttle' => 'space-shuttle',
			'fa fa-spinner' => 'spinner',
			'fa fa-spoon' => 'spoon',
			'fa fa-square' => 'square',
			'fa fa-square-o' => 'square-o',
			'fa fa-star' => 'star',
			'fa fa-star-half' => 'star-half',
			'fa fa-star-half-o' => 'star-half-o',
			'fa fa-star-o' => 'star-o',
			'fa fa-suitcase' => 'suitcase',
			'fa fa-sun-o' => 'sun-o',
			'fa fa-tablet' => 'tablet',
			'fa fa-tachometer' => 'tachometer',
			'fa fa-tag' => 'tag',
			'fa fa-tags' => 'tags',
			'fa fa-tasks' => 'tasks',
			'fa fa-taxi' => 'taxi',
			'fa fa-terminal' => 'terminal',
			'fa fa-thumb-tack' => 'thumb-tack',
			'fa fa-thumbs-down' => 'thumbs-down',
			'fa fa-thumbs-o-down' => 'thumbs-o-down',
			'fa fa-thumbs-o-up' => 'thumbs-o-up',
			'fa fa-thumbs-up' => 'thumbs-up',
			'fa fa-ticket' => 'ticket',
			'fa fa-times' => 'times',
			'fa fa-times-circle' => 'times-circle',
			'fa fa-times-circle-o' => 'times-circle-o',
			'fa fa-tint' => 'tint',
			'fa fa-toggle-off' => 'toggle-off',
			'fa fa-toggle-on' => 'toggle-on',
			'fa fa-trash' => 'trash',
			'fa fa-trash-o' => 'trash-o',
			'fa fa-tree' => 'tree',
			'fa fa-trophy' => 'trophy',
			'fa fa-truck' => 'truck',
			'fa fa-tty' => 'tty',
			'fa fa-umbrella' => 'umbrella',
			'fa fa-university' => 'university',
			'fa fa-unlock' => 'unlock',
			'fa fa-unlock-alt' => 'unlock-alt',
			'fa fa-upload' => 'upload',
			'fa fa-user' => 'user',
			'fa fa-users' => 'users',
			'fa fa-video-camera' => 'video-camera',
			'fa fa-volume-down' => 'volume-down',
			'fa fa-volume-off' => 'volume-off',
			'fa fa-volume-up' => 'volume-up',
			'fa fa-wheelchair' => 'wheelchair',
			'fa fa-wifi' => 'wifi',
			'fa fa-wrench' => 'wrench',
			'fa fa-file' => 'file',
			'fa fa-file-archive-o' => 'file-archive-o',
			'fa fa-file-audio-o' => 'file-audio-o',
			'fa fa-file-code-o' => 'file-code-o',
			'fa fa-file-excel-o' => 'file-excel-o',
			'fa fa-file-image-o' => 'file-image-o',
			'fa fa-file-o' => 'file-o',
			'fa fa-file-pdf-o' => 'file-pdf-o',
			'fa fa-file-powerpoint-o' => 'file-powerpoint-o',
			'fa fa-file-text' => 'file-text',
			'fa fa-file-text-o' => 'file-text-o',
			'fa fa-file-video-o' => 'file-video-o',
			'fa fa-file-word-o' => 'file-word-o',
			'fa fa-circle-o-notch' => 'circle-o-notch',
			'fa fa-cog' => 'cog',
			'fa fa-refresh' => 'refresh',
			'fa fa-spinner' => 'spinner',
			'fa fa-check-square' => 'check-square',
			'fa fa-check-square-o' => 'check-square-o',
			'fa fa-circle' => 'circle',
			'fa fa-circle-o' => 'circle-o',
			'fa fa-dot-circle-o' => 'dot-circle-o',
			'fa fa-minus-square' => 'minus-square',
			'fa fa-minus-square-o' => 'minus-square-o',
			'fa fa-plus-square' => 'plus-square',
			'fa fa-plus-square-o' => 'plus-square-o',
			'fa fa-square' => 'square',
			'fa fa-square-o' => 'square-o',
			'fa fa-cc-amex' => 'cc-amex',
			'fa fa-cc-discover' => 'cc-discover',
			'fa fa-cc-mastercard' => 'cc-mastercard',
			'fa fa-cc-paypal' => 'cc-paypal',
			'fa fa-cc-stripe' => 'cc-stripe',
			'fa fa-cc-visa' => 'cc-visa',
			'fa fa-credit-card' => 'credit-card',
			'fa fa-google-wallet' => 'google-wallet',
			'fa fa-paypal' => 'paypal',
			'fa fa-area-chart' => 'area-chart',
			'fa fa-bar-chart' => 'bar-chart',
			'fa fa-line-chart' => 'line-chart',
			'fa fa-pie-chart' => 'pie-chart',
			'fa fa-btc' => 'btc',
			'fa fa-eur' => 'eur',
			'fa fa-gbp' => 'gbp',
			'fa fa-ils' => 'ils',
			'fa fa-inr' => 'inr',
			'fa fa-jpy' => 'jpy',
			'fa fa-krw' => 'krw',
			'fa fa-money' => 'money',
			'fa fa-rub' => 'rub',
			'fa fa-try' => 'try',
			'fa fa-usd' => 'usd',
			'fa fa-align-center' => 'align-center',
			'fa fa-align-justify' => 'align-justify',
			'fa fa-align-left' => 'align-left',
			'fa fa-align-right' => 'align-right',
			'fa fa-bold' => 'bold',
			'fa fa-chain-broken' => 'chain-broken',
			'fa fa-clipboard' => 'clipboard',
			'fa fa-columns' => 'columns',
			'fa fa-eraser' => 'eraser',
			'fa fa-file' => 'file',
			'fa fa-file-o' => 'file-o',
			'fa fa-file-text' => 'file-text',
			'fa fa-file-text-o' => 'file-text-o',
			'fa fa-files-o' => 'files-o',
			'fa fa-floppy-o' => 'floppy-o',
			'fa fa-font' => 'font',
			'fa fa-header' => 'header',
			'fa fa-indent' => 'indent',
			'fa fa-italic' => 'italic',
			'fa fa-link' => 'link',
			'fa fa-list' => 'list',
			'fa fa-list-alt' => 'list-alt',
			'fa fa-list-ol' => 'list-ol',
			'fa fa-list-ul' => 'list-ul',
			'fa fa-outdent' => 'outdent',
			'fa fa-paperclip' => 'paperclip',
			'fa fa-paragraph' => 'paragraph',
			'fa fa-repeat' => 'repeat',
			'fa fa-scissors' => 'scissors',
			'fa fa-strikethrough' => 'strikethrough',
			'fa fa-subscript' => 'subscript',
			'fa fa-superscript' => 'superscript',
			'fa fa-table' => 'table',
			'fa fa-text-height' => 'text-height',
			'fa fa-text-width' => 'text-width',
			'fa fa-th' => 'th',
			'fa fa-th-large' => 'th-large',
			'fa fa-th-list' => 'th-list',
			'fa fa-underline' => 'underline',
			'fa fa-undo' => 'undo',
			'fa fa-angle-double-down' => 'angle-double-down',
			'fa fa-angle-double-left' => 'angle-double-left',
			'fa fa-angle-double-right' => 'angle-double-right',
			'fa fa-angle-double-up' => 'angle-double-up',
			'fa fa-angle-down' => 'angle-down',
			'fa fa-angle-left' => 'angle-left',
			'fa fa-angle-right' => 'angle-right',
			'fa fa-angle-up' => 'angle-up',
			'fa fa-arrow-circle-down' => 'arrow-circle-down',
			'fa fa-arrow-circle-left' => 'arrow-circle-left',
			'fa fa-arrow-circle-o-down' => 'arrow-circle-o-down',
			'fa fa-arrow-circle-o-left' => 'arrow-circle-o-left',
			'fa fa-arrow-circle-o-right' => 'arrow-circle-o-right',
			'fa fa-arrow-circle-o-up' => 'arrow-circle-o-up',
			'fa fa-arrow-circle-right' => 'arrow-circle-right',
			'fa fa-arrow-circle-up' => 'arrow-circle-up',
			'fa fa-arrow-down' => 'arrow-down',
			'fa fa-arrow-left' => 'arrow-left',
			'fa fa-arrow-right' => 'arrow-right',
			'fa fa-arrow-up' => 'arrow-up',
			'fa fa-arrows' => 'arrows',
			'fa fa-arrows-alt' => 'arrows-alt',
			'fa fa-arrows-h' => 'arrows-h',
			'fa fa-arrows-v' => 'arrows-v',
			'fa fa-caret-down' => 'caret-down',
			'fa fa-caret-left' => 'caret-left',
			'fa fa-caret-right' => 'caret-right',
			'fa fa-caret-square-o-down' => 'caret-square-o-down',
			'fa fa-caret-square-o-left' => 'caret-square-o-left',
			'fa fa-caret-square-o-right' => 'caret-square-o-right',
			'fa fa-caret-square-o-up' => 'caret-square-o-up',
			'fa fa-caret-up' => 'caret-up',
			'fa fa-chevron-circle-down' => 'chevron-circle-down',
			'fa fa-chevron-circle-left' => 'chevron-circle-left',
			'fa fa-chevron-circle-right' => 'chevron-circle-right',
			'fa fa-chevron-circle-up' => 'chevron-circle-up',
			'fa fa-chevron-down' => 'chevron-down',
			'fa fa-chevron-left' => 'chevron-left',
			'fa fa-chevron-right' => 'chevron-right',
			'fa fa-chevron-up' => 'chevron-up',
			'fa fa-hand-o-down' => 'hand-o-down',
			'fa fa-hand-o-left' => 'hand-o-left',
			'fa fa-hand-o-right' => 'hand-o-right',
			'fa fa-hand-o-up' => 'hand-o-up',
			'fa fa-long-arrow-down' => 'long-arrow-down',
			'fa fa-long-arrow-left' => 'long-arrow-left',
			'fa fa-long-arrow-right' => 'long-arrow-right',
			'fa fa-long-arrow-up' => 'long-arrow-up',
			'fa fa-arrows-alt' => 'arrows-alt',
			'fa fa-backward' => 'backward',
			'fa fa-compress' => 'compress',
			'fa fa-eject' => 'eject',
			'fa fa-expand' => 'expand',
			'fa fa-fast-backward' => 'fast-backward',
			'fa fa-fast-forward' => 'fast-forward',
			'fa fa-forward' => 'forward',
			'fa fa-pause' => 'pause',
			'fa fa-play' => 'play',
			'fa fa-play-circle' => 'play-circle',
			'fa fa-play-circle-o' => 'play-circle-o',
			'fa fa-step-backward' => 'step-backward',
			'fa fa-step-forward' => 'step-forward',
			'fa fa-stop' => 'stop',
			'fa fa-youtube-play' => 'youtube-play',
			'fa fa-adn' => 'adn',
			'fa fa-android' => 'android',
			'fa fa-angellist' => 'angellist',
			'fa fa-apple' => 'apple',
			'fa fa-behance' => 'behance',
			'fa fa-behance-square' => 'behance-square',
			'fa fa-bitbucket' => 'bitbucket',
			'fa fa-bitbucket-square' => 'bitbucket-square',
			'fa fa-btc' => 'btc',
			'fa fa-cc-amex' => 'cc-amex',
			'fa fa-cc-discover' => 'cc-discover',
			'fa fa-cc-mastercard' => 'cc-mastercard',
			'fa fa-cc-paypal' => 'cc-paypal',
			'fa fa-cc-stripe' => 'cc-stripe',
			'fa fa-cc-visa' => 'cc-visa',
			'fa fa-codepen' => 'codepen',
			'fa fa-css3' => 'css3',
			'fa fa-delicious' => 'delicious',
			'fa fa-deviantart' => 'deviantart',
			'fa fa-digg' => 'digg',
			'fa fa-dribbble' => 'dribbble',
			'fa fa-dropbox' => 'dropbox',
			'fa fa-drupal' => 'drupal',
			'fa fa-empire' => 'empire',
			'fa fa-facebook' => 'facebook',
			'fa fa-facebook-square' => 'facebook-square',
			'fa fa-flickr' => 'flickr',
			'fa fa-foursquare' => 'foursquare',
			'fa fa-git' => 'git',
			'fa fa-git-square' => 'git-square',
			'fa fa-github' => 'github',
			'fa fa-github-alt' => 'github-alt',
			'fa fa-github-square' => 'github-square',
			'fa fa-gittip' => 'gittip',
			'fa fa-google' => 'google',
			'fa fa-google-plus' => 'google-plus',
			'fa fa-google-plus-square' => 'google-plus-square',
			'fa fa-google-wallet' => 'google-wallet',
			'fa fa-hacker-news' => 'hacker-news',
			'fa fa-html5' => 'html5',
			'fa fa-instagram' => 'instagram',
			'fa fa-ioxhost' => 'ioxhost',
			'fa fa-joomla' => 'joomla',
			'fa fa-jsfiddle' => 'jsfiddle',
			'fa fa-lastfm' => 'lastfm',
			'fa fa-lastfm-square' => 'lastfm-square',
			'fa fa-linkedin' => 'linkedin',
			'fa fa-linkedin-square' => 'linkedin-square',
			'fa fa-linux' => 'linux',
			'fa fa-maxcdn' => 'maxcdn',
			'fa fa-meanpath' => 'meanpath',
			'fa fa-openid' => 'openid',
			'fa fa-pagelines' => 'pagelines',
			'fa fa-paypal' => 'paypal',
			'fa fa-pied-piper' => 'pied-piper',
			'fa fa-pied-piper-alt' => 'pied-piper-alt',
			'fa fa-pinterest' => 'pinterest',
			'fa fa-pinterest-square' => 'pinterest-square',
			'fa fa-qq' => 'qq',
			'fa fa-rebel' => 'rebel',
			'fa fa-reddit' => 'reddit',
			'fa fa-reddit-square' => 'reddit-square',
			'fa fa-renren' => 'renren',
			'fa fa-share-alt' => 'share-alt',
			'fa fa-share-alt-square' => 'share-alt-square',
			'fa fa-skype' => 'skype',
			'fa fa-slack' => 'slack',
			'fa fa-slideshare' => 'slideshare',
			'fa fa-soundcloud' => 'soundcloud',
			'fa fa-spotify' => 'spotify',
			'fa fa-stack-exchange' => 'stack-exchange',
			'fa fa-stack-overflow' => 'stack-overflow',
			'fa fa-steam' => 'steam',
			'fa fa-steam-square' => 'steam-square',
			'fa fa-stumbleupon' => 'stumbleupon',
			'fa fa-stumbleupon-circle' => 'stumbleupon-circle',
			'fa fa-tencent-weibo' => 'tencent-weibo',
			'fa fa-trello' => 'trello',
			'fa fa-tumblr' => 'tumblr',
			'fa fa-tumblr-square' => 'tumblr-square',
			'fa fa-twitch' => 'twitch',
			'fa fa-twitter' => 'twitter',
			'fa fa-twitter-square' => 'twitter-square',
			'fa fa-vimeo-square' => 'vimeo-square',
			'fa fa-vine' => 'vine',
			'fa fa-vk' => 'vk',
			'fa fa-weibo' => 'weibo',
			'fa fa-weixin' => 'weixin',
			'fa fa-windows' => 'windows',
			'fa fa-wordpress' => 'wordpress',
			'fa fa-xing' => 'xing',
			'fa fa-xing-square' => 'xing-square',
			'fa fa-yahoo' => 'yahoo',
			'fa fa-yelp' => 'yelp',
			'fa fa-youtube' => 'youtube',
			'fa fa-youtube-play' => 'youtube-play',
			'fa fa-youtube-square' => 'youtube-square',
			'fa fa-ambulance' => 'ambulance',
			'fa fa-h-square' => 'h-square',
			'fa fa-hospital-o' => 'hospital-o',
			'fa fa-medkit' => 'medkit',
			'fa fa-plus-square' => 'plus-square',
			'fa fa-stethoscope' => 'stethoscope',
			'fa fa-user-md' => 'user-md',
			'fa fa-wheelchair' => 'wheelchair',
		);
	}

    /**
	 * Using   SLZ_Params::get('font_icon_library', $field )
	 *    or   SLZ_Params::font_icon_library()
	 * @return array
	 */
	public static function font_icon_library(){
		$icon_config = slz()->theme->get_config('supported_flaticon');
		$params = array(
			esc_html__( 'Font Awesome', 'slz' )          => 'vs',
			esc_html__( 'Open Iconic', 'slz' )           => 'openiconic',
			esc_html__( 'Typicons', 'slz' )              => 'typicons',
			esc_html__( 'Entypo', 'slz' )                => 'entypo',
			esc_html__( 'Linecons', 'slz' )              => 'linecons',
			esc_html__( 'Mono Social', 'slz' )           => 'monosocial',
			esc_html__( 'Material', 'js_composer' )      => 'material'
		);
		if( !empty($icon_config['is_supported']) && !empty($icon_config['vc_icons_map'])) {
			$params[esc_html__( 'Flaticon', 'slz' )] = 'flaticon';
		}
		return $params;
    }
}