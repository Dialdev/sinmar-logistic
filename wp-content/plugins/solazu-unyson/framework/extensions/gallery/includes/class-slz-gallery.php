<?php
class SLZ_Gallery extends SLZ_Custom_Posttype_Model {

	private $post_type = 'slz-gallery';
	private $post_taxonomy = 'slz-gallery-cat';

	public function __construct() {
		$this->meta_attributes();
		$this->set_meta_attributes();
		$this->taxonomy_cat = $this->post_taxonomy;
		$this->html_format = $this->set_default_options();
		$this->uniq_id = SLZ_Com::make_id();
	}
	public function meta_attributes() {
		$slz_merge_meta_atts = array();
		$meta_atts = array(
			'gallery_images' => esc_html__('Gallery Images', 'slz'),
			'options_icon_image'  => '',
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
	public function init( $atts = array(), $query_args = array() ) {
		// set attributes
		$default_atts = array(
			'layout'			=> 'gallery',
			'limit_post'		=> '-1',
			'offset_post'		=> '0',
			'sort_by'			=> '',
			'post_id'			=> '',
			'method'			=> '',
			'list_category'		=> '',
			'list_post'			=> '',
		);
		$atts = array_merge( $default_atts, $atts );
		$post_type = '';
		if ( !empty( $atts['post_type'] ) ) {
			$post_type = substr( $atts['post_type'], 4);
		}

		if ( !empty( $atts['post_type'] ) && $atts['post_type'] == 'slz-portfolio' ) {
			$this->taxonomy_cat = $atts['post_type'].'-cat';
		}elseif ( !empty( $atts['post_type'] ) && $atts['post_type'] == 'slz-gallery' ) {
			$this->taxonomy_cat = $atts['post_type'].'-cat';
		}
		
		if( empty( $atts['post_id'] ) ){
			if( isset( $atts['method_'.$post_type] ) ) {
				if( $atts['method_'.$post_type] == 'cat' ) {
					if( empty( $atts['category_slug'] ) ) {
						list( $atts['category_list_parse'], $atts['category_slug'] ) = SLZ_Util::get_list_vc_param_group( $atts, 'list_category_'.$post_type, 'category_slug' );
						if ( empty( $atts['category_slug'] ) ) {
							$default = array("orderby"=>"name", "hierarchical"=>false, "hide_empty" => true);
							$args = array_merge( $default, array()		 );
							$terms = get_terms( $this->taxonomy_cat, $args);
							if ( !empty( $terms ) ) {
								foreach ($terms as $term) {
									$atts['category_slug'][] = $term->slug; 
								}
							}
						}
					}
					$atts['post_id'] = $this->parse_cat_slug_to_post_id( 
												$atts['post_type'].'-cat',
												$atts['category_slug'],
												$atts['post_type']
											);
				} else {
					$atts['method'] = 'post';
					if(isset($atts['list_post_'.$post_type])){
						$list_post = array();
						if( function_exists('vc_param_group_parse_atts')) {
							$list_post = (array) vc_param_group_parse_atts( $atts['list_post_'.$post_type] );
						}
						$atts['post_id'] = $this->parse_list_to_array( 'post', $list_post );
						if ( empty( $atts['post_id'] ) ) {
							$default = array("orderby"=>"name", "hierarchical"=>false, "hide_empty" => true);
							$args = array_merge( $default, array()		 );
							$terms = get_terms( $this->taxonomy_cat, $args);
							if ( !empty( $terms ) ) {
								foreach ($terms as $term) {
									$atts['category_slug'][] = $term->slug; 
								}
							}
						}else{
							if ( !empty( $atts['post_id'] ) ) {
								$array = array();
								foreach ($atts['post_id'] as $id) {
									$terms = get_the_terms( $id, $this->taxonomy_cat);
									if ( !empty( $terms ) ) {
										foreach ($terms as $term) {
											if( empty( $array ) ){
												$array[] = $term->slug;
											}else{
												if( !in_array($term->slug, $array) ){
													$array[] = $term->slug;
												}
											}
										}// end foreach
									}
								}// end foreach
								$atts['category_slug'] = $array;
							}							
						}
					}
				}
			}
		}
		$this->attributes = $atts;

		// query
		$default_args = array(
			'post_type' => $atts['post_type'],
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
			$custom_css .= sprintf('.%1$s .block-gallery .block-content .title { color: %2$s;}',
								$this->attributes['uniq_id'], $this->attributes['color_title']
							);
		}
		return $custom_css;
	}

	public function set_default_options( $html_options = array() ) {
		$defaults = array(
			'title_format'			=> '<a href="%2$s" class="block-title">%1$s</a>',
			'category_format'       => '<a href="%2$s" class="block-category">%1$s</a>',
			'excerpt_format'		=> '<div class="block-text">%1$s</div>',
			'description_format'	=> '<div class="quote-item"><div class="icon-quote"></div><div class="block-quote">%s</div></div>',
			'thumb_class' 			=> 'img-responsive img-full',
			'image_format'			=> '%1$s',
			'author_format'         => '<a href="%2$s" class="link">%1$s</a>',
			'date_format'           => '<a href="%2$s" class="link">%1$s</a>',
			'icon_format'           => '<div class="icon-block"><a href="%2$s"><i class="%1$s"></i></a></div>',
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
	public function render_category_filter_tab() {
		$out = '';
		$terms = '';
		$taxonomy = $this->taxonomy_cat;

		if ( !empty( $this->attributes['show_category_filter'] ) && $this->attributes['show_category_filter'] == 'yes' ) {
			$out .= '<div class="slz-isotope-nav">';
				$out .= '<ul class="tab-filter">';
					$out .= '
					<li data-filter="*" data-category="all" class="tab active">
						<div class="link">all</div>
					</li>
					';
			if( $this->query->have_posts() ) {
				while ( $this->query->have_posts() ) {
					$this->query->the_post();
					$this->loop_index();

					$terms = get_the_terms( $this->post_id, $taxonomy );
					if ( !empty( $terms ) ) {
						foreach ($terms as $term) {
							$out .= '
							<li data-filter=".'.esc_attr( $term->slug ).'" data-category="'. esc_attr( $term->slug ) .'" class="tab">
								<div class="link">'. esc_html( $term->name ) .'</div>
							</li>
							';
						}
					}

				}
				$this->reset();
			}
				$out .= '</ul>';
			$out .= '</div>';
		}
		echo ($out);
	}
	public function parse_isotope_class(){
		$class_arr = array();
		$item_size = array();
		switch($this->attributes['style']) {
			case 'style-1':
				$class_arr = array(
					'1'  => '',
					'2'  => '',
					'3'  => 'grid-item-height-2',
					'4'  => 'grid-item-width-2',
					'5'  => '',
					'6'  => '',
					'7'  => 'grid-item-width-2 grid-item-height-1',
				);
				$item_size['7'] = 'small';
				break;
			case 'style-2':
				$class_arr = array(
					'1'  => 'grid-item-height-2',
					'2'  => 'grid-item-width-2 grid-item-height-1',
					'3'  => '',
					'4'  => 'grid-item-width-2',
					'5'  => '',
					'6'  => '',
					'7'  => '',
				);
				$item_size['2'] = 'small';
				break;
			case 'style-3':
				$class_arr = array(
					'1'  => 'grid-item-height-2',
					'2'  => '',
					'3'  => '',
					'4'  => 'grid-item-width-2',
					'5'  => 'grid-item-width-2 grid-item-height-1',
					'6'  => '',
					'7'  => '',
					'8'  => 'grid-item-width-2 grid-item-height-1',
					'9'  => '',
				);
				$item_size['5'] = 'small';
				$item_size['8'] = 'small';
				break;
			case 'style-4':
				$class_arr = array(
					'1'  => '',
					'2'  => '',
					'3'  => '',
					'4'  => 'grid-item-width-2',
					'5'  => '',
					'6'  => 'grid-item-width-2 grid-item-height-1',
					'7'  => 'grid-item-width-2 grid-item-height-1',
					'8'  => '',
					'9'  => '',
					'10' => '',
				);
				$item_size['6'] = 'small';
				$item_size['7'] = 'small';
				break;
			case 'style-5':
				$class_arr = array(
					'1'  => '',
					'2'  => '',
					'3'  => 'grid-item-width-2 grid-item-height-1',
					'4'  => '',
					'5'  => 'grid-item-width-2 grid-item-height-1',
					'6'  => '',
					'7'  => '',
					'8'  => '',
				);
				$item_size['3'] = 'small';
				$item_size['5'] = 'small';
				break;
			case 'style-6':
				$class_arr = array(
					'1'  => '',
					'2'  => '',
					'3'  => 'grid-item-width-2',
					'4'  => '',
					'5'  => 'grid-item-width-2',
					'6'  => 'grid-item-height-2',
					'7'  => '',
					'8'  => '',
				);
				break;
			case 'style-7':
				$class_arr = array(
					'1'  => '',
					'2'  => 'grid-item-width-2 grid-item-height-1',
					'3'  => '',
					'4'  => '',
					'5'  => '',
				);
				$item_size['2'] = 'small';
				break;
			case 'style-8':
				$class_arr = array(
					'1'  => '',
					'2'  => '',
					'3'  => '',
					'4'  => '',
					'5'  => '',
					'6'  => '',
					'7'  => '',
					'8'  => '',
					'9'  => '',
				);
				break;
			case 'style-9':
				$class_arr = array(
					'1'  => '',
					'2'  => 'grid-item-height-2',
					'3'  => '',
					'4'  => '',
					'5'  => '',
					'6'  => '',
					'7'  => '',
					'8'  => 'grid-item-width-2 grid-item-height-1'
				);
				$item_size['8'] = 'small';
				break;
			case 'style-10':
				$class_arr = array(
					'1'  => '',
					'2'  => '',
					'3'  => '',
					'4'  => '',
					'5'  => '',
					'6'  => '',
					'7'  => '',
					'8'  => '',
				)
				;break;
			case 'style-11':
				$class_arr = array(
					'1'  => 'grid-item-height-2',
					'2'  => 'grid-item-width-2 grid-item-height-1',
					'3'  => '',
					'4'  => '',
					'5'  => 'grid-item-width-2 grid-item-height-1',
					'6'  => ''
				);
				$item_size['2'] = 'small';
				$item_size['5'] = 'small';
				break;
			case 'style-12':
			$class_arr = array(
				'1'  => '',
				'2'  => '',
				'3'  => '',
				'4'  => '',
				'5'  => '',
				'6'  => '',
				'7'  => '',
				'8'  => '',
				'9'  => '',
				'10'  => ''
			);
		}
		return array($class_arr, $item_size);
	}
	/*-------------------- >> Render Html << -------------------------*/
	/**
	 * Render html by shortcode.
	 *
	 * @param array $html_options
	 * Format: 1$ - image, 2$ - title, 3$ - img url, 4$ - url, 5$ excerpt or description meta , 6$ class, $7 category, $8 author, $9 date, $10 meta icon  
	 */
	public function render_isotope_post( $html_options = array() ) {

		$this->html_format = $this->set_default_options( $html_options );
		$row_count = 1;
		$i = 1;
		$thumb_size = 'large';
		$class_img = '';

		list($class_arr, $item_size) = $this->parse_isotope_class();
		if( $this->query->have_posts() ) {
			while ( $this->query->have_posts() ) {
				$this->query->the_post();
				$this->loop_index();
				$thumb_size = 'large';
				if(isset($item_size["{$i}"])) {
					$thumb_size = $item_size["{$i}"];
				}

				$title = '';
				if( $this->attributes['show_title'] == 'yes' ){
					$title = $this->get_title( $this->html_format );
				}

				$html_options = $this->html_format;
				printf( $html_options['html_format'],
					$this->get_featured_image( $html_options, $thumb_size ),
					wp_kses_post( $title ),
					$this->get_zoom_in_btn(),
					$this->get_read_more_btn(),
					$this->get_description_or_excerpt(),
					esc_attr( $class_arr[$i] ),
					$this->get_category(),
					$this->get_data_meta_post( $html_options ),
					$this->get_meta_icon(),
					$this->get_navfilter_class(),
					$this->get_feature_img_url_full()
				);
				$row_count++;
				$i++;
				if( $i > count($class_arr) ){
					$i = 1;
				}
			}
			$this->reset();
		}
	}

	public function render_filter_tab( $atts = array(), $html_options ) {
		$output = $output_grid = '';
		$taxonomy = $this->taxonomy_cat;
		$text_class = ' tab-title-content';
		$format = '<li class="%5$s tab_item" role="presentation" ><a class="link" href="#tab-%3$s" role="tab" data-toggle="tab" aria-expanded="%4$s" data-slug="%1$s">%2$s</a></li>';
		$args = array(
			'pad_counts ' 	=> 1,
			'slug' 			=> $atts['category_slug'],
		);
		if( empty($html_options['tab_content_format'])) {
			$tab_content_format = '<div id="tab-%2$s" class="tab-pane  %3$s" role="tabpanel"><div class="gallery-list grid-main  %4$s">%1$s</div></div>';
		} else {
			$tab_content_format = $html_options['tab_content_format'];
		}
		$terms = get_terms( $taxonomy, $args );
		$tab_id = '';
		$column = '4';

        $class_col = 'column-3';
        $arr_column = array(
            'style-1' => 'column-3',
            'style-2' => 'column-4',
            'style-3' => 'column-5',
            'style-4' => 'column-5',
            'style-5' => 'column-5',
            'style-6' => 'column-5',
            'style-7' => 'column-3',
            'style-8' => 'column-3',
            'style-9' => 'column-5'
        );
        if(isset($arr_column[$atts['style']])){
            $class_col = $arr_column[$atts['style']];
        }

        if( $atts['layout'] == 'layout-2' ){
            $class_col .= ' slz-isotope-grid-2';
        }

		$post_type = substr( $atts['post_type'], 4);
		
		if( isset( $atts['method_'.$post_type] ) ) {
			if( $atts['method_'.$post_type] == 'cat' ) {
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
								esc_attr( $classActive ) . $text_class
						);
						$atts['category_slug'] = $term->slug;
						$atts['tab_key'] = $key;
						$model = new SLZ_Gallery();
						$model->init( $atts );
						$grid = $model->render_gallery_tab( '',$html_options );
						$output_grid .= sprintf($tab_content_format,
								$grid,
								esc_attr( $tab_id ),
								$classFadeActive ,
								$class_col
								);
					}
				}
			} else {

				if(isset($atts['list_post_'.$post_type])){
					$post_id = $this->attributes['post_id'];
					if ( !empty( $post_id ) ) {
						$title = '';
						$count = 0;
						foreach ( $post_id as $key => $value ) {
							$classActive = $classFadeActive = '';
							$expanded = 'false';
							if ( $count == 0 ) {
								$classActive = 'active';
								$expanded = 'true';
								$classFadeActive = 'in active';
							}
							if($post_type == 'gallery'){
								$icon = slz_get_db_post_option( $value, 'options_icon_image/icon/icon_options' );
							}else{
								$icon = slz_get_db_post_option( $value, 'font-icon' );
							}
							if( $atts['filter_title_'.$post_type] == 'icon'){
								$title = '<i class="'.esc_attr($icon).'"></i>';
								$text_class = '';
							}else{
								$title = get_the_title( $value );
							}
							$tab_id = $atts['uniq_id'] . '-' .  $value;
							$json_data = esc_attr( json_encode($atts) );
							$output .= sprintf( $format,
									esc_attr( $value),
									wp_kses_post($title),
									esc_attr( $tab_id ),
									esc_attr( $expanded ),
									esc_attr( $classActive ) . $text_class
							);
							$atts['tab_key'] = $value;
							$model = new SLZ_Gallery();
							$atts['post_id'] = array($value);
							$model->init( $atts );
							$grid = $model->render_gallery_tab( $value,$html_options );
							$output_grid .= sprintf($tab_content_format,
									$grid,
									esc_attr( $tab_id ),
									$classFadeActive ,
									$class_col
									);
							$count++;

							}
							
					}
				}
			}
		}
		
		return array( $output, $output_grid );
	}

	public function render_gallery_tab( $post_id ='', $html_options = array() ) {
		$this->html_format = $this->set_default_options( $html_options );
		$row_count = 1;
		$output = '';
		$i = 1;
		$group = 1;
		$thumb_size = 'large';
		list($class_arr, $item_size) = $this->parse_isotope_class();

		$class_img = '';
		if( $this->query->have_posts() ) {
			while ( $this->query->have_posts() ) {
				$this->query->the_post();
				$this->loop_index();
				$gallery_arr = $this->post_meta['gallery_images'];
				if($gallery_arr){
					foreach ($gallery_arr as $key => $value) {
						$thumb_size = 'large';
						if(isset($item_size["{$i}"])) {
							$thumb_size = $item_size["{$i}"];
						}
						$group_class = 'group-'. $group . '-' . $i;
						$tab_group = $this->attributes['tab_key'];
						$post_class = $this->get_post_class( $group_class );
						if( isset($value['attachment_id']) && $attachment_id = $value['attachment_id'] ) {
							$img_url = $this->get_image_url_by_id($attachment_id, $thumb_size);
							$html_options = $this->html_format;
							$output .= sprintf( $html_options['html_format'],
									esc_attr( $class_arr[$i] ),
									esc_url( $value['url'] ),
									esc_url( $img_url ),
									esc_attr($post_class),
									esc_attr($tab_group)
							);
							if($row_count == $this->attributes['limit_post']){
								break;
							}
							$row_count++;
							$i++;
							
							if( $i > count($class_arr) ){
								$i = 1;
								$group ++;
							}
						}
					}
				}
			}
			
			
			$this->reset();
		}
		return $output;

	}
	
	public function render_gallery_carousel( $html_options = array(), $layout = '' ) {
		$this->html_format = $html_options;
		$thumb_size = 'large';
		$image_count = 0;
		if( $this->query->have_posts() ) {
			while ( $this->query->have_posts() ) {
				$this->query->the_post();
				$this->loop_index();
				$gallery_arr = $this->post_meta['gallery_images'];
				foreach ($gallery_arr as $key => $value) {
					$html_options = $this->html_format;
					$image_title = '';
					$image_title = get_the_title($value['attachment_id']);
					$img_url = $this->get_image_url_by_id($value['attachment_id'], $thumb_size);
					printf( $html_options['html_format'],
						esc_url($value['url']),
						esc_attr($image_title),
						esc_url($img_url)
					);
					if( $image_count == $this->attributes['limit_image'] - 1 ){
						break;
					}
					$image_count++;
				
				}
				if( $image_count == $this->attributes['limit_image'] - 1 ){
					break;
				}
			}
			$this->reset();
		}
	}
	public function render_gallery_feature( $html_options = array(), $item = '' ) {
		$this->html_format = $this->set_default_options( $html_options );

		$count = 1;
		$i = 0;
		$thumb_size = 'large';
		$class_arr = array();

		if( $this->query->have_posts() ) {
			$number_post = floor(count($this->query->posts) / 2);
			while ( $this->query->have_posts() ) {
				$this->query->the_post();
				$this->loop_index();
				$title = '';
				if( $this->attributes['show_title'] == 'yes' ){
					$title = $this->get_title( $this->html_format );
				}
				$html_options = $this->html_format;
				if( $item == 'even' && ($count % 2) == 0 || $item =='' || $item == 'odd' && ($count % 2) != 0){
					printf( $html_options['html_format'],
					$this->get_featured_image( $html_options, $thumb_size ),
					wp_kses_post( $title ),
					$this->get_read_more_btn(),
					$this->get_description_or_excerpt(),
					esc_url( $this->permalink ),
					$this->get_meta_icon(),
					$this->get_options_image_icon(),
					$i
				);
				}
				$i++;
				$count++;
			}
			$this->reset();
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
		$this->html_format = $html_options;
		$thumb_size = 'large';
		if( $this->query->have_posts() ) {
			while ( $this->query->have_posts() ) {
				$this->query->the_post();
				$this->loop_index();
				$html_options = $this->html_format;
				printf( $html_options['html_format'],
					$this->get_featured_image( $html_options, $thumb_size ),
					$this->get_feature_img_url_full()
				);
			}
			$this->reset();
		}
	}

	/*-------------------- >> Render Widget Image Slider << -------------------------*/
		/**
		 * use for widget image slider
		 *
		 * @param array $html_options
		 * Format: 1$ - image, 2$ - image link
		 */
	public function render_widget_image_slider( $html_options = array() ) {
		$this->html_format = $html_options;
		$thumb_size = 'large';
		if( $this->query->have_posts() ) {
			while ( $this->query->have_posts() ) {
				$this->query->the_post();
				$this->loop_index();
				$html_options = $this->html_format;
				printf( $html_options['html_format'],
					$this->get_feature_img_url_full(),
					$this->get_featured_image( $html_options, $thumb_size )
				);
			}
			$this->reset();
		}
	}
	
	/*-------------------- >> General Functions << --------------------*/

	public function get_feature_img_url_full() {
		$out = '';
		if ( get_post_thumbnail_id( $this->post_id ) ) {
			$out = wp_get_attachment_url( get_post_thumbnail_id( $this->post_id ) );
		}
		return $out;
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

	public function get_category(){
		$out = '';
		$format = $this->html_format['category_format'];
		if ( !empty( $this->attributes['show_category'] ) && $this->attributes['show_category'] == 'yes' ) {
			$category = get_the_terms( $this->post_id, $this->taxonomy_cat );
			if ( !empty( $category[0] ) ) {
				$term_link = get_term_link( $category[0]->term_id, $this->taxonomy_cat );
				$out .= sprintf( $format, esc_attr( $category[0]->name ), esc_url( $term_link ) );
			}
		}

		return $out;
	}

	public function get_meta_icon(){
		$out = '';
		$format = $this->html_format['icon_format'];
		if( $this->attributes['post_type'] == 'slz-gallery' ){
			$icon = slz_get_db_post_option( $this->post_id, 'options_icon_image/icon/icon_options' );
		}else{
			$icon = slz_get_db_post_option( $this->post_id, 'font-icon' );
		}
		if ( !empty( $icon ) ) {
			$out .= sprintf( $format, esc_attr( $icon ), esc_url( $this->permalink ) );
		}
		return $out;
	}

	public function get_description_or_excerpt() {
		$out = '';
		$format = $this->html_format['excerpt_format'];

		if ( !empty( $this->attributes['show_description'] ) && $this->attributes['show_description'] == 'yes' ) {
			$description = slz_get_db_post_option( $this->post_id, 'description' );

			if ( !empty( $description ) ) {
				$out .= sprintf( $format, wp_kses_post( $description ) );
			}else{
				$out .= sprintf( $format, get_the_excerpt() );
			}
		}

		return $out;
	}

	public function get_data_meta_post( $html_options ){
		$out = '';

		if ( !empty( $this->attributes['show_meta_data'] ) && $this->attributes['show_meta_data'] == 'yes' ) {
			$author = $this->get_author( $html_options );
			$date = $this->get_date( $html_options );

			$format = '
				<ul class="block-info">
					<li>
						%1$s
					</li>
					<li>
						%2$s
					</li>
				</ul>
			';
			if ( !empty( $author ) && !empty( $date ) ) {
				$out .= sprintf( $format, $author, $date );
			}
		}


		return $out;
	}

	public function get_navfilter_class() {
		$out = '';
		$i = 1;
		if ( !empty( $this->attributes['show_category_filter'] ) && $this->attributes['show_category_filter'] == 'yes' ) {
			$terms = get_the_terms( $this->post_id, $this->taxonomy_cat );
			if ( !empty( $terms ) ) {
				foreach ($terms as $term) {
					if ( $i == 1 ) {
						$out .= $term->slug;
					}else{
						$out .= ' '.$term->slug;
					}
					$i++;
				}
			}
		}
		return $out;
	}

	public function render_filter_type( $atts = array() ) {
		$output = '';
		$text_class = 'tab-title-content';
		$taxonomy = $this->taxonomy_cat;
		if ( !empty( $this->attributes['show_category_filter'] ) && $this->attributes['show_category_filter'] == 'yes' && !empty( $atts['category_slug'] ) ) {
			$format = '<li class="tab tab-data-less %3$s '.$text_class.'" data-filter=".%1$s" data-slug="%1$s" data-category="%2$s"><div class="link">%2$s</div></li>';
			$args = array(
				'pad_counts ' 	=> 1,
				'slug' 			=> $atts['category_slug'],
			);
			$terms = get_terms( $taxonomy, $args );
			if ($terms && ! is_wp_error($terms)) {
				foreach( $terms as $key => $term ) {
					$classActive = '';

					$atts['category_slug'] = $term->slug;
					$json_data = esc_attr( json_encode($atts) );
					$output .= sprintf( $format, esc_attr( $term->slug), esc_html( $term->name ), esc_attr( $classActive ) );
				}
			}
			$tab_align_class = '';
			if( isset($this->attributes['align_category_filter']) ) {
				$tab_align_class = $this->attributes['align_category_filter'];
			}
			$format = '
				<div class="slz-isotope-nav '.$tab_align_class.'">
					<ul class="tab-filter">
						<li data-filter="*" data-category="all" class="tab tab-all-active active '.$text_class.' ">
							<div class="link">all</div>
						</li>
						%1$s
					</ul>
				</div>
			';
			printf( $format, $output );
		}
	}

	public function get_read_more_btn(){
		$out = '';

		if ( !empty( $this->attributes['show_read_more'] ) && $this->attributes['show_read_more'] == 'yes' ) {
			if(!isset($this->html_format['read_more'])){
				$out .= '
					<a href="'. esc_url( $this->permalink ) .'" class="block-read-mores">'. esc_html__('Read More', 'slz') .'
						<i class="slz-icon icon-read-more"></i>
					</a>
				';
			}else{
				$out = sprintf($this->html_format['read_more'],esc_url( $this->permalink ),$this->attributes['read_more_text']);
			}
			
		}

		return $out;
	}

	public function get_zoom_in_btn(){
		$out = '';

		if ( !empty( $this->attributes['show_fancybox_zoomin'] ) && $this->attributes['show_fancybox_zoomin'] == 'yes' ) {
			$img = '';
			if ( get_post_thumbnail_id( $this->post_id ) ) {
				$img = wp_get_attachment_url( get_post_thumbnail_id( $this->post_id ) );
			}

			$out .= '
				<a href="'. esc_url( $img ) .'" class="fancybox block-zoom-img">'. esc_html__( 'Zoomin', 'slz' ) .'
					<i class="slz-icon icon-zoom-in"></i>
				</a>
			';
		}

		return $out;
	}
	
	public function get_options_image_icon(){
		$out = '';
		$icon_arr = array();
		$item = '';
		$format = $this->html_format['icon_format'];
		if( $this->attributes['post_type'] == 'slz-gallery' ){
			$icon_arr = $this->post_meta['options_icon_image'];
			if( isset( $icon_arr['options-choices'] ) ) {
				if( $icon_arr['options-choices'] == 'image' ) {
					if( empty( $icon_arr['image']['image_upload']['attachment_id'] ) ) {
						return $out;
					}
					$format = $this->html_format['image_format'];
					$item = wp_get_attachment_image( $icon_arr['image']['image_upload']['attachment_id'], 'full' );
				}else{
					if( empty( $icon_arr['icon']['icon_options'] ) ) {
						return $out;
					}
					$item = $icon_arr['icon']['icon_options'];
				}
			}
		}else{
			$item = slz_get_db_post_option( $this->post_id, 'font-icon' );
		}
		if ( !empty( $item ) ) {
			$out .= sprintf( $format,  $item , esc_url( $this->permalink ) );
		}
		return $out;
	}

}