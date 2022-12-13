<?php
class SLZ_Team extends SLZ_Custom_Posttype_Model {

	private $post_type = 'slz-team';
	private $post_taxonomy = 'slz-team-cat';

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
			'position'		=> esc_html__('Postition', 'slz'),
			'phone'			=> esc_html__('Phone', 'slz'),
			'email'			=> esc_html__('Email', 'slz'),
			'skype'			=> esc_html__('Skype', 'slz'),
			'description'	=> esc_html__('Description', 'slz'),
			'short_des'		=> esc_html__('Short description', 'slz'),
			'quote'			=> esc_html__('Quote', 'slz'),
            'arr_icon'      => '',
            'list_image'    => '',
		);
		foreach ($meta_atts as $key_gr => $value_gr) {
			if ( is_array($value_gr) ) {
				foreach ($value_gr as $key => $value) {
					$slz_merge_meta_atts[$key_gr.'/'.$key] = $value;
				}
			}
		}
		$this->post_meta_atts = array_merge($meta_atts, $slz_merge_meta_atts, SLZ_Params::get( 'params_social'));
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
			'layout'			=> 'grid-01',
			'column'			=> '3',
			'limit_post'		=> '-1',
			'offset_post'		=> '0',
			'sort_by'			=> '',
			'post_id'			=> '',
			'exclude_id'		=> '',
			'method'			=> '',
			'list_category'		=> '',
			'list_post'			=> '',
			'description_lenghth' =>'',
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
		if( !empty( $atts['exclude_id'] ) ){
			if( !is_array( $atts['exclude_id'] ) ){
				$atts['exclude_id'] = explode(',', $atts['exclude_id']);
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
		$class = '';
		$column = $this->attributes['column'];
		$def = array(
			'1' => 'team-col-1 col-xs-12',
			'2' => 'team-col-2 col-sm-6 col-xs-12',
			'3' => 'team-col-3 col-md-4 col-sm-6 col-xs-12',
			'4' => 'team-col-4 col-lg-3 col-md-4 col-sm-6 col-xs-12',
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
			$custom_css .= sprintf('.%1$s .title { color: %2$s !important;}',
								$this->attributes['uniq_id'], $this->attributes['color_title']
							);
		}
		if( !empty($this->attributes['color_title_hv']) ) {
			$custom_css .= sprintf('.%1$s .title:hover { color: %2$s !important;}',
								$this->attributes['uniq_id'], $this->attributes['color_title_hv']
							);
		}
		if( !empty($this->attributes['color_position']) ) {
			$custom_css .= sprintf('.%1$s .position { color: %2$s !important;}',
								$this->attributes['uniq_id'], $this->attributes['color_position']
							);
		}
		if( !empty($this->attributes['color_quote']) ) {
			$custom_css .= sprintf('.%1$s .quote-item .block-quote { color: %2$s;}',
								$this->attributes['uniq_id'], $this->attributes['color_quote']
							);
		}
		if( !empty($this->attributes['color_quote_icon']) ) {
			$custom_css .= sprintf('.%1$s .col-right .description .quote-item .icon-quote { color: %2$s;}',
								$this->attributes['uniq_id'], $this->attributes['color_quote_icon']
							);
		}
		if( !empty($this->attributes['color_info']) ) {
			$custom_css .= sprintf('.%1$s .team-body .slz-info-block a{ color: %2$s;}',
								$this->attributes['uniq_id'], $this->attributes['color_info']
							);
		}
		if( !empty($this->attributes['color_hv_info']) ) {
			$custom_css .= sprintf('.%1$s .team-body .slz-info-block a:hover { color: %2$s;}',
								$this->attributes['uniq_id'], $this->attributes['color_hv_info']
							);
		}
		if( !empty($this->attributes['color_description']) ) {
			$custom_css .= sprintf('.%1$s .team-body .description { color: %2$s;}',
								$this->attributes['uniq_id'], $this->attributes['color_description']
							);
			if( $this->attributes['layout'] == 'carousel' ) {
				$custom_css .= sprintf('.%1$s .col-right .description { color: %2$s;}',
								$this->attributes['uniq_id'], $this->attributes['color_description']
							);
			}
		}
		if( !empty($this->attributes['color_social']) ) {
			$custom_css .= sprintf('.%1$s .social-list .item i.icon { color: %2$s !important;}',
								$this->attributes['uniq_id'], $this->attributes['color_social']
							);
		}
		if( !empty($this->attributes['color_social_hv']) ) {
			$custom_css .= sprintf('.%1$s .social-list .item:hover i.icon { color: %2$s !important;}',
								$this->attributes['uniq_id'], $this->attributes['color_social_hv']
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

		if( !empty($this->attributes['color_slide_dots_at']) ) {
			$custom_css .= sprintf('.%1$s .slick-dots li button:before { color: %2$s;}',
								$this->attributes['uniq_id'], $this->attributes['color_slide_dots_at']
							);
		}


		if( !empty($this->attributes['color_carousel_arrow']) ) {
			$custom_css .= sprintf('.%1$s .slz-carousel-wrapper .slick-arrow { color: %2$s;}',
								$this->attributes['uniq_id'], $this->attributes['color_carousel_arrow']
							);
		}
		if( !empty($this->attributes['color_carousel_arrow_hv']) ) {
			$custom_css .= sprintf('.%1$s .slz-carousel-wrapper .slick-arrow:hover { color: %2$s;}',
								$this->attributes['uniq_id'], $this->attributes['color_carousel_arrow_hv']
							);
		}
		if( !empty($this->attributes['color_carousel_arrow_bg']) ) {
			$custom_css .= sprintf('.%1$s .slz-carousel-wrapper .slick-arrow { background-color: %2$s;}',
								$this->attributes['uniq_id'], $this->attributes['color_carousel_arrow_bg']
							);
		}
		if( !empty($this->attributes['color_carousel_arrow_bg_hv']) ) {
			$custom_css .= sprintf('.%1$s .slz-carousel-wrapper .slick-arrow:hover { background-color: %2$s;}',
								$this->attributes['uniq_id'], $this->attributes['color_carousel_arrow_bg_hv']
							);
		}

		return $custom_css;
	}

	public function set_default_options( $html_options = array() ) {
		$defaults = array(
			'title_format'			=> '<a href="%2$s" class="title">%1$s</a>',
			'info_format'			=> '<div class="%2$s info-item"><a href="%1$s">%3$s</a></div>',
			'phone_format'			=> '<a href="%1$s" class="%2$s info-item"><span>'.esc_html('Phone Number: ', 'slz').'</span>%3$s</a>',
			'email_format'			=> '<a href="%1$s" class="%2$s"><span>'.esc_html('Email: ', 'slz').'</span>%3$s</a>',
			'info_format2'          => '<div class="item"><i class="%2$s"></i>%1$s</div>',
			'position_format'		=> '<div class="position">%s</div>',
			'quote_format'			=> '<div class="quote-item">
											<div class="block-quote">%s</div>
										</div>',
			'social_format'			=> '<a href="%2$s" class="item">
											<i class="icon %1$s fa fa-%1$s"></i><span class="text">%3$s</span>
										</a>',
			'excerpt_format'		=> '<div class="description">%s</div>',
			'thumb_class' 			=> 'img-full',
			'image_format'			=> '<a href="%2$s" tabindex="1" class="link">%1$s</a>',
			'description_all'       => '<div>%1$s</div><div>%2$s</div>',
            'list_image'            => array(
                'format'    => '<div class="horizontal-scroll-div mCustomScrollbar " data-mcs-theme="light-thin" data-mcs-axis:"x">
                                            %s
                                        </div>',
                'item'      => '<div class="item"><div class="item-inner">
                                               %s
                                        </div></div>',
                'img'       => '<div class="cd-thumb"><div class="wrap-cd">
                                            <img src="%s" alt="" class="img-full"> 
                                        </div></div>',
                'max_show' => 4,
                'show_all' => 1
            )
		);

		$html_options = array_merge( $defaults, $html_options );
		return $html_options;
	}

	private function get_thumb_size() {
		$layout = $this->attributes['layout'];
		if( empty($this->attributes['thumb-size']) ) {
			if ( isset($this->attributes['image_size']) && is_array($this->attributes['image_size']) ) {
				$image_size = $this->attributes['image_size'];
				if( !empty($this->attributes['image_size'][$layout]) ) {
					$image_size = $this->attributes['image_size'][$layout];
				} else if( isset($this->attributes['image_size']['default']) ) {
					$image_size = $this->attributes['image_size']['default'];
				}
				$this->attributes['thumb-size'] = SLZ_Util::get_thumb_size( $image_size, $this->attributes );
			}
		}
	}

	/*-------------------- >> Render Html << -------------------------*/
	/**
	 * Render html by shortcode. style grid-01 & grid-02
	 *
	 * @param array $html_options
	 * Format: 1$ - image, 2$ - title, 3$ - position, 4$ - contact info, 5$ - description, 6$ - social, 7$ - post_id, 8$ - responsive
	 */
	public function render_team_list_sc( $html_options = array() ) {
		$this->html_format = $this->set_default_options( $html_options );
		$thumb_size = 'small';
		if ( !empty($this->attributes['column']) && ( $this->attributes['column'] == 1 || $this->attributes['column'] == 2 ) ) {
			$thumb_size = 'large';
		}
		if( $this->query->have_posts() ) {
			while ( $this->query->have_posts() ) {
				$this->query->the_post();
				$this->loop_index();

				$html_options = $this->html_format;
				printf( $html_options['html_format'],
					$this->get_featured_image( $html_options, $thumb_size ),
					$this->get_title( $html_options ),
					$this->get_meta_position(),
					$this->get_meta_info(),
					$this->get_meta_short_description(),
					$this->get_meta_social(),
					$this->post_id,
					$this->attributes['responsive-class'],
					$this->permalink
				);
			}
			$this->reset();
			if( !empty($this->attributes['pagination']) && $this->attributes['pagination'] == 'yes' ) {
				echo '<div class="clearfix"></div>';
				echo SLZ_Pagination::paging_nav( $this->query->max_num_pages, 2, $this->query);
			}
		}
	}
	/**
	 * Render html by shortcode. style carousel
	 *
	 * @param array $html_options
	 * Format: 1$ - image, 2$ - title, 3$ - position, 4$ - contact info, 5$ - description, 6$ - social, 7$ - content, 8$ - quote
	 */
	public function render_team_carousel_sc( $html_options = array() ) {
		$this->html_format = $this->set_default_options( $html_options );
		$thumb_size = 'small';
		if ( !empty($this->attributes['column']) && ( $this->attributes['column'] == 1 || $this->attributes['column'] == 2 ) ) {
			$thumb_size = 'large';
		}
		if( $this->attributes['layout'] == 'layout-6' ) {
			$thumb_size = 'large';
			$this->attributes['image_size'] = array(
				'large'   => 'full',
				'no-image-large'   => 'full',
			);
		}
		if( $this->query->have_posts() ) {
			while ( $this->query->have_posts() ) {
				$this->query->the_post();
				$this->loop_index();

				$html_options = $this->html_format;
				printf( $html_options['html_format'],
					$this->get_featured_image( $html_options, $thumb_size ),
					$this->get_title( $html_options ),
					$this->get_meta_position(),
					$this->get_meta_info(),
					$this->get_meta_short_description(),
					$this->get_meta_social(),
					$this->get_meta_description(),
					$this->get_meta_quote(),
					$this->get_description_all( $html_options ),
					$this->get_meta_info2(),
					$this->permalink,
                    $this->get_meta_list_image($html_options)
                );
			}
			$this->reset();
		}
	}

	/**
	 * Render html by shortcode. navigation style carousel-1
	 *
	 * @param array $html_options 
	 * Format: 1$ - image, 2$ - post_id
	 */
	public function render_team_carousel_nav_sc( $html_options = array() ) {
		$this->html_format = $this->set_default_options( $html_options );
		if( $this->query->have_posts() ) {
			while ( $this->query->have_posts() ) {
				$this->query->the_post();
				$this->loop_index();
				$html_options = $this->html_format;
				printf( $html_options['html_format'],
					$this->get_featured_image( $html_options, 'small' ),
					$this->post_id
				);
			}
			$this->reset();
		}
	}


	public function render_filter_tab( $atts = array(), $html_options ) {

		$output = $output_grid = '';
		$taxonomy = $this->taxonomy_cat;
		$format = '<li class="%5$s tab_item" role="presentation" ><a class="link" href="#tab-%3$s" role="tab" data-toggle="tab" aria-expanded="%4$s" data-slug="%1$s">%2$s</a></li>';

		$args = array(
			'pad_counts ' 	=> 1,
			'slug' 			=> $atts['category_slug'],
		);

		$terms = get_terms( $taxonomy, $args );
		$tab_id = '';
		if ($terms && ! is_wp_error($terms)) {
			foreach( $terms as $key => $term ) {
				$classActive = $classFadeActive = '';
				$expanded = 'false';
				if ( $key == 0 ) {
					$classActive = 'active';
					$expanded = 'true';
					$classFadeActive = 'in active';
				}
				$tab_id = $atts['uniq_id'] . '-' . $key;
				$json_data = esc_attr( json_encode($atts) );
				$output .= sprintf( $format,
						esc_attr( $term->slug),
						esc_html( $term->name ),
						esc_attr( $tab_id ),
						esc_attr( $expanded ),
						esc_attr( $classActive )
				);
				$atts['category_slug'] = $term->slug;
				$model = new SLZ_Team();
				$model->init( $atts );
				$grid = $model->render_team_tab( $html_options );
				$output_grid .= sprintf('<div id="tab-%2$s" class="tab-pane fade %3$s" role="tabpanel"><div class="slz-list-block slz-column-'.esc_attr($model->attributes['column']).'">%1$s</div></div>',
						$grid,
						esc_attr( $tab_id ),
						$classFadeActive 
						);
			}
		}
		return array( $output, $output_grid );
	}

	public function render_team_tab(  $html_options = array() ) {

		$this->html_format = $this->set_default_options( $html_options );
		$thumb_size = 'small';
		$output = '';
		if ( !empty($this->attributes['column']) && ( $this->attributes['column'] == 1 || $this->attributes['column'] == 2 ) ) {
			$thumb_size = 'large';
		}
		if( $this->query->have_posts() ) {
			while ( $this->query->have_posts() ) {
				$this->query->the_post();
				$this->loop_index();
				$html_options = $this->html_format;

				$output .= sprintf( $html_options['html_format'],
					$this->get_featured_image( $html_options, $thumb_size ),
					$this->get_title( $html_options ),
					$this->get_meta_position(),
					$this->get_meta_info(),
					$this->get_meta_short_description(),
					$this->get_meta_social(),
					$this->post_id,
					$this->attributes['responsive-class']
				);
			}
			$this->reset();
			if( !empty($this->attributes['pagination']) && $this->attributes['pagination'] == 'yes' ) {
				echo '<div class="clearfix"></div>';
				echo SLZ_Pagination::paging_nav( $this->query->max_num_pages, 2, $this->query);
			}
		}

		return $output;

	}

	/*-------------------- >> General Functions << --------------------*/
	public function get_meta_position() {
		$out = '';
		$show_position = $this->attributes['show_position'];
		if ( !empty($show_position) && $show_position == 'yes' ) {
			$format = $this->html_format['position_format'];
			$position = $this->post_meta['position'];
			if( !empty( $position ) ) {
				$out = sprintf( $format, esc_html($position) );
			}
		}
		return $out;
	}

	public  function get_meta_list_image( $option_format=array() ) {
	    $out = $list_image = $limit = $html_item = $html_img =  '';
        if ( empty( $option_format['list_image']['max_show'] ) ) {
            $option_format['list_image']['max_show'] = $this->html_format['list_image']['max_show'];
        }
        $limit = intval( $option_format['list_image']['max_show'] );
	    if ( empty( $option_format['list_image']['format'] ) ) {
            $option_format['list_image']['format'] = $this->html_format['list_image']['format'];
        }
        if ( empty( $option_format['list_image']['item'] ) ) {
            $option_format['list_image']['item'] = $this->html_format['list_image']['item'];
        }
        if (  empty( $option_format['list_image']['img'] ) ) {
            $option_format['list_image']['img'] = $this->html_format['list_image']['img'];
        }
        if (  empty( $option_format['list_image']['show_all'] )  ) {
            $option_format['list_image']['show_all'] = $this->html_format['list_image']['show_all'];
        }

        $list_image = array();
	    
	    if (isset($this->post_meta['list_image'])) {
	        $list_image = $this->post_meta['list_image'];
        }

	    foreach ($list_image as $index => $img) {
	        if ( empty( $img['url'] ) ){
	            $limit++;
                continue;
            }
            $html_img .= sprintf( $option_format['list_image']['img'], $img['url'] );
            if ( $index + 1 == $limit) {
                $html_item .= sprintf( $option_format['list_image']['item'], $html_img );
                $html_img = '';
                if ($option_format['list_image']['show_all']) {
                    $limit += $option_format['list_image']['max_show'];
                    if ($limit > count($list_image)) {
                        $limit = count($list_image);
                    }
                }
            }
        }
        if ( ! empty( $html_item ) ) {
	        $out = sprintf($option_format['list_image']['format'], $html_item );
        }
	    return $out;
    }

    public function get_meta_arr_icon($format='', $format_custom='') {
        $out = '';
        if ( empty($format) ) {
            $format = '<li>
            				<div class="list-icons-wrapper">
            					<div class="icon-wrapper">
		                            <i class="%1$s team-icon"></i>
		                        </div>
	                            <div class="info-wrapper">
	                                <span class="title">%2$s</span>
	                                <span class="value">%3$s</span>
	                            </div>
                            </div>
                        </li>';

        }

        if ( empty($format_custom) ) {
            $format_custom = '<li>
            				<div class="list-icons-wrapper">
            					<div class="icon-wrapper">
	                            	<img class="team-img" src="%1$s" alt="" />
	                            </div>
	                            <div class="info-wrapper">
	                                <span class="title">%2$s</span>
	                                <span class="value">%3$s</span>
	                            </div>
                            </div>
                        </li>';

        }

        $arr_icon = $this->post_meta['arr_icon'];
        if ( !empty($arr_icon) && count($arr_icon) > 0 ) {
            foreach ($arr_icon as $icon) {
                if ( ! empty( $icon['icon']['type'] ) && $icon['icon']['type'] == 'icon-font' ) {
                    $out .= sprintf($format, $icon['icon']['icon-class'], $icon['name'], $icon['value']);
                }
                if ( ! empty( $icon['icon']['type'] ) && $icon['icon']['type'] == 'custom-upload' ) {
                    $out .= sprintf($format_custom, $icon['icon']['url'], $icon['name'], $icon['value']);
                }
            }
        }
        return $out;
    }

	// get phone number
	public function get_phone(){
		$out = '';
		$show_info = $this->attributes['show_contact_info'];
		if ( !empty($show_info) && $show_info == 'yes' ) {
			$format = $this->html_format['phone_format'];
			$phone  = $this->post_meta['phone'];
			if( !empty( $phone ) ) {
				$phonere = str_replace(' ', '', $phone);
			}
			if( !empty( $phonere )  ) {
				$out .= sprintf( $format, 'tel:' . esc_attr( $phonere ), 'mobile', esc_html( $phone ) );
			}
			
		}
		return $out;
	}
	//get email
	public function get_email(){
		$out = '';
		$show_info = $this->attributes['show_contact_info'];
		if ( !empty($show_info) && $show_info == 'yes' ) {
			$format = $this->html_format['email_format'];
			$email  = $this->post_meta['email'];
			if( !empty( $email ) ) {
					$out .= sprintf( $format, 'mailto:' . esc_attr( $email ), 'email', esc_html( $email ) );
				}
			
		}
		return $out;
	}
	public function get_meta_info() {
		$out = '';
		$show_info = $this->attributes['show_contact_info'];
		if ( !empty($show_info) && $show_info == 'yes' ) {
			$format = $this->html_format['info_format'];
			$phone  = $this->post_meta['phone'];
			$email  = $this->post_meta['email'];
			if( !empty( $phone ) ) {
				$phonere = str_replace(' ', '', $phone);
			}
			if( !empty( $phonere ) || !empty( $email ) ) {
				$out .= '<div class="slz-info-block">';

				if( !empty( $phonere ) ) {
					$out .= sprintf( $format, 'tel:' . esc_attr( $phonere ), 'mobile', esc_html( $phone ) );
				}
	
				if( !empty( $email ) ) {
					$out .= sprintf( $format, 'mailto:' . esc_attr( $email ), 'email', esc_html( $email ) );
				}

				$out .= '</div>';
			}
			
		}
		return $out;
	}
	public function get_meta_info2() {
		$out = '';
		$show_info = $this->attributes['show_contact_info'];
		if ( !empty($show_info) && $show_info == 'yes' ) {
			$format = $this->html_format['info_format2'];
			$phone  = $this->post_meta['phone'];
			$email  = $this->post_meta['email'];
			if( !empty( $phone ) ) {
				$phonere = str_replace(' ', '', $phone);
			}
			if( !empty( $phonere ) || !empty( $email ) ) {
				$out .= '<div class="info-title">'. esc_html__( 'contact information', 'slz' ) .'</div>';
				$out .= '<div class="info-description contact-info">';

				if( !empty( $phonere ) ) {
					$out .= sprintf( $format, esc_html( $phone ), 'fa fa-phone' );
				}
	
				if( !empty( $email ) ) {
					$out .= sprintf( $format, esc_html( $email ), 'fa fa-envelope-o' );
				}

				$out .= '</div>';
			}
			
		}
		return $out;
	}
	public function get_meta_quote() {
		$out = '';
		$format = $this->html_format['quote_format'];
		$show_quote = $this->attributes['show_quote'];
		if ( !empty($show_quote) && $show_quote == 'yes' ) {
			$quote = $this->post_meta['quote'];
			if( !empty( $quote ) ) {
				$out = sprintf( $format, wp_kses_post(nl2br($quote)) );
			}
		}
		return $out;
	}


	
	public function get_meta_social() {
		$out = $out_social_more = '';
		$format = $this->html_format['social_format'];
		$show_social = $this->attributes['show_social'];
		if ( !empty($show_social) && $show_social == 'yes' ) {
			$social_group = SLZ_Params::params_social();
			$count = 0;
			$social_more_open = $social_more_item = $social_more_close = '';
			foreach( $social_group as $social => $social_text ){
				$value = $this->post_meta[$social];
				if( !empty($value) ) {
					if ($social == 'skype') {
						if ( strpos($value, 'skype:') === false ) {
							$value = sprintf('skype:%s?call', esc_attr($value) );
						}
					}
					if($this->attributes['layout'] == 'layout-4' ){
						if( $count >= 3){
							if( $count == 3 ){
								$social_more_open .= '<li class="more-social-item">
							                            <div class="text">...</div>
							                            <ul class="more-list">'; 
							}
							$social_more_item .= sprintf( $format, esc_attr( $social ), esc_attr( $value ), esc_html( $social_text ) );
						}else{
							$out .= sprintf( $format, esc_attr( $social ), esc_attr( $value ), esc_html( $social_text ) );
						} 
					}else{
						$out .= sprintf( $format, esc_attr( $social ), esc_attr( $value ), esc_html( $social_text ) );
					}
					$count++;
				}

			}
			if($this->attributes['layout'] == 'layout-4'){
				$social_more_close = '</ul></li>';
				if($count == 4){
					$out .= $social_more_item;
				}elseif($count > 4){
					$out .= $social_more_open.$social_more_item.$social_more_close;
				}	
			}
			if( ! empty( $out ) ) {
                if( is_singular( $this->post_type ) ) {
                    return $out;
                } else {
                    if( $this->attributes['layout'] == 'layout-4' ) {
                        $out = sprintf( '<ul class="social-list">%1$s</ul>', $out );
                    }
                    elseif( $this->attributes['layout'] == 'layout-5' ) {
                        $out = sprintf( '<div class="team-social social-list">%1$s</div>', $out );
                    }
                    elseif( $this->attributes['layout'] == 'layout-6' ) {
                        $out = sprintf( '<div class="info-social social-list">%1$s</div>', $out );
                    }else {
                    	$out = sprintf( '<div class="social-list">%1$s</div>', $out );
                    }
                }
            }
		}
		return $out;
	}

	public function get_meta_description() {
		$out = '';
		$format = '%s';
		$description = $this->post_meta['description'];
		$show_description = $this->attributes['show_description'];
		if ( !empty( $description ) && !empty($show_description) && $show_description == 'yes' ) {
			$out = sprintf( $format, wp_kses_post( $description) );
		}
		return $out;
	}

	public function get_meta_short_description() {
		$format = '%s';
		$description = '';
		$show_description = $this->attributes['show_description'];
		if ( !empty($show_description) && $show_description == 'yes' ) {
			$description = $this->post_meta['short_des'];
		}
		if ( empty($description) ) {
			return '';
		}
		$description_lenghth = (int) $this->attributes['description_lenghth'];
		if ( !empty($description_lenghth) ) {
			$description = wp_trim_words( $description, $description_lenghth, '...' );
		}
		if ( isset($this->html_format['excerpt_format']) ) {
			$format = $this->html_format['excerpt_format'];
		}
		$out = sprintf($format, wp_kses_post(nl2br($description)) );
		return $out;
	}

	public function get_description_all( $html_options = array() ) {
		$out = '';
		$format = $html_options['description_all'];
		if( $this->attributes['show_description'] == 'no' ) {
			return  $out;
		}
		$out .= sprintf( $format, $this->get_meta_short_description(), $this->get_meta_description() );
		return $out;
	}
}