<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class SLZ_Extension_Articles extends SLZ_Extension
{
	/**
	 * @var SLZ_Article[]
	 */
	private $articles;

	/**
	 * Gets a certain article by a given tag
	 *
	 * @param string $tag The article tag
	 * @return SLZ_Article|null
	 */
	public function get_article($tag)
	{
		$this->load_articles();
		return isset($this->articles[$tag]) ? $this->articles[$tag] : null;
	}

	/**
	 * Gets all articles
	 *
	 * @return SLZ_Article[]
	 */
	public function get_articles()
	{
		$this->load_articles();
		return $this->articles;
	}

	/**
	 * Gets all article options
	 *
	 * @return array()
	 */
	public function get_article_options()
	{
		$articles = $this->get_articles();
		$result = array();
		foreach ($articles as $article_key => $article_instance) {
			$result[ $article_key ] = $article_instance->get_options();
		}
		return $result;
	}

	/**
	 * Gets all article to choices option
	 *
	 * @return array()
	 */
	public function get_article_choices()
	{
		$result = array();
		$articles = $this->get_articles();
		foreach ($articles as $article_key => $article_instance) {
			$config = $article_instance->get_config('general');
			$result[ $article_key ] = array(
				'small' => $config['small_img'],
                'large' => $config['large_img'],
			);
		}
		return $result;
	}

	public function load_articles()
	{
		static $is_loading = false; // prevent recursion

		if ($is_loading) {
			trigger_error('Recursive articles load', E_USER_WARNING);
			return;
		}

		if ($this->articles) {
			return;
		}

		$is_loading = true;

		$disabled_articles = apply_filters('slz_ext_articles_disabled_articles', array());
		$this->articles    = _SLZ_Articles_Loader::load(array(
			'disabled_articles' => $disabled_articles
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

		// renders the articles so that css will get in <head>
		add_action(
			'wp_enqueue_scripts',
			array($this, '_action_enqueue_articles_static_in_frontend_head'),
			30
		);
	}

	/**
	 * @internal
	 */
	public function _action_slz_extensions_init()
	{
		$this->load_articles();
	}

	public function _action_init() {
	}

	/**
	 * Make sure to enqueue articles static in <head> (not in <body>)
	 * @internal
	 */
	public function _action_enqueue_articles_static_in_frontend_head()
	{
		if( !empty ( $this->articles ) ) {
			foreach ($this->articles as $tag => $instance) {
				$instance->_enqueue_static();
			}
		}
	}
}
