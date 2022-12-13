<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class SLZ_Extension_Top_Posts extends SLZ_Extension
{
	/**
	 * @var SLZ_Top_Post[]
	 */
	private $top_posts;

	/**
	 * Gets a certaintop post by a given tag
	 *
	 * @param string $tag Thetop post tag
	 * @return SLZ_Top_Post|null
	 */
	public function get_top_post($tag)
	{
		$this->load_top_posts();
		return isset($this->top_posts[$tag]) ? $this->top_posts[$tag] : null;
	}

	/**
	 * Gets all top posts
	 *
	 * @return SLZ_Top_Post[]
	 */
	public function get_top_posts()
	{
		$this->load_top_posts();
		return $this->top_posts;
	}

	/**
	 * Gets all top post options
	 *
	 * @return array()
	 */
	public function get_top_post_options()
	{
		$top_posts = $this->get_top_posts();
		$result = array();
		foreach ($top_posts as $top_post_key => $top_post_instance) {
			$result[ $top_post_key ] = $top_post_instance->get_options();
		}
		return $result;
	}

	/**
	 * Gets all top post to choices option
	 *
	 * @return array()
	 */
	public function get_top_post_choices()
	{
		$result = array();
		$top_posts = $this->get_top_posts();
		foreach ($top_posts as $top_post_key => $top_post_instance) {
			$config = $top_post_instance->get_config('general');
			$result[ $top_post_key ] = array(
				'small' => $config['small_img'],
                'large' => $config['large_img'],
			);
		}
		return $result;
	}

	public function load_top_posts()
	{
		static $is_loading = false; // prevent recursion

		if ($is_loading) {
			trigger_error('Recursivetop posts load', E_USER_WARNING);
			return;
		}

		if ($this->top_posts) {
			return;
		}

		$is_loading = true;

		$disabled_top_posts = apply_filters('slz_ext_top_posts_disabled_top_posts', array());
		$this->top_posts    = _SLZ_Top_Posts_Loader::load(array(
			'disabled_top_posts' => $disabled_top_posts
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

		// renders thetop posts so that css will get in <head>
		add_action(
			'wp_enqueue_scripts',
			array($this, '_action_enqueue_top_posts_static_in_frontend_head'),
			30
		);
	}

	/**
	 * @internal
	 */
	public function _action_slz_extensions_init()
	{
		$this->load_top_posts();
	}

	public function _action_init() {
	}

	/**
	 * Make sure to enqueuetop posts static in <head> (not in <body>)
	 * @internal
	 */
	public function _action_enqueue_top_posts_static_in_frontend_head()
	{
		if( !empty ( $this->top_posts ) ) {
			foreach ($this->top_posts as $tag => $instance) {
				$instance->_enqueue_static();
			}
		}
	}	
}
