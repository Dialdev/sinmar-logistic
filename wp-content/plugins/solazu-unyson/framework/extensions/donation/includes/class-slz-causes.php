<?php
class SLZ_Causes extends SLZ_Custom_Posttype_Model {

	private $post_type = 'slz-causes';
	private $post_taxonomy = 'slz-causes-cat';

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
			'urgent'          => '',
			'goal'            => '',
			'location'        => '',
			'people_benefits' => '',
			'donation_url'    => '',
			'time'            => '',
			'description'     => '',
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
			'layout'			=> 'layout-1',
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
				if(isset($atts['list_post']) && function_exists('vc_param_group_parse_atts') ){
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

	}
	public function reset(){
		wp_reset_postdata();
	}

	public function set_default_options( $html_options = array() ) {
		$defaults = array(
			'urgent_label'         => '<div class="block-label"><span class="text">%1$s</span></div>',
			'image_with_label'     => '<div class="block-image">%4$s<a href="%3$s" class="link">%1$s%2$s</a></div>',
			'image_format'         => '%1$s',
			'term_format'          => '<span class="cate-text">%1$s</span>',
			'title_format'         => '<a href="%2$s" class="block-title">%1$s</a>',
			'btn_more_format'      => '<a href="%2$s">%1$s</a>',
			'raised_number'        => '<div class="raise"><span class="title">%2$s</span><span class="text">%1$s</span></div>',
			'goal_number'          => '<div class="goal"><span class="title">%2$s</span><span class="text">%1$s</span></div>',
			'description_html'     => '<div class="block-text">%1$s</div>',
			'social_share'         => '<div class="slz-social-share">%2$s<div class="social">%1$s</div></div>',
			'location_format'      => '<div class="location-item"><span class="title">%2$s</span><span class="text">%1$s</span></div>',
			'dornors_format'       => '<li><span class="link dornor"><span class="title">%2$s</span><span class="text">%1$s</span></span></li>',
			'people_benefits_format'  => '<li><span class="link benefits"><span class="title">%2$s</span><span class="text">%1$s</span></span></li>',
			'remain_time_format'    => '<span class="remain_time"> (%s Days left)</span>',
		    'donation_button'      => '<a href="#donate-modal-%1$s" data-id="%3$s" data-toggle="modal" data-target="#donate-modal-%1$s" class="slz-btn btn-block-donate">%2$s</a>',
		);

		$html_options = array_merge( $defaults, $html_options );
		return $html_options;
	}

	private function get_thumb_size() {
		if ( isset($this->attributes['image_size']) && is_array($this->attributes['image_size']) ) {
			$this->attributes['thumb-size'] = SLZ_Util::get_thumb_size( $this->attributes['image_size'], $this->attributes );
		}
	}

	/*-------------------- >> Render Html << -------------------------*/
	/**
	 * Render html by shortcode. style grid-01 & grid-02
	 *
	 * @param array $html_options
	 * Format: 1$ - image, 2$ - title, 3$ - position, 4$ - contact info, 5$ - description, 6$ - social, 7$ - post_id, 8$ - responsive
	 */
	public function render_causes_block( $html_options = array() ) {
		$this->html_format = $this->set_default_options( $html_options );
		$thumb_type = 'large';
		if( $this->query->have_posts() ) {
			while ( $this->query->have_posts() ) {
				$this->query->the_post();
				$this->loop_index();

				$html_options = $this->html_format;
				printf( $html_options['html_format'],
					$this->get_featured_image_with_label( $html_options, $thumb_type ),
					$this->get_title(),
					$this->get_button_causes( $html_options ),
					$this->get_goal_number( $html_options ),
					$this->get_raised_number( $html_options ),
					$this->get_donate_progressbar(),
					$this->get_meta_description(),
					$this->get_social_share(),
					$this->get_remaining_day(),
					$this->get_meta_location( $html_options ),
					$this->get_donors( $html_options ),
					$this->get_meta_people_benefits( $html_options ),
					$this->get_remaining_day( $html_options ),
					$this->get_donate_btn()
				);
			}
			$this->reset();
			if( !empty($this->attributes['pagination']) && $this->attributes['pagination'] == 'yes' ) {
				echo '<div class="clearfix"></div>';
				echo SLZ_Pagination::paging_nav( $this->query->max_num_pages, 2, $this->query);
			}
		}
	}

	/*-------------------- >> General Functions << --------------------*/

	public function get_button_causes( $html_options ) {
        if( ! empty( $this->attributes['show_donation_button'] ) && $this->attributes['show_donation_button'] == 'yes' ) {
            $format = $this->html_format['donation_button'];
            return sprintf( $format, esc_attr( $this->attributes['uniq_id'] ), esc_html__( 'Donate now', 'slz' ), $this->post_id );
        } else {
            return $this->get_btn_more( $html_options );
        }
    }

	public function get_featured_image_with_label($html_options, $thumb_type) {
		$out = '';
		$format = $this->html_format['image_with_label'];
		
		$out .= sprintf( $format,
			$this->get_featured_image($html_options, $thumb_type),
			$this->get_current_term(),
			esc_url( $this->permalink ),
			$this->get_label_urgent()
		);
		
		return $out;
	}
	
	public function get_label_urgent() {
		$out = '';
		$format = $this->html_format['urgent_label'];
		
		if( $this->post_meta['urgent'] == 'yes' ) {
			$out .= sprintf( $format, esc_html__( 'Urgent', 'slz' ) );
		}
		
		return $out;
	}
	
	public function get_current_term() {
		$out = '';
		
		$cat_arr = $this->get_current_taxonomy();
		$main_category = '';
		if( !empty( $cat_arr ) ) {
			$main_category = $cat_arr['name'];
			$format = $this->html_format['term_format'];
			$out .= sprintf( $format, esc_html( $main_category ) );
		}

		return $out;
	}
	
	public function get_raised_number( $html_format = array(), $value_only = false ) {
		$out = '';
		
		if( !isset( $html_format['raised_number'] ) ) {
			$format = $this->html_format['raised_number'];
		}else{
			$format = $html_format['raised_number'];
		}
		
		$raised = get_post_meta( $this->post_id, 'slz-donation-raised-money', true );
		if( empty( $raised ) ) {
			$raised = 0;
		}
		$raised = intval( $raised );
		
		$raised_money = slz_get_currency_format_options( $raised );
		if( $value_only ) {
			$out .= $raised;
		}else{
			$out .= sprintf( $format, esc_html( $raised_money ), esc_html__( 'Raised: ', 'slz' ) );
		}
		
		return $out;
	}
	
	public function get_goal_number( $html_format = array(), $value_only = false ) {
		$out = '';
		if( !isset( $html_format['goal_number'] ) ) {
			$format = $this->html_format['goal_number'];
		}else{
			$format = $html_format['goal_number'];
		}
		
		if( !empty( $this->post_meta['goal'] ) ) {
			$goal_number = slz_get_currency_format_options( $this->post_meta['goal'] );
			if( $value_only ) {
				$out .= $this->post_meta['goal'];
			}else{
				$out .= sprintf( $format, esc_html( $goal_number ), esc_html__( 'Goal: ', 'slz' ) );
			}
		}
		
		return $out;
	}
	
	public function get_donate_progressbar() {
		$out = '';
		
		if( $this->attributes['show_progress_bar'] != 'yes' ) {
			return $out;
		}
		$money_goal = $this->get_goal_number( array(), true );
		$money_raised = $this->get_raised_number( array(), true );
		
		if( $money_goal == 0 || empty( $money_goal ) ) {
			if( intval( $money_raised ) > 0 ) {
				$percent = 100;
			}else{
				$percent = 0;
			}
		}else{
			$percent = intval( $money_raised ) / intval( $money_goal ) * 100;
		}
		$percent_arr = explode( '.', $percent);
		$final = 0;
		
		if( isset( $percent_arr[1] ) ) {
			$percent_arr[1] = substr( $percent_arr[1], 0, 1);
			if( $percent_arr[1] > 5 ) {
				$final = intval( $percent_arr[0]++ );
			}else{
				$final = intval( $percent_arr[0] );
			}
		}else{
			$final = intval( $percent );
		}

		if( intval( $money_raised ) > intval( $money_goal ) ) {
			$final = 100;
		}
		
		$format = '
			<div class="slz-progress-bar-01 style-1 donate-bar">
				<div class="progress-title">
					<span data-from="0" data-to="%1$s" data-speed="1200" class="percent"></span>
				</div>
				<div class="progress">
					<div role="progressbar" aria-valuenow="%1$s" aria-valuemin="0" data-unit="&#37;" aria-valuemax="100" class="progress-bar progress-bar-striped active">
						<span data-from="0" data-to="" data-speed="1200" class="percent"></span>
					</div>
				</div>
			</div>
		';
		
		$out = sprintf( $format, esc_attr( $final ) );
		
		return $out;
	}
	
	public function get_meta_description() {
		$out = '';
		$format = $this->html_format['description_html'];
		if( !empty( $this->post_meta['description'] ) ) {
			$out .= sprintf( $format, wp_kses_post( $this->post_meta['description'] ) );
		}
		return $out;
	}
	
	public function get_social_share() {
		$out = '';
		if( $this->attributes['show_social_share_2'] != 'yes' ) {
			return $out;
		}
		$social_sharing = new SLZ_Social_Sharing();
		$format = $this->html_format['social_share'];
		$format_social = '<a href="%1$s" class="link" target="_blank">%2$s</a>';
		$share_link = "";
		if ( $this->attributes['show_social_share_2'] == 'yes' ) {
			$list_social_share_2 = (array) vc_param_group_parse_atts($this->attributes['list_social_share_2']);
			if ( $list_social_share_2 ) {
				foreach ($list_social_share_2 as $key => $obj) {
					if ( !empty($obj) ) {
						$network = $obj['social'];
						$share_link .= $social_sharing->render($network, false, $format_social);
					}
				}
				if( !empty( $share_link ) ) {
					$title = '<span class="title">'. esc_html__( 'Share', 'slz' ) .'</span>';
					$out .= sprintf( $format,  $share_link, $title );
				}
			}
		}
		return $out;
	}

	function get_remaining_day( $html_format = array() ) {
		$out = '';
		
		$format = $this->html_format['remain_time_format'];
		if( isset( $html_format['remain_time_format'] ) ) {
			$format = $html_format['remain_time_format'];
		}
		$time_db_arr = slz_get_db_post_option( $this->post_id, 'time', '' );
		if( !empty( $time_db_arr ) && isset( $time_db_arr['from'] ) ) {
			$now = time();
			$time_db_arr = explode( ' ', $time_db_arr['from'] );
			$time_db = strtotime( $time_db_arr[0] );
			$datediff = $time_db - $now;
			$count = floor($datediff / (60 * 60 * 24));
			if( $count < 0 ) {
				$count = 0;
			}

			$out .= sprintf( $format, esc_html( $count ), esc_html__( 'Remaining time:', 'slz' ) );
		}
		
		return $out;
	}
	
	function get_meta_location( $html_format = array() ) {
		
		$out = '';
		$format = $this->html_format['location_format'];
		if( isset( $html_format['location_format'] ) ) {
			$format = $html_format['location_format'];
		}
		
		if( !empty( $this->post_meta['location'] ) ) {
			$out .= sprintf( $format, esc_html( $this->post_meta['location'] ), esc_html__( 'Location:', 'slz' ) );
		}
		return $out;
	}
	
	public function get_donors( $html_forat = array() ) {
		$out = '';
		$count = get_post_meta( $this->post_id, 'slz-donation-dornors-number',true );

		$format = $this->html_format['dornors_format'];
		if( isset( $html_forat['dornors_format'] ) ) {
			$format = $html_forat['dornors_format'];
		}
		
		if( empty( $count ) ) {
			$count = 0;
		}
		$out .= sprintf( $format, esc_html( $count ), esc_html__( 'Donor(s):', 'slz' ) );

		return $out;
	}
	
	public function get_meta_people_benefits( $html_format = array() ) {
		$out = '';
		
		if( !empty( $this->post_meta['people_benefits'] ) ) {
			$format = $this->html_format['people_benefits_format'];
			if( isset( $html_format['people_benefits_format'] ) ) {
				$format = $html_format['people_benefits_format'];
				
				$out .= sprintf( $format, esc_html( $this->post_meta['people_benefits'] ), esc_html__( 'People Benefits:', 'slz' ) );
			}
		}
		
		return $out;
	}
	
	/*
	 * Not Change Code Or HTML Please
	 * It's Linked with Donate Method!
	 */
	public function get_donate_btn() {
        $out = '';

        $time_db_arr = slz_get_db_post_option( $this->post_id, 'time', '' );
        $time_remain = 0;
        if( !empty( $time_db_arr ) && isset( $time_db_arr['from'] ) ) {
            $now = time();
            $time_db_arr = explode( ' ', $time_db_arr['from'] );
            $time_db = strtotime( $time_db_arr[0] );
            $datediff = $time_db - $now;
            $count = floor($datediff / (60 * 60 * 24));
            if( $count <= 0 ) {
                return $out;
            }
        }

		$unique_id = SLZ_Com::make_id();
		$donate_payment_option = slz_get_db_settings_option( 'donation-payment-option' );

		if( !is_plugin_active( 'woocommerce/woocommerce.php' ) || $donate_payment_option == 'customlink' ){
			$donation_url = $this->post_meta['donation_url'];

			$out .= '<a href="'. ( empty( $donation_url ) ? 'javascript:void(0)' : esc_url( $donation_url ) ).'" class="slz-btn btn-block-donate">'. esc_html__( 'Donate now', 'slz' ) .'</a>';
			return $out;
		}

        $data_price_paypal = (array)slz()->theme->get_config('price_paypal');
        $format_price_paypal = '<div class="donate-item">
                            <input type="radio" name="%1$s" value="%2$s" />
                            <span class="label-check slz-btn">%3$s</span>
                        </div>';
        $html_price_paypal = '';
        $num_limit_show_price_paypal = 4;
        foreach ($data_price_paypal as $index=>$value) {
            $html_price_paypal .= sprintf($format_price_paypal, 'valueDonation', $value, slz_get_currency_format_options($value));
            if ($index == $num_limit_show_price_paypal-1) {
                break;
            }
        }

		$out .= '<a href="#donate-modal-'. esc_attr( $unique_id ) .'" data-toggle="modal" data-target="#donate-modal-'. esc_attr( $unique_id ) .'" class="slz-btn btn-block-donate">'. esc_html__( 'Donate now', 'slz' ) .'</a>';
		$out .= '
			<div id="donate-modal-'. esc_attr( $unique_id ) .'" tabindex="-1" role="dialog" class="modal fade">
				<div role="document" class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" data-dismiss="modal" aria-label="Close" class="close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h4 class="modal-title">'. esc_html__( 'Donation', 'slz' ) .'</h4>
						</div>
						<div class="slz-donate-submit slz-form-donate">
							<div class="modal-body">
								<div class="form-group">
								    <span class="gdlr-head">How much would you like to donate?</span>
									<div class="donation-button-segment-group slz-form-donate">
										<div class="radio">
											'.__($html_price_paypal, 'slz').'
											<div class="donate-item">
												<input type="radio" class="donation-other-price" name="valueDonation" value="100" />
												<div class="label-check another-donation">
													<span class="currencies">'. slz_get_db_settings_option( 'currency-money-format', '$' ) .'</span>
													<input class="form-control" type="text" maxlength="12" name="anotherAmount" />
												</div>
											</div>
										</div>
										<input type="text" name="slz_causes_post_id" value="'. esc_attr( $this->post_id ) .'" class="slz_causes_post_id" hidden />
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="slz-btn btn-block-donate slz_money_donate_btn">'. esc_html__( 'Donate now', 'slz' ) .'</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		';
		
		return $out;
	}
}