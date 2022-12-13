<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class SLZ_Extension_Custom_Sidebar extends SLZ_Extension
{

	/**
	 * @internal
	 */
	protected function _init()
	{
		add_action(
			'widgets_init',
			array($this, '_action_slz_widgets_init')
		);

		add_action(
			'admin_print_scripts',
			array($this, '_action_slz_add_widget_field')
		);

		add_action(
			'load-widgets.php',
			array($this, '_action_slz_add_sidebar_area')
		);

		add_action(
			'wp_ajax_slz_delete_custom_sidebar',
			array($this, '_action_slz_delete_custom_sidebar')
		);
	}

	public function _action_slz_widgets_init() {

		$sidebars = get_option( slz_ext('custom-sidebar')->manifest->get('sidebar-id') );

		$args =  array (
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => ''
		);

		if( is_array($sidebars) ) {
			foreach ( $sidebars as $sidebar ) {
				if( !empty($sidebar) ) {
					$name = isset($sidebar['name']) ? $sidebar['name'] : '';
					$title = isset($sidebar['title']) ? $sidebar['title'] : '';
					$class = isset($sidebar['class']) ? $sidebar['class'] : '';
					$args['name']   = $title;
					$args['id']     = str_replace(' ','-',strtolower( $name ));
					$args['class']  = 'slz-custom';
					$args['before_widget'] = '<div class="box %2$s slz-widget '. esc_attr($class) .'">';
					$args['after_widget']  = '</div>';
					$args['before_title']  = '<div class="title-widget">';
					$args['after_title']   = '</div>';
					register_sidebar($args);
				}
			}
		}
	}
	/**
	 * Add custom sidebar area
	 *
	 */
	public function _action_slz_add_widget_field() {

		$nonce =  wp_create_nonce ('slz-delete-sidebar-nonce');

		echo slz_render_view( dirname( __FILE__ ) . '/views/custom_field.php', compact( 'nonce' ) );

	}

	public function _action_slz_add_sidebar_area() {
		if( isset($_POST['slz-add-widget']) && !empty($_POST['slz-add-widget']['name']) ) {
			$sidebars = array();
			$sidebars = get_option( slz_ext('custom-sidebar')->manifest->get('sidebar-id') );
			$name = $this->_action_slz_get_widget_name($_POST['slz-add-widget']['name']);
			$class = $_POST['slz-add-widget']['class'];
			$sidebars[] = array('name'=>sanitize_title($name), 'title' => $name, 'class'=>$class);
			update_option( slz_ext('custom-sidebar')->manifest->get('sidebar-id') , $sidebars);
			wp_redirect( admin_url('widgets.php') );
			die();
		}
	}

	public function _action_slz_get_widget_name( $name ) {
		if( empty($GLOBALS['wp_registered_sidebars']) ){
			return $name;
		}

		$taken = array();
		foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) {
			$taken[] = $sidebar['name'];
		}
		$sidebars = get_option( slz_ext('custom-sidebar')->manifest->get('sidebar-id') );

		if( empty($sidebars) ) {
			$sidebars = array();
		}

		$taken = array_merge($taken, $sidebars);
		if( in_array($name, $taken) ) {
			$counter  = substr($name, -1);
			$new_name = "";
			if( !is_numeric($counter) ) {
				$new_name = $name . " 1";
			}
			else {
				$new_name = substr($name, 0, -1) . ((int) $counter + 1);
			}
			$name = $new_name;
		}
		return $name;
	}

	public function _action_slz_delete_custom_sidebar() {
		check_ajax_referer('slz-delete-sidebar-nonce');

		if( !empty($_POST['name']) ) {
			$name = sanitize_title($_POST['name']);
			$sidebars = get_option( slz_ext('custom-sidebar')->manifest->get('sidebar-id') );
			foreach($sidebars as $key => $sidebar){
				if( strcmp(trim($sidebar['name']), trim($name)) == 0) {
					unset($sidebars[$key]);
					update_option( slz_ext('custom-sidebar')->manifest->get('sidebar-id'), $sidebars);
					echo "success";
					break;
				}
			}
		}
		die();
	}
}
