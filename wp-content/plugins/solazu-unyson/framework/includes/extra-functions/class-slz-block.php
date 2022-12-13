<?php
class SLZ_Block {
	public $post_id;
	public $title;
	public $title_attribute;
	public $has_thumbnail = false;
	public $permalink;

	public $uniq_id;
	public $post;
	public $attributes = array();
	public $query;

	public function __construct( $atts, $content = null ) {
		$atts['content'] = $content;
		$atts = $this->get_block_setting($atts);
		$this->block_atts = $atts;
		$this->set_attributes( $atts );
		$this->block_atts['block-class'] = $this->attributes['block-class'];

		// add inline css
		$custom_css = $this->add_custom_css();

		if ( !empty( $custom_css ) )
			do_action( 'slz_add_inline_style', $custom_css );
	}

	public function set_attributes( $atts = array() ) {
		$this->uniq_id = SLZ_Com::make_id();
		$default = array(
			'shortcode'            => '',
			'layout'               => '',
			'thumb-size'		   => '',
			'style'                => '',
			'column'			   => '',
			'block_title'          => '',
			'block_title_class'    => '',
			'block_title_color'    => '',
			'block_title_bg_color' => '',
			'limit_post'           => '',
			'offset_post'          => '0',
			'extra_class'          => '',
			'sort_by'              => '',
			'pagination'           => '',
			'category_filter'      => '',
			'category_filter_text' => 'All',
			'title_length'         => '',
			'excerpt_length'       => '',
			'category_list'        => '',
			'tag_list'             => '',
			'author_list'          => '',
			'category_slug'        => '',
			'tag_slug'             => '',
			'author'               => '',
			'paged'                => '',
			'post_type'				=> 'post',
			'row'					=> '',
			'show_title'           => '',
			'show_thumnail'        => '',
			'show_excerpt'         => '',
			'block-class'		   => '',
			'cur_limit'			   => '',
			'btn_read_more'        => '',
			'list_show_excerpt'    => '',
			'list_show_excerpt_2'  => '',
			'list_show_excerpt_3'  => '',
		);
		foreach ($atts as $key => $value) {
			if ( !isset ( $default[$key] ) ) 
				$default[$key] = '';
		}

		$manifest = slz()->theme->get_config('post_info', array());
		$default = array_merge( $default, $manifest );

		$data = SLZ_Com::set_shortcode_defaults( $default, $atts);

		if( empty( $data['category_slug'] ) ) {
			list( $data['category_list_parse'], $data['category_slug'] ) = SLZ_Util::get_list_vc_param_group( $data, 'category_list', 'category_slug' );
		}

		if( empty( $data['post_format_slug'] ) ) {
			list( $data['post_format_parse'], $data['post_format_slug'] ) = SLZ_Util::get_list_vc_param_group( $data, 'post_format', 'format_type' );
		}

		if( empty( $data['tag_slug'] ) ) {
			list( $data['tag_list_parse'], $data['tag_slug'] ) = SLZ_Util::get_list_vc_param_group( $data, 'tag_list', 'tag_slug' );
		}
		if( empty( $data['author'] ) ) {
			list( $data['author_list_parse'], $data['author'] ) = SLZ_Util::get_list_vc_param_group( $data, 'author_list', 'author' );
		}
		// Check valid
		if($data['limit_post'] != -1) {
			$data['limit_post'] = absint($data['limit_post']);
		}
		$data['offset_post'] = absint($data['offset_post']);
		if( empty($data['offset_post']) ) {
			$data['offset_post'] = 0;
		}
		if( empty($data['block-class'] ) ) {
			$data['block-class'] = sprintf( '%s-%s', $data['shortcode'], $this->uniq_id ) ;
		}

		$this->attributes = $data;
		$this->query = $this->get_query( $data );
		$this->get_thumb_size();
	}

	/**
	 * Query
	 * 
	 * @return WP_Query
	 */
	private function get_query( $data, $paged = '') {
		$query_args = array(
			'post_type' => $data['post_type'],
			'post_status' => 'publish',
			'ignore_sticky_posts' => 1 // do not move sticky posts to the start of the set.
		);
		$is_paging = false;
		// post id
		if( isset( $data['post_id'] ) && !empty( $data['post_id'] ) ) {
			if( is_array( $data['post_id'] ) ) {
				$query_args['post__in'] = $data['post_id'];
			}
		}
		// limit post
		$posts_per_page = get_option('posts_per_page');
		//custom pagination limit
		if( isset($data['limit_post']) ) {
			if ( empty($data['limit_post'] ) ) {
				$data['limit_post'] = $posts_per_page;
			}
			if( isset( $data['cur_limit'] ) &&  $data['cur_limit'] ) {
				$data['limit_post'] = $data['cur_limit'];
			}
			$query_args['posts_per_page'] = $data['limit_post'];
		}
		//paging
		if( isset($data['paged']) && $data['paged'] ) {
			$paged = $data['paged'];
		} else {
			$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
		}
		
		$offset = SLZ_Com::get_value( $data, 'offset_post', 0 );  
		if( isset( $data['pagination'] ) ) {
			if( empty($data['paged']) && ($data['pagination'] == 'ajax' || $data['pagination'] == 'load_more') ) {
				$paged = 1;
			}
			if( $data['pagination'] == '' ) {
				$query_args['nopaging '] = false;
			} else {
				$is_paging = true;
				$query_args['nopaging '] = 'paging';
				$query_args['paged'] = $paged;
				if( isset($data['offset_post']) && $paged > 1 ) {
					$offset += ( ($paged - 1) * $data['limit_post']) ;
				}
			}
		}  
		$query_args['offset'] = $offset ;
		// tax query
		$this->parse_tax_query( $query_args, $data );
		// filter by
		$this->parse_post_filter( $query_args, $data );
		//search by meta
		$this->parse_meta_key( $query_args, $data );
		// sort by
		switch ( $data['sort_by'] ) {
			case 'az_order':
				$query_args['orderby'] = 'title';
				$query_args['order'] = 'ASC';
				break;
			case 'za_order':
				$query_args['orderby'] = 'title';
				$query_args['order'] = 'DESC';
				break;
			case 'popular':
				$query_args['meta_key'] = slz()->theme->manifest->get('post_view_name');
				$query_args['orderby'] = 'meta_value_num';
				$query_args['order'] = 'DESC';
				break;
			case 'random_posts':
				$query_args['orderby'] = 'rand';
				break;
			case 'random_today':
				$query_args['orderby'] = 'rand';
				$query_args['year'] = date('Y');
				$query_args['monthnum'] = date('n');
				$query_args['day'] = date('j');
				break;
			case 'random_7_day':
				$query_args['orderby'] = 'rand';
				$query_args['date_query'] = array(
					'column' => 'post_date_gmt',
					'after' => '1 week ago'
				);
				break;
			case 'random_month':
				$query_args['orderby'] = 'rand';
				$query_args['date_query'] = array(
					'column' => 'post_date_gmt',
					'after' => '1 month ago'
				);
				break;
			case 'comment_count':
				$query_args['orderby'] = 'comment_count';
				$query_args['order'] = 'DESC';
				break;
			default:
		}
		$query = new WP_Query( $query_args );
		if( $is_paging && $this->attributes['offset_post'] > 0 ) {
			$start_offset = $this->attributes['offset_post']; 
			$query->found_posts = $this->recalc_found_posts($query, $start_offset );
			$query->max_num_pages = ceil( $query->found_posts / $query_args['posts_per_page']);
		}
		$this->query = $query;
		return $query;
	} 

	private function recalc_found_posts($query, $start_offset ) {
		$query->set( 'posts_per_page', $start_offset );
		return $query->found_posts - $start_offset;
	}

	private function parse_post_filter( &$query_args, $data ) {
		if( !empty( $data['post_filter_by'] ) ) {
			$cur_post_id = $this->attributes['cur_post_id'];
			if( empty($cur_post_id) ) {
				$cur_post_id = get_the_ID();
			}
			switch ($data['post_filter_by'] ) {
				case 'post_same_author':
					$query_args['author'] = get_post_field( 'post_author', $cur_post_id );
					$query_args['post__not_in'] = array( $this->post_id );
					break;
				case 'post_same_category':
					$query_args['category__in'] = wp_get_post_categories( $cur_post_id );
					$query_args['post__not_in'] = array( $cur_post_id );

					break;
				case 'post_same_format':
					$post_format = get_post_format( $cur_post_id );
					if( $post_format ) {
						$tax_query = array(
							array(
								'taxonomy' => 'post_format',
								'field' => 'slug',
								'terms' => array("post-format-{$post_format}")
							)
						);
						$query_args["tax_query"] = $tax_query;
						$query_args['post__not_in'] = array( $cur_post_id );
					}
					break;
				case 'post_same_tag':
					$tags = wp_get_post_tags( $cur_post_id );
					if ( $tags ) {
						$tag_list = array();
						for ($i = 0; $i <= 4; $i++) {
							if (!empty($tags[$i])) {
								$taglist[] = $tags[$i]->term_id;
							} else {
								break;
							}
						}
						$query_args['tag__in'] = $tag_list;
						$query_args['post__not_in'] = array( $this->post_id  );
					}
					break; 
				case 'post_format_video': 
						$tax_query = array(
							array(
								'taxonomy' => 'post_format',
								'field' => 'slug',
								'terms' => array("post-format-video")
							)
						);
						$query_args["tax_query"] = $tax_query;
					break;
			}
		}
	}

	private function parse_tax_query( &$query_args, $data ) {
		if( !empty( $data['category_slug'] ) ) {
			if( is_array( $data['category_slug'] ) ) {
				$data['category_slug'] = implode(',', $data['category_slug']);
			}
			$query_args['category_name'] = $data['category_slug'];
		}
		if( !empty( $data['tag_slug'] ) ) {
			if( is_array( $data['tag_slug'] )) {
				$data['tag_slug'] = implode(',', $data['tag_slug']);
			}
			$query_args['tag'] = $data['tag_slug'];
		}
		if( !empty( $data['author'] ) ) {
			//author_id
			if( is_array( $data['author'] )) {
				$data['author'] = implode(',', $data['author']);
			}
			$query_args['author'] = $data['author'];
		}

		$tax_query = array();

		if( !empty( $data['post_format_slug'] ) && is_array( $data['post_format_slug'] ) ) {

			$tax_query_post = array(
				array(
					'taxonomy' => 'post_format',
					'field' => 'slug',
					'terms' => $data['post_format_slug']
				)
			);

			$tax_query[] = $tax_query_post;
			
		}

		// Any taxonomy
		if( isset($data['taxonomy_slug']) && !empty( $data['taxonomy_slug'] ) ) {
			$taxonomy_slug = $data['taxonomy_slug'];
			if( is_array($taxonomy_slug) ) {
				foreach( $taxonomy_slug as $taxonomy_name => $slug_val ) {
					if( !empty($slug_val ) ) {
						$taxonomy_args = array(
							'taxonomy' => $taxonomy_name,
							'field'    => 'slug',
							'terms'    => $slug_val,
						);
						$tax_query[] = $taxonomy_args;
					}
				}
			}
		}
		if(! empty( $tax_query ) ) {
			if( count($tax_query) > 1 ) {
				$tax_query['relation'] = 'AND';
			}
			$query_args["tax_query"] = $tax_query;
		}
	}

	private function parse_meta_key( &$query_args, $data ){
		$meta_query = array();
		if( isset($data['meta_key']) && !empty( $data['meta_key'] ) ) {
			$meta_key_arr = $data['meta_key'];
			if( is_array($meta_key_arr) ) {
				//multi key
				foreach( $meta_key_arr as $key => $val ) {
					$meta_query[] = array(
						'key'     => $key,
						'value'   => $val,
					);
				}
			} else {
				//single key
				$meta_query[] = array(
					'key'     => $data['meta_key'],
					'value'   => $data['meta_value']
				);
			}
		}
		if( isset($data['meta_key_compare']) && !empty( $data['meta_key_compare'] ) ) {
			$meta_key_arr = $data['meta_key_compare'];
			foreach( $meta_key_arr as $value ) {
				$meta_query[] = $value;
			}
		}
		if(! empty( $meta_query ) ) {
			if( count( $meta_query ) > 1 ) {
				$meta_query['relation'] = 'AND';
			}
			$query_args["meta_query"] = $meta_query;
		}
	}

	public function add_post_filter_atts( $atts ) {
		if ( !empty( $atts['post_filter_by'] ) ) {
			$atts['cur_post_id'] = get_queried_object_id(); //add the current post id
			$atts['cur_post_author'] =  get_post_field( 'post_author', $atts['cur_post_id']); //get the current author
		}
		return $atts;
	}

	public function get_post_view( $post_id = '' ) {
		global $post;
		if( $post_id ) {
			$post_id = $post->ID;
		}
		$count_key = slz()->theme->manifest->get('post_view_name');
		$count = get_post_meta( $post_id, $count_key, true );
		$res = '';
		if($count == '') {
			delete_post_meta( $post_id, $count_key );
			add_post_meta( $post_id, $count_key, '0' );
			$res = 0;
		} else {
			$res = $count;
		}
		return $res;
	}

	public function get_post_class( $class = '', $post_id = '' ) {
		if( empty( $post_id ) ) {
			$post_id = $this->post_id;
		}
		return join( ' ', get_post_class( $class, $post_id ) );
	}

	public function view_more_button( $echo = false, $post_id = '', $btn_content = '', $html_options = array() ) {
		if( empty( $btn_content ) ) {
			$btn_content = esc_html__( 'View more', 'slz' );
		}
		if( ! isset( $html_options['class'] ) ) {
			$html_options['class'] = 'btn btn-viewmore';
		}
		if( $echo ) {
			return printf( '<a href="%1$s" class="%2$s">%3$s</a>', $this->permalink, $html_options['class'], $btn_content );
		}
		return sprintf( '<a href="%1$s" class="%2$s">%3$s</a>', $this->permalink, $html_options['class'], $btn_content );
	}

	public function add_custom_css() {
		$css = '';
		if( $this->attributes['block_title_color'] ) {
			$css .= sprintf('.%s .%s{ color: %s;}', $this->attributes['block-class'], $this->attributes['block_title_class'], $this->attributes['block_title_color']);
		}
		return $css;
	}

	private function get_block_setting( $atts ) {

		$displays = array(
			'show_category'        => 'category',
			'show_comments'        => 'comment',
			'show_views'           => 'view',
			'show_date'            => 'date',
			'show_author'          => 'author',
		);

		$block_info = slz_get_db_settings_option('block-info', '');

		if ( empty ( $block_info ) )
			return $atts;

		foreach ($displays as $key => $value) {
			if ( isset( $block_info[$value] ) ){
				$atts[$key] = $block_info[$value];
			} else {
				$atts[$key] = false;
			}
		}

		return $atts;
	}

	public function paging_nav( $pages = '', $range = 2, $current_query = '' ) {
		global $paged;

		if( $current_query == '' ) {
			global $paged;
			if( empty( $paged ) ) $paged = 1;
		} else {
			$paged = $current_query->query_vars['paged'];
		}
		
		
		$prev = $paged - 1;
		$next = $paged + 1;
		$showitems = ($range * 2)+1;
		
		if($pages == '') {
			global $wp_query;
			$pages = $wp_query->max_num_pages;
			if(!$pages) {
				$pages = 1;
			}
		}
		$method = "get_pagenum_link";
		if(is_single()) {
			$method = self::$post_page_link;
		}
		$output_page = $output_prev = $output_next = $last = $pages_of_total = '';
		
		if( 1 != $pages ) {
			$output_page .= '<div class="nav-links">';
			// first
			if( $paged > 2 && $paged > $range+1 && $showitems < $pages ) {
				$output_page .= '<a href="' . $method( 1 ) . '" class="first page-numbers">' . esc_html__('First', 'slz') . '</a>';
			}
			// prev
			$output_page .= ($paged > 1 && $showitems < $pages)? '<a href="' . $method( $prev ) . '" class="prev page-numbers">' . esc_html__('Previous', 'slz') . '</a>':'';
			if( $paged - $range > 2 ) {
				$output_page .= '<a href="' . $method( $prev ) . '" class="page-numbers">&bull;&bull;&bull;</a>';
			}
		
			for ($i=1; $i <= $pages; $i++) {
				if (1 != $pages &&( !($i >= $paged+$showitems || $i <= $paged-$showitems) || $pages <= $showitems )) {
					$output_page .= ($paged == $i)? '<span class="page-numbers current">'.$i.'</span>':'<a href="' . $method( $i ) . '" class="page-numbers" >'.$i.'</a>';
				}
			}
		
			if( $paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages ) {
				if( $paged+$showitems < $pages +1) {
					$output_page .= '<a href="' . $method( $next ) . '" class="page-numbers">&bull;&bull;&bull;</a>';
				}
			}
			$output_page .= ($paged < $pages && $showitems < $pages) ? '<a href="' . $method( $next ) . '" class="next page-numbers">' . esc_html__('Next', 'slz') . '</a>' :'';
			$output_page .= ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) ? '<a href="' . $method( $pages ) .'" class="last page-numbers">' . esc_html__('Last', 'slz') . '</a>':'';
			$output_page .= '</div>'."\n";
		}
		$output = sprintf('<nav class="navigation pagination">%1$s</nav>', $output_page);
		return $output;
	}

	public function paging_custom($page = '',$query = '' ,$show  = false, $tt) {
		$max_num_pages = $tt;
		$paged = ( $page !== null ) ? absint( $page  ) : 1;
		$paginate = paginate_links( array (
			'base'      => '%_%',
			'type'      => 'array',
			'total'     => $max_num_pages,
			'format'    => '?page=%#%&tt='.$max_num_pages,
			'current'   => $paged,
			'end_size'  => 1,
			'mid_size'  => 2,
			'prev_next' => true,
			'prev_text' => '<i class="fa fa-angle-left"></i>',
			'next_text' => '<i class="fa fa-angle-right"></i>'
		) );
		if ( $query->max_num_pages > 1 ) : ?>
		<nav class="pagination-box">
			<ul class="pagination mbn full-width"><?php
			if ( $paged != 1 ):
				echo '<li class="page-num page-num-first"><a href="?page=1&tt='.$max_num_pages.'"><i class="fa fa-angle-double-left"></i> </a></li>';
			endif;
			foreach ( $paginate as $index => $page ) { 
				echo '<li >' . $page . '</li>';
			}
			if ( $paged != $max_num_pages ):
				echo '<li class="page-num page-num-last"><a href="?page='.$max_num_pages.'&tt='.$max_num_pages.'"><i class="fa fa-angle-double-right"></i> </a></li>';
			endif; 
			?>
			</ul>
			<?php 
			if ($show) { ?> 
				<div class="result-count">
					<?php echo '<p>' . sprintf( esc_html__('Page %1$s of %2$s ','slz'), $paged, $max_num_pages) . '</p>' ?>
				</div>
			<?php } ?>
		</nav><?php
		endif;
	}
	
	// pagination with ajax
	public function paging_ajax( $pages = '', $range = 2, $current_query = '' ) {
		global $paged;
		if( $current_query == '' ) {
			global $paged;
			if( empty( $paged ) ) $paged = 1;
		} else {
			$paged = $current_query->query_vars['paged'];
		}
		
		$prev = $paged - 1;
		$next = $paged + 1;
		$range = 1; // only edit this if you want to show more page-links
		$showitems = ($range * 2)+1;
		
		if($pages == '') {
			global $wp_query;
			$pages = $wp_query->max_num_pages;
			if(!$pages) {
				$pages = 1;
			}
		}
		$output_page = $output_prev = $output_next = $last = $pages_of_total = '';

		$output_page .= '<input type="hidden" name="block_atts" class="block_atts" value="'.esc_attr(json_encode($this->block_atts)).'"/>';
		if( 1 != $pages ) {
			$output_page .= '<div class="nav-links pagination_with_ajax">';
			// first
			if( $paged > 2 && $paged > $range+1 && $showitems < $pages ) {
				$output_page .= '<a href="1" class="first page-numbers">' . esc_html__('First', 'slz') . '</a>';
			}
			// prev
			$output_page .= ($paged > 1 && $showitems < $pages)? '<a href="'.$prev.'" class="prev page-numbers">' . esc_html__('Previous', 'slz') . '</a>':'';
			if( $paged - $range > 2 ) {
				$output_page .= '<a href="'.$prev.'" class="page-numbers">&bull;&bull;&bull;</a>';
			}
		
			for ($i=1; $i <= $pages; $i++) {
				if (1 != $pages &&( !($i >= $paged+$showitems || $i <= $paged-$showitems) || $pages <= $showitems )) {
					$output_page .= ($paged == $i)? '<span class="page-numbers current">'.$i.'</span>':'<a href="'.$i.'" class="page-numbers" >'.$i.'</a>';
				}
			}
		
			if( $paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages ) {
				if( $paged+$showitems < $pages +1) {
					$output_page .= '<a href="'.$next.'" class="page-numbers">&bull;&bull;&bull;</a>';
				}
			}
			$output_page .= ($paged < $pages && $showitems < $pages) ? '<a href="'.$next.'" class="next page-numbers">' . esc_html__('Next', 'slz') . '</a>' :'';
			$output_page .= ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) ? '<a href="'.$pages.'" class="last page-numbers">' . esc_html__('Last', 'slz') . '</a>':'';
			$output_page .= '</div>'."\n";
		}
		$output = sprintf('<nav class="navigation pagination">%1$s</nav>', $output_page);
		return $output;
	}

	// pagination with ajax
	public function paging_next_prev( $pages = '', $range = 2, $current_query = '' ) {
		global $paged;
		if( $current_query == '' ) {
			global $paged;
			if( empty( $paged ) ) $paged = 1;
		} else {
			$paged = $current_query->query_vars['paged'];
		}
		
		$prev = $paged - 1;
		$next = $paged + 1;

		if($pages == '') {
			global $wp_query;
			$pages = $wp_query->max_num_pages;
			if(!$pages) {
				$pages = 1;
			}
		}

		$output_page = $output_prev = $output_next = $last = $pages_of_total = '';

		$output_page .= '<input type="hidden" name="block_atts" class="block_atts" value="'.esc_attr(json_encode($this->block_atts)).'"/>';
		if( 1 != $pages ) {
			$output_page .= ($paged > 1)? '<a href="'.$prev.'" class="slz-prev"><i class="fa fa-angle-left"></i><span class="text">' . esc_html__('Previous', 'slz') . '</span></a>':'<a href="'.$prev.'" class="slz-prev disable"><i class="fa fa-angle-left"></i><span class="text">' . esc_html__('Previous', 'slz') . '</span></a>';

			$output_page .= ($paged < $pages) ? '<a href="'.$next.'" class="slz-next"> <span class="text">' . esc_html__('Next', 'slz') . '</span><i class="fa fa-angle-right"></i></a>' :'<a href="'.$next.'" class="slz-next disable"> <span class="text">' . esc_html__('Next', 'slz') . '</span><i class="fa fa-angle-right"></i></a>';
		}
		$output = sprintf(' <nav class="pagination pagination_next_prev"><div class="nav-links">%1$s</div></nav>', $output_page);
		return $output;
	}

	// pagination load_page
	public function paging_next_prev_load( $pages = '', $range = 2, $current_query = '' ) {
		global $paged;

		if( $current_query == '' ) {
			global $paged;
			if( empty( $paged ) ) $paged = 1;
		} else {
			$paged = $current_query->query_vars['paged'];
		}
		
		
		$prev = $paged - 1;
		$next = $paged + 1;
		$showitems = ($range * 2)+1;
		
		if($pages == '') {
			global $wp_query;
			$pages = $wp_query->max_num_pages;
			if(!$pages) {
				$pages = 1;
			}
		}
		$method = "get_pagenum_link";
		if(is_single()) {
			$method = self::$post_page_link;
		}
		$output_page = $output_prev = $output_next = $last = $pages_of_total = '';
		if( 1 != $pages ) {
			$output_page .= ($paged > 1 && $showitems < $pages)? '<a href="'.$method($prev).'" class="btn-prev"></a>':'';
			$output_page .= ($paged < $pages && $showitems < $pages) ? '<a href="'.$method($next).'" class="btn-next"></a>' :'';
		}
		$output = sprintf('<div class="btn-change-page">%1$s</div>', $output_page);
		return $output;
	}

	public function render_category_tabs() {
		if( $this->attributes['pagination'] == 'yes' || empty( $this->attributes['category_filter'] ) || !is_plugin_active( 'js_composer/js_composer.php' ) ){
			return;
		}
		$output = '<input type="hidden" name="cat_block_atts" class="cat_block_atts" value="'.esc_attr(json_encode($this->block_atts)).'"/>';
		$output .= '<div class="tab-list-wrapper">';
		$output .= '<ul class="tab-list block_category_tabs">';
		$tabs = array();
		$slug = array();
		$all_tab = array();
		$slug_name = '';

		if($this->attributes['category_filter'] == 'category'){
			$slug_name = 'category_slug';
			$this->attributes['category_list'] = null;
			if( function_exists('vc_param_group_parse_atts') ) {
				$data = (array) vc_param_group_parse_atts($this->attributes['category_list']);
				foreach($data as $val){
					if(isset($val['category_slug'])) $slug[] = $val['category_slug'];
				}
			}
			$all_tab[$this->attributes['category_list']] = $this->attributes['category_filter_text'];
			$tabs = SLZ_Com::get_tax_options('category', array('slug'=>$slug));
		}
		else if($this->attributes['category_filter'] == 'author'){
			$slug_name = 'author';
			if( function_exists('vc_param_group_parse_atts') ) {
				$data = (array) vc_param_group_parse_atts($this->attributes['author_list']);
				foreach($data as $val){
					if(isset($val['author'])) $slug[] = $val['author'];
				}
			}
			$all_tab[$this->attributes['author_list']] = $this->attributes['category_filter_text'];
			$tabs = SLZ_Com::get_user_id2login(array('include'=>$slug));
		}
		else if($this->attributes['category_filter'] == 'tag_slug'){
			$slug_name = 'tag_slug';
			if( function_exists('vc_param_group_parse_atts') ) {
				$data = (array) vc_param_group_parse_atts($this->attributes['tag_list']);
				foreach($data as $val){
					if(isset($val['tag_slug'])) $slug[] = $val['tag_slug'];
				}
			}
			$all_tab[$this->attributes['tag_list']] = $this->attributes['category_filter_text'];
			$tabs = SLZ_Com::get_tax_options( 'post_tag', array('slug'=>$slug) );
		}
		
		if(!empty($tabs)){
			$tabs = $all_tab + $tabs;
			$count = 0;
			foreach($tabs as $k=>$v){
				$active_cls = '';
				if(is_array($this->attributes[$slug_name]) && $v == "All") $active_cls = 'class="active"';
				else if($k == $this->attributes[$slug_name]) $active_cls = 'class="active"';
				$count++;
				if($count == 5){
					$output .= '<li role="presentation" class="dropdown">
					<a href="#" role="tab" class="dropdown-toggle more" data-toggle="dropdown">More&nbsp; <i class="fa fa-angle-down"></i></a>
                                    <ul class="dropdown-menu">';
				}
				$output .= '<li '.$active_cls.'  role="presentation"><a href="'.esc_attr($k).'" role="tab" data-toggle="tab">'.esc_attr($v).'</a></li>';
			}
			if($count >= 5) $output .= '</ul></li>';
		}
		$output .= '</ul></div><div class="clearfix"></div>';
		
		return $output;
	}

	public function paging_load_more( $pages = '', $range = 2, $current_query = '' ){
		$output = '';
		if($pages == '') {
			global $wp_query;
			$pages = $wp_query->max_num_pages;
			if(!$pages) {
				$pages = 1;
			}
		}

		if( 1 != $pages ) {

			$atts = $this->block_atts;
			$output .= '<input type="hidden" name="block_atts" class="block_atts" value="' . esc_attr(json_encode($atts)) . '"/><a href="#" class="slz-btn-loadmore">' . esc_html__('load more', 'slz') . '</a>';

		}

		return $output;
	}

	public function get_pagination(){
		$output = '';
		switch ($this->attributes['pagination']) {
			case 'yes':
				$output .= '<div class="slz-pagination">' . $this->paging_nav( $this->query->max_num_pages, 2, $this->query) . '</div>';
				break;
			case 'ajax':
				$output .= '<div class="slz-pagination">' . $this->paging_ajax( $this->query->max_num_pages, 2, $this->query) . '</div>';
				break;
			case 'next-prev':
				$output .= '<div class="slz-pagination-02">' . $this->paging_next_prev( $this->query->max_num_pages, 2, $this->query) . '</div>';
				break;
			case 'load_more':
				$output .= '<div class="btn-loadmore-wrapper pagination_with_load_more">' . $this->paging_load_more( $this->query->max_num_pages, 2, $this->query) . '</div>';
				break;
			case 'next-prev-load':
				$output .= '<div class="slz-pagination" >' . $this->paging_next_prev_load( $this->query->max_num_pages, 2, $this->query) . '</div>';
				break;
			default:
				# code...
				break;
		}

		return $output;
	}

    public function get_block_title( $format = null ){

    	$out = '';

    	if( $format == null ) $format = '<div class="%s">%s</div>';

    	if( !empty( $this->attributes['block_title'] ) ) {

    		$out = sprintf( $format, esc_attr( $this->attributes['block_title_class'] ) , esc_attr( $this->attributes['block_title'] ) );

    	}

        return $out;

    }
	public function set_default_options( $html_options = array() ) {
		$defaults = array(
			'title_format1'    => '<a href="%2$s" class="media-heading">%1$s</a>',
			'category_format'  => '',
		);

		$html_options = array_merge( $defaults, $html_options );
		return $html_options;
	}

	public function reset(){
		wp_reset_postdata();
	}

    /*-------------------- >> Render Widget << -------------------------*/
	/**
	 * use for widget recent post
	 *
	 * @param array $html_options
	 * Format: 1$ - title, 2$ - date,3$ - author,4$ - feature image,5$ - view,6$ - comment
	 */
	public function render_widget( $html_options = array() ) {
		global $post;
		$this->html_format = $this->set_default_options($html_options);
		$thumb_size = 'large';
		if( $this->query->have_posts() ) {
			while ( $this->query->have_posts() ) {
				$this->query->the_post();
				$model = new SLZ_Block_Module( $post, $this->attributes );
				$post_id = get_the_ID();
				printf( $html_options['html_format'],
					$model->get_title(true,$this->html_format,''),
					$model->get_date( null, false ),
					$model->get_author(),
					$model->get_featured_image(),
					$model->get_views($this->html_format['view_format']),
					$model->get_comments($this->html_format['comment_format']),
					$model->get_category('', $this->html_format['category_format'])
				);
			}
			$this->reset();
		}
	}

	private function get_thumb_size() {
		if ( isset($this->attributes['image_size']) && is_array($this->attributes['image_size']) ) {
			$this->attributes['thumb-size'] = SLZ_Util::get_thumb_size( $this->attributes['image_size'], $this->attributes );
		}
	}
}