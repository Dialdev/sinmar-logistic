<?php
class SLZ_Recruitment extends SLZ_Custom_Posttype_Model {

	private $post_type = 'slz-recruitment';
	private $post_taxonomy = 'slz-recruitment-cat';

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
			'recruit_type'     => '',
			'salary'           => '',
			'location'         => '',
			'expired_date'     => '',
			'more_info'        => '',
			'img'              => '',
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
		if( !empty( $this->attributes['title_color'] ) ) {
			$custom_css .= sprintf('.%1$s .slz-cv-wrapper .slz-title-shortcode { color: %2$s;}',
									$uniq_id, $this->attributes['title_color']
								);
		}
		if( !empty( $this->attributes['active_color'] ) ) {
			$custom_css .= sprintf('.%1$s .cv-navigation ul.slz-categories li.active a { color: %2$s;}',
									$uniq_id, $this->attributes['active_color']
								);
		}
		return $custom_css;
	}

	public function set_default_options( $html_options = array() ) {
		$defaults = array(
			'image_format'           => '<a href="%2$s" class="link">%1$s</a>',
			'title_format'           => '<a class="block-title" href="%2$s">%1$s</a>',
			'btn_format'      		 => ' <a href="%2$s" class="block-read-more" %3$s>
                                                <i class="fa fa-long-arrow-right"></i>%1$s
                                            </a>',
			'thumb_class'            => 'img-responsive',
			'salary_format'          => '<li class="salary"><i class="fa fa-money"></i> %1$s</li>',
			'location_format'        => '<li class="location"><i class="fa fa-map-marker "></i>%1$s</li>',
			'expired_date_format'    => '<li class="date-post"><i class="fa fa-calendar-times-o"></i>%1$s</li>',
			'recruit_type_format'    => '<div class="block-label ribbon-box">
                    <div class="text"><span>%1$s</span></div>
                </div>',
            'more_info_format'       => '<li class="more-info"><span class="info-title">%2$s: </span><span class="info-value">%1$s</span></li>',
            'thumbnail_format'       => '<a href="%2$s" class="link">%1$s</a>',
		);

		$html_options = array_merge( $defaults, $html_options );
		return $html_options;
	}

	/*-------------------- >> General Functions << --------------------*/
	public function get_meta_image_upload( $thumb_size = 'large' , $option ) {
		$out = '';
		$format = $this->html_format['thumbnail_format'];
		$img = $this->get_meta_image( $thumb_size, false, false );
		if( empty( $img ) ) {
			if( $img = $this->get_featured_image($option) ){
				return $img;
			}
		} else {
			return $img;
		}
		return $out;
	}
	public function get_meta_image( $thumb_type = 'large', $echo = false, $has_image = true ) {
		$html_options = $this->html_format;
		$output = $thumb_img = '';
		$format = '%1$s';
		if( isset( $html_options['thumbnail_format'] ) ) {
			$format = $html_options['thumbnail_format'];
		}
	
		$href_class = SLZ_Com::get_value( $html_options, 'thumbnail_href_class' );
		$thumb_class = SLZ_Com::get_value( $html_options, 'thumbnail_class', 'img-responsive' );
	
		$attrArr = array( 'class' => $thumb_class );
		if( empty( $this->attributes['thumb-size'] ) ) {
			$this->attributes['thumb-size'] = array(
				'large'          => 'post-thumbnail',
				'small'          => 'post-thumbnail',
			);
		}
		$thumb_size = $this->attributes['thumb-size'][$thumb_type];
        $thumb_id = $this->post_meta['img'];

        if (is_array($this->post_meta['img']) && isset($this->post_meta['img']['attachment_id'])) {
            $thumb_id = $this->post_meta['img']['attachment_id'];
        }

        if ($thumb_id) {
            // regenerate if not exist.
            $helper = new SLZ_Image();
            $helper->regenerate_attachment_sizes($thumb_id, $thumb_size);
            $thumb_img = wp_get_attachment_image($thumb_id, $thumb_size, false, $attrArr);
        }
        if (empty($thumb_img) && $has_image) {
            $thumb_img = SLZ_Util::get_no_image($this->attributes['thumb-size'], $this->cur_post, $thumb_type);
        }
        if ($thumb_img) {
            //1: img, 2: url, 3: url class
            $output = sprintf($format, $thumb_img, $this->permalink, $href_class);
            if ($echo) {
                echo wp_kses_post($output);
            } else {
                return $output;
            }
        }

	}
	public function get_description() {
		$output = '';
		$des_type = $this->attributes['description'];
		if( $des_type == 'content' ){
			$output = $this->get_content( array() );
		}
		else{
			$output = $this->get_excerpt( array() );
		}
		return $output;
	}
	public function get_apply_button() {
		$out = $other_atts = '';
		$format = $this->html_format['btn_format'];
		if ( !empty($this->attributes['button_text']) ) {
			$button_text = $this->attributes['button_text'];
			$button_link = $this->permalink;
			if( !empty($this->attributes['button_link'])){
				$link = SLZ_Util::parse_vc_link($this->attributes['button_link']);
				if( !empty($link['url'])) {
					$button_link = $link['url'];
					$other_atts = $link['other_atts'];
				}
			}else{
				$link = $this->permalink;
			}
			$out  = sprintf($format, esc_html($button_text), esc_url($button_link), $other_atts);
		}
		return $out;
	}

	public function get_post_date() {
		
		$post_time = get_the_date('U');
		$current_time = current_time( 'timestamp' );
		$subtract_time = $current_time - $post_time;
		$days = ( 60*60*24*5 ); // 5 days
		if( $subtract_time > $days ){
			$out =  get_the_date();
		}
		else {
			$out = sprintf('%1$s %2$s %3$s',
					esc_html__( 'Posted', 'slz' ),
					human_time_diff( get_the_date( 'U' ), current_time( 'timestamp' ) ),
					esc_html__( 'ago', 'slz' )
			);
		}
		return $out;

	}
	public function get_more_info() {
		$info = $out =  '';
		$info_arr = $this->post_meta['more_info'];
		$format = $this->html_format['more_info_format'];
        if( !empty($info_arr)){
	        foreach ($info_arr as $key => $info) {
	        	$label = $value = '';
	        	if(!empty($info['info_name'])){
	        		$label = $info['info_name'];
	        	}
	        	if(!empty($info['info_value'])){
	        		$value = $info['info_value'];
	        	}
	        	$out .= sprintf($format,$value,$label);
	        }
    	}
    	return $out;
	}
	public function get_salary() {

		$salary = $out =  '';
		$salary = $this->post_meta['salary'];
		$format = $this->html_format['salary_format'];
        if( !empty($salary)):
          $out .= sprintf($format,$salary);
    	endif;
    	return $out;

	}
	public function get_recruit_type($index = ''){

		$recruit_type = $out =  '';
		$recruit_type =  get_term_by('slug', $this->post_meta['recruit_type'], 'slz-recruitment-type', ARRAY_A );
		$format = $this->html_format['recruit_type_format'];
        if( !empty($recruit_type['name'])):
          $out .= sprintf($format,$recruit_type['name'], esc_attr($index));
    	endif;
    	return $out;
	}
	public function get_location(){

		$location = $out =  '';
		$location = $this->post_meta['location'];
		$format = $this->html_format['location_format'];
		if( !empty($location)):
			$out .= sprintf($format,$location);
		endif;
		return $out;

	}
	public function get_expired_date(){
		$expired_date = $out =  '';
		$expired_date = $this->post_meta['expired_date'];
		$format = $this->html_format['expired_date_format'];
		if( !empty($expired_date)):
			$expired_date = SLZ_Util::format_date( $expired_date );
			$out = sprintf($format, $expired_date);
		endif;
		return $out;
	}

	public function get_meta_info(){
		$out = '';
		if(!empty($this->attributes['show_location'])){
			$out .= $this->get_location();
		}
		if( !empty($this->attributes['show_salary'])){
			$out .= $this->get_salary();
		}
		if(!empty($this->attributes['show_expired_date'])){
			$out .= $this->get_expired_date();
		}
		if(!empty($this->attributes['show_more_info'])){
			$out .= $this->get_more_info();
		}
		if(!empty($this->attributes['show_working_type'])){
			$out .= $this->get_recruit_type();
		}
		return $out;

	}
    public function render_filter_list( $atts = array(), $html_options, $id )
    {
        $output = $output_grid = '';

        $format = '<li class="%4$s tab_item" role="presentation">
                    <a class="link" href="#%2$s" data-toggle="tab" role="tab"  aria-expanded="%3$s">%1$s</a></li>';

        $count = 0;
        $uniq_id = '';

        $this->html_format = $this->set_default_options($html_options);
        if ($this->query->have_posts()) {
            while ($this->query->have_posts()) {
                $this->query->the_post();
                $this->loop_index();
                $count++;
                $classActive = $classFadeActive = '';
                $expanded = 'false';
                $uniq_id = 'recruitment-tab-' . SLZ_Com::make_id();
                if ($count == 1) {
                    $classActive = 'active';
                    $expanded = 'true';
                    $classFadeActive = 'in active';
                }

                $output .= sprintf($format,
                    esc_html( $this->get_title( $html_options ) ),
                    esc_attr( $uniq_id ),
                    esc_attr( $expanded ),
                    esc_attr( $classActive )
                );

                $model = new SLZ_Recruitment();
                $model->init($atts);
                $grid = $model->render_recruitment_list($this->post_id, $html_options);

                $output_grid .= sprintf('<div id="%2$s" role="tabpanel" class="tab-pane fade %3$s">%1$s</div>',
                    $grid,
                    $uniq_id,
                    $classFadeActive
                );

            }
        }
        return array($output, $output_grid);
    }

	public function render_filter_tab( $atts = array(), $html_options, $id ) {
		$output = $output_grid = '';
		$taxonomy = $this->taxonomy_cat;
		$format = '<li class="%5$s tab_item" role="presentation" ><a class="link" href="#tab-%3$s" role="tab" data-toggle="tab" aria-expanded="%4$s" data-slug="%1$s">%2$s</a></li>';

		$args = array(
			'pad_counts ' 	=> 1,
			'slug' 			=>  $this->attributes['category_slug'],
		);
		$terms = get_terms( $taxonomy, $args );
		$tab_id = '';
		$array_cat = array();
			if ($terms && ! is_wp_error($terms)) {
				foreach( $terms as $key => $term ) {
					$classActive = $classFadeActive = '';
					$expanded = 'false';
					$tab_id = $id . '-' . $term->slug;
					if ( $key == 0 ) {
						$classActive = 'active';
						$expanded = 'true';
						$classFadeActive = 'in active';
					}else{
						$array_cat[$key-1] = array('id'=>$tab_id,'cat'=> $term->slug);
					}
					
					$json_data = esc_attr( json_encode($atts) );
					$output .= sprintf( $format,
							esc_attr( $term->slug),
							esc_html( $term->name ),
							esc_attr( $tab_id ),
							esc_attr( $expanded ),
							esc_attr( $classActive )
					);
					if($key == 0){
						$atts['category_slug'] = $term->slug;
						$model = new SLZ_Recruitment();
						$model->init( $atts );
						$grid = $model->render_recruiment_tab( '',$html_options );
						
						$output_grid .= sprintf('<div id="tab-%2$s" class="tab-pane fade  %3$s" role="tabpanel"><div class=" cv-content">%1$s</div></div>',
								$grid,
								$tab_id,
								$classFadeActive
						);
						
					}
					
				}
			}
		return array( $output, $output_grid, $array_cat );
	}

	public function render_recruitment_list( $post_id ='', $html_options = array() ) {
        $output = '';
        $this->html_format = $this->set_default_options( $html_options );
        if( $this->query->have_posts($post_id) ) {
                $this->get_custom_post( $post_id );
                $html_options = $this->html_format;
                $output .= sprintf( $html_options['html_format'],
                    $this->get_featured_image($html_options),
                    $this->get_title($html_options),
                    $this->get_recruit_type(),
                    $this->get_expired_date(),
                    $this->get_salary(),
					$this->get_location(),
                    $this->get_description(),
                    $this->get_apply_button()
                );

        }
        return $output;
    }

	public function render_recruiment_tab( $post_id ='', $html_options = array() ) {
		$output = '';
		$this->html_format = $this->set_default_options( $html_options );
		if( $this->query->have_posts() ) {
			while ( $this->query->have_posts() ) {
				$this->query->the_post();
				$this->loop_index();
				$html_options = $this->html_format;
				$output .= sprintf( $html_options['html_format'],
					$this->get_featured_image($html_options),
					$this->get_title($html_options),
					$this->get_recruit_type(),
					$this->get_expired_date(),
					$this->get_salary(),
					$this->get_description(),
					$this->get_apply_button(),
					$this->get_location()
				);
			}
			
			$this->reset();
		}
		return $output;
	}

}