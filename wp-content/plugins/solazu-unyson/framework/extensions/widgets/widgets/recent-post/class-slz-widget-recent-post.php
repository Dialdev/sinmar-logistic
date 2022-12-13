<?php 

class SLZ_Widget_Recent_Post extends WP_Widget {

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
		$thumb_size = $this->slz_widget->get_config('thumb-size');
		$instance['image_size'] = $thumb_size;
		//get translated strings
		$title = slz_ext_widget_filters_widget_title( $args, $instance );
		$data = array(
			'before_widget' => $args['before_widget'],
			'after_widget'  => $args['after_widget'],
			'title'         => $title,
			'instance'      => $instance			
		);
		echo slz_render_view($this->slz_widget->locate_path( '/views/front.php' ), $data);
	}

	function update( $new_instance, $old_instance ) {
		$new_instance['show_thumbnail'] = strip_tags($new_instance['show_thumbnail']);
		$new_instance['show_view']      = strip_tags($new_instance['show_view']);
		$new_instance['show_author']    = strip_tags($new_instance['show_author']);
		$new_instance['show_comment']   = strip_tags($new_instance['show_comment']);
		$new_instance['show_date']      = strip_tags($new_instance['show_date']);
		return $new_instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance,array( 
			'title'           => esc_html__( "Recent Post", 'slz'),
			'limit_post'      => '5',
			'sort_by'         => '',
			'show_thumbnail'  => 'on',
			'show_date'       => 'on',
			'show_author'     => 'on',
			'show_view'       => '',
			'show_comment'    => '',
			'show_category'   => ''
			));
		$check_box = $this->slz_widget->get_config('check_box');
		$data = array(
			'data'            => $instance,
			'wp_widget'       => $this,
			'check_box'       => $check_box
		);

		echo slz_render_view($this->slz_widget->locate_path( '/views/admin.php' ), $data );
		
	}
}