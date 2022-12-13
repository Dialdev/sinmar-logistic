<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class SLZ_Extension_Headers extends SLZ_Extension
{
	/**
	 * @var SLZ_Header[]
	 */
	private $headers;

	/**
	 * Gets a certain header by a given tag
	 *
	 * @param string $tag The header tag
	 * @return SLZ_Header|null
	 */
	public function get_header($tag)
	{
		$this->load_headers();
		$tag = str_replace("-", "_", $tag);
		return isset($this->headers[$tag]) ? $this->headers[$tag] : null;
	}

	/**
	 * Gets all headers
	 *
	 * @return SLZ_Header[]
	 */
	public function get_headers()
	{
		$this->load_headers();
		return $this->headers;
	}

	/**
	 * Gets all header options
	 *
	 * @return array()
	 */
	public function get_header_options()
	{
		$headers = $this->get_headers();
		$result = array();
		foreach ($headers as $header_key => $header_instance) {
			$result[ $header_key ] = $header_instance->get_options();
		}
		return $result;
	}

	/**
	 * Gets all header to choices option
	 *
	 * @return array()
	 */
	public function get_header_choices()
	{
		$result = array();
		$headers = $this->get_headers();
		foreach ($headers as $header_key => $header_instance) {
			$config = $header_instance->get_config('general');
			$result[ $header_key ] = array(
				'small' => $config['small_img'],
                'large' => $config['large_img'],
			);
		}
		return $result;
	}

	public function get_first_header(){

		$headers = $this->get_headers();

		if ( !empty ( $headers ) ){

			reset($headers);

			return key($headers);
		}

		return;

	}

	public function load_headers()
	{
		static $is_loading = false; // prevent recursion

		if ($is_loading) {
			trigger_error('Recursive headers load', E_USER_WARNING);
			return;
		}

		if ($this->headers) {
			return;
		}

		$is_loading = true;

		$disabled_headers = apply_filters('slz_ext_headers_disabled_headers', array());
		$this->headers    = _SLZ_Headers_Loader::load(array(
			'disabled_headers' => $disabled_headers
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

		// renders the headers so that css will get in <head>
		add_action(
			'wp_enqueue_scripts',
			array($this, '_action_enqueue_headers_static_in_frontend_head'),
			30
		);
	}

	/**
	 * @internal
	 */
	public function _action_slz_extensions_init()
	{
		$this->load_headers();
	}

	public function _action_init() {
	}

	/**
	 * Make sure to enqueue headers static in <head> (not in <body>)
	 * @internal
	 */
	public function _action_enqueue_headers_static_in_frontend_head()
	{
		if( !empty ( $this->headers ) ) {
			foreach ($this->headers as $tag => $instance) {
				// $instance->_enqueue_static();
			}
		}
	}
}
