<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class SLZ_Extension_Posts extends SLZ_Extension
{
	/**
	 * @var SLZ_Post[]
	 */
	private $posts;

	/**
	 * Gets a certain post by a given tag
	 *
	 * @param string $tag The post tag
	 * @return SLZ_Post|null
	 */
	public function get_post($tag)
	{
		$this->load_posts();
		return isset($this->posts[$tag]) ? $this->posts[$tag] : null;
	}

	/**
	 * Gets all posts
	 *
	 * @return SLZ_Post[]
	 */
	public function get_posts()
	{
		$this->load_posts();
		return $this->posts;
	}

	/**
	 * Gets all post options
	 *
	 * @return array()
	 */
	public function get_posts_options()
	{
		$posts = $this->get_posts();
		$result = array();
		foreach ($posts as $post_key => $post_instance) {
			$result[ $post_key ] = $post_instance->get_options();
		}
		return $result;
	}

	/**
	 * Gets all post to choices option
	 *
	 * @return array()
	 */
	public function get_post_choices()
	{
		$result = array();
		$posts = $this->get_posts();
		foreach ($posts as $post_key => $post_instance) {
			$config = $post_instance->get_config('general');
			$result[ $post_key ] = array(
				'small' => $config['small_img'],
                'large' => $config['large_img'],
			);
		}
		return $result;
	}

	public function load_posts()
	{
		static $is_loading = false; // prevent recursion

		if ($is_loading) {
			trigger_error('Recursive posts load', E_USER_WARNING);
			return;
		}

		if ($this->posts) {
			return;
		}

		$is_loading = true;

		$disabled_posts = apply_filters('slz_ext_posts_disabled_posts', array());
		$this->posts    = _SLZ_Posts_Loader::load(array(
			'disabled_posts' => $disabled_posts
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
		$this->load_posts();
	}

	public function _action_init() {
	}

}
