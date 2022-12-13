<?php 

class SLZ_Widget_Gallery extends WP_Widget {

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
		if( !isset($instance['post_type'])) {
			$instance['post_type'] = 'slz-gallery';
		}
		$data = array(
			'before_widget' => $args['before_widget'],
			'after_widget'  => $args['after_widget'],
			'title'         => $title,
			'limit_post'    => esc_attr($instance['limit_post']),
			'cat_id'        => esc_attr($instance['cat_id']),
			'column'        => esc_attr($instance['column']),
			'post_type'     => esc_attr($instance['post_type']),
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
			'title'      => '',
			'limit_post' => '',
			'cat_id'     => '',
			'column'     => 'three-column',
			'post_type'  => 'slz-gallery',
			));
		
		$post_type = $this->slz_widget->get_config('post-type');
		$data = array(
			'data'            => $instance,
			'wp_widget'       => $this,
			'post_type'       => $post_type

		);

		echo slz_render_view($this->slz_widget->locate_path( '/views/admin.php' ), $data );
		
	}
}