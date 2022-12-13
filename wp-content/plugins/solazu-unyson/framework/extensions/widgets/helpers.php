<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( ! function_exists( 'slz_ext_widget_wpml_register_string' ) ) {
	function slz_ext_widget_wpml_register_string($object, $value, $type = 'input-'){
		if (function_exists ( 'icl_register_string' )){
			$context = esc_html__( 'Widgets', 'slz' );
			$name = $object->name . ' ' . $type . $object->number;
			icl_register_string( $context, $name, $value );
		}
	}
}

if( ! function_exists( 'slz_ext_widget_wpml_translate_string' ) ) {
	function slz_ext_widget_wpml_translate_string($object, &$value, $type = 'input-'){
		if ( has_filter( 'wpml_translate_single_string' ) ){
			$context = esc_html__( 'Widgets', 'slz' );
			$name = $object->name . ' ' . $type . $object->number;
			$value = apply_filters('wpml_translate_single_string', $value, $context, $name );
		}
	}
}

if( ! function_exists( 'slz_ext_widget_filters_widget_title' ) ) {
	function slz_ext_widget_filters_widget_title( $args, $instance ){
		$title = '';
		if(!empty( $instance['title'])){
			$title = apply_filters( 'widget_title', $instance['title'], $instance );
			$before_title =  str_replace( 'class="', 'class="widget-title ', $args['before_title'] );
			$title = $before_title . esc_html( $title ) . $args['after_title'];
		}
		return $title;
	}
}

if( ! function_exists( 'slz_ext_widget_filters_block_title' ) ) {
	function slz_ext_widget_filters_block_title( $args, $object, $block_title ){
		$title = '';
		if(!empty( $block_title)){
			slz_ext_widget_wpml_translate_string($object, $block_title);
			$before_title =  str_replace( 'class="', 'class="widget-title ', $args['before_title'] );
			$title = $before_title . esc_html( $block_title ) . $args['after_title'];
		}
		return $title;
	}
}
