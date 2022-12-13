<?php
class SLZ_Widget_Events extends WP_Widget {
    private $slz_widget;
    private $config;

    public function __construct()
    {
        // Get current widget instance
        $this->slz_widget = slz_ext( 'widgets' )->get_widget( get_class( $this ) );
        // Thrown warning if load fail
        if( is_null( $this->slz_widget ) ) {
            trigger_error( 'Cannot load this widget', E_USER_WARNING );
            return;
        }
        // Get config
        $this->config = $this->slz_widget->get_config( 'general' );
        $widget_ops = array(
            'description' => ( ! empty( $this->config['description'] ) ) ? $this->config['description'] : '',
            'classname' => ( ! empty( $this->config['classname'] ) ) ? $this->config['classname'] : '',
        );
        parent::__construct( $this->config['id'], $this->config['name'], $widget_ops );
    }

    public function widget($args, $instance)
    {
        $unique_id = SLZ_Com::make_id();
        $data = array(
            'before_widget' => $args['before_widget'],
            'after_widget'  => $args['after_widget'],
            'instance'      => $instance,
        	'image_size'    => $this->slz_widget->get_config('image_size'),
            'unique_id'     => $unique_id,
        );
        $style = '';
        $css = '';
        if( ! empty( $instance['block_title_color']) && $instance['block_title_color'] != '#' ) {
            $style = '.slz-event .slz-widget-event-%1$ .widget-title { color: %2$s }';
            $css .= sprintf( $style, esc_attr( $unique_id ), esc_attr( $instance['block_title_color'] ) );
            do_action( 'slz_add_inline_style', $css );
        }
        echo slz_render_view( $this->slz_widget->locate_path( '/views/front.php' ), $data );
    }

    public function update($new_instance, $old_instance)
    {
        return $new_instance;
    }

    public function form( $instance )
    {
        $instance = wp_parse_args( (array) $instance, $this->slz_widget->get_config( 'default_value' ) );
        echo slz_render_view( $this->slz_widget->locate_path( '/views/admin.php' ), array( 'instance' => $instance, 'object' => $this ) );
    }


}