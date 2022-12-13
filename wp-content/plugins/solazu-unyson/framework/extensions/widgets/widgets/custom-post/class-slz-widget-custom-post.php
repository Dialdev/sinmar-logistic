<?php 

class SLZ_Widget_Custom_Post extends WP_Widget {

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
		$defaults = array(
			'title'           => '',
			'limit_post'      => '',
			'sort_by'         => '',
			'post_type'       => '',
		);
		$instance = array_merge( $defaults, (array) $instance );
		//get translated strings
		$title = slz_ext_widget_filters_widget_title( $args, $instance );
	
		$data = array(
			'before_widget' => $args['before_widget'],
			'after_widget'  => $args['after_widget'],
			'title'         => $title,
			'data'          => $instance,
		);

		echo slz_render_view($this->slz_widget->locate_path( '/views/front.php' ), $data );
		
	}

	function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance,array( 
			'title'           => '',
			'limit_post'      => '',
			'sort_by'         => '',
			'post_type'       => '',
			));
		$post_type = $this->slz_widget->get_config('post_type');
		$extensions = $this->slz_widget->get_config('extensions');
		foreach($post_type as $key => $val ) {
			if( isset($extensions[$key]) && !slz_ext($extensions[$key])) {
				unset($post_type[$key]);
			}
		}
		$sort_arr   = SLZ_Params::get('sort-blog');
		$data = array(
			'data'        => $instance,
			'wp_widget'   => $this,
			'post_type'   => $post_type,
			'sort_arr'    => $sort_arr
		);

		echo slz_render_view($this->slz_widget->locate_path( '/views/admin.php' ), $data );
		
	}
}