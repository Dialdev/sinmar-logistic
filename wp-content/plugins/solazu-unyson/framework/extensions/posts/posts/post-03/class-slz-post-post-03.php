<?php 

class SLZ_Post_Post_03 extends SLZ_Post {

	public function render( $echo = true )
	{

		$this->enqueue_static();

		$post_instance = $this;

		$post_id = get_the_ID();

		if ( empty ( $post_id ) )
			return;

		$related_post = '';
			
		if ( slz_get_db_settings_option('blog-article/status', '' ) == 'show' ){

			$blog_article = slz_get_db_settings_option('blog-article/show', '' );

			if ( slz_akg( 'filter-by', $blog_article, '' ) == 'category' ){

				$categories = get_the_category ( $post_id );

				if ( !empty( $categories ) ) {

					$category_ids = array();

					foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;

					$args = array(
						'ignore_sticky_posts' 	=> 1,
						'posts_per_page' 		=> slz_akg( 'limit', $blog_article, 6 ),
						'post__not_in' 			=> array( $post_id ),
						'post_type' 			=> 'post',
						'category__in' 			=> $category_ids,
						'orderby'		   		=> slz_akg( 'order_by', $blog_article, 'id' ),
						'order'			 		=> slz_akg( 'order', $blog_article, 'desc' )
					);

					$related_post =  new WP_Query( $args );
				}

			} else {
				$tags = wp_get_post_tags( $post_id );

				if ( !empty( $tags ) ){

					$tag_ids = array();

					foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;

					$args = array(
						'ignore_sticky_posts' 	=> 1,
						'posts_per_page' 		=> slz_akg( 'limit', $blog_article, 6 ),
						'post__not_in' 			=> array( $post_id ),
						'post_type' 			=> 'post',
						'tag__in' 				=> $tag_ids,
						'orderby'		   		=> slz_akg( 'order_by', $blog_article, 'id' ),
						'order'			 		=> slz_akg( 'order', $blog_article, 'desc' )
					);

					$related_post =  new WP_Query( $args );
				}

			}

			if( $related_post ) {
				$related_post->related_args = $this->get_data();
				$related_post->related_args['thumb-size'] = $this->get_related_image_size();
				$this->get_related_post_setting( $related_post->related_args );
			}

		}

		$results = slz_render_view( $this->locate_path('/views/view.php'), compact( 'related_post', 'post_instance' ) );
		if( !$echo ) {
			return $results;
		}
		echo $results;
	}
}
