<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class SLZ_Extension_Shortcodes extends SLZ_Extension
{
	/**
	 * @var SLZ_Shortcode[]
	 */
	private $shortcodes;

	/**
	 * @var SLZ_Ext_Shortcodes_Attr_Coder[]
	 */
	private $coders = array();

	/**
	 * Gets a certain shortcode by a given tag
	 *
	 * @param string $tag The shortcode tag
	 * @return SLZ_Shortcode|null
	 */
	public function get_shortcode($tag)
	{
		$tag = str_replace('-', '_', $tag);
		$this->load_shortcodes();
		return isset($this->shortcodes[$tag]) ? $this->shortcodes[$tag] : null;
	}

	/**
	 * Gets all shortcodes
	 *
	 * @return SLZ_Shortcode[]
	 */
	public function get_shortcodes()
	{
		$this->load_shortcodes();
		return $this->shortcodes;
	}

	/**
	 * @internal
	 */
	protected function _init()
	{
		add_action('slz_extensions_init', array($this, '_action_slz_extensions_init'));
		add_action('init', array($this, '_action_init'),
			11 // register shortcodes later than other plugins (there were some problems with the `column` shortcode)
		);

		add_action('wp_ajax_slz_shortcode_ext_ajax', array( $this, 'ajax_response') );
		add_action('wp_ajax_nopriv_slz_shortcode_ext_ajax', array( $this, 'ajax_response') );


		/**
		 * We need aggressive only for wp-editor, at least for now.
		 * https://github.com/ThemeFuse/Unyson/issues/1807#issuecomment-235243578
		 */
		add_action(
			'wp_enqueue_editor',
			array($this, '_action_editor_shortcodes')
		);

		// renders the shortcodes so that css will get in <head>
		add_action(
			'wp_enqueue_scripts',
			array($this, '_action_enqueue_shortcodes_static_in_frontend_head'),
			/**
			 * Enqueue later than theme styles
			 * https://github.com/ThemeFuse/Theme-Includes/blob/b1467714c8a3125f077f1251f01ba6d6ca38640f/init.php#L41
			 * to be able to wp_add_inline_style('theme-style-handle', ...) in 'slz_ext_shortcodes_enqueue_static:{name}' action
			 * http://manual.unyson.io/en/latest/extension/shortcodes/index.html#enqueue-shortcode-dynamic-css-in-page-head
			 * in case the shortcode doesn't have a style, needed in step 3.
			 */
			30
		);

		add_action(
			'wp_ajax_slz_ext_wp_shortcodes_data',
			array($this, 'send_wp_shortcodes_data')
		);
	}

	/**
	 * @since 1.3.19
	 */
	public function send_wp_shortcodes_data() {
		wp_send_json_success(array(
			'shortcodes' => $this->build_shortcodes_list()
		));
	}

	/**
	 * @since 2.5.6
	 */
	public function ajax_response(){

		if ( !empty ( $_POST['module'] ) ) {

			if( !empty( $_POST['params']['0']['block'] ) ){
				$atts = $_POST['params'][0]['atts'];

				if(isset($_POST['params'][0]['page'])){
					$page = $_POST['params'][0]['page'];
					$atts['paged'] = $page;
				}
				else{
					if(empty($atts['cur_limit'])){
						$atts['cur_limit'] = $atts['limit_post'];
					}

					if( empty( $atts['large_post_count'] ) ) $atts['large_post_count'] = 0;
					
					$atts['cur_limit'] += intval($atts['limit_post'] - $atts['large_post_count']);
				}  

				$shortcode = $this->get_shortcode( $_POST['params']['0']['block'] );

				echo ( $shortcode->render($atts, '', '', true) );
			}

		}
		
		exit;

	}

	public function ajax_response_category(){

		if( !empty( $_POST['params']['0']['block'] ) ){
			$atts = $_POST['params'][0]['atts'];
			$category = $_POST['params'][0]['cat'];
			$all_tab = isset($_POST['params'][0]['all_tab']) ? true : false;

			if(isset($_POST['params'][0]['page'])){
				set_query_var( "paged", $_POST['params'][0]['page']);
			}

			if($atts['category_filter'] == 'author'){
				if($all_tab)
					$atts['author'] = '';
				else
					$atts['author'] = $category;
			}
			else if($atts['category_filter'] == 'category'){
				if($all_tab)
					$atts['category_slug'] = '';
				else
					$atts['category_slug'] = $category;
			}
			else if($atts['category_filter'] == 'tag_slug'){
				if($all_tab)
					$atts['tag_slug'] = '';
				else
					$atts['tag_slug'] = $category;
			}
			if(get_query_var('paged'))
				$atts['paged'] = get_query_var('paged');

			$shortcode = $this->get_shortcode( $_POST['params']['0']['block'] );

			echo ( $shortcode->render($atts, '', '', true) );
		}
		exit;
	}


    /**
     * Like post and update like view
     */
    function ajax_postlike() {
        session_start();
        $liked = array();
        if( isset( $_SESSION['postliked'] ) && is_array( $_SESSION['postliked'] ) ) {
            $liked = $_SESSION['postliked'];
        }
        $params = $_POST['params'];
        if( ! isset( $params[0]['postid'] ) ){
            exit();
        }
        $post_id = intval( $params[0]['postid'] );
        $class = 'link like ';
        $title = esc_html__( 'Like', 'slz' );
        $count_key = 'slz_postlike_number';
        $count = get_post_meta( $post_id, $count_key, true );
        if( $count == '' ) {
            $count = 0;
            delete_post_meta( $post_id, $count_key );
            add_post_meta( $post_id, $count_key, $count );
        } else {
            if( in_array($post_id, $liked) ) {
                $count--;
                $arr_id = array_search($post_id, $liked);
                unset( $liked[$arr_id] );
            } else {
                $count++;
                $liked[] = $post_id;
                $class .= 'text-red';
                $title = esc_html__( 'Unlike', 'slz' );
            }
            update_post_meta( $post_id, $count_key, $count );
        }
        $_SESSION['postliked'] = $liked;
        $res = array( 'count' => $count, 'class' => $class, 'title' => $title );
        echo json_encode( $res );
        exit();
    }

	/**
	 * @since 1.3.19
	 */
	public function build_shortcodes_list() {
		$shortcodes = array_values( slz_ext('shortcodes')->get_shortcodes() );

		$shortcodes = array_map(
			array($this, '_parse_single_shortcode'),
			$shortcodes
		);

		return $shortcodes;
	}

	/**
	 * @since 1.3.19
	 */
	public function _parse_single_shortcode( $shortcode ) {
		$result = array();

		$icon = $shortcode->locate_URI('/static/img/page_builder.png');

		if ($icon) {
			$result['icon'] = $icon;
		}

		$result['options'] = $shortcode->get_options();
		$result['config'] = $shortcode->get_config();
		$result['tag'] = $shortcode->get_tag();

		if ($result['options']) {
			$result['default_values'] = slz_get_options_values_from_input(
				$result['options'],
				array()
			);
		}

		$title = $shortcode->get_config('page_builder/title');
		$result['title'] = $title ? $title : $result['tag'];

		return $result;
	}

	/**
	 * @internal
	 */
	public function _action_slz_extensions_init()
	{
		$this->load_shortcodes();
	}

	public function _action_editor_shortcodes()
	{
		wp_enqueue_script('slz-ext-shortcodes-editor-integration');
	}

	public function _action_init() {
		$this->register_shortcodes();
	}

	public function load_shortcodes()
	{
		static $is_loading = false; // prevent recursion

		if ($is_loading) {
			trigger_error('Recursive shortcodes load', E_USER_WARNING);
			return;
		}

		if ($this->shortcodes) {
			return;
		}

		$is_loading = true;

		$disabled_shortcodes = apply_filters('slz_ext_shortcodes_disable_shortcodes', array());
		$this->shortcodes    = _SLZ_Shortcodes_Loader::load(array(
			'disabled_shortcodes' => $disabled_shortcodes
		));

		$enabled_shortcodes = apply_filters('slz_ext_shortcodes_enable_shortcodes', array());

		if ( count( $enabled_shortcodes ) > 0 ) {

			foreach ($this->shortcodes as $shortcode_key => $shortcode_object ) {
				
				if ( !in_array( $shortcode_key , $enabled_shortcodes ) )
					unset ( $this->shortcodes[$shortcode_key]);

			}

		}

		$is_loading = false;
	}

	private function register_shortcodes()
	{
		foreach ($this->shortcodes as $tag => $instance) {

			$config = $instance->get_config('page_builder');

			if ( !empty ( $config['tag'] ) )
				$shortcode_tag = $config['tag'];
			else
				$shortcode_tag = $tag;

			add_shortcode($shortcode_tag, array($instance, 'render'));
		}
	}

	/**
	 * Make sure to enqueue shortcodes static in <head> (not in <body>)
	 * @internal
	 */
	public function _action_enqueue_shortcodes_static_in_frontend_head()
	{
		do_action('slz:ext:shortcodes:enqueue_custom_content');

		/** @var WP_Post $post */
		global $post;

		if (!$post) {
			return;
		}

		$this->enqueue_shortcodes_static($post->post_content);
	}

	/**
	 * @see slz_ext_shortcodes_enqueue_shortcodes_static()
	 * @param string $content
	 */
	public function enqueue_shortcodes_static( $content ) {
		preg_replace_callback( '/'. get_shortcode_regex() .'/s', array( $this, 'enqueue_shortcode_static'), $content );
	}

	private function enqueue_shortcode_static( $shortcode ) {
		/**
		 * Remember the enqueued shortcodes and prevent enqueue static multiple times.
		 * There is no sense to call enqueue_static() multiple times
		 * because there is no dynamic data passed to it.
		 */
		static $enqueued_shortcodes = array();

		// allow [[foo]] syntax for escaping a tag
		if ( $shortcode[1] == '[' && $shortcode[6] == ']' ) {
			return;
		}

		$tag = $shortcode[2];

		if ( ! is_null( $this->get_shortcode( $tag ) ) ) {
			if (!isset($enqueued_shortcodes[$tag])) {
				$this->get_shortcode($tag)->_enqueue_static();
				$enqueued_shortcodes[$tag] = true;
			}

			/** @var WP_Post $post */
			global $post;

			do_action('slz_ext_shortcodes_enqueue_static:'. $tag, array(
				/**
				 * Transform to array:
				 * $attr = shortcode_parse_atts( $data['atts_string'] );
				 *
				 * By default it's not transformed, but sent as raw string,
				 * to prevent useless computation for every shortcode,
				 * because this action may be used very rare and only for a specific shortcode.
				 */
				'atts_string' => $shortcode[3],
				'post' => $post,
			));

			$this->enqueue_shortcodes_static($shortcode[5]); // inner shortcodes

			/**
			 * @since 1.3.18
			 */
			do_action(
				'slz_ext_shortcodes:after_shortcode_enqueue_static',
				$shortcode
			);
		}
	}

	/**
	 * @param string $coder_id
	 * @return null|SLZ_Ext_Shortcodes_Attr_Coder|SLZ_Ext_Shortcodes_Attr_Coder[]
	 */
	public function get_attr_coder($coder_id = null)
	{
		if (empty($this->coders)) {
			if (!class_exists('SLZ_Ext_Shortcodes_Attr_Coder')) {
				require_once dirname(__FILE__) . '/includes/coder/interface-slz-ext-shortcodes-attr-coder.php';
			}

			if (!class_exists('SLZ_Ext_Shortcodes_Attr_Coder_JSON')) {
				require_once dirname(__FILE__) . '/includes/coder/class-slz-ext-shortcodes-attr-coder-json.php';
			}

			if (!class_exists('SLZ_Ext_Shortcodes_Attr_Coder_Aggressive')) {
				require_once dirname(__FILE__) . '/includes/coder/class-slz-ext-shortcodes-attr-coder-aggressive.php';
			}

			$coder_json = new SLZ_Ext_Shortcodes_Attr_Coder_JSON();
			$this->coders[ $coder_json->get_id() ] = $coder_json;

			$coder_aggressive = new SLZ_Ext_Shortcodes_Attr_Coder_Aggressive();
			$this->coders[ $coder_aggressive->get_id() ] = $coder_aggressive;

			if (!class_exists('SLZ_Ext_Shortcodes_Attr_Coder_Post_Meta')) {
				require_once dirname(__FILE__) . '/includes/coder/class-slz-ext-shortcodes-attr-coder-post-meta.php';
			}
			$coder_post_meta = new SLZ_Ext_Shortcodes_Attr_Coder_Post_Meta();
			$this->coders[ $coder_post_meta->get_id() ] = $coder_post_meta;

			foreach (apply_filters('slz_ext_shortcodes_coders', array()) as $coder) {
				if (!($coder instanceof SLZ_Ext_Shortcodes_Attr_Coder)) {
					trigger_error(get_class($coder) .' must implement SLZ_Ext_Shortcodes_Attr_Coder', E_USER_WARNING);
					continue;
				}

				if (isset($this->coders[ $coder->get_id() ])) {
					trigger_error('Coder id='. $coder->get_id() .' is already defined', E_USER_WARNING);
					continue;
				}

				$this->coders[ $coder->get_id() ] = $coder;
			}
		}

		if (is_null($coder_id)) {
			return $this->coders;
		} else {
			if (isset($this->coders[$coder_id])) {
				return $this->coders[$coder_id];
			} else {
				return null;
			}
		}
	}
}
