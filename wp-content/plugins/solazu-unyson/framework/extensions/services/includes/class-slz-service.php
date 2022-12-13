<?php
class SLZ_Service extends SLZ_Custom_Posttype_Model {

	private $post_type = 'slz-service';
	private $post_taxonomy = 'slz-service-cat';

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
			'icon'              => '',
			'thumbnail'         => '',
			'description'       => '',
			'gallery_images'     => ''
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
			'layout'			=> '',
			'column'			=> '',
			'limit_post'		=> '-1',
			'offset_post'		=> '0',
			'sort_by'			=> '',
			'post_id'			=> '',
			'method'			=> '',
			'list_category'		=> '',
			'list_post'			=> '',
			'description'       => '',
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
				if(isset($atts['list_post']) && function_exists('vc_param_group_parse_atts') ){
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
			'1' => 'slz-column-1',
			'2' => 'slz-column-2',
			'3' => 'slz-column-3',
			'4' => 'slz-column-4'
		);
		
		if( $column && isset($def[$column])) {
			return $this->attributes['responsive-class'] = $def[$column];
		} else {
			return $this->attributes['responsive-class'] = $def['4'];
		}
	}
	
	public function add_custom_css() {
		$custom_css = '';
		$uniq_id    = $this->attributes['uniq_id'];
		if( !empty( $this->attributes['icon_color'] ) ) {
			$custom_css .= sprintf('.%1$s .icon-cell .wrapper-icon .slz-icon { color: %2$s;}',
									$uniq_id, $this->attributes['icon_color']
								);
			$custom_css .= sprintf('.%1$s ul.tab-list li a[data-toggle="tab"] .wrapper-icon { color: %2$s;}',
									$uniq_id, $this->attributes['icon_color']
								);
		}
		if( !empty( $this->attributes['icon_bd_color'] ) ) {
			$custom_css .= sprintf('.%1$s .icon-cell .wrapper-icon { border-color: %2$s;}',
									$uniq_id, $this->attributes['icon_bd_color']
								);
		}
		if( !empty( $this->attributes['icon_bd_hv_color'] ) ) {
			$custom_css .= sprintf('.%1$s .icon-cell .wrapper-icon:hover { border-color: %2$s;}',
									$uniq_id, $this->attributes['icon_bd_hv_color']
								);
		}

		if( !empty( $this->attributes['block_bg_color'] ) ) {
			$custom_css .= sprintf('.%1$s .item .icon-box-item{ background-color: %2$s;}',
									$uniq_id, $this->attributes['block_bg_color']
								);
		}
		if( !empty( $this->attributes['block_bg_hv_color'] ) ) {
			$custom_css .= sprintf('.%1$s .item .icon-box-item:hover{ background-color: %2$s;}',
									$uniq_id, $this->attributes['block_bg_hv_color']
								);
		}
		if( !empty( $this->attributes['title_color'] ) ) {
			$custom_css .= sprintf('.%1$s .item .title { color: %2$s !important;}',
									$uniq_id, $this->attributes['title_color']
								);
			$custom_css .= sprintf('.%1$s ul.tab-list li a[data-toggle="tab"] { color: %2$s;}',
									$uniq_id, $this->attributes['title_color']
								);
		}

		if( !empty( $this->attributes['des_color'] ) ) {
			$custom_css .= sprintf('.%1$s .content-cell .wrapper-info .description { color: %2$s;}',
									$uniq_id, $this->attributes['des_color']
								);
		}
		if( !empty( $this->attributes['btn_color'] ) ) {
			$custom_css .= sprintf('.%1$s .content-cell .wrapper-info .slz-btn { color: %2$s;}',
									$uniq_id, $this->attributes['btn_color']
								);
		}
		if( !empty( $this->attributes['btn_bg_color'] ) ) {
			$custom_css .= sprintf('.%1$s .content-cell .wrapper-info .slz-btn { background-color: %2$s;}',
									$uniq_id, $this->attributes['btn_bg_color']
								);
		}
		if( isset( $this->attributes['nav_color'] ) && !empty( $this->attributes['nav_color'] ) ) {
			$custom_css .= sprintf('.%1$s .btn.slick-arrow { color: %2$s;}',
									$uniq_id, $this->attributes['nav_color']
								);
		}
		if( isset( $this->attributes['title_active_color'] ) && !empty( $this->attributes['title_active_color'] ) ) {
			$custom_css .= sprintf('.%1$s ul.tab-list li.active a[data-toggle="tab"] { color: %2$s;}',
									$uniq_id, $this->attributes['title_active_color']
								);
		}
		return $custom_css;
	}

	public function set_default_options( $html_options = array() ) {
		$defaults = array(
			'image_format'          => '%1$s',
			'image_format_custom'   => '<div class="wrapper-icon-image"><img src="%1$s" class="slz-icon-img" alt="" /></div>',
			'gallery_format'        => '<div class="slz-isotope-grid-2 column-3">%1$s</div>',
			'gallery_item_format'   => '<div class="%2$s"><img src="%1$s" alt="" class="img-full"></div>',
			'icon_format'           => '<div class="wrapper-icon"><i class="slz-icon %1$s"></i></div>',
			'title_format'          => '<a class="title" href="%2$s">%1$s</a>',
			'description_format'    => '<div class="description">%1$s</div>',
			'excerpt_format'        => '<div class="description">%1$s</div>',
			'btn_more_format'       => '<a href="%2$s" class="slz-btn">
                                            <span class="text">%1$s</span>
                                            <span class="icons fa fa-angle-double-right"></span>
                                            </a>',
			'thumb_class'           => 'img-responsive'
		);

		$html_options = array_merge( $defaults, $html_options );
		return $html_options;
	}

	/*-------------------- >> Render Html << -------------------------*/
	/**
	 * Render html by shortcode.
	 *
	 * @param array $html_options
	 * Format: 1$ - image, 2$ - title, 3$ - description, 4$ - button
	 */
	public function render_list( $html_options = array(), $args = array() ) {
		$this->html_format = $this->set_default_options( $html_options );
		$i = 0;
		$count = 0;
		if( $this->query->have_posts() ) {
			while ( $this->query->have_posts() ) {
				$this->query->the_post();
				$this->loop_index();
				$i++;
				$html_options = $this->html_format;
				if(empty($args['split_columns']) ||($args['split_columns'] == 'even' &&  ($count % 2) == 0) || ($args['split_columns'] == 'odd' && ($count % 2) != 0 ) ){
					printf( $html_options['html_format'],
						$this->get_service_icon($i),
						$this->get_title( $html_options ),
						$this->get_description(),
						$this->get_btn_more_custom( $html_options ),
						$this->get_service_thumbnail(),
						$this->get_featured_image(),
						$count
					);
				}
				$count++;
			}
			$this->reset();
			// pagination
			if( !empty($this->attributes['pagination']) && $this->attributes['pagination'] == 'yes' ) {
				echo SLZ_Pagination::paging_nav( $this->query->max_num_pages, 2, $this->query);
			}
		}
	}

	/**
	 * @param array $html_options
	 * Format: 1$ - uniq_id, 2$ - active class, 3$ - image, 4$ - title
	 */
	public function render_tab_list( $html_options = array() ) {
		$this->html_format = $this->set_default_options( $html_options );

		if( $this->query->have_posts() ) {
			$count = 1;
			while ( $this->query->have_posts() ) {
				$this->query->the_post();
				$this->loop_index();

				$cls_active = '';
				if( $count == 1 ){
					$cls_active = 'active';
				}
				$uniq_id =  $this->attributes['uniq_id'] . '-' . $this->post_id;
				printf( $this->html_format['tab_format'],
					esc_attr( $uniq_id ),
					esc_attr( $cls_active ),
					$this->get_service_icon(),
					esc_html( $this->title )
				);
				$count ++;
			}
			$this->reset();
		}
	}

	/**
	 * @param array $html_options
	 * Format: 1$ - uniq_id, 2$ - active class, 3$ - gallery, 4$ - content
	 */
	public function render_tab_content( $html_options = array() ) {
		$this->html_format = $this->set_default_options( $html_options );

		if( $this->query->have_posts() ) {
			$count = 1;
			while ( $this->query->have_posts() ) {
				$this->query->the_post();
				$this->loop_index();

				$cls_active = '';
				if( $count == 1 ){
					$cls_active = 'in active';
				}
				$uniq_id =  $this->attributes['uniq_id'] . '-' . $this->post_id;
				$html_options = $this->html_format;
				printf( $html_options['html_format'],
					esc_attr( $uniq_id ),
					esc_attr( $cls_active ),
					$this->get_service_gallery(),
					$this->get_title( $html_options ),
					$this->get_description(),
					$this->get_btn_more_custom( $html_options ),
					$this->get_featured_image()
				);
				$count ++;
			}
			$this->reset();
		}
	}



	/*-------------------- >> General Functions << --------------------*/
	public function get_service_thumbnail() {
		$out = '';
		
		$attachment_id   = $this->post_meta['thumbnail'];
		if( empty( $attachment_id ) ) {
			return $out;
		}
		$out = wp_get_attachment_image( $attachment_id['attachment_id'] );
		
		return $out;
	}

	public function get_service_icon($number=1) {
		$output = '';
		$show_icon = $this->attributes['show_icon'];
		if ( !empty($show_icon) && $show_icon == 'icon' ) {
			if(!empty($this->attributes['show_number'])){
				$output .= '<div class="number"><span>'.str_pad($number, 2, '0', STR_PAD_LEFT).'</span></div>';
			}
			$format = $this->html_format['icon_format'];
			$icon   = $this->post_meta['icon'];
			if( !empty( $icon ) ){
				$output .= sprintf( $format, esc_attr( $icon ) );
			}
		}
		else if($show_icon == 'image'){
			$format   = $this->html_format['image_format_custom'];
			if( isset($this->post_meta['thumbnail']['url']) && !empty( $this->post_meta['thumbnail']['url'] ) ){
				$output = sprintf( $format, esc_url( $this->post_meta['thumbnail']['url'] ) );
			}
		}else if($show_icon == 'feature-image') {
            $format   = $this->html_format['image_format_custom'];
            if( has_post_thumbnail() ){
                $output = sprintf( $format, esc_url( wp_get_attachment_url(get_post_thumbnail_id($this->post_id)) ) );
            }
        }
		return $output;
	}
	public function get_description_with_length() {
		$description = $this->get_content( $this->html_format );
		$description_length = (int) $this->attributes['description_length'];
		if ( !empty($description_length ) ) {
			$description = wp_trim_words( $description, $description_length, '...' );
		}
		$description = '<div class="description">' . $description . '</div>';
		return $description;
	}
	public function get_description() {
		$output = '';
		$html_options = $this->html_format;
		$des_type = $this->attributes['description'];
		if( $des_type == 'des' ){
			$format = $html_options['description_format'];
			$description = $this->post_meta['description'];
			if( !empty( $description ) ) {
				$output = sprintf( $format, wp_kses_post( $description ) );
			}
		}
		elseif( $des_type == 'content' ){
			$output = $this->get_description_with_length();
		} elseif( $des_type == 'archive' ){
			$description = $this->post_meta['description'];
			if( empty( $description ) ) {
				$description = $this->get_excerpt();
			}
			if( empty( $description ) ) {
				$description = $this->get_content();
			}
			$format = $html_options['description_format'];
			if( !empty($description) ) {
				$output = sprintf( $format, wp_kses_post( $description ) );
			}
		}
		else{
			$output = $this->get_excerpt( $html_options );
		}
		return $output;
	}
	public function get_service_gallery(){
		$output = '';
		$gallery_ids = $this->post_meta['gallery_images'];
		if( !empty( $gallery_ids ) ){
			$gallery_format = $this->html_format['gallery_format'];
			$item_format    = $this->html_format['gallery_item_format'];
			$images = '';
			$count = 1;
			foreach ($gallery_ids as $key => $value) {
				if( isset( $value['url'] ) && !empty( $value['url'] ) ){
					$item_cls = 'grid-item';
					if( $count == 2 ){
						$item_cls = 'grid-item grid-item-width-2 grid-item-height-1';
					}
					$images .= sprintf( $item_format, esc_url( $value['url'] ), esc_attr( $item_cls ) );
					$count ++;
				}
			}
			if( !empty( $images ) ){
				$output = sprintf( $gallery_format, $images );
			}
		}
		return $output;
	}
	
	public function get_btn_more_custom( $html_options ) {
		$out = '';
		if( !empty($this->attributes['btn_content']) ) {
			$out .= $this->get_btn_more( $html_options );
		}
		return $out;
	}

}