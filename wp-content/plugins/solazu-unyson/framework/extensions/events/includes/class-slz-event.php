<?php
class SLZ_Event extends SLZ_Custom_Posttype_Model {

	private $post_type = 'slz-event';
	private $post_taxonomy = 'slz-event-cat';

    /**
     * SLZ_Event constructor.
     */
    public function __construct() {
		$this->meta_attributes();
		$this->set_meta_attributes();
		$this->taxonomy_cat = $this->post_taxonomy;
		$this->html_format = $this->set_default_options();
		$this->set_default_attributes();
	}

    /**
     * link to DB
     */
    public function meta_attributes() {
		$slz_merge_meta_atts = array();
		$meta_atts = array(
			'event_ticket_price'    => '',
            'event_ticket_number'   => '',
			'description'	        => '',
     		'event_location'        => '',
     		'address'         		=> '',
			'event_date_range'		=> '',
			'event_ticket_url'      => '',
			'event_goal_donation'	=> '',
			'event_donation_url'    => '',
			'banner_image'          => '',
            'price_box'             => '',
			'event_attributes'		=> '',
			'gallery_images'		=> '',
			'event_show_button'		=> '',
			'event_ticket_text'		=> '',
			'event_donation_text'	=> '',
            'hide_event_expired'    => ''
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

    /**
     *
     */
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

    /**
     *
     */
    public function set_default_attributes() {
		$default_atts = array(
			'layout'			=> 'event',
			'style'				=> 'style-1',
			'limit_post'		=> '-1',
			'offset_post'		=> '0',
			'sort_by'			=> '',
			'post_id'			=> '',
			'method'			=> '',
			'list_category'		=> '',
		    'show_image_1'      => '2',
		    'show_image_2'      => '0',
			'list_post'			=> '',
		);
		$this->attributes = $default_atts;
	}

    /**
     * Init event extension model
     * @param array $atts
     * @param array $query_args
     */
    public function init($atts = array(), $query_args = array() ) {
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
		$this->attributes = $atts;

		// query
		$default_args = array(
			'post_type' => $this->post_type,
		);
		$query_args = array_merge( $default_args, $query_args );
		// setting
		$this->setting( $query_args);
	}

    /**
     * @param $query_args
     */
    public function setting($query_args ){
		if( !isset( $this->attributes['uniq_id'] ) ) {
			$this->attributes['uniq_id'] = $this->post_type . '-' .SLZ_Com::make_id();
		}
		// query
        if ( function_exists('slz_get_post_hide_event_expired') ) {
            $arr_post_hide['post__not_in'] = slz_get_post_hide_event_expired();
        }

        $list_status_disable = slz_get_db_settings_option( 'list-status-disable', array());
        $tax_status_not_in = array(
            'tax_query' => array(
                array(
                    'taxonomy' => 'slz-event-status',
                    'field'    => 'slug',
                    'terms'    => $list_status_disable,
                    'operator' => 'NOT IN'
                ),
            ),
        );

        $query_args = array_merge($arr_post_hide, $query_args, $tax_status_not_in);
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

    /**
     *
     */
    public function reset(){
		wp_reset_postdata();
	}

    /**
     * @param array $atts
     */
    public function set_responsive_class($atts = array() ) {

	}

    /**
     * Add custom css
     * @return string
     */
    public function add_custom_css() {
		$custom_css = '';
		if( !empty($this->attributes['title_color']) ) {
			$custom_css .= sprintf('.sc_event_block .slz-title-shortcode, .sc_event_carousel .slz-title-shortcode { color: %1$s;}',
								$this->attributes['title_color']
							);
		}
		return $custom_css;
	}

    /**
     * Set default option value from config
     * @param array $html_options
     * @return array
     */
    public function set_default_options($html_options = array() ) {
		$defaults = array(
		    'category'                 => '<div class="slz-category"><span class="text">%1$s</span></div>',
		    'title_info'               => '<div class="slz-title-shortcode">%1$s</div>',
			'title_format'			   => '<a href="%2$s" class="block-title">%1$s</a>',
			'image_format'			   => '<div class="block-image"><a href="%2$s" class="link">%1$s</a></div>',
            'thumb_class' 			   => 'img-responsive img-full',
            'event_description_format' => '<div class="block-description">%1$s</div>',
            'event_block_info'         => '<ul class="block-info">%1$s%2$s</ul>',
            'event_location'           => '<li><a href="javascript:void(0);" class="link place">%1$s</a></li>',
            'event_time'               => '<li><a href="javascript:void(0);" class="link time"><span class="text">%2$s %1$s</span> '. esc_html( 'to', 'slz' ) .' <span class="text">%4$s %3$s</span></a></li>',
            'event_date'               => '<a href="javascript:void(0);" class="link date-event">
		            <span class="date">%1$s</span>
		            <span class="month">%2$s - %3$s</span>
		        </a>',
            'time_format'              => '%1$s:%2$s %3$s',
            'date_format'              => '%2$s %3$s, %1$s',
			'event_ticket_price'   => '<div class="block-price"><span class="title">'. esc_html__( 'Price:', 'slz' ) .'</span><span class="text">'. esc_html__( 'from ', 'slz' ) .'<b>%1$s</b></span></div>',
		    'event_ticket_number'   => '%s',
            'event_ticket_carted'   => '%s',
            'btn_donation_format'   => '<a href="#donate-modal-%1$s" data-id="%2$s" data-toggle="modal" data-target="#donate-modal-%1$s" class="slz-event-donate slz-btn">'. esc_html__('Donation Now', 'slz' ) .'</a>',
            'event_address'         => '<li><a href="javascript:void(0);">%1$s</a></li>',
            'event_start_end'       => '<li><a href="javascript:void(0);">%1$s</a></li>',
            'event_attributes'      => '<li><span class="link place">%1$s : %2$s</span></li>',
            'hide_event_expired'    => ''
        );

		$html_options = array_merge( $defaults, $html_options );
		$this->html_format = $html_options;
		return $html_options;
	}

    /**
     * Get image thumb size
     */
    private function get_thumb_size() {
		if ( isset($this->attributes['image_size']) && is_array($this->attributes['image_size']) ) {
			$this->attributes['thumb-size'] = SLZ_Util::get_thumb_size( $this->attributes['image_size'], $this->attributes );
		}
	}

	/*-------------------- >> Render Html << -------------------------*/

    /**
     * Render HTML by Shortcode
     * @param array $html_options
     */
    public function render_event_sc($html_options = array() ) {
		$this->html_format = $this->set_default_options( $html_options );
		if( $this->query->have_posts() ) {
			$html_options = $this->html_format;
			$inc = 0;
			while ( $this->query->have_posts() ) {
				$this->query->the_post();
				$this->loop_index();
				printf( $html_options['html_format'],
					$this->get_event_date( $html_options ),
					$this->get_image( $html_options ),
					$this->get_title( $html_options ),
					$this->get_event_block_info( $html_options ),
					$this->get_event_description( $html_options  ),
					$inc++,
					$this->post_meta['event_date_range']['from'],
					$this->get_permalink(),
					$this->get_event_location( $html_options ),
					$this->get_meta_price( $html_options ),
					$this->get_title_info($html_options),
					$this->get_category($html_options),
					$this->get_show_more($html_options),
                    $this->get_btn_by_type(),
                    $this->get_event_address($html_options),
                   	$this->get_event_start_to_end_day($html_options)
				);
			}
			$this->reset();
			if( ! empty( $this->attributes['pagination'] ) && $this->attributes['pagination'] == 'yes' ) {
					echo SLZ_Pagination::paging_nav( $this->query->max_num_pages, 2, $this->query );
			}
		}
	}

    public function render_event_ajax($html_options = array() ) {
        $html = '';
        $this->html_format = $this->set_default_options( $html_options );
        if( $this->query->have_posts() ) {
            $html_options = $this->html_format;
            $inc = 0;
            while ( $this->query->have_posts() ) {
                $this->query->the_post();
                $this->loop_index();
                $html .= sprintf( $html_options['html_format'],
                    $this->get_event_date( $html_options ),
                    $this->get_image( $html_options ),
                    $this->get_title( $html_options ),
                    $this->get_event_block_info( $html_options ),
                    $this->get_event_description( $html_options  ),
                    $inc++,
                    $this->post_meta['event_date_range']['from'],
                    $this->get_permalink(),
                    $this->get_event_location( $html_options ),
                    $this->get_meta_price( $html_options ),
                    $this->get_title_info($html_options),
                    $this->get_category($html_options)
                );
            }
            $this->reset();
            return $html;
        }
    }

    /**
     * Render HTML by Shortcode
     * @param array $html_options
     */
    public function render_event_carousel_01($html_options = array() ) {
		$this->html_format = $this->set_default_options( $html_options );
		if( $this->query->have_posts() ) {
			$html_options = $this->html_format;
			$inc = 0;
			$i = intval( $this->attributes['slide_to_show'] );
			if( empty( $i ) ) {
				$i = 1;
			}
			$count = 0;
			while ( $this->query->have_posts() ) {
				$this->query->the_post();
				$this->loop_index();
				if( $count == 0 ) {
					echo '<div class="item">';
						echo '<div class="slz-list-block slz-column-1">';
				}
				printf( $html_options['html_format'],
                    $this->get_event_date( $html_options ),
					$this->get_image( $html_options ),
					$this->get_title( $html_options ),
                    $this->get_event_block_info( $html_options ),
					$this->get_event_description( $html_options  ),
					$inc++,
					$this->post_meta['event_date_range']['from'],
					$this->permalink,
					$this->get_event_location( $html_options ),
					$this->get_meta_price( $html_options ),
                    $this->get_title_info($html_options),
                    $this->get_btn_by_type()
				);
				if( $count == $i-1 ) {
						echo '</div>';
					echo '</div>';
				}
				$count++;
				if( $count == $i ) {
					$count = 0;
				}
			}
			if( $count < $i && $count != 0 ) {
					echo '</div>';
				echo '</div>';
			}

			$this->reset();
			if( ! empty( $this->attributes['pagination'] ) && $this->attributes['pagination'] == 'yes' ) {
                    echo SLZ_Pagination::paging_nav( $this->query->max_num_pages, 2, $this->query );
			}
		}
	}

    public function render_event_single($html_options = array() ) {
		$this->html_format = $this->set_default_options( $html_options );
		if( $this->query->have_posts() ) {
			$html_options = $this->html_format;
			$custom_css = '';
			
			$inc = 0;
			while ( $this->query->have_posts() ) {
				$this->query->the_post();
				$this->loop_index();
				printf( $html_options['html_format'],
					$this->get_image( $html_options ),
					$this->get_title( $html_options ),
					$this->get_event_description( $html_options  ),
					$this->get_event_location( $html_options ),
					$this->get_meta_ticket_price($html_options),
					$this->get_event_time( $html_options ),
					$this->get_banner_countdown( $html_options )
				);
				
				if( !empty( $this->post_meta['banner_image'] ) ) {
					$custom_css .= '.slz-event-countdown-02.slz-single-ticket-banner{ background-image:url('. esc_attr( $this->post_meta['banner_image']['url'] ) .'); }';
					do_action('slz_add_inline_style', $custom_css);
				}
			}
			$this->reset();
		}
	}

    public function render_price_box() {
        $unique_id = SLZ_Com::make_id();
        $item_html = '';
        $price_box = $this->post_meta['price_box'];

        $ticket_carted = get_post_meta( $this->post_id, 'event_ticket_carted', '' );
        if( ! empty( $ticket_carted[0] ) ) {
            $ticket_carted[0] = str_replace( '"', '', $ticket_carted[0] );
            $ticket_carted  = (array) json_decode( $ticket_carted[0] );
        }

        $item_format = '
            <div class="item">
                <div class="slz-pricing-table-01 pricing-box-total-%1$d ">
                    <div class="pricing-header">
                        <div class="title pricing-box-title-%1$d">%2$s</div>
                        %3$s
                    </div>
                    <div class="pricing-body pricing-box-pricing-body-%1$d">
                        %4$s
                    </div>
                    <div class="pricing-footer slz-form-buy-ticket">
                    %5$s
                    </div>
                </div>
            </div>
        ';

        foreach ( $price_box as $idx => $box ) {

            if( $box['ticket_price'] == '' ) {
                continue;
            }

            $ticket_item_html = $price_html = $buy_button = '';
            $ticket_url = empty( $box['ticket_url'] ) ? 'javascript:void(0);' : $box['ticket_url'];
            $ticket_number = $box['ticket_number'];
            $pricing_column = md5( $box['ticket_name'].$box['ticket_price'] );

            if( ! isset( $ticket_carted[$pricing_column] ) ) {
                $ticket_carted[$pricing_column] = 0;
            }

            $price_html = '
                <div class="pricing-section pricing-box-section-'. $idx .'">
                    <sup class="unit"></sup>
                    '. slz_get_currency_format_options( $box['ticket_price'] ) .'
                    <span class="per"></span>
                </div>
            ';

            $event_payment_option = slz_get_db_settings_option( 'event-payment-option' );

            //event_ticket_url
            if( !is_plugin_active( 'woocommerce/woocommerce.php' ) || $event_payment_option == 'customlink' ) {
                $buy_button = '<a href="'. esc_attr( $ticket_url ) .'" class="slz-btn">'. esc_html__( 'Buy ticket', 'slz' ) .'</a>';
            } else {
                if( $box['ticket_number'] == '' || $ticket_carted[$pricing_column] < $ticket_number ) {
                    $buy_button = '
                    <input type="hidden" class="slz_event_post_id" name="slz_event_post_id" value="'. esc_attr( $this->post_id ) .'" />
                    <input type="hidden" class="pricing_column" name="pricing_column" value="'. $pricing_column .'" />
                    <a href="javascript:void(0);" class="slz-btn btn pricing-box-button-'. $idx .' slz_buy_ticket_event_btn slz-buy-ticket-method" style="background-position-x: 0px;">'. esc_html__( 'Buy Ticket', 'slz' ) .'</a>
                ';
                }
            }

            foreach( $box['items'] as $key => $val ) {
                $ticket_item_html .= sprintf( '<div class="pricing-option pricing-box-option-%1$d">&nbsp;%2$s</div>', ++$key, $val['item'] );
            }

            $item_html .= sprintf( $item_format, $idx, $box['ticket_name'], $price_html , $ticket_item_html, $buy_button );
        }

        $html_render = '
            <div class="slz_shortcode slz-pricing-plan-01 pricing_box-'. $unique_id .' ">
                <div class="slz-main-title">
                    <h2 class="title">'. esc_html__( 'Ticket Prices', 'slz' ) .'</h2>
                </div>
                <div class="slz-list-block slz-list-column slz-column-3">
                '. $item_html .'
                </div>
            </div>
        ';

        if( $item_html != '' ) {
            echo $html_render;
        }
    }

	/*-------------------- >> General Functions << --------------------*/
    /**
     * Get event date
     * @param array $html_options
     * @return string
     */
    public function get_event_raised($html_options = array() ) {
    	if (get_post_meta( get_the_ID(), 'slz-donation-raised-money', true ) > 0) {
    		$raise = get_post_meta( get_the_ID(), 'slz-donation-raised-money', true );
    	}else $raise = 0;
    	return slz_get_currency_format_options($raise);
    }


        /**
     * Get event date
     * @param array $html_options
     * @return string
     */
    public function get_event_progressing($html_options = array() ) {
    	$progressing = 0;
        $goal = intval( $this->post_meta['event_goal_donation'] );
        if ( $goal > 0) {
            $raised = intval( get_post_meta( get_the_ID(), 'slz-donation-raised-money', true ) );
            $progressing = ( $raised / $goal )*100;
        }
        return $progressing;
    }

    /**
     * Get event date
     * @param array $html_options
     * @return string
     */
    public function get_event_remaning( $html_options = array() ) {
        $remaining = 0;
        $event_goal_donation = $this->post_meta['event_goal_donation'];
        if( ! empty( $event_goal_donation ) ) {
            $event_goal_donation = intval( $event_goal_donation );
            $donation_raised_money = intval( get_post_meta( get_the_ID(), 'slz-donation-raised-money', true ) );
            if( $event_goal_donation - $donation_raised_money > 0 ) {
                $remaining = $event_goal_donation - $donation_raised_money;
            }
        }
    	return slz_get_currency_format_options( $remaining );
    }

    /**
     * Get event date
     * @param array $html_options
     * @return string
     */
    public function get_event_date($html_options = array() ) {
		$out = '';
		$format = $this->html_format['event_date'];
        if ( ! empty( $html_options['event_date'] ) )
        {
            $format = $html_options['event_date'];
        }
		$start = $this->post_meta['event_date_range']['from'];
        if( ! empty( $start ) ) {
            $day = $this->_get_date( $start, '%3$s');
            $month = $this->_get_date( $start, '%2$s', true);
            $year = $this->_get_date( $start, '%1$s');
            switch ( $day ) {
                case '1':
                    $subfix = 'st';
                    break;
                case '2':
                    $subfix = 'nd';
                    break;
                case '3':
                    $subfix = 'rd';
                    break;
                default:
                    $subfix = 'th';
            }
            if( ! empty( $day ) && ! empty( $month ) && ! empty( $year ) ) {
                $out = sprintf( $format, esc_html( $day ), esc_html( $month ), esc_html( $year ), esc_html( ltrim( $day, '0' ).$subfix ) );
            }
        } else {
            $out = '-';
        }
       	
		return $out;
	}

    /**
     * Get event featured image
     * @param array $html_options
     * @param string $thumb_size
     * @return string
     */
    public function get_image( $html_options = array(), $thumb_size = 'small', $echo = false, $has_image = false ) {
		$out = '';
		if( empty( $html_options ) ) {
			$html_options = $this->html_format;
		}
		if( ! empty( $this->attributes['image_display'] ) && $this->attributes['image_display'] == 'show' )
		{
			$out = $this->get_featured_image( $html_options, $thumb_size,$echo, $has_image );
		}
		return $out;
	}

    /**
     * Get event description
     * @param array $html_options
     * @return string
     */
    public function get_event_description( $html_options = array() ) {
		$out = '';
		$format = $this->html_format['event_description_format'];
		if ( ! empty( $html_options['event_description_format'] ) )
		{
			$format = $html_options['event_description_format'];
		}
		if( ! empty( $this->attributes['description_display'] ) && $this->attributes['description_display'] == 'show' )
		{
		    if( ! empty( $this->post_meta['description'] ) )
            {
                $content = $this->post_meta['description'];
                if (isset($this->attributes['excerpt_length']) && !empty($this->attributes['excerpt_length'])) {
                    $excerpt = intval($this->attributes['excerpt_length']);
                    $excerpt_length = apply_filters( 'excerpt_length', $excerpt );
                    $excerpt_more = apply_filters( 'excerpt_more', ' ' . '[...]' );
                    $content = wp_trim_words( $content, $excerpt_length, $excerpt_more );
                }
                $out = sprintf( $format, $content ) ;
            }
		}
		return $out;
	}

	    /**
     * Get event get_event_goal_donate
     * @param array $html_options
     * @return string
     */
    public function get_event_goal_donate( $html_options = array() ) {
		$out = '';
		    if( !empty( $this->post_meta['event_goal_donation']) )
            {
                $out =  $this->post_meta['event_goal_donation'];

            }else $out = 0;	
		return slz_get_currency_format_options($out);
	}

    /**
     * Get event block info
     * @param array $html_options
     * @return string
     */
    public function get_event_block_info($html_options = array() ) {
        $out = '';
        $format = $this->html_format['event_block_info'];
        if ( ! empty( $html_options['event_block_info'] ) )
        {
            $format = $html_options['event_block_info'];
        }
        $event_time = $this->get_event_time( $html_options );

        $event_location = $this->get_event_location( $html_options );
        if( ! empty( $event_time ) || ! empty( $event_location ) ) {
            $out = sprintf( $format, $event_time, $event_location );
        }
        return $out;
    }

    public function get_title_info( $html_options = array() ) {
        $out = '';
        $format = $this->html_format['title_info'];
        if ( ! empty( $html_options['title_info'] ) ) {
            $format = $html_options['title_info'];
        }
        if ( ! empty( $this->attributes['title'] ) ) {
            $out = sprintf($format, esc_html( $this->attributes['title'] ) );
        }
        return $out;
    }
    public function get_show_more( $html_options = array() ) {
		$out = '';
		if( !empty($this->attributes['showmore_text']) ) {
			$out .= $this->get_btn_more( $html_options );
		}
		return $out;
    }
    public function get_btn_more( $html_options = array(), $echo = false ) {
		$btn_content = SLZ_Com::get_value( $this->attributes, 'showmore_text', esc_html__('Read More', 'slz') );

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
    function  get_category($html_options=array() ) {
        $out = '';
        $format = $this->html_format['category'];
        if ( ! empty( $html_options['category'] ) ){
            $format = $html_options['category'];
        }
        $arr = get_the_terms( $this->post_id, 'slz-event-cat' );
        if (  ! empty( $arr ) && count( $arr ) > 0 ) {
            $cat = '';
            foreach ($arr as $index => $obj) {
                if ($index == 0)
                    $cat.=$obj->name;
                else
                    $cat.= ' - ' . $obj->name;
            }
            $out = sprintf($format, $cat);
        }
        return $out;
    }

    function  get_permalink( $html_options=array() ) {
        $out = '';
        if (isset($this->html_format['permalink']) ) {
            $format = $this->html_format['permalink'];
        }

        if ( empty( $format ) )
        {
           return $this->permalink;
        }
        $out = sprintf($format, $this->permalink);
        return $out;
    }
    /**
     * Get event location
     * @param array $html_options
     * @return string
     */
    public function get_event_location( $html_options = array() ) {
		$out = '';
		$format = $this->html_format['event_location'];
		if ( ! empty( $html_options['event_location'] ) )
		{
			$format = $html_options['event_location'];
		}
		
		$event_location = $this->post_meta['event_location'];
        if( ! empty( $this->attributes['event_location_display'] ) && $this->attributes['event_location_display'] == 'show' ) {
            if( ! empty( $event_location ) ) {
                $out = sprintf( $format, esc_html( $event_location ) );
            }
        }
		return $out;
	}

    /**
     * Get event address return String of address with formated 
     * @param array $html_options
     * @return string
     */
    public function get_event_address( $html_options = array() ) {
		$out = '';
		$format = $this->html_format['event_address'];

		if ( ! empty( $html_options['event_address'] ) )
		{
			$format = $html_options['event_address'];
		}
		$event_address = $this->post_meta['address']['location'];
		
        if( ! empty( $this->attributes['event_address_display'] ) && $this->attributes['event_address_display'] == 'show' ) {
            if( ! empty( $event_address ) ) {

                $out = sprintf( $format, esc_html( $event_address ) );
            }
        }
		return $out;
	}	
    /**
     * Get event time
     * @param array $html_options
     * @return string
     */
    public function get_event_time( $html_options = array() ) {
		$out = '';
        $time_format = $this->html_format['time_format'];
        $date_format = $this->html_format['date_format'];
        $format = $this->html_format['event_time'];
        if ( ! empty( $html_options['time_format'] ) )
        {
            $time_format = $html_options['time_format'];
        }
        if ( ! empty( $html_options['date_format'] ) )
        {
            $date_format = $html_options['date_format'];
        }
        if ( ! empty( $html_options['event_time'] ) )
        {
            $format = $html_options['event_time'];
        }
        if( ! empty( $this->attributes['event_time_display'] ) && $this->attributes['event_time_display'] == 'show' )
        {
            $start = $this->post_meta['event_date_range']['from'];
            $end = $this->post_meta['event_date_range']['to'];
            $start_time = $this->_get_time( $start, $time_format, false);
            $end_time = $this->_get_time( $end, $time_format, false );
            $start_date = $this->_get_date( $start, $date_format, true );
            $end_date = $this->_get_date( $end, $date_format, true );
            if( ! empty( $start_time ) && ! empty( $start_date ) && ! empty( $end_time ) && ! empty( $end_date ) ) {
                $out = sprintf( $format, esc_html( $start_time ), esc_html( $start_date ), esc_html( $end_time ), esc_html( $end_date ) );
            }
        }
		return $out;
	}

    /**
     * Get date from event meta
     * @param $date_string
     * @param $format - 1$ - year, 2$ - month, 3$ - day, display month as short date string
     * @param bool $month_string
     * @return string
     */
    public function _get_date( $date_string, $format, $month_string = false ) {
        $out = '';
        if( ! empty( $date_string ) ) {
            $arr = explode( ' ', $date_string );
            list( $year, $month, $day  ) = explode( '/', $arr[0] );
            if( ! empty( $day ) && ! empty( $month ) && ! empty( $year ) ) {
                if( $month_string ) {
                    $timestamp = new DateTime( '2000-'.$month.'-01' );
                    $month = $timestamp->format( 'M' );
                }
                $out = sprintf( $format, $year, $month, $day );
            }
        }
		return $out;
	}

    /**
     * Get time from event meta
     * @param $date_string
     * @param $format - 1$ - hour, 2$ - minute, 3$ - toggle period
     * @param bool $_24h
     * @return string
     */
    public function _get_time( $date_string, $format, $_24h = true ) {
		$out = $period =  '';
		if( ! empty( $date_string ) ) {
            $arr = explode( ' ', $date_string );
            list( $hour, $minute  ) = explode( ':', $arr[1] );
            if ( ! empty( $hour ) && ! empty( $minute ) ) {
                if( ! $_24h )
                {
                    $period = $hour < 11 ? esc_html( 'AM' ) : esc_html( 'PM' );
                    $hour = $hour > 12 ? $hour - 12 : $hour;
                }
            }
            $out = sprintf( $format, $hour, $minute, $period );
        }
		return $out;
	}
	
	public function get_meta_ticket_price( $html_options = array() ) {
		$out = '';
		$format = $this->html_format['event_ticket_price'];
		if( ! empty( $html_options['event_ticket_price'] ) ) {
			$format = $html_options['event_ticket_price'];
		}
		if( ! empty( $this->post_meta['event_ticket_price'] ) || $this->post_meta['event_ticket_price'] == 0 ) {
			$money_formated = slz_get_currency_format_options( $this->post_meta['event_ticket_price'] );
			$out .= sprintf( $format, esc_html( $money_formated ) );
		}
		
		return $out;
	}

    public function get_meta_ticket_carted( $html_options = array() ) {
        $out = '';
        $format = $this->html_format['event_ticket_carted'];
        if( ! empty( $html_options['event_ticket_carted'] ) ) {
            $format = $html_options['event_ticket_carted'];
        }

        $ticket_carted = get_post_meta( $this->post_id, 'event_ticket_carted', '0' );

        if ( is_array($ticket_carted) && count($ticket_carted) > 0 ) {
            $ticket_carted = $ticket_carted[0];
        } else {
            return $out;
        }

        $out .= sprintf( $format, esc_html( $ticket_carted ) );

        return $out;
    }

    public function get_meta_ticket_number( $html_options = array() ) {
        $out = '';
        $format = $this->html_format['event_ticket_number'];
        if( ! empty( $html_options['event_ticket_number'] ) ) {
            $format = $html_options['event_ticket_number'];
        }
        if( ! empty( $this->post_meta['event_ticket_number'] ) ) {
            $number_ticket = $this->post_meta['event_ticket_number'];
            $out .= sprintf( $format, esc_html( $number_ticket ) );
        }

        return $out;
    }

	
	public function get_btn_buy_ticket( $html_options = array() ) {
		$out = '';
		$event_payment_option = slz_get_db_settings_option( 'event-payment-option' );
		$btn_ticket_text = esc_html__( 'Buy ticket', 'slz' );
		if( isset( $html_options['btn_ticket_text'] ) && !empty( $html_options['btn_ticket_text'] ) ){
			$btn_ticket_text = $html_options['btn_ticket_text'];
		}
		
        //event_ticket_url
		if( !is_plugin_active( 'woocommerce/woocommerce.php' ) || $event_payment_option == 'customlink' ) {
			$buyticket_url = $this->post_meta['event_ticket_url'];
			$out .= '<a href="'. ( empty( $buyticket_url ) ? 'javascript:void(0)' : esc_url( $buyticket_url ) ) .'" class="slz-btn">'. esc_html( $btn_ticket_text ) .'</a>';
			return $out;
		}

		$ticket_number = intval( $this->get_meta_ticket_number() );
		$ticket_carted = intval( $this->get_meta_ticket_carted() );
		if ( ($this->get_meta_ticket_number() != '' && $ticket_carted >= $ticket_number) ){
		    return $out;
        }

		$out .= '<div class="slz-form-buy-ticket slz-buy-ticket-method">';
			$out .= '<input type="text" name="slz_event_post_id" value="'. esc_attr( $this->post_id ) .'" class="slz_event_post_id" hidden />';
			$out .= '<a href="javascript:void(0);" class="slz-btn slz_buy_ticket_event_btn slz-buy-ticket-method">'. esc_html( $btn_ticket_text ) .'</a>';
		$out .= '</div>';
		
		return $out;
	}
	
	public function get_meta_price( $html_options = array() ) {
		$out = '';
		if( !isset( $html_options['price_format'] ) ) {
			$format = '<div class="price">%1$s</div>';
		} else {
		    $format = $html_options['price_format'];
        }

        if( ! slz_ext( 'events' )->get_config( 'is_multiple_price' ) ) {
            $price = $this->post_meta['event_ticket_price'];
        } else {
		    $price = 0;
		    $price_box = $this->post_meta['price_box'];
            if( ! empty( $price_box ) && isset( $price_box[0]['ticket_price'] ) ) {
                $price = $price_box[0]['ticket_price'];
            }
        }

		if( empty( $price ) ) {
			$price = 0;
		}
		$money = slz_get_currency_format_options( $price );
		$out .= sprintf( $format, esc_html( $money ) );
		
		return $out;
		
	}
	
	public function is_remaining_event() {
		
		if( !empty( $this->post_meta['event_date_range'] ) ) {
			$time_db_arr = $this->post_meta['event_date_range'];
			if( isset( $time_db_arr['from'] ) && !empty( $time_db_arr['from'] ) ) {
				$now = time();
				$time_db_arr = explode( ' ', $time_db_arr['from'] );
				$time_db = strtotime( $time_db_arr[0] );
				$datediff = $time_db - $now;
				$count = floor($datediff / (60 * 60 * 24));
				if( $count < 0 ) {
					return false;
				}else{
					return true;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	public function get_banner_countdown( $html_options = array() ) {
		$out = '';
		$format = '
			<div class="slz-event-countdown-02 slz-single-ticket-banner style-1">
				<div class="col-left">
					<div class="coming-soon single-page-comming-soon count-down" data-unique-id="%1$s" data-expire="%2$s" >
						<div class="main-count-wrapper">
							<div class="main-count">
								<div class="time days flip"><span class="count curr top">00</span></div>
								<div class="count-height"></div>
								<div class="stat-label">'.esc_html__( 'days', 'slz' ).'</div>
							</div>
						</div>
						<div class="main-count-wrapper">
							<div class="main-count">
								<div class="time hours flip"><span class="count curr top">00</span></div>
								<div class="count-height"></div>
								<div class="stat-label">'.esc_html__( 'hours', 'slz' ).'</div>
							</div>
						</div>
						<div class="main-count-wrapper">
							<div class="main-count">
								<div class="time minutes flip"><span class="count curr top">00</span></div>
								<div class="count-height"></div>
								<div class="stat-label">'.esc_html__( 'mins', 'slz' ).'</div>
							</div>
						</div>
						<div class="main-count-wrapper">
							<div class="main-count">
								<div class="time seconds flip"><span class="count curr top">00</span></div>
								<div class="count-height"></div>
								<div class="stat-label">'.esc_html__( 'secs', 'slz' ).'</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-right">%3$s %4$s</div>
			</div>
		';
		if( isset( $html_options['banner_format'] ) ) {
			$format = $html_options['banner_format'];
		}
		$status = $this->is_remaining_event();
		if( $status ) {
			$unique_id = SLZ_Com::make_id();
			$out .= sprintf( $format,
				$unique_id,
				$this->post_meta['event_date_range']['from'],
				$this->get_btn_buy_ticket(),
				$this->get_donate_btn( $html_options )
			);
		}
		
		return $out;
	}

	/*
	 * It's Linked with Donate Method!
	 */
	public function get_donate_btn( $html_options = array() ) {
		$out = '';
		$unique_id = SLZ_Com::make_id();
		$donate_payment_option = slz_get_db_settings_option( 'donation-payment-option' );
		$btn_donate_text = esc_html__( 'Donate now', 'slz' );
		if( isset( $html_options['btn_donate_text'] ) && !empty( $html_options['btn_donate_text'] ) ){
			$btn_donate_text = $html_options['btn_donate_text'];
		}

		if( !is_plugin_active( 'woocommerce/woocommerce.php' ) || $donate_payment_option == 'customlink' ){
			$donation_url = $this->post_meta['event_donation_url'];

			$out .= '<a href="'. ( empty( $donation_url ) ? 'javascript:void(0)' : esc_url( $donation_url ) ).'" class="slz-btn slz-event-donate">'. esc_html( $btn_donate_text ) .'</a>';
			return $out;
		}

        $data_price_paypal = (array)slz()->theme->get_config('price_paypal');
        $format_price_paypal = '<div class="donate-item">
                            <input type="radio" name="%1$s" value="%2$s"/>
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

		$out .= '<a href="#donate-modal-'. esc_attr( $unique_id ) .'" data-toggle="modal" data-target="#donate-modal-'. esc_attr( $unique_id ) .'" class="slz-btn slz-event-donate">'. esc_html( $btn_donate_text ) .'</a>';
		$out .= '
			<div id="donate-modal-'. esc_attr( $unique_id ) .'" tabindex="-1" role="dialog" class="modal fade">
				<div role="document" class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" data-dismiss="modal" aria-label="Close" class="close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h4 class="modal-title">'. esc_html__( 'Events Donation', 'slz' ) .'</h4>
						</div>
						<div class="slz-event-donate-submit slz-form-event-donate">
							<div class="modal-body">
								<div class="form-group">
								    <span class="gdlr-head">'.esc_html__('How much would you like to donate?', 'slz').'</span>
									<div class="donation-button-segment-group slz-form-donate">
										<div class="radio">
											'.$html_price_paypal.'
											<div class="donate-item">
												<input type="radio" class="donation-other-price" name="valueDonation" value="100" />
												<div class="label-check another-donation">
													<span class="currencies">'. slz_get_db_settings_option( 'currency-money-format', '$' ) .'</span>
													<input class="form-control" type="text" maxlength="12" name="anotherAmount" />
												</div>
											</div>
										</div>
										<input type="text" name="slz_event_post_id" value="'. esc_attr( $this->post_id ) .'" class="slz_event_post_id" hidden />
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
	/**
	 * [get_btn_by_type description]
	 * @return [type] [description]
	 */
    function get_btn_by_type() {
        $type_btn = '';
        $out ='';
        if (isset($this->attributes['show_btn_buy_ticket'])) {
            $type_btn = $this->attributes['show_btn_buy_ticket'];
        }

        if ($type_btn == 'ticket') {
            $out = $this->get_btn_buy_ticket();
        } else
        if ($type_btn == 'donation'){
            $btn_fomat = '';
            if (isset($this->html_format['btn_donation_format'])) {
                $btn_fomat = $this->html_format['btn_donation_format'];
            }
            $out = sprintf($btn_fomat, $this->attributes['uniq_id'], $this->post_id);
        } else
        if ($type_btn == 'readmore') {
            $out = $this->get_btn_more();
        }
        return $out;
    }

    // get search atts
	public function get_search_atts( &$atts, &$query_args, $search_data ) {
		// search by keyword
		if( isset($search_data['keyword']) && !empty($search_data['keyword']) ){
			$query_args['s'] = $search_data['keyword'];
		}
		
		// search by location
		if( isset($search_data['location']) && !empty($search_data['location']) ){
			$atts['meta_key_compare'][] = array(
							array(
								'key'     => 'slz_option:event_location',
								'value'   => $search_data['location'],
								'compare' => 'LIKE'
							)
						);
		}
		
		// search by start date
		if( isset($search_data['start_date']) && !empty( $search_data['start_date'] ) ) {
			$atts['meta_key']['slz_option:from_date'] = $search_data['start_date'];
		}
	}

    /**
     * [get_format_of_day description]
     * @param  [type] $format_string [description]
     * @param  [type] $date          [description]
     * @return [type]                [description]
     */
    function get_format_of_day($format_string, $date){
    	return date($format_string, $date);
    }
    function get_event_start_to_end_day( $html_options = array() ){
    	$out = '';
		if( empty( $this->attributes['event_time_display'] ) || $this->attributes['event_time_display'] != 'show' ) {
            return $out;
        }
    	$format = $this->html_format['event_start_end'];
		if ( ! empty( $html_options['event_start_end'] ) )
		{
			$format = $html_options['event_start_end'];
		}
    	$start = new DateTime($this->post_meta['event_date_range']['from']);
    	$start_date = $start->format('l, H:i a');
    	$end = new DateTime($this->post_meta['event_date_range']['to']);
    	$end_date = $end->format('l, H:i a'); 
    	$date_is = $start_date . " - " . $end_date;   

	    if (!empty($date_is)) {
	    	$out = sprintf($format, $date_is);
	    }
        return $out;
    }

	/**
	 * Get event attributes
	 * @param  array  $html_options format array
	 * @return string               html
	 */
    function get_event_attributes( $html_options = array() ){
		$out         = '';
		$attributes  = $this->post_meta['event_attributes'];
		$format      = $this->html_format['event_attributes'];

		if ( ! empty( $html_options['event_attributes'] ) ){
			$format = $html_options['event_attributes'];
		}
		if ( !empty( $attributes ) ) {
			foreach ( $attributes as $atts) {
				if( !empty($atts['name']) || !empty( $atts['value'] ) ){
	        		$out .= sprintf($format, $atts['name'], $atts['name']);
	        	}
        	}
		}
        return $out;
    }
    
/**
 * [get_event_gallery description]
 * @return [type] [description]
 */
    function get_event_gallery(){
    	$out    = '';
    	$item   = array();
    	$images = $this->post_meta['gallery_images'];
    	if ( !empty( $images ) ) {
    		foreach ($images as $value) { 
	    		$item[] = '{"img":"'.$value['attachment_id'].'"}';
    		}
    	}
    	if( !empty( $item ) ){
    		$out = '[' . implode( ',' , $item ) . ']';
    		$out = urlencode($out);
    	}
    	return $out;
    }
}