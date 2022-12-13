<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class SLZ_Extension_Widgets extends SLZ_Extension
{
	/**
	 * @var SLZ_Widget[]
	 */
	private $widgets;

	/**
	 * Gets a certain widget by a given tag
	 *
	 * @param string $tag The widget tag
	 * @return SLZ_Widget|null
	 */
	public function get_widget($tag)
	{
		$this->load_widgets();
		return isset($this->widgets[$tag]) ? $this->widgets[$tag] : null;
	}

	/**
	 * Gets all widgets
	 *
	 * @return SLZ_Widget[]
	 */
	public function get_widgets()
	{
		$this->load_widgets();
		return $this->widgets;
	}

	public function load_widgets()
	{
		static $is_loading = false; // prevent recursion

		if ($is_loading) {
			trigger_error('Recursive widgets load', E_USER_WARNING);
			return;
		}

		if ($this->widgets) {
			return;
		}

		$is_loading = true;

		$disabled_widgets = apply_filters('slz_ext_widgets_disabled_widgets', array());
		$this->widgets    = _SLZ_Widgets_Loader::load(array(
			'disabled_widgets' => $disabled_widgets
		));

		$enabled_widgets = apply_filters('slz_ext_widgets_enable_widgets', array());

		if ( count( $enabled_widgets ) > 0 ) {

			foreach ($this->widgets as $widget_key => $widget_object ) {
				
				if ( !in_array( $widget_key , $enabled_widgets ) )
					unset ( $this->widgets[$widget_key]);

			}

		}

		$is_loading = false;
	}

	public function register_widgets(){

		foreach ($this->widgets as $tag => $instance) {

			if ( $instance->get_widget_class() != '' ) {
				if ( class_exists( $instance->get_widget_class() ) )
					register_widget( $instance->get_widget_class() );
			}

		}

	}

	/**
	 * @internal
	 */
	protected function _init()
	{
		add_action('slz_extensions_init', array($this, '_action_slz_extensions_init'));
		add_action('init', array($this, '_action_init'),
			11
		);

		add_action('widgets_init', array($this, 'register_widgets'),
			11
		);

		// renders the widget so that css will get in <head>
		add_action(
			'wp_enqueue_scripts',
			array($this, '_action_enqueue_widgets_static_in_frontend_head'),
			30
		);

		// check newsletter plugin
		if ( is_plugin_active( 'newsletter/plugin.php' ) ) {
			add_action('widgets_init', create_function('', 'return unregister_widget( "NewsletterWidget" );'));
		}
		else {
			add_filter('slz_ext_widgets_disabled_widgets', create_function('', 'return array("newsletter");'));
		}
	}

	/**
	 * @internal
	 */
	public function _action_slz_extensions_init()
	{
		$this->load_widgets();
	}

	public function _action_init() {
		$this->register_widgets();
	}

	/**
	 * Make sure to enqueue widgetes static in <head> (not in <body>)
	 * @internal
	 */
	public function _action_enqueue_widgets_static_in_frontend_head()
	{
		if( !empty ( $this->widgets ) ) {
			foreach ($this->widgets as $tag => $instance) {
				$instance->_enqueue_static();
			}
		}
	}
}
