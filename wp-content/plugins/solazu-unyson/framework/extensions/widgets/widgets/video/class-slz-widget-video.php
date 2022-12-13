<?php 

class SLZ_Widget_Video extends WP_Widget {

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
		slz_ext_widget_wpml_translate_string($this, $instance['title']);

        $unique_id = SLZ_Com::make_id();
        $css = '';
        if ( !empty( $instance['height'] ) ) {
            $style = '.slz-widget-video-%1$s.slz-block-video .block-video::before{ padding-top:%2$s ; }';
            $css .= sprintf( $style, esc_attr( $unique_id ), esc_attr( $instance['height'] ) );
        }
        if( !empty( $css ) ) {
            do_action( 'slz_add_inline_style', $css );
        }

        $image_url = '';
        if( !empty( $instance['bg_image'] ) ) {
            $image_arr = json_decode($instance['bg_image']);
            if(!empty($image_arr)){
            	$image_id = $image_arr->ID;
	            if( !empty( $image_id ) ) {
	                $image_url = wp_get_attachment_url( $image_id );
	            }
            }
        }

		$option_arr = array('title','content');
		foreach ($option_arr as $key ) {
			if( !isset( $instance[$key] ) ) {
				$instance[$key] = '';
			}
		}

		$data = array(
			'before_widget' => $args['before_widget'],
			'after_widget'  => $args['after_widget'],
            'unique_id'     => $unique_id,
            'title'         => $title,
			'content'       => esc_attr( $instance['content'] ),
			'type'          => $instance['type'],
			'align'         => $instance['align'],
            'bg_image'      => esc_attr( $image_url ),
            'video_id'      => $instance['video_id'],
		);
		echo slz_render_view($this->slz_widget->locate_path( '/views/front.php' ), $data);
	}

	function update( $new_instance, $old_instance ) {
		//register strings for translation
		slz_ext_widget_wpml_register_string($this, $new_instance['title']);
		return $new_instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance,array( 
			'title'         => esc_html__( "Video", 'slz'),
            'content'       => '',
			'height'        => '',
			'bg_image'      => '',
			'type'          => '',
			'align'         => '',
			'video_id'      => '',
		));

		$data = array(
			'data'            => $instance,
			'wp_widget'       => $this,
		);

		echo slz_render_view($this->slz_widget->locate_path( '/views/admin.php' ), $data );
		
	}
}