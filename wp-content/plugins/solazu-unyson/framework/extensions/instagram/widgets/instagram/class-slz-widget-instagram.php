<?php 

class SLZ_Widget_Instagram extends WP_Widget {

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
			'classname' => (!empty( $this->config['classname'] ) ? $this->config['classname'] : ''),
		);
		parent::__construct( $this->config['id'], $this->config['name'], $widget_ops );
	}
	/**
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {
		$instagram_data = '';
		if( !empty( $instance['instagram_id'] ) ) {
			$instagram_data = slz_ext_instagram_get_instagram_data( $instance['instagram_id'] );
		}
		
		//get translated strings
		$block_title = slz_ext_widget_filters_block_title($args, $this, $instance['block_title']);
		
		$data = array(
			'before_widget' => $args['before_widget'],
			'after_widget'  => $args['after_widget'],
			'instagram_id'  => $instance['instagram_id'],
			'column'  		=> $instance['column'],
			'limit_image'   => $instance['limit_image'],
			'unique_id'   	=> SLZ_Com::make_id(),
			'media'			=> $instagram_data,
			'block_title'   => $block_title
		);

		$style = '';

		$css = '';

		if ( !empty( $instance['block_title_color'] ) && $instance['block_title_color'] != '#'  ) {

			$style ='.slz-gallery.instagram-%1$s .widget-title{ color: %2$s }';

			$css .= sprintf( $style, esc_attr( $data['unique_id'] ), esc_attr( $instance['block_title_color'] ) );

			do_action( 'slz_add_inline_style', $css );

		}

		echo slz_render_view($this->slz_widget->locate_path( '/views/front.php' ), $data );

	}

	function update( $new_instance, $old_instance ) {
		//register strings for translation
		slz_ext_widget_wpml_register_string($this, $new_instance['block_title']);

		return $new_instance;
	}

	function form( $instance ) {
		
		$instance = wp_parse_args( (array) $instance, $this->slz_widget->get_config('default_value') );
		
		echo slz_render_view($this->slz_widget->locate_path( '/views/admin.php' ), array( 'instance' => $instance, 'object' => $this ) );
		
	}

}
