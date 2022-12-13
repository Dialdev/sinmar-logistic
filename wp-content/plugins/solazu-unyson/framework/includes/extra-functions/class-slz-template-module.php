<?php
class SLZ_Template_Module {

	public $post;
	public $title;
	public $attributes = array();
	public $post_id;
	public $permalink;

	/**
	 * @param $post WP_Post
	 * @throws ErrorException
	 */
	function __construct($post, $attributes) {

		if (gettype($post) == 'object' && get_class($post) == 'WP_Post') {

			
			$this->attributes = $attributes;

			$this->post = $post;

			$this->post_id = $post->ID;

			$this->permalink = esc_url( $this->get_post_url( $post->ID ) );

		}

	}

	/**
	 * Get post author.
	 * 
	 * @return string
	 */
	public function author( $attr = array() ) {

		$out = '';

		if( empty( $this->attributes['show_author'] ) || $this->attributes['show_author'] != 'hide' ) {

			$default = array(
				'class'		=>		'link',
				'text'		=>		esc_html__('By ', 'slz')
			);

			$attr = shortcode_atts( $default, $attr );

			$format = '<a href="%1$s" class="' . esc_attr ( $attr['class'] ) . '">' . esc_html( $attr['text'] ) . ' %2$s</a>';

			$url = get_author_posts_url( $this->post->post_author );

			$out = sprintf( $format,

					esc_url( $url ),

					esc_html( get_the_author_meta('display_name', $this->post->post_author) )

			);

		}

		return $out;
	}

	/**
	 * Get post date
	 * 
	 * @param string $echo - false(default)
	 * @return string
	 */
	public function date( $attr = array() ) {

		$out = '';

		if( empty( $this->attributes['show_date'] ) || $this->attributes['show_date'] != 'hide' ) {

			$default = array(
				'class'		=>		'link',
				'format'	=>		''
			);

			$attr = shortcode_atts( $default, $attr );

			$format = '<a href="%1$s" class="' . esc_attr ( $attr['class'] ) . '">%2$s</a>';

			$date = get_the_date( $attr['format'], $this->post );

			$out = sprintf( $format, $this->permalink, esc_html( $date ) );

		}

		return $out;

	}
	
	/**
	 * Get post comment number.
	 * 
	 * @param string $echo - false(default)
	 * @return string
	 */
	public function comments( $attr = array() ) {

		$out = '';

		if( empty( $this->attributes['show_comments'] ) || $this->attributes['show_comments'] != 'hide' ) {

			$default = array(
				'class'		=>		'link comment',
				'text'		=>		esc_html__('Comments', 'slz')
			);

			$attr = shortcode_atts( $default, $attr );

			$format = '<a href="%1$s" class="' . esc_attr ( $attr['class'] ) . '">%2$s ' . esc_html( $attr['text'] ) . '</a>';

			$out = sprintf( $format, get_comments_link( $this->post_id ), get_comments_number() );

		}

		return $out;

	}

	/**
	 * Get post views
	 * 
	 * @return string
	 */
	public function view( $attr = array() ) {

		$out = '';

		if( empty( $this->attributes['show_views'] ) || $this->attributes['show_views'] != 'hide' ) {

			$default = array(
				'class'		=>		'link view',
				'text'		=>		esc_html__('Views', 'slz')
			);

			$attr = shortcode_atts( $default, $attr );

			$format = '<a href="%1$s" class="' . esc_attr ( $attr['class'] ) . '">%2$s ' . esc_html( $attr['text'] ) . '</a>';

			$icon = sprintf( '<i class="icon %s"></i>', slz()->backend->get_param('meta_icon/view') );

			$out = sprintf( $format, $this->permalink, $this->get_post_view( ));

		}

		return $out;

	}

	/**
	 * Feature images
	 * 
	 */
	public function image( $attr = array() ) {

		$thumb_type = 'large';

		$out = $thumb_img = $img_cate = '';

		$thumb_size = $this->attributes['thumb-size'][$thumb_type];

		$default = array(
			'class'		=>		'img-responsive img-full',
			'thumb_size'=>		$thumb_size
		);

		$attr = shortcode_atts( $default, $attr );

		if( has_post_thumbnail( $this->post_id ) ) {

			$thumb_id = get_post_thumbnail_id( $this->post_id );

			// regenerate if not exist.
			$helper = new SLZ_Image();

			$helper->regenerate_attachment_sizes($thumb_id, $attr['thumb_size']);

			$thumb_img = wp_get_attachment_image( $thumb_id, $attr['thumb_size'], false, array('class' => $attr['class'] ) );
			
		}else {

			$thumb_img = Slz_Util::get_no_image( $this->attributes['thumb-size'], $this->post, $thumb_type, array('thumb_class' => $attr['class'] ) );

		}

		return $thumb_img;
	}

	public function has_post_thumbnail(){

		return has_post_thumbnail( $this->post_id );

	}

	public function has_image(){

		return has_post_thumbnail( $this->post_id );

	}


	/**
	 * Get post title
	 * 
	 * @param string $limit
	 * @param string $echo
	 * @return string
	 */
	public function title( $attr = array() ) {

		$default = array(
			'class'		=>		'block-title',
			'length'	=>		$this->attributes['title_length'],
			'is_limit'	=>		true
		);

		$attr = shortcode_atts( $default, $attr );

		$format = '<a href="%2$s" class="%3$s">%1$s</a>';

		$title = get_the_title( $this->post );

		if( $attr['is_limit'] && !empty( $attr['length'] ) ) {

			$limit = $attr['length'];

			// cut title by limit
			$title = wp_trim_words($title, $limit);

		}
		
		return sprintf( $format, esc_html( $title ), $this->permalink, esc_attr ( $attr['class'] ) );
	}


	/**
	 * Get the excerpt
	 * 
	 * @param string $limit
	 * @param string $echo
	 * @return string
	 */
	public function excerpt( $attr = array() ) {

		$trim_excerpt = '';

		if ( empty( $this->attributes['show_excerpt'] ) || $this->attributes['show_excerpt'] != 'hide'){

			$default = array(
				'length'	=>		$this->attributes['excerpt_length'],
				'is_limit'	=>		true,
				'cut_content' =>	true

			);

			$attr = shortcode_atts( $default, $attr );

			$trim_excerpt = get_the_excerpt( $this->post );

			if ( $trim_excerpt != '' ){

				if( $attr['is_limit'] && !empty( $attr['length'] ) ) {

					$limit = $attr['length'];

					$trim_excerpt = wp_trim_words($trim_excerpt, $limit, ' [...]');

				}

			}
			elseif( $attr['cut_content'] == true ) {

				if ( $attr['is_limit'] && !empty( $attr['length'] ) ) {
					$trim_excerpt = $this->cut_excerpt( $this->post->post_content, $attr['length'] );
				}
				else {
					$trim_excerpt = $this->cut_excerpt( $this->post->post_content, 20 );
				}
			}
		}

		return $trim_excerpt;

	}

	function cut_excerpt($post_content, $limit, $show_shortcodes = '') {
		if ($show_shortcodes == '') {
			$post_content = preg_replace("/\[caption(.*)\[\/caption\]/i", '', $post_content);
			$post_content = preg_replace('`\[[^\]]*\]`','',$post_content);
		}

		$post_content = stripslashes(wp_filter_nohtml_kses($post_content));

		$excerpt = strip_tags ( wp_trim_words($post_content, $limit, ' [...]') );

		return $excerpt;
	}

	/**
	 * Get main category of post.
	 * 
	 * @param string $echo - false(default)
	 * @return string
	 */
	public function category( $attr = array() ) {

		// $class = 'block-category', $format = null 

		$out = $cat = '';

		if( empty( $this->attributes['show_category'] ) || $this->attributes['show_category'] != 'hide' ) {

			$default = array(
				'class'		=>		'block-category'
			);

			$attr = shortcode_atts( $default, $attr );

			$format = '<a href="%1$s" class="%3$s">%2$s</a>';

			$cat = current( get_the_category( $this->post ) );

			$out = sprintf( $format, get_category_link($cat->cat_ID), esc_html( $cat->name ), $attr['class'] );

		}

		return $out;
	}

	public function tag( $attr = array() ) {

		if( empty( $this->attributes['show_tag'] ) || $this->attributes['show_tag'] != 'hide' ) {

			$default = array(
				'class'		=>		'block-category'
			);

			$attr = shortcode_atts( $default, $attr );

			$tags = get_the_tags( $this->post );

			$tag_html = array();

			if ( is_array( $tags ) ) {

				foreach ($tags as $tag) {
					$tag_html[] = '<a href="' . get_tag_link($tag->term_id) . '" class="' . esc_attr( $attr['class'] ) . '">' . $tag->name . '</a> ';
				}

			}

			if ( !empty ( $tag_html ) )
				return join($tag_html, ',');

		}

		return;
	}

	private function get_post_url( $post_id ) {

		if( get_post_format( $post_id ) === 'link' ) {

			$content = get_the_content( $post_id );

			$has_url = get_url_in_content( $content );
				
			return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink( $post_id ) );

		} else {

			return get_permalink( $post_id );

		}

	}

	public function url(){
		return esc_url( $this->permalink );
	}

	private function get_post_view( ) {

		$count_key = slz()->theme->manifest->get('post_view_name');

		$count = get_post_meta( $this->post_id, $count_key, true );

		$res = '';

		if($count == '') {

			delete_post_meta( $this->post_id, $count_key );

			add_post_meta( $this->post_id, $count_key, '0' );

			$res = 0;

		} else {

			$res = $count;

		}

		return $res;

	}

}