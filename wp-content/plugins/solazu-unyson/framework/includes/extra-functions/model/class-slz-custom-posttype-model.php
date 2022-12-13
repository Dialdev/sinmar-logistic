<?php
require_once slz_get_framework_directory('/helpers') . '/class-slz-image.php';

class SLZ_Custom_Posttype_Model {
	public $post_id;
	public $cur_post;
	public $permalink;
	public $taxonomy_cat;
	public $attributes;
	public $post_view_key;
	public $query;
	public $post_count;
	public $post_meta_atts;
	public $post_meta;
	public $post_meta_label;
	public $post_meta_def;
	public $slz_metakey_prefix = 'slz_option:';
	public $post_password;
	public $html_format = array();
	public $meta_key_compare;

	public $title;
	public $title_attribute;
	public $has_thumbnail;
	public $uniq_id;
	public $sort_meta_key;
	
	public function get_single_post( $post_id ) {
		global $post;
		if( ! empty( $post_id ) ) {
			$post = get_post( $post_id );
		}
		$this->loop_index( $post );
	}
	public function get_custom_post( $post_id ) {
		if( ! empty( $post_id ) ) {
			$post = get_post( $post_id );
			if( $post ) {
				$this->loop_index( $post, false );
			}
		}
	}

	/**
	 * Get post meta slz by meta key
	 *
	 * @param $meta_key example: general+key_name / key_name
	 *
	 * @return string
	 */
	public function get_slz_options( $meta_key ) {
		if ( isset($meta_key) ) {
			if ( strpos($meta_key, '/') !== false ) {
				
				$meta_key = str_replace('//', '/', $meta_key);
				$meta_key_gr = explode('/', $meta_key);
				if ( is_array($meta_key_gr) ) {
					$get_meta = slz_get_db_post_option( $this->post_id, $meta_key_gr[0] );
					return ( ( isset( $get_meta[$meta_key_gr[1]] ) and false === empty( $get_meta[$meta_key_gr[1]] ) ) ? $get_meta[$meta_key_gr[1]] : '' );
				}
			} else {

				return slz_get_db_post_option( $this->post_id, $meta_key );
			}
		}
	}

	/**
	 * Setting current post.
	 * 
	 * @param string $cur_post
	 */
	public function loop_index( $current_post = '' ) {
		global $post;
		if( ! empty( $current_post ) ) {
			$post = $current_post;
		}
	
		$this->post_id = $post->ID;
		$this->cur_post = $post;
	
		$this->title = get_the_title( $post->ID );
		$this->title_attribute = esc_attr( strip_tags( $this->title ) );
		$this->permalink = esc_url( get_permalink( $post->ID ) );
	
		if ( has_post_thumbnail( $post->ID ) ) {
			$this->has_thumbnail = true;
		} else {
			$this->has_thumbnail = false;
		}
		$this->post_password = post_password_required( $post );
		// set post meta
		$meta_data = array();
		if( $this->post_meta_def ) {
			foreach( $this->post_meta_def as $key => $val ) {
				$meta_key = $key;
				$meta_data[$key] = $this->get_slz_options($meta_key);
			}
		}
		$this->post_meta = $meta_data;
	}
	/**
	 * Get post query.
	 * 
	 * @param array $args   Optional. Query arguments.
	 * @param array $data
	 * @return WP_Query
	 */
	public function get_query( $args = array(), $data = array() ) {
		$is_paging = false;
		$defaults = array(
			'post_status'    =>'publish',
			'posts_per_page' => -1,
		);
		$query_args = array_merge( $defaults, $args );
		//post slug
		if( isset( $data['post_slug'] ) && !empty( $data['post_slug'] ) ) {
			if( is_array( $data['post_slug'] ) ) {
				$post_in_arr = array();
				foreach( $data['post_slug'] as $slug ) {
					$post_in_id = $this->get_custom_post_id_by_slug( $query_args['post_type'], $slug );
					if( $post_in_id ) {
						$post_in_arr[] = $post_in_id;
					}
				}
				if( $post_in_arr ) {
					$query_args['post__in'] = $post_in_arr;
				}
			} else {
				$query_args['name'] = $data['post_slug'];
			}
		}
		// post id
		if( isset( $data['post_id'] ) && !empty( $data['post_id'] ) ) {
			if( is_array( $data['post_id'] ) ) {
				$query_args['post__in'] = $data['post_id'];
				if ( isset($data['post__not_in']) ) {
					$query_args['post__not_in'] = array($data['post__not_in']);
					foreach ($query_args['post__not_in']  as $key => $value) {
						$key_unset = array_search($value, $query_args['post__in']);
						if(($key_unset !== false)) {
					    	unset($query_args['post__in'][$key_unset]);
						}
					}
				}
			}
		}
		// limit post
		$posts_per_page = get_option('posts_per_page');
		if( isset($data['limit_post']) ) {
			if ( empty($data['limit_post'] ) ) {
				$data['limit_post'] = $posts_per_page;
			}
			if( isset( $data['cur_limit'] ) &&  $data['cur_limit'] ) {
				$data['limit_post'] = $data['cur_limit'];
			}
			$query_args['posts_per_page'] = $data['limit_post'];
		}
		//paged
		if( isset($data['paged']) && $data['paged'] ) {
			$paged = $data['paged'];
		} else {
			$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
		}
		// Offset start: 0
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
					$offset = $offset + ( ($paged - 1) * $data['limit_post']) ;
				}
			}
		}
		$query_args['offset'] = $offset ;
		$author_data = SLZ_Com::get_value( $data, 'author', 0 );
		if( is_array( $author_data ) ) {
			$query_args['author__in'] = $author_data;
		}
		else {
			$query_args['author'] = $author_data;
		}

		// category or taxonomy
		$this->parse_tax_query( $query_args, $data );
		//search by meta
		if(!empty($this->meta_key_compare)){
			$this->parse_meta_key( $query_args, $data ,$this->meta_key_compare );
		}else{
			$this->parse_meta_key( $query_args, $data );
		}
	
		// sort by
		$this->parse_order_by( $query_args, $data );

		if( $is_paging && !empty($this->attributes['max_post']) && $this->attributes['max_post'] > 0 ) {
			$max_num_pages = ceil( $this->attributes['max_post'] / $query_args['posts_per_page']);
			if ( $this->attributes['max_post'] < $query_args['posts_per_page'] ) {
				$query_args['posts_per_page'] = $this->attributes['max_post'];
			}
			// go to first page when paged larger paged after apply max_post
			if ($query_args['paged'] > $max_num_pages) {
				$query_args['offset'] = $data['offset_post'];
				$query_args['paged'] = 1;
			}
		}

		$query = new WP_Query( $query_args );
		if( $is_paging ) {
			$start_offset = !empty($this->attributes['offset_post']) && $this->attributes['offset_post'] > 0 ? $this->attributes['offset_post'] : 0;
			$query->found_posts = $this->recalc_found_posts($query, $start_offset );
			if (!empty($this->attributes['max_post']) && $this->attributes['max_post'] < $query->found_posts ) {
				$query->found_posts = $this->attributes['max_post'];
			}
			$query->max_num_pages = ceil( $query->found_posts / $query_args['posts_per_page']);
			if( $query_args['posts_per_page'] < 0 ){
				// limit_post = -1
				$query->max_num_pages  = 1;
			}
		}
// 		slz_print($query);
		return $query;

	}
	private function parse_order_by( &$query_args, $data ) {
		// sort by
		if( isset( $data['order_by'] ) && ! empty( $data['order_by'] ) ) {
			$args['orderby'] = $data['order_by'];
			$args['order'] = $data['order'];
		}
		$sort_by = SLZ_Com::get_value( $data, 'sort_by' );
		switch ( $sort_by ) {
			case 'az_order':
				$query_args['orderby'] = 'title';
				$query_args['order'] = 'ASC';
				break;
			case 'za_order':
				$query_args['orderby'] = 'title';
				$query_args['order'] = 'DESC';
				break;
			case 'popular':
				$query_args['meta_key'] = $this->post_view_key;
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
			case 'post__in':
				$query_args['orderby'] = 'post__in';
				$query_args['order'] = 'ASC';
				break;
			case 'az_rating':
				if( isset($this->sort_meta_key['rating']) ) {
					$query_args['orderby'] = array( 'meta_value_num' => 'ASC', 'date' => 'DESC' );
					$query_args['meta_key'] = $this->sort_meta_key['rating'];
				}
				break;
			case 'za_rating':
				if( isset($this->sort_meta_key['rating']) ) {
					$query_args['orderby'] = array( 'meta_value_num' => 'DESC', 'date' => 'DESC' );
					$query_args['meta_key'] = $this->sort_meta_key['rating'];
				}
				break;
			default:
		}
	}
	private function parse_tax_query( &$query_args, $data ) {
		$tax_query = array();
		if( isset($data['category_slug']) && !empty( $data['category_slug'] ) ) {
			$tax_query[] = array(
				'taxonomy' => $this->taxonomy_cat,
				'field'    => 'slug',
				'terms'    => $data['category_slug'],
				'include_children' => 0,
			);
		}
		if( isset($data['location_slug']) && !empty( $data['location_slug'] ) ) {
			$tax_query[] = array(
				'taxonomy' => $this->taxonomy_location,
				'field'    => 'slug',
				'terms'    => $data['location_slug'],
				'include_children' => 0,
			);
		}
		if( isset($data['taxonomy_not_in']) && !empty( $data['taxonomy_not_in'] ) ) {
			$tax_query[] = array(
				'taxonomy'  => $this->taxonomy_cat,
				'field'     => 'term_id',
				'terms'    => $data['taxonomy_not_in'],
				'operator' => 'NOT IN',
			);
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
						if( $taxonomy_name == 'slz_property_amenity' && is_array( $slug_val ) ) {
							$taxonomy_args['operator'] = 'AND';
						}
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
	private function parse_meta_key( &$query_args, $data ,$compare='' ){
		$meta_query = array();
		if(empty($compare)){
			$compare = '=';
		}
		if( isset($data['meta_key']) && !empty( $data['meta_key'] ) ) {
			$meta_key_arr = $data['meta_key'];
			if( is_array($meta_key_arr) ) {
				//multi key
				foreach( $meta_key_arr as $key => $val ) {
					$meta_query[] = array(
						'key'     => $key,
						'value'   => $val,
						'compare' => $compare,
					);
				}
			} else {
				//single key
				$meta_query[] = array(
					'key'     => $data['meta_key'],
					'value'   => $data['meta_value'],
					'compare' => $compare,
				);
			}
		}
		if( isset($data['meta_key_compare']) && !empty( $data['meta_key_compare'] ) ) {
			$meta_key_arr = $data['meta_key_compare'];
			foreach( $meta_key_arr as $value ) {
				$meta_query[] = $value;
			}
		}
		if( isset($data['date_query']) && !empty( $data['date_query'] ) ) {
			$meta_key_arr = $data['date_query'];
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
	public function get_taxonomy_params( $post_type, $post_taxonomy, $atts ) {
		$taxonomy_arr = array();
		foreach( $post_taxonomy as $key ) {
			$taxonomy = $post_type . '_' . $key;
			$tax_slug = $key . '_slug';
			if( isset( $atts[$tax_slug] ) && !empty( $atts[$tax_slug] ) ) {
				if( is_array($atts[$tax_slug])) {
					$atts[$tax_slug] = array_filter($atts[$tax_slug]);
				}
				$taxonomy_arr[$taxonomy] = $atts[$tax_slug];
				
			}
		}
		return $taxonomy_arr;
	}
	/**
	 * Get the title.
	 * 
	 * @param array $html_options   title_format: 1$ - title, 2$ - permalink.
	 * @param string $echo          Default "false"
	 * @return string
	 */
	public function get_title( $html_options = array(), $echo = false ) {
		if( empty($html_options) ) {
			$html_options = $this->html_format;
		}
		$format = '%1$s';
		if( isset( $html_options['title_format'] ) ) {
			$format = $html_options['title_format'];
		}
		$output = sprintf( $format, esc_attr( $this->title ), esc_url( $this->permalink ) );
		if( $echo ) {
			echo wp_kses_post( $output );
		} else {
			return $output;
		}
	}
	/**
	 * Get featured image.
	 * 
	 * @param array $html_options   image_format: 1$ - img, 2$ - url, 3$ - thumb_href_class
	 * @param string $thumb_type    Type "large" or "small". Default "large"
	 * @param string $echo          Default "false"
	 * @return string
	 */
	public function get_featured_image( $html_options = array(), $thumb_type = 'large', $echo = false , $has_image = true ) {
		if ( !empty($this->attributes['show_thumbnail']) && $this->attributes['show_thumbnail'] != 'yes' ) {
			return '';
		}
		if( empty($html_options) ) {
			$html_options = $this->html_format;
		}
		
		$output = $thumb_img = '';
		$format = '%1$s';
		if( isset( $html_options['image_format'] ) ) {
			$format = $html_options['image_format'];
		}

		$href_class = SLZ_Com::get_value( $html_options, 'thumb_href_class' );
		$thumb_class = SLZ_Com::get_value( $html_options, 'thumb_class', 'img-responsive' );

		$attrArr = array( 'class' => $thumb_class );
		if( empty( $this->attributes['thumb-size'] ) ) {
			$this->attributes['thumb-size'] = array(
				'large'          => 'post-thumbnail',
				'small'          => 'post-thumbnail',
			);
		}
		$thumb_size = $this->attributes['thumb-size'][$thumb_type];
		if( empty($thumb_size)) {
			$thumb_size = 'post-thumbnail';
			
		}
		if( $this->has_thumbnail ) {
			$thumb_id = get_post_thumbnail_id( $this->post_id );
			// regenerate if not exist.
			$helper = new SLZ_Image();
			$helper->regenerate_attachment_sizes($thumb_id, $thumb_size);
			$thumb_img = wp_get_attachment_image( $thumb_id, $thumb_size, false, $attrArr );
		}
		if( empty($thumb_img) && $has_image ){
			$thumb_img = SLZ_Util::get_no_image( $this->attributes['thumb-size'], $this->cur_post, $thumb_type, $html_options );
		}

		if( $thumb_img ) {
			//1: img, 2: url, 3: url class
			$output = sprintf( $format, $thumb_img, $this->permalink, $href_class );
			if( $echo ) {
				echo wp_kses_post( $output );
			} else {
				return $output;
			}
		}
	}
	public function get_thumbnail( $html_options = array(), $thumb_type = 'large', $echo = false, $has_image = true ) {
		if ( !empty($this->attributes['show_thumbnail_meta']) && $this->attributes['show_thumbnail_meta'] != 'yes' ) {
			return '';
		}
		if( empty($html_options) ) {
			$html_options = $this->html_format;
		}
		$output = $thumb_img = '';
		$format = '%1$s';
		if( isset( $html_options['thumbnail_format'] ) ) {
			$format = $html_options['thumbnail_format'];
		}
		
		$href_class = SLZ_Com::get_value( $html_options, 'thumb_href_class' );
		$thumb_class = SLZ_Com::get_value( $html_options, 'thumb_class', 'img-responsive' );
		
		$attrArr = array( 'class' => $thumb_class );
		if( empty( $this->attributes['thumb-size'] ) ) {
			$this->attributes['thumb-size'] = array(
				'large'          => 'post-thumbnail',
				'small'          => 'post-thumbnail',
			);
		}
		$thumb_size = $this->attributes['thumb-size'][$thumb_type];
		$thumb_id = $this->post_meta['thumbnail'];
		if( is_array($this->post_meta['thumbnail']) && isset($this->post_meta['thumbnail']['attachment_id']) ) {
			$thumb_id = $this->post_meta['thumbnail']['attachment_id'];
		}
		if( $thumb_id ) {
			// regenerate if not exist.
			$helper = new SLZ_Image();
			$helper->regenerate_attachment_sizes($thumb_id, $thumb_size);
			$thumb_img = wp_get_attachment_image( $thumb_id, $thumb_size, false, $attrArr );
		}
		if( empty($thumb_img) && $has_image ) {
			$thumb_img = SLZ_Util::get_no_image( $this->attributes['thumb-size'], $this->cur_post, $thumb_type );
		}
		if( $thumb_img ) {
			//1: img, 2: url, 3: url class
			$output = sprintf( $format, $thumb_img, $this->permalink, $href_class );
			if( $echo ) {
				echo wp_kses_post( $output );
			} else {
				return $output;
			}
		}
	}
	public function get_image_url_by_id( $thumb_id = null, $thumb_type = 'large', $has_image = true ) {
		$output = $img_url = '';

		if( empty($thumb_id) && $this->has_thumbnail && $this->post_id ) {
			$thumb_id = get_post_thumbnail_id( $this->post_id );
		}
		if( $thumb_id ) {
			if( empty( $this->attributes['thumb-size'] ) ) {
				$this->attributes['thumb-size'] = array(
					'large'          => 'post-thumbnail',
					'small'          => 'post-thumbnail',
				);
			}
			$thumb_size = $this->attributes['thumb-size'][$thumb_type];
			// regenerate if not exist.
			$helper = new SLZ_Image();
			$helper->regenerate_attachment_sizes($thumb_id, $thumb_size);
			$img_url = wp_get_attachment_image_url( $thumb_id, $thumb_size );
		}
		if( empty($img_url) && $has_image ) {
			$img_url = slz_get_framework_directory_uri('/static/img/no-image/thumb.png');
		}
		return $img_url;
	}
	/**
	 * Get the excerpt
	 * 
	 * @param array $html_options   excerpt_format: 1$ - excerpt.
	 * @param string $echo          Default "false"
	 * @return string
	 */
	public function get_excerpt( $html_options = array(), $echo = false ) {
		if( empty($html_options) ) {
			$html_options = $this->html_format;
		}
		$format = '%1$s';
		if( isset( $html_options['excerpt_format'] ) ) {
			$format = $html_options['excerpt_format'];
		}
		$excerpt = get_the_excerpt();
		if(!empty($this->attributes['excerpt_length'])){
			$limit = $this->attributes['excerpt_length'];
			if(!empty($limit)){
				$excerpt = wp_trim_words($excerpt, $limit, ' [...]');
			}
		}
		$output = sprintf( $format, $excerpt );
		if( isset( $html_options['extend_desc'])) {
			$output = $output . $html_options['extend_desc'];
		}
		if( !$echo ) {
			return $output;
		}
		echo wp_kses_post($output);
	}
	public function get_content( $html_options = array(), $echo = false ){
		if( empty($html_options) ) {
			$html_options = $this->html_format;
		}
		$format = '%1$s';
		if( isset( $html_options['content_format'] ) ) {
			$format = $html_options['content_format'];
		}
		$more_link_format = '<a href="%s"><button class="btn btn-green"><span>%s</span></button></a>';
		if( isset( $html_options['content_more_link_format'] ) ) {
			$more_link_format = $html_options['content_more_link_format'];
		}
		$more_link_text = SLZ_Com::get_value( $html_options, 'content_more_link_text', esc_html__('Read more', 'slz') );
		$more_link_text = sprintf( $more_link_format, $this->permalink, $more_link_text );
		$content = apply_filters('the_content', get_the_content( $more_link_text ));

		$output = sprintf( $format, $content );
		if( $echo ) {
			echo wp_kses_post( $output );
		} else {
			return $output;
		}
	}
	/**
	 * Get post date
	 * 
	 * @param array $html_options   date_format: 1$ - date, 2$ - permalink.
	 * @param string $echo          Default "false"
	 * @return string
	 */
	public function get_date( $html_options = array(), $echo = false ) {
		if( ! $this->is_show( $this->attributes, 'show_date') ) {
			return '';
		}
		if( empty($html_options) ) {
			$html_options = $this->html_format;
		}
		$format = '%1$s';
		if( isset( $html_options['date_format'] ) ) {
			$format = $html_options['date_format'];
		}

		$date = get_the_date(); // Default: Wordpress date_format

		$output = sprintf( $format, esc_attr( $date ), $this->permalink );
		if( $echo ) {
			echo wp_kses_post( $output );
		} else {
			return $output;
		}
	}
	/**
	 * Get the author
	 * 
	 * @param array $html_options   author_format: 1$ - author, 2$ - author href.
	 * @param string $echo          Default "false"
	 * @return string
	 */
	public function get_author( $html_options = array(), $echo = false ){
		if( ! $this->is_show( $this->attributes, 'show_author') ) {
			return '';
		}
		if( empty($html_options) ) {
			$html_options = $this->html_format;
		}
		//show
		$format = '%1$s';
		if( isset( $html_options['author_format'] ) ) {
			$format = $html_options['author_format'];
		}

		$post_author = $this->cur_post->post_author;
		$url = get_author_posts_url( $post_author );
		$author = get_the_author_meta('display_name', $post_author );

		$output = sprintf( $format, esc_html( $author ), esc_url( $url ) );
		if( $echo ) {
			echo wp_kses_post( $output );
		} else {
			return $output;
		}
	}
	/**
	 * Get post view counts
	 * 
	 * @param array $html_options   Format: 1$ - view counts, 2$ - permalink.
	 * @param string $echo          Default "false"
	 * @return string
	 */
	public function get_views( $html_options = array(), $echo = false ) {
		if( ! $this->is_show( $this->attributes, 'show_views') ) {
			return '';
		}
		if( empty($html_options) ) {
			$html_options = $this->html_format;
		}
		$format = '%1$s';
		if( isset( $html_options['view_format'] ) ) {
			$format = $html_options['view_format'];
		}

		$output = sprintf( $format, $this->get_post_view(), $this->permalink );
		if( $echo ) {
			echo wp_kses_post( $output );
		} else {
			return $output;
		}
	}
	/**
	 * Get post comment counts
	 * 
	 * @param array $html_options Format: 1$ - comment counts, 2$ - comment link.
	 * @param string $echo
	 * @return string
	 */
	public function get_comments( $html_options = array(), $echo = false ) {
		if( ! $this->is_show( $this->attributes, 'show_comments') ) {
			return '';
		}
		if( empty($html_options) ) {
			$html_options = $this->html_format;
		}
		$output = '';
		$format = '%1$s';
		if( isset( $html_options['comment_format'] ) ) {
			$format = $html_options['comment_format'];
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			$output = sprintf( $format, get_comments_number(), get_comments_link( $this->post_id ) );
		}
		if( $echo ) {
			echo wp_kses_post( $output );
		} else {
			return $output;
		}
	}
	/**
	 * Get more button
	 * 
	 * @param array $html_options Format: 1$ - button content, 2$ - link.
	 * @param string $echo
	 * @return string
	 */
	public function get_btn_more( $html_options = array(), $echo = false ) {
		$btn_content = SLZ_Com::get_value( $this->attributes, 'btn_content', esc_html__('Read More', 'slz') );

		if( empty($html_options) ) {
			$html_options = $this->html_format;
		}
		$format = '<a href="%2$s">%1$s</a>';
		if( isset( $html_options['btn_more_format'] ) ) {
			$format = $html_options['btn_more_format'];
		}

		if( $echo ) {
			printf( $format, esc_html( $btn_content ), $this->permalink );
		} else {
			return sprintf( $format, esc_html( $btn_content ), $this->permalink );
		}
	}
	public function get_full_post_class( $class = '', $post_id = '' ) {
		if( empty( $post_id ) ) {
			$post_id = $this->post_id;
		}
		return join( ' ', get_post_class( $class, $post_id ) );
	}
	public function get_post_class( $class = '', $post_id = '' ) {
		if( empty( $post_id ) ) {
			$post_id = $this->post_id;
		}
		if ( $class ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}
			$classes = array_map( 'esc_attr', $class );
		}
		$classes[] = 'post-' . $post_id;
		$classes[] = get_post_type( $post_id );
		return join( ' ', $classes );
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
	public function get_taxonomy_list( $taxonomy = '', $format = '', $sep = ', ' ) {
		if( empty( $taxonomy ) ) {
			$taxonomy = $this->taxonomy_cat;
		}
		if( empty($format) ) {
			$format = '%1$s';
		}
		$result = array();
		$terms = get_the_terms( $this->post_id, $taxonomy );
		if ($terms && ! is_wp_error($terms)) {
			foreach( $terms as $item ){
				$item = (array)$item;
				$result[] = sprintf( $format, esc_html($item['name']), esc_url(get_term_link($item['term_id'])), esc_attr($item['slug']) );
			}
		}
		if( $result ) {
			return implode($sep, $result);
		}
		return '';
	}
	public function get_current_taxonomy( $taxonomy = '' ) {
		if( empty( $taxonomy ) ) {
			$taxonomy = $this->taxonomy_cat;
		}
		$result = array();
		$terms = get_the_terms( $this->post_id, $taxonomy );
		if ($terms && ! is_wp_error($terms)) {
			$result = current( $terms );
		}
		return (array)$result;
	}
	public function get_taxonomy_slug( $taxonomy = '', $seperate = ' ' ) {
		if( empty( $taxonomy ) ) {
			$taxonomy = $this->taxonomy_cat;
		}
		$result = array();
		$terms = get_the_terms( $this->post_id, $taxonomy );
		if ($terms && ! is_wp_error($terms)) {
			foreach( $terms as $term ) {
				$result[] = $term->slug;
			}
		}
		$result = implode( $seperate, $result );
		return $result;
	}
	public function is_video() {
		return get_post_format() === 'video';
	}
	public function is_audio() {
		return get_post_format() === 'audio';
	}
	public function is_show( $atts, $fields ) {
		if( !isset( $atts[$fields] ) || ( isset( $atts[$fields] ) && $atts[$fields] != 'no' ) ) {
			return true;
		}
		return false;
	}
	
	public function recalc_found_posts($query, $offset) {
		$found_posts = $query->found_posts;
		if( $offset ) {
			return $found_posts - $offset;
		}
		return $found_posts;
	}
	public function get_custom_post_id_by_slug( $post_type, $slug ) {
		$id = '';
		if( !empty( $slug ) ) {
			$slug_args = array(
				'post_status' => 'publish',
				'post_type'   => $post_type,
				'name'        => $slug,
				'suppress_filters' => false,
			);
			$p = get_posts($slug_args);
			if( $p ) {
				$id = $p[0]->ID;
			}
		}
		return $id;
	}
	public function parse_list_to_array( $name, $listIDs = array() ) {
		$res = array();
		if( !empty( $listIDs) ){
			foreach($listIDs as $value){
				if(!empty($value)){
					$res[] = $value[$name];
				}
			}
		}
		return $res;
	}
	public function parse_cat_slug_to_post_id( $taxonomy, $slug, $post_type ) {
		$id = array();
		if( !empty( $slug ) ) {
			$args = array(
				'post_type'         => $post_type,
				'post_status'       => 'publish',
				'posts_per_page'    => -1,
				'suppress_filters'  => false,
				$taxonomy           => $slug,
			);
			$posts = get_posts($args);
			if( $posts ) {
				foreach( $posts as $val){
					$id[] = $val->ID;
				}
			}
		}
		return $id;
	}

	
	public static function get_atts_option_slick_slide ( $atts = array(), $options = array() ) {
		$attrSlickArr = array();
		$slick_json = '';

		if ( !empty($atts['slide_autoplay']) && $atts['slide_autoplay'] == 'yes' ) {
			$attrSlickArr['autoplay'] = true;
		}

		$attrSlickArr['dots'] = true;
		if ( !empty($atts['slide_dots']) && $atts['slide_dots'] != 'yes' ) {
			$attrSlickArr['dots'] = false;
		}

		$attrSlickArr['arrows'] = false;
		if ( !empty($atts['slide_arrows']) && $atts['slide_arrows'] == 'yes' ) {
			$attrSlickArr['arrows'] = true;
		}

		$attrSlickArr['infinite'] = true;
		if ( !empty($atts['slide_infinite']) && $atts['slide_infinite'] != 'yes' ) {
			$attrSlickArr['infinite'] = false;
		}

		if ( !empty( $atts['slide_speed']) ) {
			$slide_speed = absint( $atts['slide_speed'] );
			$attrSlickArr['speed'] = !empty($slide_speed) ? $slide_speed : 600;
		}

		if ( !empty( $atts['column'] ) || !empty( $atts['slide_to_show']) ) {
			$slidesToShow = absint( $atts['column'] );
			if( !empty( $atts['slide_to_show']) ) {
				$slidesToShow = absint( $atts['slide_to_show'] );
			}
			$attrSlickArr['slidesToShow'] = $slidesToShow;
			$attrSlickArr['slidesToScroll'] = $slidesToShow;

			$responsive = array();

			switch ($slidesToShow)
			{
				case 1:
					$responsive = array(
						array(
							'breakpoint'	=> 481,
							'settings'		=> array(
								'slidesToShow'		=> 1,
								'slidesToScroll'	=> 1,
								'dots'				=> true
								)
							)
						);
					break;
				case 2:
					$responsive = array(
						array(
							'breakpoint'	=> 481,
							'settings'		=> array(
								'slidesToShow'		=> 1,
								'slidesToScroll'	=> 1,
								'dots'				=> true
							)
						)
					);
					break;
				case 3:
					$responsive = array(
						array(
							'breakpoint'	=> 769,
							'settings'		=> array(
								'slidesToShow'		=> 2,
								'slidesToScroll'	=> 2
							)
						),
						array(
							'breakpoint'	=> 481,
							'settings'		=> array(
								'slidesToShow'		=> 1,
								'slidesToScroll'	=> 1,
								'dots'				=> true
							)
						)
					);
					break;
				case 4:
					$responsive = array(
						array(
							'breakpoint'	=> 1025,
							'settings'		=> array(
								'slidesToShow'		=> 3,
								'slidesToScroll'	=> 3
							)
						),
						array(
							'breakpoint'	=> 769,
							'settings'		=> array(
								'slidesToShow'		=> 2,
								'slidesToScroll'	=> 2
							)
						),
						array(
							'breakpoint'	=> 481,
							'settings'		=> array(
								'slidesToShow'		=> 1,
								'slidesToScroll'	=> 1,
								'dots'				=> true
							)
						)
					);
					break;
				default:
					$responsive = array(
						array(
							'breakpoint'	=> 1025,
							'settings'		=> array(
								'slidesToShow'		=> 3,
								'slidesToScroll'	=> 3
							)
						),
						array(
							'breakpoint'	=> 769,
							'settings'		=> array(
								'slidesToShow'		=> 2,
								'slidesToScroll'	=> 2
							)
						),
						array(
							'breakpoint'	=> 481,
							'settings'		=> array(
								'slidesToShow'		=> 1,
								'slidesToScroll'	=> 1,
								'dots'				=> true
							)
						)
					);
					break;
			}
			$attrSlickArr['responsive'] = $responsive;
		}
		$attrSlickArr['prevArrow'] = '<button class="btn btn-prev"><i class="icons fa"></i><span class="text">Previous</span></button>';
		$attrSlickArr['nextArrow'] = '<button class="btn btn-next"><span class="text">Next</span> <i class="icons fa"></i></button>';
		$attrSlickArr['centerMode'] = true;
		if ( !empty($attrSlickArr) && is_array($attrSlickArr) ) {
			$slick_json = json_encode($attrSlickArr);
		}
		return $slick_json;
	}

	public function render_category_tabs( $custom_html = false, $addition_arr = array( 'first' => '', 'last' => '', ) ) {
		if( $this->attributes['pagination'] == 'yes' || empty( $this->attributes['category_filter'] ) || !is_plugin_active( 'js_composer/js_composer.php' ) ){
			return;
		}
		$output = '<input type="hidden" name="cat_block_atts" class="cat_block_atts" value="'.esc_attr(json_encode($this->attributes)).'"/>';
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
			$tabs = SLZ_Com::get_tax_options($this->taxonomy_cat, array('slug'=>$slug));
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
			$append_html = array(
				'first' => '',
				'last'  => '',
			);
			if( $custom_html ) {
                $append_html = $addition_arr;
            }
			foreach($tabs as $k=>$v){
				$active_cls = '';
				if(is_array($this->attributes[$slug_name]) && empty($k)) $active_cls = 'class="active"';
				else if($k == $this->attributes[$slug_name]) $active_cls = 'class="active"';
				$count++;
				if($count == 5){
					$output .= '
                        <li role="presentation" class="dropdown">
					        <a href="#" role="tab" class="dropdown-toggle more link" data-toggle="dropdown">'
                                .wp_kses_post( $append_html['first'] )
                                .esc_html__( 'More', 'slz' ).'&nbsp; <i class="fa fa-angle-down"></i>
                                '. wp_kses_post( $append_html['last'] ) .'
					        </a>
                                    <ul class="dropdown-menu">';
				}
				$output .= '
				    <li '.$active_cls.'  role="presentation">
				        <a href="'.esc_attr($k).'" class="link" role="tab" data-toggle="tab">'
                            .wp_kses_post( $append_html['first'] )
                            .esc_attr($v)
                            .wp_kses_post( $append_html['last'] ).
                        '</a>
                    </li>';
			}
			if($count >= 5) $output .= '</ul></li>';
		}
		$output .= '</ul></div><div class="clearfix"></div>';
		
		return $output;
	}
	public function get_uniq_id(){
		if( empty($this->uniq_id)) {
			$this->uniq_id = SLZ_Com::make_id();
		}
		return $this->uniq_id;
	}
	public function set_uniq_id( $val = null ){
		if( empty($val) ) {
			$val = SLZ_Com::make_id();
		}
		$this->uniq_id = $val;
	}
}