<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }
$column_class = (empty($column))?'':$column;
 
 

$atts = array(
        'limit_post'      => $limit_post,
        'image_size'      => $image_size,
        'post_type'       => 'slz-gallery'
        );

if( !empty( $cat_id ) ){
    $arr_cat_id = explode( ',', rtrim( $cat_id, ',' ) );
    $category_slug = array();
    foreach( $arr_cat_id as $value ){
        if( !empty( $value ) ){
            $term = SLZ_Com::get_tax_options_by_id( $value, 'slz-gallery-cat' );
            if( $term ){
                $category_slug[] = $term->slug;
            }
        }
    }
   
    if( !empty( $category_slug ) ){
        $atts['category_slug'] = $category_slug;

    }
}

$model = new SLZ_Gallery();

$model->init($atts);
$uniq_id = SLZ_Com::make_id();
$html_format = '
<div class="item">
	<a href="%1$s" data-fancybox-group="photos-'. $uniq_id .'" class="thumb fancybox">%2$s<span class="dh-overlay"></span></a>
</div>
';
$html_render['html_format'] = $html_format;
$html_render['fancybox_size'] = array(100,100);

echo $before_widget;?>
<div class="slz-carousel-photos">
	<?php echo wp_kses_post($title); ?>
	<div data-slidestoshow="<?php echo esc_attr($slides_to_show); ?>" class="slz-carousel">
			<?php $model->render_widget_image_slider($html_render); ?>
	</div>
</div>
<?php echo $after_widget;?>