<?php
class SLZ_Review {
	
	public $post_reviews;
	
	public function __construct() {
		$this->post_reviews = slz()->theme->get_config('posts_rating');
	}
	public function init(){
		if( $this->post_reviews ) {
			add_action( 'comment_post',      array( &$this, 'add_comment_rating' ) );
			add_action( 'deleted_comment',   array( &$this, 'update_review_rating' ) );
			add_action( 'trashed_comment',   array( &$this, 'update_review_rating' ) );
			add_action( 'untrashed_comment', array( &$this, 'update_review_rating' ) );
		}
	}
	public function add_comment_rating( $comment_id ) {
		$review_count = 0;
		$post_id = $_POST['comment_post_ID'];
		$post_type = get_post_type( $post_id );
		if ( isset( $_POST['rating'] ) && isset($this->post_reviews[$post_type]) ) {
			if ( empty( $_POST['rating']) || $_POST['rating'] > 5 || $_POST['rating'] < 1 ) {
				return;
			}
			$meta_key = $this->post_reviews[ $post_type ];
			add_comment_meta( $comment_id, $meta_key, (int) esc_attr( $_POST['rating'] ), true );
			
			$rating = $this->get_average_rating( $review_count, $post_id, $meta_key );
			update_post_meta ( $post_id, $meta_key, $rating );
		}
	}
	public function update_review_rating( $comment_id ) {
		$review_count = 0;
		$comment = get_comment( $comment_id, ARRAY_A );
		$post_id = $comment['comment_post_ID'];
		$post_type = get_post_type( $post_id );
		if( !isset($this->post_reviews[ $post_type ]) ) {
			return;
		}
		$meta_key = $this->post_reviews[ $post_type ];
		$rating = $this->get_average_rating( $review_count, $post_id, $meta_key );
		update_post_meta ( $post_id, $meta_key, $rating );
	}
	public function get_average_rating(&$review_count, $post_id, $meta_key = null ) {
		if( empty($meta_key) ){
			$post_type = get_post_type( $post_id );
			if( !isset($this->post_reviews[ $post_type ]) ) {
				return;
			}
			$meta_key = $this->post_reviews[ $post_type ];
		}
		$comments = get_comments( array('post_id' => $post_id) );
		$review_count = $rate_number = 0;
		if( empty( $comments ) ){
			return $review_count;
		}
		foreach($comments as $cmt){
			$rating = get_comment_meta( $cmt->comment_ID, $meta_key, true);
			if($rating){
				$rate_number += intval($rating);
				$review_count ++;
			}
		}
		if(  $review_count == 0 ) {
			return 0;
		}
		$rate_number = number_format($rate_number/$review_count, 1);
		return $rate_number;
	}
	public function get_rating_html( $post_id, $format = null, $rating = null, $class = '' ) {
		$rating_html = $review_count = '';

		if ( ! is_numeric( $rating ) ) {
			$rating = $this->get_average_rating( $review_count, $post_id );
		}

		if ( $rating > 0 ) {
			$rate_width = ( $rating / 5 ) * 100;
			$sub_rate = substr($rate_width,1);
			if($sub_rate){
				if(intval($sub_rate) < 5){
					$rate_width = $rate_width - $sub_rate;
				}
				else{
					$rate_width = 10*(intval(substr($rate_width, 0, 1)) + 1);
				}
			}
			if( empty($format) ){
				$format = '<div class="ratings '. esc_attr( $class ) .'">
							<div class="star-rating" title="Rated %2$s out of 5">
								<span class="width-%1$s">
									<strong class="rating">%2$s out of 5</strong>
								</span>
							</div>
							<div class="number">(%3$s)</div>
						</div>';
			}
			$rating_html = sprintf( $format, $rate_width, $rating, $review_count);
		}

		return $rating_html;
	}
	
}