<?php 

class SLZ_Widget_Causes extends WP_Widget {

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
		$data = array(
			'before_widget' => $args['before_widget'],
			'after_widget'  => $args['after_widget'],
			'before_title'  => str_replace( 'class="', 'class="widget_causes ', $args['before_title']),
			'after_title'   => $args['after_title'],
			'title'         => str_replace( 'class="', 'class="widget_causes widget-title ',
				 $args['before_title'] ) . esc_html($instance['title']) . $args['after_title'],
			'limit_post'    => esc_attr($instance['limit_post']),
			'method'		=> 'cat',
			'offset_post'	=> esc_attr($instance['offset_post']),
			'category_slug'		=> esc_attr($instance['category_slug']),
			'image_size'    => $this->slz_widget->get_config('image_size'),
			'instance'      => $instance
		);
		echo slz_render_view($this->slz_widget->locate_path( '/views/front.php' ), $data);
	}

	function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance,array( 
			'title'       		=> '',
			'limit_post'  		=> '',
			'offset_post' 		=> '',
			'method'	 	    => 'cat',
			'category_slug'     => '',
			));
		
		$method = $this->slz_widget->get_config('method');
		$data = array(
			'data'            => $instance,
			'wp_widget'       => $this,
			'method'	 	  => $method,

		);

		echo slz_render_view($this->slz_widget->locate_path( '/views/admin.php' ), $data );
		
	}
}