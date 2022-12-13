<?php 

class SLZ_Widget_Project extends WP_Widget {

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
		$check_box = $this->slz_widget->get_config('check_box');
		//get translated strings
		$title = slz_ext_widget_filters_widget_title( $args, $instance );
		slz_ext_widget_wpml_translate_string($this, $instance['button_text']);
		$data = array(
			'before_widget' => $args['before_widget'],
			'after_widget'  => $args['after_widget'],
			'title'         => $title,
			'instance'      => $instance,
			'check_box'     => $check_box
		);
		echo slz_render_view($this->slz_widget->locate_path( '/views/front.php' ), $data);
	}

	function update( $new_instance, $old_instance ) {
		$new_instance['show_image']     = strip_tags($new_instance['show_image']);
		$new_instance['show_category']  = strip_tags($new_instance['show_category']);
		$new_instance['show_description'] = strip_tags($new_instance['show_description']);
        $new_instance['show_team']     = strip_tags($new_instance['show_team']);
        $new_instance['show_date']  = strip_tags($new_instance['show_date']);
        $new_instance['show_download'] = strip_tags($new_instance['show_download']);
		//register strings for translation
		slz_ext_widget_wpml_register_string($this, $new_instance['button_text']);
		return $new_instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance,array( 
			'title'           => '',
			'limit_post'      => '5',
			'sort_by'         => '',
			'cat_id'          => '',
			'offset_post'     => '',
			'image_type'      => '',
			'button_text'     => '',
			'button_custom_link' => '',
			'show_image'       => 'on',
			'show_description' => 'on',
            'show_category'    => 'on',
            'show_team'        => 'on',
            'show_date'        => 'on',
            'show_download'    => 'on',
			));
		$check_box = $this->slz_widget->get_config('check_box');
		$image_type = $this->slz_widget->get_config('image_type');

		$data = array(
			'data'            => $instance,
			'wp_widget'       => $this,
			'check_box'       => $check_box,
			'image_type'      => $image_type
		);

		echo slz_render_view($this->slz_widget->locate_path( '/views/admin.php' ), $data );
		
	}
}