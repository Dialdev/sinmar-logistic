<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Forbidden' ); }

$arr_column = array(
	'style-1' => 'column-3',
	'style-2' => 'column-4',
	'style-3' => 'column-5',
	'style-4' => 'column-5',
	'style-5' => 'column-5',
	'style-6' => 'column-5',
	'style-7' => 'column-3',
	'style-8' => 'column-3',
	'style-9' => 'column-5',
	'style-10'=> 'column-4',
	'style-11'=> 'column-3',
	'style-12'=> 'column-5'
);

$arr_limit = array(
	'style-1' => 7,
	'style-2' => 7,
	'style-3' => 9,
	'style-4' => 10,
	'style-5' => 8,
	'style-6' => 8,
	'style-7' => 5,
	'style-8' => 9,
	'style-9' => 8,
	'style-10' => 8,
	'style-11' => 6,
	'style-12' => 10
);
$limit_options = array(
	'style-8' => 9,
	'style-10' => 8,
	'style-12' => 10,
);
$class_col = $arr_column[$data['style']];
$data['limit_post'] = intval($data['limit_post']);
if( !isset($limit_options[$data['style']]) || empty($data['limit_post']) ) {
	$data['limit_post'] = $arr_limit[$data['style']];
}
$query_args = array(
	'meta_query' => array(
		array(
			'key'     => '_thumbnail_id',
			'value'   => '',
			'compare' => '!='
		)
	)
);
$model = new SLZ_Gallery();
$model->init( $data, $query_args );

$css = $custom_css = '';
$uniq_id = $model->attributes['uniq_id'];
$data_json = json_encode( $model->attributes );
$block_cls = $model->attributes['extra_class'] . ' ' . $uniq_id;
$model->attributes['paged'] = 2;

$slz_isotop_grid = 'slz-isotope-grid-2';

if ( $model->attributes['post_type'] == 'slz-gallery' ) {
	$html_format = '
		<div class="grid-item %6$s %10$s">
			<div class="slz-block-gallery-01 style-1">
				<div class="block-image">
					<a href="%11$s" class="link fancybox-thumb">
						%1$s
						<span class="dh-overlay"></span>
					</a>
				</div>
			</div>
		</div>
	';
}else{
	$html_format = '
		<div class="grid-item %6$s %10$s">
			<div class="slz-block-gallery-01 style-1">
				<div class="block-image">
					<a href="%11$s" class="link fancybox-thumb">
						%1$s
					</a>
				</div>
				<div class="block-content">
					<div class="block-content-wrapper">
						%9$s
						%7$s
						%2$s
						%8$s
						%5$s
						%4$s
						%3$s
					</div>
				</div>
			</div>
		</div>
	';	
}


$html_render['html_format'] = $html_format;
?>
<div class="slz-shortcode sc_isotope_post <?php echo esc_attr( $block_cls ); ?>" data-block-class=".<?php echo esc_attr( $uniq_id ); ?>">
	<?php
		$model->render_filter_type( $model->attributes );
	?>
	<div class="<?php echo esc_attr($slz_isotop_grid); ?>  grid-main <?php echo esc_attr( $class_col ); ?>">
			<?php
				$model->render_isotope_post( $html_render ); 
			?>

	</div>
	<div class="grid-clone hide">
		<?php
			$model->render_isotope_post( $html_render ); 
		?>
		<div data-pages="1" data-json="<?php echo esc_attr( json_encode( $model->attributes ) ); ?>" class="gallery_atts_more hide"></div>
	</div>
	<?php
		if( !empty($model->attributes['load_more_btn_text']) && ( $model->query->found_posts > $data['limit_post'] ) ) {
	?>
			<div class="btn-loadmore-wrapper">
				<a href="javascript:void(0)" class="slz-btn btn-loadmore"><?php echo esc_html( $model->attributes['load_more_btn_text'] ); ?></a>
			</div>
	<?php
		}
	?>
</div>

<?php

if ( $model->attributes['post_type'] == 'slz-portfolio' ) {
	/* category color */
	if ( !empty( $model->attributes['cat_color'] ) ) {
		$css = '
			.%1$s .block-category{
				color: %2$s;
			}
		';
		$custom_css .= sprintf( $css, esc_attr( $uniq_id ), esc_attr( $model->attributes['cat_color'] ) );
	}

	/* title color */
	if ( !empty( $model->attributes['title_color'] ) ) {
		$css = '
			.%1$s .block-title{
				color: %2$s;
			}
		';
		$custom_css .= sprintf( $css, esc_attr( $uniq_id ), esc_attr( $model->attributes['title_color'] ) );
	}

	/* title hover color */
	if ( !empty( $model->attributes['title_color_hover'] ) ) {
		$css = '
			.%1$s a.block-title:hover{
				color: %2$s;
			}
		';
		$custom_css .= sprintf( $css, esc_attr( $uniq_id ), esc_attr( $model->attributes['title_color_hover'] ) );
	}

	/* meta data color */
	if ( !empty( $model->attributes['meta_data_color'] ) ) {
		$css = '
			.%1$s ul.block-info li a.link{
				color: %2$s;
			}
		';
		$custom_css .= sprintf( $css, esc_attr( $uniq_id ), esc_attr( $model->attributes['meta_data_color'] ) );
	}

	/* meta data hover color */
	if ( !empty( $model->attributes['meta_data_hover_color'] ) ) {
		$css = '
			.%1$s ul.block-info li a:hover{
				color: %2$s;
			}
		';
		$custom_css .= sprintf( $css, esc_attr( $uniq_id ), esc_attr( $model->attributes['meta_data_hover_color'] ) );
	}

	/* description color */
	if ( !empty( $model->attributes['description_color'] ) ) {
		$css = '
			.%1$s .block-text{
				color: %2$s;
			}
		';
		$custom_css .= sprintf( $css, esc_attr( $uniq_id ), esc_attr( $model->attributes['description_color'] ) );
	}

	/* read more btn color */
	if ( !empty( $model->attributes['readmore_btn_color'] ) ) {
		$css = '
			.%1$s a.block-read-mores{
				color: %2$s;
			}
		';
		$custom_css .= sprintf( $css, esc_attr( $uniq_id ), esc_attr( $model->attributes['readmore_btn_color'] ) );
	}

	/* read more btn hover color */
	if ( !empty( $model->attributes['readmore_btn_hover_color'] ) ) {
		$css = '
			.%1$s a.block-read-mores:hover{
				color: %2$s
			}
		';
		$custom_css .= sprintf( $css, esc_attr( $uniq_id ), esc_attr( $model->attributes['readmore_btn_hover_color'] ) );
	}

	/* zoom in btn color */
	if ( !empty( $model->attributes['zoomin_btn_color'] ) ) {
		$css = '
			.%1$s .slz-block-gallery-01 .block-content a.block-zoom-img{
				color: %2$s;
			}
		';
		$custom_css .= sprintf( $css, esc_attr( $uniq_id ), esc_attr( $model->attributes['zoomin_btn_color'] ) );
	}

	/* zoom in btn hover color */
	if ( !empty( $model->attributes['zoomin_btn_hover_color'] ) ) {
		$css = '
			.%1$s .slz-block-gallery-01 .block-content a.block-zoom-img:hover{
				color: %2$s;
			}
		';
		$custom_css .= sprintf( $css, esc_attr( $uniq_id ), esc_attr( $model->attributes['zoomin_btn_hover_color'] ) );
	}

	if ( !empty( $custom_css ) ) {
		do_action('slz_add_inline_style', $custom_css);
	}
}