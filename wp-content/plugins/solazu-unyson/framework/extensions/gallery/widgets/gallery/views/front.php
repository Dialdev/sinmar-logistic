<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }
$column_class = (empty($column))?'':$column;

$atts = array(
		'limit_post'  => $limit_post,
		'post_type'   => $post_type,
		'image_size'  => $image_size
		);

if( !empty( $cat_id ) ){
	$arr_cat_id = explode( ',', rtrim( $cat_id, ',' ) );
	$category_slug = array();
	foreach( $arr_cat_id as $value ){
		if( !empty( $value ) ){
			$term = SLZ_Com::get_tax_options_by_id( $value, $post_type . '-cat' );
			if( $term ){
				$category_slug[] = $term->slug;
			}
		}
	}
	if( !empty( $category_slug ) ){
		$atts['category_slug'] = $category_slug;
	}
}

switch ($post_type) {
	case 'slz-gallery':
		$model = new SLZ_Gallery();
		break;
	case 'slz-portfolio':
		$model = new SLZ_Portfolio();
		break;
	default:
		$model = new SLZ_Gallery();
		break;
}

$model->init($atts);
$html_render['thumbnail_format'] = '<img class="img-responsive" src="%1$s">';
$html_render['fancybox_size'] = array('1200','600');
$id = $model->get_uniq_id();

$model->html_format = $html_render;
$thumb_size = 'large';
$output = '';
if( $model->query->have_posts() ) {
	while ( $model->query->have_posts() ) {
		$model->query->the_post();
		$model->loop_index();
		$html_options = $model->html_format;
		if( $image = $model->get_featured_image( $html_options, $thumb_size, false, false )) {
			$full_url = $model->get_feature_img_url_full();
			$output .= '<li><a href="'.esc_url($full_url).'"  class="thumb fancybox-thumb" data-fancybox-group="wg-gallery-'.esc_attr($id).'">'.$image.'</a></li>';
		}
	}
	$model->reset();
}
echo $before_widget;?>
	<div class="wg-gallery wg-gallery-<?php echo esc_attr($id);?>" data-block-class="wg-gallery-<?php echo esc_attr($id);?>">
	<?php echo wp_kses_post($title); ?>
	<div class="widget-content">
		<?php if( $output ):
			echo '<ul class="list-unstyled list-inline '. esc_attr($column_class).'">'.$output.'</ul>';
		endif;
		?>
	</div>
	</div>
<?php echo $after_widget;?>