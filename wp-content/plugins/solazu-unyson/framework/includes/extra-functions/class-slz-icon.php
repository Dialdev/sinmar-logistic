<?php
/**
* Icon Class
*/
class SLZ_Icon
{	
	public $icon_config;
	public function __construct(){
		$this->icon_config = slz()->theme->get_config('supported_flaticon');
		// Register Backend and Frontend CSS Styles
		add_action( 'vc_base_register_front_css', array(&$this, '_action_iconpicker_base_register_css') );
		add_action( 'vc_base_register_admin_css', array(&$this, '_action_iconpicker_base_register_css') );

		// Enqueue Backend and Frontend CSS Styles
		add_action( 'vc_backend_editor_enqueue_js_css', array(&$this, '_action_iconpicker_editor_js_css') );
		add_action( 'vc_frontend_editor_enqueue_js_css', array(&$this, '_action_iconpicker_editor_js_css') );

		// Enqueue CSS in Frontend when it's used
		add_action('vc_enqueue_font_icon_element', array(&$this, '_action_enqueue_font_flaticon') );
		// Define Icons for VC Iconpicker
		add_filter( 'vc_iconpicker-type-flaticon', array(&$this, '_filter_iconpicker_type_flaticon')  );

	}
	public function _action_iconpicker_base_register_css(){
		if( !empty($this->icon_config['is_supported']) && !empty($this->icon_config['url']) 
				&& !empty($this->icon_config['vc_icons_map'])) {
			wp_register_style('font-flaticon', $this->icon_config['url']);
		}
	}

	public function _action_iconpicker_editor_js_css(){
		if( !empty($this->icon_config['is_supported']) && !empty($this->icon_config['url']) 
				&& !empty($this->icon_config['vc_icons_map']) ) {
			wp_enqueue_style( 'font-flaticon' );
		}
	}

	public function _action_enqueue_font_flaticon($font){
		switch ( $font ) {
			case 'flaticon': wp_enqueue_style( 'font-flaticon' );
		}
	}
	public function _filter_iconpicker_type_flaticon( $icons ) {
		$flaticons = array();
		/**
		 * config array : array('flaticon-animals' => 'flaticon-animals')
		 */
		if( !empty($this->icon_config['is_supported']) && !empty($this->icon_config['url'])
				&& !empty($this->icon_config['vc_icons_map'])) {
			$flaticons = $this->icon_config['vc_icons_map'];
			return array_merge( $icons, $flaticons );
		}
		
	}

} new SLZ_Icon();