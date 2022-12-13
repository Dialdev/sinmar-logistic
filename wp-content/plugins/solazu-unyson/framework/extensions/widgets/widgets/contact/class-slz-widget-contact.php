<?php 

class SLZ_Widget_Contact extends WP_Widget {

	private $slz_widget;
	private $config;

	/**
	 * @internal
	 */
	function __construct() {

		$this->slz_widget = slz_ext('widgets')->get_widget( get_class ($this) );
		
		if ( is_null( $this->slz_widget ) ) {
			trigger_error('Cannot load this widget', E_USER_WARNING);
			return;
		}

		$this->config = $this->slz_widget->get_config('general');

		$widget_ops = array( 
			'description' => (!empty( $this->config['description'] ) ? $this->config['description'] : ''),
			'classname'   => (!empty( $this->config['classname'] ) ? $this->config['classname'] : ''),
		);
		parent::__construct( $this->config['id'], $this->config['name'], $widget_ops );
	}
	/**
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {
		//get translated strings
		$title = slz_ext_widget_filters_widget_title( $args, $instance );
		slz_ext_widget_wpml_translate_string($this, $instance['address']);
		
		$option_arr = array('address_title','phone_title','mail_title','website_title','website');
		foreach ($option_arr as $key ) {
			if( !isset( $instance[$key] ) ) {
				$instance[$key] = '';
			}
		}
		$data = array(
			'before_widget' => $args['before_widget'],
			'after_widget'  => $args['after_widget'],
			'title'         => $title,
			'address'       => esc_attr($instance['address']),
			'phone'         => esc_attr($instance['phone']),
			'mail'          => esc_attr($instance['mail']),
			'address_title'  => $instance['address_title'],
			'phone_title'   => $instance['phone_title'],
			'mail_title'    => $instance['mail_title'],
			'website_title' => $instance['website_title'],
			'website'       => $instance['website'],
		);
		echo slz_render_view($this->slz_widget->locate_path( '/views/front.php' ), $data);
	}

	function update( $new_instance, $old_instance ) {
		//register strings for translation
		slz_ext_widget_wpml_register_string($this, $new_instance['address']);
		return $new_instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance,array( 
			'title'    => esc_html__( "Contact us", 'slz'),
			'address_title' => '',
			'address'      => '',
			'phone_title'  => '',
			'phone'        => '',
			'mail_title'   => '',
			'mail'         => '',
			'website_title'   => '',
			'website'         => '',
			));

		$data = array(
			'data'            => $instance,
			'wp_widget'       => $this,
		);

		echo slz_render_view($this->slz_widget->locate_path( '/views/admin.php' ), $data );
		
	}
}