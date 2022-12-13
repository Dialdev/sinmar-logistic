<?php
class SLZ_Testimonial extends SLZ_Custom_Posttype_Model {

	private $post_type = 'slz-testimonial';
	private $post_taxonomy = 'slz-testimonial-cat';

	public function __construct() {
		$this->meta_attributes();
		$this->set_meta_attributes();
		$this->taxonomy_cat = $this->post_taxonomy;
		$this->html_format = $this->set_default_options();
		$this->set_default_attributes();
	}
	public function meta_attributes() {
		$slz_merge_meta_atts = array();
		$meta_atts = array(
			'img'	        => '',
      'icon'          => '',
			'position'		=> '',
			'ratings'		=> '',
		);
		foreach ($meta_atts as $key_gr => $value_gr) {
			if ( is_array($value_gr) ) {
				foreach ($value_gr as $key => $value) {
					$slz_merge_meta_atts[$key_gr.'/'.$key] = $value;
				}
			}
		}
		$this->post_meta_atts = array_merge($meta_atts, $slz_merge_meta_atts);
	}
	public function set_meta_attributes() {
		$meta_arr = array();
		$meta_label_arr = array();
		foreach( $this->post_meta_atts as $att => $name ){
			$key = $att;
			$meta_arr[$key] = '';
			$meta_label_arr[$key] = $name;
		}
		$this->post_meta_def = $meta_arr;
		$this->post_meta = $meta_arr;
		$this->post_meta_label = $meta_label_arr;
	}
	public function set_default_attributes() {
		$default_atts = array(
			'layout'			=> 'testimonial',
			'style'				=> 'style-1',
			'limit_post'		=> '-1',
			'offset_post'		=> '0',
			'sort_by'			=> '',
			'post_id'			=> '',
			'method'			=> '',
			'list_category'		=> '',
      'show_image_1'      => '2',
      'show_image_2'      => '0',
			'list_post'			=> '',
		);
		$this->attributes = $default_atts;
	}
	public function init( $atts = array(), $query_args = array() ) {
		// set attributes
		$atts = array_merge( $this->attributes, $atts );

		if( empty( $atts['post_id'] ) ){
			if( $atts['method'] == 'cat' ) {
				if( empty( $atts['category_slug'] ) ) {
					list( $atts['category_list_parse'], $atts['category_slug'] ) = SLZ_Util::get_list_vc_param_group( $atts, 'list_category', 'category_slug' );
				}
				$atts['post_id'] = $this->parse_cat_slug_to_post_id( 
											$this->taxonomy_cat,
											$atts['category_slug'],
											$this->post_type
										);
			} else {
				if(isset($atts['list_post']) && function_exists('vc_param_group_parse_atts')){
					$list_post = (array) vc_param_group_parse_atts( $atts['list_post'] );
					$atts['post_id'] = $this->parse_list_to_array( 'post', $list_post );
				}
			}
		}

		$this->attributes = $atts;

		// query
		$default_args = array(
			'post_type' => $this->post_type,
		);
		$query_args = array_merge( $default_args, $query_args );
		// setting
		$this->setting( $query_args);
	}
	public function setting( $query_args ){
		if( !isset( $this->attributes['uniq_id'] ) ) {
			$this->attributes['uniq_id'] = $this->post_type . '-' .SLZ_Com::make_id();
		}
		// query
		$this->query = $this->get_query( $query_args, $this->attributes );
		$this->post_count = 0;
		if( $this->query->have_posts() ) {
			$this->post_count = $this->query->post_count;
		}
		$this->get_thumb_size();
		$this->set_responsive_class();

		$custom_css = $this->add_custom_css();
		if( $custom_css ) {
			do_action('slz_add_inline_style', $custom_css);
		}
	}
	public function reset(){
		wp_reset_postdata();
	}
	public function set_responsive_class( $atts = array() ) {

	}
	
	public function add_custom_css() {
		$custom_css = '';
		if( !empty($this->attributes['color_title']) ) {
			$custom_css .= sprintf('.%1$s .block-testimonial .block-content .title { color: %2$s;}',
								$this->attributes['uniq_id'], $this->attributes['color_title']
							);
		}
		return $custom_css;
	}

	public function set_default_options( $html_options = array() ) {
		$defaults = array(
			'title_format'			=> '<div class="name">%1$s</div>',
			'position_format'		=> '<div class="position">%s</div>',
			'description_format'	=> '<div class="item">
                                            <div class="quote-item">
                                                <div class="description">%s</div>
                                            </div>
                                        </div>',
			'thumb_class' 			=> 'img-responsive',
			'feature_image_format' 	=> '<div class="img-wrapper">%1$s</div>',
			'thumbnail_format'      => '<div class="img-wrapper thumbnail-img-wrapper">%1$s</div>',
			'ratings_format'        => '<div class="ratings"><div title="Rated %2$s out of 5" class="star-rating"><span class="width-%1$s"><strong class="rating">%2$s out of 5</strong></span></div></div>',
			'image_format'			=> '<div class="img-wrapper">%1$s</div>',
            'icon_format'           => '<i class="icons %1$s"></i>'
		);

		$html_options = array_merge( $defaults, $html_options );
		$this->html_format = $html_options;
		return $html_options;
	}

	private function get_thumb_size() {
		if ( isset($this->attributes['image_size']) && is_array($this->attributes['image_size']) ) {
			$this->attributes['thumb-size'] = SLZ_Util::get_thumb_size( $this->attributes['image_size'], $this->attributes );
		}
	}

	/*-------------------- >> Render Html << -------------------------*/
	/**
	 * Render html by shortcode.
	 *
	 * @param array $html_options
	 * Format: 1$ - image, 2$ - title, 3$ - position, 4$ - description
	 */
	public function render_testimonial_slider_sc( $html_options = array() ) {
		$this->html_format = $this->set_default_options( $html_options );
		$row_count = 0;
		$thumb_size = 'large';

		if( $this->query->have_posts() ) {
			$html_options = $this->html_format;
			while ( $this->query->have_posts() ) {
				$this->query->the_post();
				$this->loop_index();
                $meta_image = '';
                if($this->attributes['show_image_1'] == '2')
                  $meta_image = $this->get_featured_image($html_options);
                else if($this->attributes['show_image_1'] == '1')
                    $meta_image = $this->get_meta_icon();
                else if($this->attributes['show_image_1'] == '0')
                    $meta_image = $this->get_meta_image( $thumb_size );
				printf( $html_options['html_format'],
					$meta_image,
					$this->get_title( $html_options ),
					$this->get_meta_position(),
					$this->get_content_format(),
					$this->get_featured_image($html_options),
					$this->get_ratings(),
          $this->get_meta_icon(),
          $this->get_meta_image( $thumb_size )
				);
				$row_count++;
			}
			$this->reset();
		}
	}


	/*-------------------- >> General Functions << --------------------*/
	public function get_meta_position() {
		$out = '';
		$format = $this->html_format['position_format'];
		if ( !empty($this->attributes['show_position']) && $this->attributes['show_position'] == 'yes' ) {
			$position = $this->post_meta['position'];
		}
		if( empty( $position ) ) {
			return '';
		}
		$out = sprintf( $format, esc_html($position) );
		return $out;
	}

	public function get_ratings() {
		$out = '';
		$format = $this->html_format['ratings_format'];
		if ( !empty($this->attributes['show_ratings']) && $this->attributes['show_ratings'] == 'yes' ) {
			$rating = absint($this->post_meta['ratings']);
			if( $rating > 0 ){
				$rate_width = ($rating/5)*100;
				$out = sprintf( $format, $rate_width, $rating );
			}
		}
		return $out;
	}

	public function get_content_format() {
		$out = '';
		$format = $this->html_format['description_format'];
		$content = get_the_content();
		if( empty( $content ) ) {
			return '';
		}
		if ( !empty($this->attributes['show_description']) && $this->attributes['show_description'] == 'yes' ) {
			$out = sprintf( $format, wp_kses_post( $content ) );
		}
		return $out;
	}

	public function get_meta_image_upload( $thumb_size = 'large' ) {
		$out = '';
		$format = $this->html_format['thumbnail_format'];
		$img = $this->get_meta_image( $thumb_size, false, false );
		if( empty( $img ) ) {
			$format = $this->html_format['feature_image_format'];
			if( $img = $this->get_featured_image() ){
				return $img;
			}
		} else {
			return $img;
		}
		return $out;
	}
	public function get_meta_image( $thumb_type = 'large', $echo = false, $has_image = true ) {
		$html_options = $this->html_format;
		$output = $thumb_img = '';
		$format = '%1$s';
		if( isset( $html_options['thumbnail_format'] ) ) {
			$format = $html_options['thumbnail_format'];
		}
	
		$href_class = SLZ_Com::get_value( $html_options, 'thumbnail_href_class' );
		$thumb_class = SLZ_Com::get_value( $html_options, 'thumbnail_class', 'img-responsive' );
	
		$attrArr = array( 'class' => $thumb_class );
		if( empty( $this->attributes['thumb-size'] ) ) {
			$this->attributes['thumb-size'] = array(
				'large'          => 'post-thumbnail',
				'small'          => 'post-thumbnail',
			);
		}
		$thumb_size = $this->attributes['thumb-size'][$thumb_type];
        $thumb_id = $this->post_meta['img'];

        if (is_array($this->post_meta['img']) && isset($this->post_meta['img']['attachment_id'])) {
            $thumb_id = $this->post_meta['img']['attachment_id'];
        }

        if ($thumb_id) {
            // regenerate if not exist.
            $helper = new SLZ_Image();
            $helper->regenerate_attachment_sizes($thumb_id, $thumb_size);
            $thumb_img = wp_get_attachment_image($thumb_id, $thumb_size, false, $attrArr);
        }
        if (empty($thumb_img) && $has_image) {
            $thumb_img = SLZ_Util::get_no_image($this->attributes['thumb-size'], $this->cur_post, $thumb_type);
        }
        if ($thumb_img) {
            //1: img, 2: url, 3: url class
            $output = sprintf($format, $thumb_img, $this->permalink, $href_class);
            if ($echo) {
                echo wp_kses_post($output);
            } else {
                return $output;
            }
        }

	}

	public function get_meta_icon() {
        $format = $this->html_format['icon_format'];
        if(!empty($this->post_meta['icon']))
            return sprintf( $format, esc_attr($this->post_meta['icon']) );
        else
            return '';
    }

}