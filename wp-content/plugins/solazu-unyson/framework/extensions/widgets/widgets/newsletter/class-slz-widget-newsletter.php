<?php 

class SLZ_Widget_Newsletter extends NewsletterWidget {

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
		parent::__construct();
	}
	/**
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {

		$default = array(
			'title'             => '',
			'style'             => '',
			'email_placeholder' => '',
			'name_placeholder'  => '',
			'show_hide'         => '',
			'description'       => '',
			'button_text'       => '',
		);
		$instance = array_merge( $default, $instance );
		
		//get translated strings
		$title = slz_ext_widget_filters_widget_title( $args, $instance );
		slz_ext_widget_wpml_translate_string($this, $instance['email_placeholder'], 'input-1');
		slz_ext_widget_wpml_translate_string($this, $instance['name_placeholder'], 'input-2');
		slz_ext_widget_wpml_translate_string($this, $instance['button_text'], 'input-3');
		slz_ext_widget_wpml_translate_string($this, $instance['description'], 'textarea-1');
		
		$data = array(
			'before_widget' => $args['before_widget'],
			'after_widget'  => $args['after_widget'],
			'style'         => esc_attr($instance['style']),
			'title'         => $title,
			'email_placeholder'  => esc_attr( $instance['email_placeholder'] ),
			'name_placeholder'   => esc_attr( $instance['name_placeholder'] ),
			'show_hide'     => esc_attr( $instance['show_hide'] ),
			'description'   => esc_attr($instance['description']),
			'button_text'   => esc_attr( $instance['button_text'] )
		);

		echo slz_render_view($this->slz_widget->locate_path( '/views/front.php' ), $data );
		
	}

	function update( $new_instance, $old_instance ) {
		//register strings for translation
		slz_ext_widget_wpml_register_string($this, $new_instance['email_placeholder'], 'input-1');
		slz_ext_widget_wpml_register_string($this, $new_instance['name_placeholder'], 'input-2');
		slz_ext_widget_wpml_register_string($this, $new_instance['button_text'], 'input-3');
		slz_ext_widget_wpml_register_string($this, $new_instance['description'], 'textarea-1');
		
		return $new_instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance,array( 
			'style'           => '01',
			'title'           => '',
			'description'     => '',
			'email_placeholder'  => esc_html__( 'Email Address', 'slz' ),
			'name_placeholder'   => esc_html__( 'Your Name', 'slz' ),
			'show_hide'       => 'show',
			'button_text'     => 'Submit',
		));
		$style = $this->slz_widget->get_config('style');
		$show_hide = $this->slz_widget->get_config('show_hide');
		$data = array(
			'data'        => $instance,
			'show_hide'   => $show_hide,
			'style'       => $style,
			'wp_widget'   => $this
		);
		echo slz_render_view($this->slz_widget->locate_path( '/views/admin.php' ), $data );
	}
}