<?php
class SLZ_Portfolio extends SLZ_Custom_Posttype_Model {

	private $post_type = 'slz-portfolio';
	private $post_taxonomy = 'slz-portfolio-cat';

	public function __construct() {
		$this->meta_attributes();
		$this->set_meta_attributes();
		$this->taxonomy_cat = $this->post_taxonomy;
		$this->html_format = $this->set_default_options();
		$this->set_sort_meta_key();
		$this->set_default_attributes();
	}
	public function meta_attributes() {
		$slz_merge_meta_atts = array();
		$meta_atts = array(
			'thumbnail'            => '',
			'description'          => '',
			'information'          => '',
			'font-icon'            => '',
			'gallery_images'       => '',
			'is_featured'          => '',
			'attach_ids'           => '',
			'history_status'       => '',
			'show_qrcode'          => '',
			'team'                 => '',
            'show_team_box'        => '',
			'goal'                 => '',
			'location'             => '',
			'donors'               => '',
			'people_benefits'      => '',
			'time'                 => array(
		        'from' => '',
		        'to' => '',
			),
            'album_price'          => '',
            'album_quantity'       => '',
            'url'                  => '',
            'artist'               => '',
            'playlist'             => '',
            'links'                => array(),
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
	public function set_default_attributes(){
		// set attributes
		$default_atts = array(
			'template'			=> 'portfolio',
			'layout'			=> 'layout-1',
			'style'				=> 'style-1',
			'column'			=> '4',
			'limit_post'		=> '-1',
			'offset_post'		=> '0',
			'sort_by'			=> '',
			'post_id'			=> '',
			'method'			=> '',
			'list_category'		=> '',
			'category_slug'		=> '',
			'author'            => '',
			'list_post'			=> '',
			'show_description'  => '',
			'description_length' => '',
			'show_review_rating' => slz_get_db_settings_option('pf-review-rating', 'no' ),
			'show_author'        => '',
			'show_views'         => 'no',
			'show_date'          => '',
			'show_thumbnail'     => '',
			'show_category'      => '',
			'team'               => '',
            'show_team_box'      => 'yes',
            'links'              => array(),
		);
		$this->attributes = $default_atts;
	}
	public function set_sort_meta_key(){
		$posts_rating = slz()->theme->get_config('posts_rating');
		if ( isset($posts_rating[$this->post_type]) ) {
			$this->sort_meta_key['rating'] = $posts_rating[$this->post_type];
		}
	}
	public function init( $atts = array(), $query_args = array() ) {
		// set attributes
		$atts = array_merge( $this->attributes, $atts );
		if( empty( $atts['post_id'] ) ){
			if( $atts['method'] == 'cat' ) {
				if( empty( $atts['category_slug'] ) ) {
					list( $atts['category_list_parse'], $atts['category_slug'] ) = SLZ_Util::get_list_vc_param_group( $atts, 'list_category', 'category_slug' );
				}
				$atts['post_id'] = $this->parse_cat_slug_to_post_id( $this->taxonomy_cat, $atts['category_slug'], $this->post_type );
			}
			// Add filter by Team for Portfolio
			else if ( $atts['method'] == 'team' ){
			    // Check list_team exist
                if( isset( $atts['list_team'] ) ) {
                    // Get array list attribute from VC Options
                    $tmp_list = (array) vc_param_group_parse_atts( $atts['list_team'] );
                     $list_team = array();
                    foreach ( $tmp_list as $team ) {
                        $list_team[] = $team['team_slug'];
                    }
                    $ids = array();
                    // Set argument for get_posts
                    $args = array(
                        'post_type'         => $this->post_type,
                        'post_status'       => 'publish',
                        'posts_per_page'    => -1,
                        'suppress_filters'  => false,
                        // get post if team in list_team
                        'meta_query' => array(
                            array(
                                'key'     => 'slz_option:team',
                                'value'   => $list_team,
                                'compare' => 'IN',
                            ),
                        ),
                    );
                    // Get Posts
                    $posts = get_posts( $args );
                    // Get post id array from Post object array.
                    foreach ( $posts as $post ) {
                        $ids[] = $post->ID;
                    }
                    $atts['post_id'] = $ids;
                }
            } else {
				if(isset($atts['list_post'])){
					$list_post = (array) vc_param_group_parse_atts( $atts['list_post'] );
                    $atts['post_id'] = $this->parse_list_to_array( 'post', $list_post );
				}
			}
		}
		if( !empty($atts['show_thumbnail']) && $atts['show_thumbnail'] == 'none') {
			$atts['show_thumbnail_meta'] = 'none';
		}elseif( !empty($atts['show_thumbnail']) && $atts['show_thumbnail'] == 'thumbnail') {
			$atts['show_thumbnail_meta'] = 'yes';
		}
		if( !empty($atts['show_featured_image']) && $atts['show_featured_image'] == 'no'){
			$atts['show_thumbnail'] = 'no';
		}

		//set meta query
		$this->meta_key_compare = 'LIKE';
		if(!empty($atts['team'])){
			$atts['meta_key'] = array('team_list' => $atts['team']);
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

	/*
	 * Return Term detail from list_category choose
	 */
	public function init_term( $atts = array() ) {
		$atts = array_merge( $this->attributes, $atts );
		$list_category = array();

		if( !empty( $atts['list_category'] ) ) {
			$term_arr = array();
			list( $atts['category_list_parse'], $atts['category_slug'] ) = SLZ_Util::get_list_vc_param_group( $atts, 'list_category', 'category_slug' );

			if ( empty( $atts['category_slug'] ) ) {
				$args = array(
					'taxonomy'   => $this->post_taxonomy,
				);
				$term_arr = get_terms($args);
				return $term_arr;
			}else{

				if( !empty( $atts['category_slug'] ) ) {
					foreach ( $atts['category_slug'] as $slug ) {
						if( empty( $slug ) ) {
							continue;
						}
						$term_arr[] = get_term_by( 'slug', $slug, $this->post_taxonomy );
					}
				}
				return $term_arr;
			}
		}
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
		$class = '';
		$column = $this->attributes['column'];
		$def = array(
			'1' => 'portfolio-col-1 col-xs-12',
			'2' => 'portfolio-col-2 col-sm-6 col-xs-12',
			'3' => 'portfolio-col-3 col-md-4 col-sm-6 col-xs-12',
			'4' => 'portfolio-col-4 col-lg-3 col-md-4 col-sm-6 col-xs-12',
		);;

		if( $column && isset($def[$column])) {
			$this->attributes['responsive-class'] = $def[$column];
		} else {
			$this->attributes['responsive-class'] = $def['4'];
		}
	}

	public function add_custom_css() {
		$custom_css = '';
		if( !empty($this->attributes['color_title']) ) {
			$custom_css .= sprintf('.%1$s .block-title { color: %2$s !important;}',
								$this->attributes['uniq_id'], $this->attributes['color_title']
							);
		}
		if( !empty($this->attributes['color_title_hv']) ) {
			$custom_css .= sprintf('.%1$s .block-title:hover { color: %2$s !important;}',
								$this->attributes['uniq_id'], $this->attributes['color_title_hv']
							);
		}
		if( !empty($this->attributes['color_category']) ) {
			$custom_css .= sprintf('.%1$s .block-category { color: %2$s !important;}',
								$this->attributes['uniq_id'], $this->attributes['color_category']
							);
		}
		if( !empty($this->attributes['color_category_hv']) ) {
			$custom_css .= sprintf('.%1$s .block-category:hover { color: %2$s !important;}',
								$this->attributes['uniq_id'], $this->attributes['color_category_hv']
							);
		}
		if( !empty($this->attributes['color_meta_info']) ) {
			$custom_css .= sprintf('.%1$s .block-info .link { color: %2$s !important;}',
								$this->attributes['uniq_id'], $this->attributes['color_meta_info']
							);
		}
		if( !empty($this->attributes['color_meta_info']) ) {
			$custom_css .= sprintf('.%1$s .block-info .link { color: %2$s !important;}',
								$this->attributes['uniq_id'], $this->attributes['color_meta_info']
							);
		}
		if( !empty($this->attributes['color_meta_info_hv']) ) {
			$custom_css .= sprintf('.%1$s .block-info .link:hover { color: %2$s !important;}',
								$this->attributes['uniq_id'], $this->attributes['color_meta_info_hv']
							);
		}
		if( !empty($this->attributes['color_description']) ) {
			$custom_css .= sprintf('.%1$s .block-text { color: %2$s !important;}',
								$this->attributes['uniq_id'], $this->attributes['color_description']
							);
		}
		if( !empty($this->attributes['color_item_bg_hv']) ) {
			$custom_css .= sprintf('.%1$s .block-image:after { background-color: %2$s !important;}',
								$this->attributes['uniq_id'], $this->attributes['color_item_bg_hv']
							);
		}
		if( !empty($this->attributes['color_button']) ) {
			$custom_css .= sprintf('.%1$s .block-read-more { color: %2$s !important;}',
								$this->attributes['uniq_id'], $this->attributes['color_button']
							);
		}
		if( !empty($this->attributes['color_button_hv']) ) {
			$custom_css .= sprintf('.%1$s .block-read-more:hover { color: %2$s !important;}',
								$this->attributes['uniq_id'], $this->attributes['color_button_hv']
							);
		}
		if( !empty($this->attributes['color_slide_arrow']) ) {
			$custom_css .= sprintf('.%1$s .slz-carousel-wrapper .slick-arrow { color: %2$s;}',
								$this->attributes['uniq_id'], $this->attributes['color_slide_arrow']
							);
		}
		if( !empty($this->attributes['color_slide_arrow_hv']) ) {
			$custom_css .= sprintf('.%1$s .slz-carousel-wrapper .slick-arrow:hover { color: %2$s;}',
								$this->attributes['uniq_id'], $this->attributes['color_slide_arrow_hv']
							);
		}
		if( !empty($this->attributes['color_slide_arrow_bg']) ) {
			$custom_css .= sprintf('.%1$s .slz-carousel-wrapper .slick-arrow { background-color: %2$s;}',
								$this->attributes['uniq_id'], $this->attributes['color_slide_arrow_bg']
							);
		}
		if( !empty($this->attributes['color_slide_arrow_bg_hv']) ) {
			$custom_css .= sprintf('.%1$s .slz-carousel-wrapper .slick-arrow:hover { background-color: %2$s;}',
								$this->attributes['uniq_id'], $this->attributes['color_slide_arrow_bg_hv']
							);
		}
		if( !empty($this->attributes['color_slide_dots']) ) {
			$custom_css .= sprintf('.%1$s .slz-carousel-wrapper .slick-dots li button:before{ color: %2$s;}',
								$this->attributes['uniq_id'], $this->attributes['color_slide_dots']
							);
		}
		if( !empty($this->attributes['color_slide_dots_at']) ) {
			$custom_css .= sprintf('.%1$s .slz-carousel-wrapper .slick-dots .slick-active button:before{ color: %2$s;}',
								$this->attributes['uniq_id'], $this->attributes['color_slide_dots_at']
							);
		}

		return $custom_css;
	}

	public function set_default_options( $html_options = array() ) {
		$defaults = array(
			'title_format'			  => '<a href="%2$s" class="block-title">%1$s</a>',
			'category_format'         => '<li><span class="title">Categories:</span>%1$s</li>',
            'category_item_format'    => '<a href="%2$s" class="block-category"><span class="text">%1$s</span></a>',
			'excerpt_format'		  => '<div class="block-text">%s</div>',
			'thumb_class' 			  => 'img-responsive img-full',
			'image_format'			  => '<div class="block-image"><a href="%2$s" class="link">%1$s</a></div>',
			'author_format'			  => '<li><a href="%2$s" class="link author">%1$s</a></li>',
			'date_format'			  => '<li><a href="%2$s" class="link">%1$s</a></li>',
			'view_format'			  => '<li><a href="%2$s" class="link">%1$s</a></li>',
			'thumbnail_format'        => '<a href="%2$s" class="link">%1$s</a>',
			'team_format'             => '<li><a href="%2$s" class="block-team"><span class="author-label">Sermon from:</span><span class="author-text">%1$s</span></a></li>',
            'attachment_block_format' => '<ul class="tool-list">%1$s</ul>',
            'attachment_item_format'  => '<li><a href="%1$s" class="link %2$s" %4$s><i class="fa fa-%3$s"></i></a></li>',
		);

		$this->html_format = array_merge( $defaults, $html_options );
		return $this->html_format;
	}

	private function get_thumb_size() {
		if( absint($this->attributes['column']) == 1 ) {
			$this->attributes['thumb-size'] = array(
				'large'          => 'post-thumbnail',
				'small'          => 'post-thumbnail',
			);
		} else {
			if ( isset($this->attributes['image_size']) && is_array($this->attributes['image_size']) ) {
				$this->attributes['thumb-size'] = SLZ_Util::get_thumb_size( $this->attributes['image_size'], $this->attributes );
			}
		}
		if( isset($this->attributes['is_ajax']) ){
			$this->attributes['thumb-size']['is_ajax'] = true;
		}
	}

	private  function get_meta_image_upload( $html_options ) {
		$out = '';
		$format = $this->html_format['thumbnail_format'];
		$img = $this->post_meta['thumbnail'];
		if( empty( $img ) ) {
			$img =  $this->get_featured_image($html_options);
			return $img;
		}
		$out = sprintf( $format, esc_html($img['url']) );
		return $out;
	}

	/*-------------------- >> Render Html << -------------------------*/
	/**
	 * Render html by shortcode.
	 *
	 * @param array $html_options
	 * Format: 1$ - image, 2$ - title, 3$ - category, 4$ - description, 5$ - button, 6$ - meta, 7$ - post_class, 8$ - rating
	 */
	public function render_portfolio_list_sc( $html_options = array() ) {
		$this->html_format = $this->set_default_options( $html_options );
		$row_count = 0;
		$thumb_size = 'large';
		if( $this->query->have_posts() ) {
			while ( $this->query->have_posts() ) {
				$this->query->the_post();
				$this->loop_index();

				$html_options = $this->html_format;
				printf( $html_options['html_format'],
					$this->get_featured_image( $html_options, $thumb_size ),
					$this->get_title( $html_options ),
					$this->get_term_current_taxonomy(),
					$this->get_meta_description(),
					$this->get_button_readmore(),
					$this->get_meta_info(),
					$this->get_post_class(),
					$this->get_rating(),
					$this->get_thumnail()
				);
				$row_count++;
			}
			$this->reset();
			if( !empty($this->attributes['pagination']) && $this->attributes['pagination'] == 'yes' ) {
				echo SLZ_Pagination::paging_nav( $this->query->max_num_pages, 2, $this->query);
			}
		}
	}

	/*-------------------- >> Render Widget << -------------------------*/
		/**
		 * use for widget gallery
		 *
		 * @param array $html_options
		 * Format: 1$ - image, 2$ - image link
		 */
	public function render_widget( $html_options = array() ) {
		$this->html_format = $html_options ;
		$thumb_size = 'large';
		if( $this->query->have_posts() ) {
			while ( $this->query->have_posts() ) {
				$this->query->the_post();
				$this->loop_index();
				$html_options = $this->html_format;
				printf( $html_options['html_format'],
					$this->get_featured_image( $html_options, $thumb_size ),
					$this->get_feature_img_url_size($html_options['fancybox_size']),
					$this->get_title($html_options),
					$this->get_author($html_options),
					$this->get_rating(),
					$this->get_meta_description(),
					$this->get_meta_image_upload($html_options)
				);
			}
			$this->reset();
		}
	}

    /**
     * Render Team Box
     * @param array $html_options
     */
    public function render_team_box ($html_options = array() ) {
        $show_teambox = $this->post_meta['show_team_box'];
	    $team_id = intval( $this->post_meta['team'] );
	    if(  empty( $show_teambox ) || $show_teambox != 'yes' || empty( $team_id ) || ! slz_ext( 'teams' ) ) {
	        return;
        }
        $html_format = array(
            'title_format'      => '<a href="%2$s" title="" class="author">%1$s</a>',
            'image_format'      => '<a href="%2$s" class="media-image thumb">%1$s</a>'
        );
        $team_box_format = '
        <div class="slz-blog-author media">
            <div class="media-left">
                %1$s                
            </div>
            <div class="media-right">
                %2$s
                <div class="postion">%3$s</div>
                <div class="des">%4$s</div>
            </div>
        </div>
        ';
        $args = array(
            'post_id' => array( $team_id ),
        );
	    $team_model = new SLZ_Team();
	    $team_model->init( $args );

        if( $team_model->query->have_posts() ) {
            while ( $team_model->query->have_posts() ) {
                $team_model->query->the_post();
                $team_model->loop_index();
                $team_title = $team_model->get_title( $html_format );
                $team_position = $team_model->post_meta['position'];
                $team_thumb = $team_model->get_featured_image( $html_format );
                $team_description = $team_model->post_meta['short_des'];
                printf( $team_box_format, $team_thumb, $team_title, $team_position, $team_description );
            }
            $team_model->reset();
        }
    }

	/*-------------------- >> General Functions << --------------------*/
	public function pagination(){
		if( !empty($this->attributes['pagination']) && $this->attributes['pagination'] == 'yes' ) {
			echo SLZ_Pagination::paging_nav( $this->query->max_num_pages, 2, $this->query);
		}
	}
	public function get_feature_img_url_size($size) {
		$out = '';
		if ( get_post_thumbnail_id( $this->post_id ) ) {
			$out = image_downsize( get_post_thumbnail_id( $this->post_id ) ,$size);
		}
		if(isset($out[0])){
			return $out[0];
		}else{
			return $out;
		}

	}

	public function get_feature_img_url_full() {
		$out = '';
		if ( get_post_thumbnail_id( $this->post_id ) ) {
			$out = wp_get_attachment_url( get_post_thumbnail_id( $this->post_id ) );
		}
		return $out;
	}

	public function get_term_current_taxonomy( $html_options = array() ) {
		$out = '';
		$format = $this->html_format['category_format'];
		if( ! empty( $html_options['category_format'] ) ) {
			$format = $html_options['category_format'];
		}
		if ( ! empty( $this->attributes['show_category'] ) && $this->attributes['show_category'] == 'yes' ) {
			$term = $this->get_current_taxonomy();
			if( ! empty( $term ) ) {
				$out = sprintf( $format, esc_html( $term['name'] ), esc_url( get_term_link( $term['term_id'] ) ) );
			}
		}
		return $out;
	}

    public function get_terms( $html_options = array() ) {
        $out = '';
        $format = $this->html_format['category_format'];
        if( ! empty( $html_options['category_format'] ) ) {
            $format = $html_options['category_format'];
        }
        $item_format = $this->html_format['category_item_format'];
        if( ! empty( $html_options['category_item_format'] ) ) {
            $item_format = $html_options['category_item_format'];
        }
        if ( ! empty( $this->attributes['show_category'] ) && $this->attributes['show_category'] == 'yes' ) {
            $terms = $this->get_taxonomy_list('', $item_format);
            if( ! empty( $terms ) ) {
                $out = sprintf( $format, $terms );
            }
        }
        return $out;
    }

	public function get_meta_info() {
		$out = $author = $date = $views = '';
		$format = '%1$s %2$s %3$s';
		if ( isset($this->html_format['meta_info_format']) ) {
			$format = $this->html_format['meta_info_format'];
		}
		if ( !empty($this->attributes['show_meta_info']) && $this->attributes['show_meta_info'] == 'yes' ) {
			$author = $this->get_author( $this->html_format );
			$date = $this->get_date( $this->html_format );
			$views = $this->get_views( $this->html_format );
		}
		$out = sprintf( $format, wp_kses_post( $author ) , wp_kses_post( $date ), wp_kses_post( $views ) );
		return $out;
	}


	public function get_button_readmore( $echo = false ) {
		$out = $other_atts = '';
		$format = '<a href="%2$s" class="block-read-more slz-btn" %3$s >%1$s<i class="fa fa-arrow-circle-right"></i></a>';
		if ( isset($this->html_format['readmore_format']) ) {
			$format = $this->html_format['readmore_format'];
		}
		if ( !empty($this->attributes['button_text']) ) {
			$button_text = $this->attributes['button_text'];
			$link = $this->permalink;
			if( !empty($this->attributes['custom_link'])){
				$link = SLZ_Util::parse_vc_link($this->attributes['custom_link']);
				if( !empty($link['url'])) {
					$this->attributes['button_custom_link'] = $link['url'];
					$other_atts = $link['other_atts'];
				}
			}
			if( !empty($this->attributes['button_custom_link'] ) ) {
				$link = $this->attributes['button_custom_link'];
			}
			$out = sprintf($format, $button_text, esc_url($link), $other_atts);
		}
		if( !$echo ) {
			return $out;
		}
		echo $out;
	}

    public function  get_meta_album_price($format = '') {
        $album_price = '';

        $url = $this->post_meta['url'];
        if( empty( $url ) ) {
            $url = 'javascript:void(0);';
        }

        $price = $this->post_meta['album_price'];
        if( ! isset( $price ) ) {
            $price = 0;
        }
        $price = slz_get_currency_format_options( intval( $price ) );

        if( empty( $format ) ) {
            $format = '
                <div class="price-album slz-form-buy-album slz-buy-album-method">
                    %1$s
                    <div class="price">Only <span>%2$s</span> </div>
                </div>
            ';
        }

        $portfolio_payment_option = slz_get_db_settings_option( 'portfolio-payment-option' );

        if( !is_plugin_active( 'woocommerce/woocommerce.php' ) || $portfolio_payment_option == 'customlink' ) {
            $buy_button = '<a href="'. esc_attr( $url ) .'" class="slz-btn btn-buy">'. esc_html__( 'Buy Album', 'slz' ) .'</a>';
            $album_price = sprintf( $format, $buy_button, $price );
            return $album_price;
        }

        $carted = get_post_meta( $this->post_id, 'portfolio_album_carted', '0' );

        if( empty( $carted ) ) {
            $carted = 0;
        } else {
            $carted = $carted[0];
        }

        if( $this->post_meta['album_quantity'] != '' && intval( $carted ) >= intval( $this->post_meta['album_quantity'] ) ) {
            return $album_price;
        }

        $buy_button = '
            <input type="hidden" class="slz_portfolio_post_id" name="slz_portfolio_post_id" value="'. esc_attr( $this->post_id ) .'" />
            <a class="slz-btn button btn-buy " href="javascript:void(0);">'. esc_html__( 'Buy Album', 'slz' ) .'</a>
        ';

        if ( isset( $this->post_meta['album_price'] ) && $this->post_meta['album_price'] != '' ) {
            $album_price = sprintf( $format, $buy_button, $price );
        }

        return $album_price;
    }

    public function  get_meta_album_artist($format = '', $format_row='',$maximum='') {
        $artist = '';
        if ( empty($format) ) {
            $format = '<ul class="artist">%s</ul>';
        }
        if (isset( $this->post_meta['artist'] )){
            $arr = $this->post_meta['artist'];
            if (empty($format_row)) {
                $format_row = '<li class="inline"> <span class="title">%1$s</span> <span class="value">%2$s</span> </li>';
            }
            $html = '';
            if ( empty($maximum) ) {
                $maximum = count($arr);
            }
            foreach ($arr as $index => $row) {
                if ($index >= $maximum) {
                    break;
                }
                if ( empty($row['name']) && empty($row['value'])) {
                    continue;
                }
                $html .= sprintf($format_row, $row['name'], $row['value']);
            }
            $artist = sprintf($format, $html);
        }
        return $artist;
    }

    public function  get_meta_album_playlist($format = '') {
        if ( empty($format) ) {
            $format = '<div class="slz-playlist sc_audio sc_audio_portfolio">
                            <div class="slz-album-01 sc-audio-playlist">
                                <div class="main-item">
                                    <audio id="current-audio" controls="controls" class="current-audio main-audio slz-playlist-container">
                                        %s
                                    </audio>
                                </div>
                                <div class="bar-wrapper"><canvas class="oscilloscope" width="1110"></canvas></div>
                            </div>
                            <div class="oscilloscope-wrapper"></div>
                       </div>';
        }
	    $playlist = '';
        if (isset( $this->post_meta['playlist'] )) {
            $fm = '<source data-duration="%1$s" src="%2$s" title="%3$s"/>';
            $source = '';
            $arr =  $this->post_meta['playlist'];
            foreach ($arr as $item) {
                if ( !isset($item['file']) ) {
                    continue;
                }

                $file = $item['file'];

                if (!isset($file['attachment_id']) || !isset($file['url']) ) {
                    continue;
                }

                $info_audio = wp_get_attachment_metadata( $file['attachment_id'], true );

                $audio_url = $file['url'];
                if ( empty($audio_url) || !isset($info_audio['dataformat']) || $info_audio['dataformat'] != 'mp3' ) {
                    $data_format =substr($audio_url, strlen($audio_url)-4, 4);
                    if ($data_format != '.mp3')
                        continue;
                }
                $title = '';
                if ( isset($item['file']['show']) ) {
                    $title = $item['file']['show'];
                }

                if ( empty($title) && isset($info_audio['title']) ){
                    $title = $info_audio['title'];
                }
                $length_formatted = '00:00';
                if ( isset($info_audio['length_formatted']) ) {
                    $length_formatted = $info_audio['length_formatted'];
                }
                $source .= sprintf($fm, $length_formatted, $audio_url, $title);
            }
            $playlist = sprintf($format, $source);

        }
        return $playlist;
    }

	public function get_meta_description( $echo = false) {
		$format = '%s';
		$description = '';
		$show_description = $this->attributes['show_description'];
		if ( !empty($show_description) && $show_description == 'yes' ) {
			$description = $this->post_meta['description'];
			if ( empty($description) ) {
				$description = $this->get_excerpt( $this->html_format );
			}
		}
		if ( empty($description) ) {
			return '';
		}
		$description_length = absint($this->attributes['description_length']);
		if ( !empty($description_length) ) {
			$description = wp_trim_words( $description, $description_length, '...' );
		}
		if ( isset($this->html_format['excerpt_format']) ) {
			$format = $this->html_format['excerpt_format'];
		}
		$out = sprintf($format, wp_kses_post(nl2br($description)) );
		if( !$echo ){
			return $out;
		}
		echo $out;
	}
	public function get_meta_information() {
		$format = '%s';
		$description = $this->post_meta['information'];
		if ( empty($description) ) {
			$description = $this->post_meta['description'];
		}
		if ( empty($description) ) {
			$description = $this->get_excerpt( $this->html_format );
		}
		if ( empty($description) ) {
			return '';
		}
		if ( isset($this->html_format['excerpt_format']) ) {
			$format = $this->html_format['excerpt_format'];
		}
		$out = sprintf($format, wp_kses_post($description) );
		return $out;
	}
	public function get_rating( $post_id = null , $echo = false ){
		if( !empty( $this->attributes['show_review_rating'] ) && $this->attributes['show_review_rating'] == 'yes' ) {
			if( empty($post_id) ) {
				$post_id = $this->post_id;
			}
			$cls = new SLZ_Review();
			$format = '';
			if ( isset($this->html_format['review_format']) ) {
				$format = $this->html_format['review_format'];
			}
			$out = $cls->get_rating_html( $post_id, $format );
			if( !$echo ){
				return $out;
			}
			echo $out;
		}
	}
	/**
	 * Get featured image or post meta [thumbnail] to shortcode
	 *
	 * @return string
	 */
	public function get_post_image( $html_options = array(), $thumb_type = 'large', $echo = false, $has_image = true ){
		$out = '';
		if( empty($this->attributes['show_thumbnail']) ){
			$out = $this->get_featured_image($html_options, $thumb_type, false, $has_image );
		} elseif($this->attributes['show_thumbnail'] == 'thumbnail') {
			$out = $this->get_thumbnail($html_options, $thumb_type, false, $has_image);
		}
		if( !$echo ){
			return $out;
		}
		echo $out;

	}

    /**
     * Get Portfolio Gallery
     * @param string $image_size
     * @param bool $echo
     * @return string
     */
    public function get_post_gallery( $image_size = 'large', $echo = false ) {
        $out = '';
        $block_format = '<div class="block-image has-gallery"><div class="slz-gallery-format slz-image-carousel"><div class="carousel-overflow"><div class="slz-carousel">%s</div></div></div></div>';
        $item_format  = '<div class="item"><div class="featured-carousel-item"><div class="wrapper-image">%s</div></div></div>';
	    // Check Tab Gallery Enabled or Not?
	    if( slz_ext( 'portfolio' ) && slz_ext( 'portfolio' )->get_config( 'has_gallery' ) ) {
            // Get Gallery Image from Portfolio Post Meta
            $gallery_images = $this->post_meta['gallery_images'];
            // Check has Images
            if( ! empty( $gallery_images ) ) {
                $out = array();
                foreach( $gallery_images as $image ) {
                    // Get image tag with image url
                    $image = wp_get_attachment_image( $image['attachment_id'], $image_size );
                    if( $image ) {
                        // Get image with item forat
                        $out[] = sprintf( $item_format, $image );
                    }
                }
                if( ! empty( $out ) ) {
                    // Get output with block format
                    $out = sprintf( $block_format, implode( $out ) );
                }
            }
        }
        // Check print output or return
        if( $echo ) {
	        echo wp_kses_post( $out );
        } else {
            return $out;
        }
    }

	public function get_history( $post_id ){

		$os = SLZ_Util::get_mobile_operating_system();
		$history_status = slz_get_db_post_option($post_id, 'history_status', '');
		$status_out = $status_options = $button = $status_link = $target = '';

		if(!empty($history_status)){
			$count = 0;
			$status_exists = array();
			foreach ( $history_status as $key => $item ) {

				if ( wp_is_mobile() ) {

					if( $os == 'Android' ){
						if( !empty( $item['google_store'] ) ){
							$status_link = $item['google_store'];
						}
					}else if( $os == 'iPhone' || $os == 'iPod'  || $os == 'iPad' ){
						if( !empty( $item['app_store'] ) ){
							$status_link = $item['app_store'];
						}
					}else if( $os == 'Windows' ){
						if( !empty( $item['windows_store'] ) ){
							$status_link = $item['windows_store'];
						}
					}
					else {
						if( !empty( $item['link'] ) ){
							$status_link = $item['link'];
						}
					}

				}else{

					if( !empty( $item['link'] ) ){
						$status_link = $item['link'];
					}

				}
				if( !empty($item['link_target'])) {
					$target = '_blank';
				}
				if( $count == 0 ){
					if( $target ){
						$target = 'target="'.esc_attr($target).'"';
					}
					$button = '<a href="'.esc_attr($status_link).'" '.esc_attr($target).' class="slz-btn slz-btn-download">'.esc_html('get free', 'slz') .' </a>';
				}
				if( !in_array( $item['status'], $status_exists)){
					$status_exists[] = $item['status'];
					$object = get_term_by('slug',$item['status'],'slz-portfolio-status');
					$status_options .= '<option value="'.esc_url($status_link).'" data-target="'.esc_attr($target).'">'.esc_attr($object->name).'</option>';
				}

				$count++;
			}
			if( $status_options ) {
				$status_out  = '<div class="portfolio-history"><select class="slz-select-version ">';
				$status_out .= $status_options;
				$status_out .= '</select>';
				$status_out .= $button;
				$status_out .= '</div>';
			}
		}

		return $status_out;
	}
	public function get_archive_link( $posttype = '' ){
		if( empty($posttype) ) {
			$posttype = $this->post_type;
		}
		return get_post_type_archive_link($posttype);
	}

	/**
	 * Get meta team
	 * @param $html_options
	 *
	 * @return string
	 */
	public function get_meta_team( $html_options = array() ){
		$out = '';
		$format = $this->html_format['team_format'];
		if( ! empty( $html_options['team_format'] ) ) {
			$format = $html_options['team_format'];
		}
		$term_id = $this->post_meta['team'];
		if( ! empty( $term_id ) ) {
			$team_title = get_the_title( intval( $this->post_meta['team'] ) );
			$team_url = get_permalink( intval( $this->post_meta['team'] ) );
			if( ! empty( $team_title ) ) {
				$out = sprintf( $format, esc_html( $team_title ), esc_attr( $team_url ) );
			}
		}
		return $out;
	}

    /**
     * Get Attachment Block for Portfolio
     * Format: - attachment_block_format: %1$s - items content formated
     *         - attachment_item_format: %1$s - item url, %2$s - item class, %3$s - item fa icon, %4$s - item attribute
     * @param array $html_options
     * @param bool $echo
     * @return string
     */
    public function get_attachment_block($html_options = array(), $echo = false ) {
	    $out = $item_attribute = '';
	    // Make Unique ID for Modal
	    $unique_id = 'portfolio-attachment-'. SLZ_Com::make_id();
        $modal_format = '<div id="%1$s" class="modal fade" role="dialog"><div class="modal-dialog"><div class="modal-content"><div class="modal-body"></div></div></div></div>';
        $modal_attribute_format = 'data-toggle="modal" data-target="#%1$s" data-url="%2$s"';
	    // Get Block Format
        $block_format = $this->html_format['attachment_block_format'];
        if( ! empty( $html_options['attachment_block_format'] ) ) {
            $block_format = $html_options['attachment_block_format'];
        }
        // Get Item Format
        $item_format = $this->html_format['attachment_item_format'];
        if( ! empty( $html_options['attachment_item_format'] ) ) {
            $item_format = $html_options['attachment_item_format'];
        }
        // Get Links from Portfolio Post Meta
        $links = $this->post_meta['links'];
        if( ! empty( $links ) ) {
            foreach( $links as $link ) {
                $item_class = 'url';
                $item_icon  = 'link';
                $item_url   = esc_url( $link );
                $out .= sprintf( $item_format, esc_attr( $item_url ), esc_attr( $item_class ), esc_attr( $item_icon ), esc_attr( $item_attribute ) );
            }
        }
        // Get Files from Portfolio Post Meta
        $files = $this->post_meta['attach_ids'];
        if( ! empty( $files ) ) {
            foreach( $files as $file ) {
                $item_url = esc_url( $file['url'] );
                $file_type = wp_check_filetype( $item_url );
                switch ( $file_type['ext'] ) {
                    // Video
                    case 'avi' :
                    case 'flv' :
                    case 'm4v' :
                    case 'mov' :
                    case 'mp4' :
                    case 'mpg' :
                    case 'rm' :
                    case 'swf' :
                    case 'wmv' :
                        $item_class     = 'video';
                        $item_icon      = 'video-camera';
                        $item_attribute = sprintf( $modal_attribute_format, esc_attr( $unique_id ), esc_url( $item_url ) );
                        $item_url = 'javascript:void(0);';
                        break;
                    // Documents
                    case 'pdf' :
                    case 'doc' :
                    case 'odt' :
                    case 'msg' :
                    case 'docx' :
                    case 'rtf' :
                    case 'wps' :
                    case 'wpd' :
                    case 'pages' :
                    case 'csv' :
                    case 'xlsx' :
                    case 'xls' :
                    case 'xml' :
                    case 'xlr' :
                    case 'ppt' :
                    case 'pptx' :
                    case 'pptm' :
                        $item_class = 'doc';
                        $item_icon  = 'file-pdf-o';
                        $item_attribute = 'download';
                        break;
                    // Audio
                    case 'mp3' :
                    case 'wav' :
                    case 'm4a' :
                    case 'aif' :
                    case 'wma' :
                    case 'ra' :
                    case 'mpa' :
                    case 'iff' :
                    case 'm3u' :
                        $item_class = 'mp3';
                        $item_icon  = 'headphones';
                        $item_attribute = sprintf( $modal_attribute_format, esc_attr( $unique_id ), esc_url( $item_url ) );
                        $item_url = 'javascript:void(0);';
                        break;
                    // Images
                    case 'jpg' :
                    case 'jpeg' :
                    case 'png' :
                    case 'gif' :
                    case 'tiff' :  
                    case 'bmp' :   
                    	$item_class = 'image';
                        $item_icon  = 'file-image-o';
                        $item_attribute = 'download';
                        break;                 
                    // Other
                    default :
                        $item_class = 'other';
                        $item_icon  = 'file-o';
                        $item_attribute = 'download';
                        break;
                }
                $out .= sprintf( $item_format, esc_attr( $item_url ), esc_attr( $item_class ), esc_attr( $item_icon ), $item_attribute );
            }
        }
        // Check If Has Item
        if( ! empty( $out ) ) {
            $out = sprintf( $block_format, $out );
            $out .= sprintf( $modal_format, esc_attr( $unique_id ) );
        }

        // Check Echo or Return
        if( $echo ) {
            echo ( $out );
        }
	    return $out;
    }

    public function get_single_meta_info( $html_options = array() ) {
	    $meta_info = array( 'block_info' => '', 'attach' => '' );
        $pf_info = slz_get_db_settings_option( 'pf-meta-info' );
        if( empty( $pf_info ) ) {
            return;
        }
        $pf_info = array_unique( $pf_info );
        foreach ( $pf_info as $info ) {
            if( $info == 'date' ) {
                $meta_info['block_info'] .= $this->get_date( $html_options );
            }
            if( $info == 'category' ) {
                $meta_info['block_info'] .= $this->get_terms( $html_options );
            }
            if( $info == 'team' ) {
                $meta_info['block_info'] .= $this->get_meta_team( $html_options );
            }
        }
        if( in_array( 'attach', $pf_info ) ) {
            $meta_info['attach'] = $this->get_attachment_block( $html_options );
        }
        return $meta_info;
    }
}