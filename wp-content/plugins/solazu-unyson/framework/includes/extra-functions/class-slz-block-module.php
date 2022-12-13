<?php
class SLZ_Block_Module {

	public $post;
	public $title;
	public $attributes = array();
	public $post_id;
	public $permalink;
	public $attributes_format = array();
	public $post_type;

	/**
	 * @param $post WP_Post
	 * @throws ErrorException
	 */
	function __construct($post, $attributes) {

		if (gettype($post) != 'object' or get_class($post) != 'WP_Post') {

			return;

		}

		$this->attributes = $attributes;

		$this->post = $post;

		$this->post_id = $post->ID;

		$this->permalink = esc_url( $this->get_post_url( $post->ID ) );

		$this->set_attributes_format();

		$this->post_type = $post->post_type;

	}
	
	public function set_attributes_format( $format_setting = array() ) {
		
		if( empty( $format_setting ) ) {
			$format_setting = slz()->theme->get_config('post_format_setting', array());
		}
		
		$this->attributes_format = $format_setting;
	}

	/**
	 * Get post author.
	 * 
	 * @return string
	 */
	public function get_author( $format = null ) {

		$out = '';

		if( empty( $this->attributes['show_author'] ) || $this->attributes['show_author'] != 'hide' ) {

			if( $format == null && isset( $this->attributes_format['author'] ) ) {
				$format = $this->attributes_format['author'];
			}

			if($format == null) $format = '<a href="%1$s" class="link"><span class="author-label">%3$s</span><span class="author-text">%2$s</span></a>';

			$url = get_author_posts_url( $this->post->post_author );

			$out = sprintf( $format,

					esc_url( $url ),

					esc_html( get_the_author_meta('display_name', $this->post->post_author) ),
					esc_html__('By ', 'slz')

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
	public function get_date( $format = null, $check_type = true ) {

		$out = $date_type = '';
		if( $format == null && isset( $this->attributes_format['date'] ) ) {
			$format = $this->attributes_format['date'];
		}

		if( $format == null ) $format = '<a href="%1$s" class="link date">%2$s</a>';

		if( empty( $this->attributes['show_date'] ) || $this->attributes['show_date'] != 'hide' ) {
			if( $check_type ) {
				$date_type = slz_get_db_settings_option('blog-post-date-type', '');
			}
			if( $date_type != 'ribbon' || !$this->has_post_thumbnail() ) {
				$date_format = '';
				if(isset( $this->attributes_format['date_format'])){
					$date_format = $this->attributes_format['date_format'];
				}
				$date = get_the_date( $date_format, $this->post );
				$out = sprintf( $format, $this->permalink, esc_html( $date ) );
			}
		}

		return $out;

	}
	public function get_ribbon_date( $format = null ) {
	
		$out = '';
		$args = array();

		if( empty( $this->attributes['show_date'] ) || $this->attributes['show_date'] != 'hide' ) {

			if( slz_ext('templates') ) {
				$args['format'] = $format;
				slz_ext('templates')->get_template( 'ribbon_format' )->render( $this ,true, $args );
			}else{
				if( $format == null ) $format = '<div class="block-label">
											<div class="text big">%2$s</div>
											<div class="text"><span>%3$s</span><span>%4$s</span></div>
											<a href="%1$s" class="link-label"></a>
										</div>';
				
				if( empty( $this->attributes['show_date'] ) || $this->attributes['show_date'] != 'hide' ) {
					$date_type = slz_get_db_settings_option('blog-post-date-type', '');
					if( $date_type == 'ribbon' ) {
						$default = array(
							'day'   => esc_html_x('d','daily posts date format', 'slz'),
							'month' => esc_html_x('M','daily posts date format', 'slz'),
							'year'  => esc_html_x('Y','daily posts date format', 'slz'),
						);
						$date_format = array_merge( $default, slz()->theme->get_config('ribbon_date_format', array()) );
						$day    = get_the_date($date_format['day'], $this->post);
						$month  = get_the_date($date_format['month'], $this->post);
						$year   = get_the_date($date_format['year'], $this->post);
				
						$out = sprintf( $format, $this->permalink, esc_html( $day ), esc_html( $month ), esc_html( $year ) );
					}
				
				}
				
				return $out;
			}
		}
	}

	/**
	 * Get post comment number.
	 * 
	 * @param string $echo - false(default)
	 * @return string
	 */
	public function get_comments( $format = null ) {

		$out = '';

		if( $format == null && isset( $this->attributes_format['comment'] ) ) {
			$format = $this->attributes_format['comment'];
		}

		if( $format == null ) $format = '<a href="%1$s" class="link comment">%2$s %3$s</a>';

		if( empty( $this->attributes['show_comments'] ) || $this->attributes['show_comments'] != 'hide' ) {

			$comment_number = number_format_i18n( get_comments_number( $this->post_id ) );
			$text = sprintf( _nx( '%1$s', '%2$s', $comment_number, 'comments title', 'slz' ),
								esc_html__('Comment', 'slz'),
								esc_html__('Comments', 'slz')
					);
			if( $comment_number ) {
				$out = sprintf( $format, get_comments_link( $this->post_id ), $comment_number, $text );
			}
		}

		return $out;

	}

	/**
	 * Get post views
	 * 
	 * @return string
	 */
	public function get_views( $format = null ) {

		$out = '';

		if( $format == null && isset( $this->attributes_format['view'] ) ) {
			$format = $this->attributes_format['view'];
		}

		if( $format == null ) $format = '<a href="%1$s" class="link view">%2$s %3$s</a>';

		if( empty( $this->attributes['show_views'] ) || $this->attributes['show_views'] != 'hide' ) {

			$icon = sprintf( '<i class="icon %s"></i>', slz()->backend->get_param('meta_icon/view') );

			$out = sprintf( $format, $this->permalink, $this->get_post_view( ), esc_html__( 'Views', 'slz') );

		}

		return $out;

	}

	public function get_post_view( ) {

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


	/**
	 * Get Likes
	 * @param null $format
	 * @return string
	 */
	public function get_likes($format = null ) {
		$out = '';
		$class = 'link like ';
		$title = esc_html__( 'Like', 'slz' );
		$liked = array();
		if( isset( $_SESSION['postliked'] ) && is_array( $_SESSION['postliked'] ) ) {
			$liked = $_SESSION['postliked'];
		}
		if( in_array( $this->post_id, $liked ) ) {
			$class .= 'text-red';
			$title = esc_html__( 'Unlike', 'slz' );
		}
		if( $format == null ) {
			$format = '<a href="javascript:void(0);" data-postid="%1$s" title="%5$s" class="%4$s">%2$s</a>';
			if( isset( $this->attributes_format['like'] ) ) {
				$format = $this->attributes_format['like'];
			}
		}
		$out = sprintf( $format, esc_attr( $this->post_id ), esc_html( $this->get_post_like( ) ), esc_html__( 'Likes', 'slz'), esc_attr( $class ), $title );

		return $out;
	}

	/**
	 * Get Post Like
	 * @return int|mixed
	 */
	public function get_post_like( ) {
		$res = 0;
		$count_key = 'slz_postlike_number';
		$count = get_post_meta( $this->post_id, $count_key, true );
		if($count == '') {
			delete_post_meta( $this->post_id, $count_key );
			add_post_meta( $this->post_id, $count_key, '0' );
			$res = 0;
		} else {
			$res = $count;
		}
		return $res;
	}

	/**
	 * Feature images
	 * 
	 */
	public function get_featured_image( $thumb_type = 'large', $options = array() ) {

		$out = $thumb_img = $img_cate = '';

		$thumb_size = $this->attributes['thumb-size'][$thumb_type];

		$thumb_class = SLZ_Com::get_value( $options, 'thumb_class', 'img-responsive img-full' );

		if( has_post_thumbnail( $this->post_id ) ) {

			$thumb_id = get_post_thumbnail_id( $this->post_id );

			// regenerate if not exist.
			$helper = new SLZ_Image();

			$helper->regenerate_attachment_sizes($thumb_id, $thumb_size);

			$thumb_img = wp_get_attachment_image( $thumb_id, $thumb_size, false, array('class' => $thumb_class ) );
			
		}else {

			$thumb_img = Slz_Util::get_no_image( $this->attributes['thumb-size'], $this->post, $thumb_type, array('thumb_class' => $thumb_class ) );

		}

		return $thumb_img;
	}

	public function has_post_thumbnail(){

		return has_post_thumbnail( $this->post_id );

	}


	/**
	 * Get post title
	 * 
	 * @param string $limit
	 * @param string $echo
	 * @return string
	 */
	public function get_title( $is_limit = true, $options = array(), $format = null ) {

		if( $format == null ) $format = '<a href="%2$s" class="%3$s" >%1$s</a>';

		if( ! isset( $options['title_class'] ) ) $options['title_class'] = 'block-title';

		if( isset( $options['title_format'] ) && !empty( $options['title_format'] ) ) {

			$format = $options['title_format'];

		}

		$title = get_the_title( $this->post );

		if( $is_limit && !empty( $this->attributes['title_length'] ) ) {

			$limit = $this->attributes['title_length'];

			// cut title by limit
			$title = wp_trim_words($title, $limit);

		}
		
		return sprintf( $format, esc_html( $title ), $this->permalink, esc_attr ( $options['title_class'] ) );
	}


	/**
	 * Get the excerpt
	 * 
	 * @param string $limit
	 * @param string $echo
	 * @return string
	 */
	public function get_excerpt( $is_limit = true, $use_content = false ) {
		$trim_excerpt = '';
		$cut_spacimg_excerpt = '';

		if ( empty( $this->attributes['show_excerpt'] ) || $this->attributes['show_excerpt'] != 'hide'){

			$trim_excerpt = apply_filters( 'get_the_excerpt', $this->post->post_excerpt );
			
			$cut_spacimg_excerpt = str_replace(' ', '', $trim_excerpt);
			$cut_spacimg_excerpt = str_replace('	' , '', $cut_spacimg_excerpt);
			$cut_spacimg_excerpt = wpautop( $cut_spacimg_excerpt );

			if ( $cut_spacimg_excerpt != '' ){

				if( $is_limit && !empty( $this->attributes['excerpt_length'] ) ) {

					$limit = $this->attributes['excerpt_length'];

					$trim_excerpt = wp_trim_words($trim_excerpt, $limit, ' [...]');

				}

			}
			if($use_content == true) {

				if ( $is_limit && !empty( $this->attributes['excerpt_length'] ) ) {
					$trim_excerpt = $this->excerpt( $this->post->post_content, $this->attributes['excerpt_length'], 'yes' );
				}
				else {
					$trim_excerpt = $this->excerpt( $this->post->post_content, 20 );
				}
			}
		}

		return $trim_excerpt;

	}

	function excerpt($post_content, $limit, $show_shortcodes = '') {
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
	public function get_category( $class = 'block-category', $format = null ) {

		$out = $cat = '';

		if( empty($this->attributes['hide_main_category']) && ( empty( $this->attributes['show_category'] ) || $this->attributes['show_category'] != 'hide' ) ) {

			if( $format == null ) $format = '<a href="%1$s" class="%3$s">%2$s</a>';
			// Read the post meta

			$post_options = get_post_meta( $this->post_id, 'slz_page_options', true);

			if ( isset( $post_options['blog_main_category'] ) && !empty( $post_options['blog_main_category'] ) ) {

				// Main category has seleted post setting
				$cat = get_category_by_slug( $post_options['blog_main_category'] );

			} else {

				// Get one auto
				$cat = current( get_the_category( $this->post ) );

			}

			if ( $cat ) {

				$out = sprintf( $format, get_category_link($cat->cat_ID), esc_html( $cat->name ), $class );

			}

		}

		return $out;
	}
    public function get_categories($post_id, $format = null) {

        $post_categories = wp_get_post_categories( $post_id );

        $out = array();

        if( $format == null) $format = '<a href="%1$s" class="%3$s">%2$s</a>';

        if ( isset($post_categories) ) {

            foreach($post_categories as $c){

                $cat = get_category( $c );

                $out [] = sprintf( $format, get_category_link($cat->cat_ID), esc_html( $cat->name ), 'link' );
            }
        }
        if( $out ){
            return implode(', ', $out);
        }
        return '';
    }
	public function get_tag( $class = 'link tag', $format = null ) {

		if( empty( $this->attributes['show_tag'] ) || $this->attributes['show_tag'] != 'hide' ) {

			$tags = get_the_tags( $this->post );

			$tag_html = array();

			if ( is_array( $tags ) ) {

				foreach ($tags as $tag) {
					$tag_html[] = '<a href="' . get_tag_link($tag->term_id) . '" class="' . esc_attr( $class ) . '">' . $tag->name . '</a>';
				}

			}

			if ( !empty ( $tag_html ) )
				return join($tag_html, ', ');

		}

		return;
	}



	// public function get_category( $class = '', $format = null ) {

	//     $out = $cat = '';

	//     if( empty( $this->attributes['show_category'] ) || $this->attributes['show_category'] != 'hide' ) {

	//         if( $format == null ) $format = '<li><a href="%1$s" class="link">%2$s</a></li>';

	//         // Read the post meta

	//         $post_options = get_post_meta( $this->post_id, 'slz_page_options', true);

	//         if ( isset( $post_options['blog_main_category'] ) && !empty( $post_options['blog_main_category'] ) ) {

	//             // Main category has seleted post setting
	//             $cat = get_category_by_slug( $post_options['blog_main_category'] );

	//         } else {

	//             // Get one auto
	//             $cat = current( get_the_category( $this->post ) );

	//         }

	//         if ( $cat ) {

	//             $out = sprintf( $format, get_category_link($cat->cat_ID), esc_html( $cat->name ) );

	//         }

	//     }

	//     return $out;
	// }

	private function isLink( $post_id ) {

		return get_post_format( $post_id ) === 'link';

	}

	private function isVideo( $post_id ) {

		return get_post_format( $post_id ) === 'video';

	}

	private function isGallery($post_id) {

		return get_post_format( $post_id ) === 'gallery';

	}
	
	private function get_post_url( $post_id ) {

		if( $this->isLink( $post_id ) ) {

			$content = get_the_content( $post_id );

			$has_url = get_url_in_content( $content );
				
			return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink( $post_id ) );

		} else {

			return get_permalink( $post_id );

		}

	}

	public function get_url(){
		return esc_url( $this->permalink );
	}

	public function get_meta_data( $seperate = '', $remove = array() ){

		$post_info = slz_get_db_settings_option('post-info', array());

		$result = array();
		if( $post_info ) {
			$post_info = array_unique($post_info);
			foreach ($post_info as $info) {
				
				if( in_array($info, $remove ) ) {
					continue;
				}
				
				switch ($info) {
	
					case 'date':
	
						$date = $this->get_date();
	
						if ( !empty ( $date ) )
							$result[] = '<li>'. $date . '</li>';
	
						break;
	
					case 'author':
	
						$author = $this->get_author();
	
						if ( !empty ( $author ) )
							$result[] = '<li>' . $author . '</li>';
	
						break;
					
					case 'category':
	
						$category = $this->get_category('link');
						if ( !empty ( $category ) )
							$result[] = '<li>' . $category  . '</li>';
	
						break;
	
					case 'comment':
	
						$comment = $this->get_comments();
	
						if ( !empty ( $comment ) )
							$result[] = '<li>' . $comment . '</li>';
	
						break;
	
					case 'view':
	
						$view = $this->get_views();
	
						if ( !empty ( $view ) ) 
							$result[] = '<li>' . $view . '</li>';
						
						break;
	
					case 'tag':
	
						$tag = $this->get_tag();
	
						if ( !empty ( $tag ) ) 
							$result[] = '<li>' . $tag . '</li>';
	
						break;

                    case 'like':
                        $like = $this->get_likes();
                        $result[] = '<li>' . $like . '</li>';
	                    break;

					default:
						# code...
						break;
				}
	
			}

		}
		return implode( $seperate, $result );

	}

    public function get_meta_data_format( $seperate = '', $remove = array(), $array_html = array() ){

        $post_info = slz_get_db_settings_option('post-info', array());

        $result = array();
        if( $post_info ) {
            $post_info = array_unique($post_info);
            foreach ($post_info as $info) {

                if( in_array($info, $remove ) ) {
                    continue;
                }

                switch ($info) {

                    case 'date':

                        $date = $this->get_date();

                        if ( !empty ( $date ) )
                            $result[] = '<li>'. $date . '</li>';

                        break;

                    case 'author':

                        $author = $this->get_author();

                        if ( !empty ( $author ) )
                            $result[] = '<li>' . $author . '</li>';

                        break;

                    case 'category':

                        if( isset( $array_html['category']) )
                        {
                            $category = $this->get_category('link', $array_html['category']);
                        }else{
                            $category = $this->get_category('link');
                        }
                        if ( !empty ( $category ) )
                            $result[] = '<li>' . $category  . '</li>';

                        break;

                    case 'comment':

                        $comment = $this->get_comments();

                        if ( !empty ( $comment ) )
                            $result[] = '<li>' . $comment . '</li>';

                        break;

                    case 'view':

                        $view = $this->get_views();

                        if ( !empty ( $view ) )
                            $result[] = '<li>' . $view . '</li>';

                        break;

                    case 'tag':
                        
                        $tag = $this->get_tag();

                        if ( !empty ( $tag ) )
                           	$result[] = '<li>' . $tag . '</li>';

                        break;

                    case 'like':
                        $like = $this->get_likes();
                        $result[] = '<li>' . $like . '</li>';
                        break;

                    default:
                        # code...
                        break;
                }

            }

        }
        return implode( $seperate, $result );

    }

	public function get_post_perpage(){

		return $per_page = get_option('posts_per_page');

	}
	public function get_categories_meta( $container = true, $seperator = ',' ){
		$result = '';
		$post_info = slz_get_db_settings_option('post-info', array());
		$cats_box = slz_get_db_settings_option('blog-post-categories', 'yes');
		if( array_search('category', $post_info) !== false || $cats_box == 'yes') {
			
			$list = get_the_category_list( $seperator );
			if ( $list ) {
				if( '' == $seperator ) {
					$format = '<div class="categories-list"><span>%1$s</span>%2$s</div>';
				} else {
					$format = '<li>%1$s%2$s</li>';
					if( $container ) {
						$format = '<ul class="categories-list">'. $format .'</ul>';
					}
				}
				$result = sprintf( $format,
						esc_html_x( 'Categories:', 'Used before category names.', 'slz' ),
						$list
				);
			}
		}
		return $result;
	}
	public function get_tags_meta( $container = true, $seperator = ',' ){
		$result = '';
		$post_info = slz_get_db_settings_option('post-info', array());
		$tags_box = slz_get_db_settings_option('blog-post-tags', 'yes');
		if( array_search('tag', $post_info) !== false || $tags_box == 'yes') {
			
			$list = get_the_tag_list('', $seperator );
			if ( $list ) {
				$format = '<li>%1$s%2$s</li>';
				if( $container ) {
					$format = '<ul class="tags-list">'. $format .'</ul>';
				}
				$result = sprintf( $format,
						esc_html_x( 'Tags:', 'Used before tag names.', 'slz' ),
						$list
				);
			}
		}
		return $result;
	}
	public function get_block_info( $seperate = '', $exclude = array() ){
	
		$post_info = slz_get_db_settings_option('post-info', array());
		$result = array();
		$result[] = edit_post_link( esc_html__( 'Edit', 'slz' ), '<li class="edit-link"><i class="fa fa-pencil"></i>', '</li>' );;

		if( $post_info ) {
			$post_info = array_unique($post_info);
			
			foreach ($post_info as $info) {
				if( in_array( $info, $exclude ) ){
					continue;
				}
				switch ($info) {
		
					case 'date':
						
						$date = $this->get_date();
		
						if ( !empty ( $date ) )
							$result[] = '<li>' . $date . '</li>';
		
						break;
		
					case 'author':
						if( isset($this->attributes_format['article_author']) ) {
							$format = $this->attributes_format['article_author'];
						}
						if( empty($format)){
							$format = '<li class="author"><span class="author-label">'.esc_html__('By ', 'slz') . '</span> <a href="%1$s" class="link author-text">%2$s</a></li>';
						}
						$author = $this->get_author($format);
		
						if ( !empty ( $author ) )
							$result[] = $author ;
		
						break;
		
					case 'comment':
		
						$comment = $this->get_comments();
		
						if ( !empty ( $comment ) )
							$result[] = '<li>' . $comment . '</li>';
		
						break;
		
					case 'view':
		
						$view = $this->get_views();
		
						if ( !empty ( $view ) )
							$result[] = '<li>' . $view . '</li>';
							
						break;
		
					default:
						# code...
						break;
				}
		
			}
		}
	
		return implode( $seperate, $result );
	
	}
	
    public function get_comments_author_name( $format = null ) {
		$out = '';

		$arg = array(
			'post_id' => $this->post_id,
		);
		$arr = get_comments( $arg );
		$count = 1;
		if ( !empty ( $arr )  ) {
			$out .= '<div class="block-comments float-l">';
				$out .= '<ul class="comment-avatars">';
				foreach ($arr as $value) {
					$out .= '<li><a href="#" class="link"> <span>'. esc_html( ucfirst( substr( $value->comment_author, 0, 1) ) ) .'</span></a></li>';
					$count++;
	
					if ( $count == 4 ) {
						break;
					}
				}// end foreach
				$out .= '</ul>';
				$out .= $this->get_comments( '<div class="comment-counter">%2$s %3$s</div>' );
			$out .= '</div>';
		}else{
			$out .= '<div class="block-comments float-l"><div class="comment-counter">'. esc_html__( '0 Comment', 'slz' ) .'</div></div>';
		}

		return $out;
	}
	
	public function get_rating_numer() {
		$out = '';
		$obj = new SLZ_Review();
		$review_count = 0;
		$out .= $obj->get_average_rating($review_count, $this->post_id);
		return $out;
	}
	
	public function get_rating_star( $class = '' ) {
		$out = '';
		$obj = new SLZ_Review();
		$format = '<div class="ratings '. esc_attr( $class ) .'">
			<div class="star-rating" title="Rated %2$s out of 5">
				<span class="width-%1$s">
					<strong class="rating">%2$s out of 5</strong>
				</span>
			</div>
		</div>';
		$out .= $obj->get_rating_html( $this->post_id, $format, null,  $class);		
		return $out;
	}
	
	public function share_social( $format = null ) {
		$out = '';
		$social_enable = array();
		if( $format == null ) {
			$format ='<li><a href="%1$s" class="link %3$s" target="_blank">%2$s</a></li>';
		}
		
		$obj = new SLZ_Social_Sharing( $this->post );
		
		$options = slz_get_db_settings_option( 'social-in-post', '');
		$show_social =  slz_akg( 'enable-social-share', $options, '' );
		$social_enable  = slz_akg( 'enable/social-share-info', $options, array() );
		if ( empty( $social_enable ) ) {
			return;
		}
		$share_link = $obj->renders( $social_enable, false, $format);
		
		$out .= '<div class="social-wrapper">';
			$out .= esc_html__( 'Share:', 'slz' );
			$out .= '<ul class="list-unstyled list-inline list-social-wrapper">';
				$out .= $share_link;
			$out .= '</ul>';
		$out .= '</div>';
		return $out;
	}
	
	public function is_video() {
		return get_post_format( $this->post_id ) === 'video';
	}
	
	public function is_audio() {
		$status = get_post_format( $this->post_id ) === 'audio';
		$data = slz_get_db_post_option( $this->post_id, 'feature-audio-link', '' );
		if(empty($data)){
			$data = slz_get_db_post_option( $this->post_id, 'feature-audio-file', '' );
		}
		return ( $status && !empty( $data ) ) ? true : false;
		
	}
	
	public function is_gallery() {
		$data = slz_get_db_post_option( $this->post_id, 'feature-gallery-images', '' );
		$status = get_post_format( $this->post_id ) === 'gallery';
		return ( $status && !empty( $data ) ) ? true : false;
	}
	
	public function is_quote() {
		$status = get_post_format( $this->post_id ) === 'quote';
		$data = slz_get_db_post_option( $this->post_id, 'feature-quote-info', '' );
		return ( $status && !empty( $data ) ) ? true : false;
	}
	
	public function get_feature_video( $format = null, $options = array() ) {
		$out = '';
		$url = '';
		$feature_image = '';
		if( $format == null ) {
			$format = '
					<div class="block-video">
						<div class="btn-play">
							<i class="icons fa fa-play"></i>
						</div>
						<div class="btn-close" data-src="%1$s"><i class="icons fa fa-times"></i></div>
						%2$s
						%3$s
					</div>
			';
		}
		
		$iframe_video = SLZ_Post_Feature_Video::get_feature_video_iframe( $url, $this->post_id );
		if( $iframe_video ) {
			$thumb_id = get_post_thumbnail_id( $this->post_id );

			$image_size = SLZ_Com::get_value( $options, 'image_size', 'large' );
			if( get_post_thumbnail_id( $this->post_id ) ) {
				$feature_image = $this->get_featured_image( $image_size, array( 'thumb_class' => 'img-full' ) );
			}else{
				$feature_image = '';
			}
			$out .= sprintf( $format, esc_attr( $url ), $feature_image, $iframe_video );
		}
		
		return $out;
	}
	
	public function get_shares( $format = null ) {
		$out = '';
		$options = slz_get_db_settings_option( 'social-in-post', '' );
		$show_social =  slz_akg( 'enable-social-share', $options, '' );
		if( $show_social != 'enable' ) {
			return $out;
		}

		$show_count = slz_akg( 'enable/social-share-count/enable-social-share-count', $options, '' );
		if( $show_count != 'enable' ) {
			return $out;
		}

		$social_enable  = slz_akg( 'enable/social-share-info', $options, array() );
		if ( empty( $social_enable ) ) {
			return $out;
		}
		if( $format == null ) {
			$format = '<a href="javascript:void(0)" class="link share">%1$s</a>';
		}
		
		$out .= sprintf( $format, esc_html( $this->get_shares_count() ) );
		
		return $out;
	}
	
	private function get_shares_count(){
		$total = 0;
		$url = $this->permalink;
		$options = slz_get_db_settings_option( 'social-in-post', '');
		$social_enable  = slz_akg( 'enable/social-share-info', $options, array() );
		
		$obj = new SLZ_Social_Sharing( $this->post );
		if( in_array( 'facebook', $social_enable ) ){
			$fb_appid     = slz_akg( 'enable/social-share-count/enable/social-share-facebook-appid',
									$options, '' );
			$fb_secet_key = slz_akg( 'enable/social-share-count/enable/social-share-facebook-secret-key',
									$options, '' );
			$total += $obj->get_facebook_share_count( $url, $fb_appid, $fb_secet_key );

		}
		if( in_array( 'twitter', $social_enable ) ){
			$total += $obj->get_tweets_share_count($url);
		}
		if( in_array( 'google-plus', $social_enable ) ){
			$total += $obj->get_googleplus_share_count($url);
		}
		if( in_array( 'pinterest', $social_enable ) ){
			$total += $obj->get_pinterest_share_count($url);
		}
		if( in_array( 'linkedin', $social_enable ) ){
			$total += $obj->get_linkedin_share_count($url);
		}

		return $total;
	}
	
	public function get_read_more( $format = null ) {
		$out = '';
		
		if( $format == null ) {
			$format = '<a href="%1$s" class="block-read-more">'. esc_html__( 'Read More', 'slz' ) .'<i class="fa fa-angle-double-right"></i></a>';
		}
		$out .= sprintf( $format, esc_url( $this->permalink ) );
		
		return $out;
	}
	
	public function get_audio( $format = null ) {
		$out = '';
		
		$data = slz_get_db_post_option( $this->post_id, 'feature-audio-link', '' );
		if( !empty( $data ) ) {
			
			if( $format == null ) {
				$format = '
					<div class="audio-wrapper">
						<audio preload="preload" controls="controls" src="%1$s"></audio>
						<div class="slz-audio-control">
							<span class="btn-play"></span>
						</div>
					</div>
				';
			}
			$out .= sprintf( $format, esc_url( $data ) );
		
		}
 		
		return $out;
	}
	
	public function get_quote( $format = null ) {
		$out = '';
		
		$data = slz_get_db_post_option( $this->post_id, 'feature-quote-info', '' );
		if( !empty( $data ) ) {
			
			if( $format == null ) {
				$format = '
				<div class="block-quote-wrapper">
					<div class="block-quote">%1$s</div>
				</div>';
			}
			$out .= sprintf( $format, wp_kses_post( nl2br( $data ) ) );
			
		}
		
		return $out;
	}
	
	public function get_gallery() {
		$out = '';
		$temp1 = '';
		$temp2 = '';
		$data = slz_get_db_post_option( $this->post_id, 'feature-gallery-images', '' );
		if( !empty( $data ) ) {
			if( get_post_thumbnail_id( $this->post_id ) ) {
				$thumb_id = get_post_thumbnail_id( $this->post_id );
				$temp1 .= '<div class="item">';
					$temp1 .= '<div class="image-gallery-wrapper">';
						$temp1 .= '<a href="'. esc_url( wp_get_attachment_image_url( $thumb_id ) ) .'" data-fancybox-group="carousel-gallery-1" class="images thumb fancybox-thumb">';
							$temp1 .= $this->get_featured_image( 'large', array( 'thumb_class' => 'img-responsive' ) );
						$temp1 .= '</a>';
					$temp1 .= '</div>';
				$temp1 .= '</div>';
				
				$temp2 .= '<div class="item">';
					$temp2 .= '<div class="thumbnail-image">';
						$temp2 .= $this->get_featured_image( 'small', array( 'thumb_class' => 'img-responsive' ) );
					$temp2 .= '</div>';
				$temp2 .= '</div>';
			} // endif

			$image_large = 'full';
			$image_small = 'full';
			if( isset( $this->attributes['thumb-size']['large'] ) ) {
				$image_large = $this->attributes['thumb-size']['large'];
			}
			if( isset( $this->attributes['thumb-size']['small'] ) ) {
				$image_small = $this->attributes['thumb-size']['small'];
			}
			foreach ( $data as $item ) {
				$temp1 .= '<div class="item">';
					$temp1 .= '<div class="image-gallery-wrapper">';
						$temp1 .= '<a href="'. esc_url( $item['url'] ) .'" data-fancybox-group="carousel-gallery-1" class="images thumb fancybox-thumb">';
							$temp1 .= wp_get_attachment_image( $item['attachment_id'], $image_large, '', array( 'class' => 'img-responsive' ) );
						$temp1 .= '</a>';
					$temp1 .= '</div>';
				$temp1 .= '</div>';
				
				$temp2 .= '<div class="item">';
					$temp2 .= '<div class="thumbnail-image">';
						$temp2 .= wp_get_attachment_image( $item['attachment_id'], $image_small, '', array( 'class' => 'img-responsive' ) );
					$temp2 .= '</div>';
				$temp2 .= '</div>';
			}
			
			$out .= '<div class="slz-carousel-syncing">';
				$out .= '<div class="slider-for">';
					$out .= $temp1;
				$out .= '</div>';
				$out .= '<div data-slidestoshow="4" class="slider-nav">';
					$out .= $temp2;
				$out .= '</div>';
			$out .= '</div>';
			
		}
		
		return $out;
	}
	
	public function get_post_format_post_view() {
		$post_format = get_post_format( $this->post_id );
		
		if( slz_ext('templates') ) {
			switch ( $post_format ) {
				case 'video':
					slz_ext('templates')->get_template( 'post_format_video' )->render( $this );
					break;
				case 'gallery':
					slz_ext('templates')->get_template( 'post_format_gallery' )->render( $this );
					break;
				case 'audio':
					slz_ext('templates')->get_template( 'post_format_audio' )->render( $this );
					break;
				case 'quote':
					slz_ext('templates')->get_template( 'post_format_quote' )->render( $this );
					break;
				default:
					slz_ext('templates')->get_template( 'post_format_standard' )->render( $this );
					break;
			}
		}else{
			if( get_post_thumbnail_id( $this->post_id ) ):
				echo '<div class="block-image">';
					echo ( $this->get_ribbon_date() );
						echo '<a href="'.esc_url( $this->permalink ).'" class="link">';
							echo wp_kses_post( $this->get_featured_image() );
						echo '</a>';
				echo '</div>';
			endif;
		}
	}
}