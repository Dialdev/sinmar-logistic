<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class SLZ_Extension_Footers extends SLZ_Extension
{
	/**
	 * @var SLZ_Footer[]
	 */
	private $footers;

	/**
	 * Gets a certain footer by a given tag
	 *
	 * @param string $tag The footer tag
	 * @return SLZ_Footer|null
	 */
	public function get_footer($tag)
	{
		$this->load_footers();
		return isset($this->footers[$tag]) ? $this->footers[$tag] : null;
	}

	/**
	 * Gets all footers
	 *
	 * @return SLZ_Footer[]
	 */
	public function get_footers()
	{
		$this->load_footers();
		return $this->footers;
	}

	/**
	 * Gets all footer options
	 *
	 * @return array()
	 */
	public function get_footer_options()
	{
		$footers = $this->get_footers();
		$result = array();
		foreach ($footers as $footer_key => $footer_instance) {
			$result[ $footer_key ] = $footer_instance->get_options();
		}
		return $result;
	}

	/**
	 * Gets all footer to choices option
	 *
	 * @return array()
	 */
	public function get_footer_choices()
	{
		$result = array();
		$footers = $this->get_footers();
		foreach ($footers as $footer_key => $footer_instance) {
			$config = $footer_instance->get_config('general');
			$result[ $footer_key ] = array(
				'small' => $config['small_img'],
                'large' => $config['large_img'],
			);
		}
		return $result;
	}

	public function load_footers()
	{
		static $is_loading = false; // prevent recursion

		if ($is_loading) {
			trigger_error('Recursive footers load', E_USER_WARNING);
			return;
		}

		if ($this->footers) {
			return;
		}

		$is_loading = true;

		$disabled_footers = apply_filters('slz_ext_footers_disabled_footers', array());
		$this->footers    = _SLZ_Footers_Loader::load(array(
			'disabled_footers' => $disabled_footers
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
	}

	/**
	 * @internal
	 */
	public function _action_slz_extensions_init()
	{
		$this->load_footers();
	}

	public function _action_init() {
	}

}
