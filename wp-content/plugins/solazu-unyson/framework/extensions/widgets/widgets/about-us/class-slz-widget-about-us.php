<?php 

class SLZ_Widget_About_Us extends WP_Widget {

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
		if (!array_key_exists("title",$instance)){
			$instance['title'] = '';
		}
		//get translated strings
		$title = slz_ext_widget_filters_widget_title( $args, $instance );
		slz_ext_widget_wpml_translate_string($this, $instance['description'], 'textarea-1');
		
		$data = array(
			'before_widget' => $args['before_widget'],
			'after_widget'  => $args['after_widget'],
			'instance'      => $instance,
			'title'         => $title
		);
		echo slz_render_view($this->slz_widget->locate_path( '/views/front.php' ), $data);
	}

	function update( $new_instance, $old_instance ) {
		//register strings for translation
		slz_ext_widget_wpml_register_string($this, $new_instance['description'], 'textarea-1');
		return $new_instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance,array( 
			'description'  => '',
			'image'        => '',
			'title_type'   => '',
			'title'        => '',
			));
		$social_default = array();
		$arr_social  = SLZ_Params::get('social-icons');
		foreach($arr_social as $k => $v){
			$social_default[$k] = '';
		}
		$instance    = wp_parse_args( (array) $instance, $social_default );
		$data = array(
			'data'            => $instance,
			'social_default'  => $social_default,
			'wp_widget'       => $this,
		);

		echo slz_render_view($this->slz_widget->locate_path( '/views/admin.php' ), $data );
		
	}
}