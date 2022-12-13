<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class SLZ_Extension_Templates extends SLZ_Extension
{
	/**
	 * @var SLZ_Template[]
	 */
	private $templates;

	/**
	 * Gets a certain template by a given tag
	 *
	 * @param string $tag The template tag
	 * @return SLZ_Template|null
	 */
	public function get_template($tag)
	{
		$this->load_templates();
		return isset($this->templates[$tag]) ? $this->templates[$tag] : null;
	}

	/**
	 * Gets all templates
	 *
	 * @return SLZ_Template[]
	 */
	public function get_templates()
	{
		$this->load_templates();
		return $this->templates;
	}

	/**
	 * Gets all template options
	 *
	 * @return array()
	 */
	public function get_template_options()
	{
		$templates = $this->get_templates();
		$result = array();
		foreach ($templates as $template_key => $template_instance) {
			$result[ $template_key ] = $template_instance->get_options();
		}
		return $result;
	}

	/**
	 * Gets all template to choices option
	 *
	 * @return array()
	 */
	public function get_template_choices()
	{
		$result = array();
		$templates = $this->get_templates();
		foreach ($templates as $template_key => $template_instance) {
			$config = $template_instance->get_config('general');
			$result[ $template_key ] = array(
				'small' => $config['small_img'],
                'large' => $config['large_img'],
			);
		}
		return $result;
	}

	public function load_templates()
	{
		static $is_loading = false; // prevent recursion

		if ($is_loading) {
			trigger_error('Recursive templates load', E_USER_WARNING);
			return;
		}

		if ($this->templates) {
			return;
		}

		$is_loading = true;

		$disabled_templates = apply_filters('slz_ext_templates_disabled_templates', array());
		$this->templates    = _SLZ_Templates_Loader::load(array(
			'disabled_templates' => $disabled_templates
		));

		$is_loading = false;
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

		// renders the templates so that css will get in <head>
		add_action(
			'wp_enqueue_scripts',
			array($this, '_action_enqueue_templates_static_in_frontend_head'),
			30
		);
	}

	/**
	 * @internal
	 */
	public function _action_slz_extensions_init()
	{
		$this->load_templates();
	}

	public function _action_init() {
	}

	/**
	 * Make sure to enqueue templates static in <head> (not in <body>)
	 * @internal
	 */
	public function _action_enqueue_templates_static_in_frontend_head()
	{
		if( !empty ( $this->templates ) ) {
			foreach ($this->templates as $tag => $instance) {
				$instance->_enqueue_static();
			}
		}
	}
}
