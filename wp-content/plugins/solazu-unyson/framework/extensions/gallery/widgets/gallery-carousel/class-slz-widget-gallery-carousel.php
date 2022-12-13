<?php 

class SLZ_Widget_Gallery_Carousel extends WP_Widget {

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
		$data = array(
			'before_widget' => $args['before_widget'],
			'after_widget'  => $args['after_widget'],
			'title'         => $title,
			'limit_post'    => esc_attr($instance['limit_post']),
			'cat_id'        => esc_attr($instance['cat_id']),
			'image_size'    => $this->slz_widget->get_config('image_size'),
			'slides_to_show'=> esc_attr($instance['slides_to_show'])
		);
		echo slz_render_view($this->slz_widget->locate_path( '/views/front.php' ), $data);
	}

	function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance,array( 
			'title'          => '',
			'limit_post'     => '',
			'slides_to_show' => '',
			'cat_id'         => ''
		   )
		);
		
		$data = array(
			'data'            => $instance,
			'wp_widget'       => $this,
		);

		echo slz_render_view($this->slz_widget->locate_path( '/views/admin.php' ), $data );
		
	}
}