<?php

class SLZ_Widget_Contact_Form extends WP_Widget {

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

        $unique_id = SLZ_Com::make_id();

        $style = '';
        $css = '';
        if( !empty( $instance['bg_color'] ) && $instance['bg_color'] != '#' ) {
            $style = '.slz-widget-contact-form-%1$s { background-color: %2$s !important; }';
            $css .= sprintf( $style, esc_attr( $unique_id ), esc_attr( $instance['bg_color'] ) );
        }
        $image_id = '';
        if( !empty( $instance['bg_image'] ) ) {
            $image_arr = json_decode($instance['bg_image']);
            $image_id = $image_arr->ID;
            if( !empty( $image_id ) ) {
                $image_url = wp_get_attachment_url( $image_id );
                $style = '.slz-widget-contact-form-%1$s { background-image: url(%2$s) !important; background-size: cover; }';
                $css .= sprintf( $style, esc_attr( $unique_id ), esc_url( $image_url ) );
            }
        }
        if( !empty( $css ) ) {
            do_action( 'slz_add_inline_style', $css );
        }

        $data = array(
            'before_widget' => $args['before_widget'],
            'after_widget'  => $args['after_widget'],
            'title'         => $title,
            'before_title'  => $args['before_title'],
            'after_title'   => $args['after_title'],
            'unique_id'     => $unique_id,
            'ctf'           => esc_attr( $instance['ctf'] ),
        );
        echo slz_render_view($this->slz_widget->locate_path( '/views/front.php' ), $data);
    }

    function update( $new_instance, $old_instance ) {
        //register strings for translation
        slz_ext_widget_wpml_register_string($this, $new_instance['address']);
        return $new_instance;
    }

    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance,array(
            'title'    => esc_html__( "Contact form", 'slz'),
            'bg_color'     => '',
            'bg_image'     => '',
            'ctf'          => '',
        ));

        $data = array(
            'data'            => $instance,
            'wp_widget'       => $this,
        );

        echo slz_render_view($this->slz_widget->locate_path( '/views/admin.php' ), $data );

    }
}