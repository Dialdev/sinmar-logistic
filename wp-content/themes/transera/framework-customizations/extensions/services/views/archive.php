<?php if ( ! defined( 'SLZ' ) ) die( 'Forbidden' ); ?>
<?php
/**
 * The template for displaying the service archive content
 *
 */

get_header();
$slz_container_css = slz_extra_get_container_class();

$atts = array(
			'layout'      => 'layout-2',
			'style'       => 'style-1',
			'show_icon'   => 'feature-image',
			'column'      => '3',
			'pagination'  => 'yes',
			'limit_post'  => get_option('posts_per_page'),
			'description' => 'archive',
			'btn_more'    => 'yes',
			'btn_content' => esc_html__('Read More', 'transera')
		);
if( is_tax( 'slz-service-cat' ) ){
	$queried_object = get_queried_object();
	$atts['category_slug'] = $queried_object->slug;
}
if ( ! $slz_container_css['show_sidebar'] ){
	$atts['column'] = '4';
}
$model = new SLZ_Service();
$model->init( $atts );

$html_format = '
    <div class="item service-item">
        <div class="slz-icon-box-2 theme-'. esc_attr( $model->attributes['style'] ) .'">
            <div class="icon-cell">
                %1$s
                <div class="item-description">
                	%3$s
                	<a href="" class="item-description__button">Узнать больше</a>
                </div>
            </div>
            <div class="content-cell">
                <div class="wrapper-info">
                    %2$s
                </div>
            </div>
        </div>
    </div>
';
$html_render =  array( 'html_format' => $html_format );
?>
<script>
	jQuery(function(){
		console.log('Шаблон услуг: /wp-content/themes/transera/framework-customizations/extensions/services/views')
		jQuery('.item.service-item').each(function() {
			href = jQuery(this).find('a.title').attr('href');
			jQuery(this).find('.item-description__button').attr('href', href);
		});
        jQuery('a[href="http://sinmarlogistic.ru/service/perevozka-negabaritnogo-gruza/"]').parents('.service-item').detach().appendTo('.sc-service-list');
	})
</script>
<div class="slz-title-command page-title-area service-title-block">
	<div class="container">
		<div class="title-command-wrapper">
			<h1 class="title">Услуги</h1>
		</div>
		<a class="my slz-btn fancybox-inline" href="#contact_form_pop"> Оформить заявку </a>
	</div>
</div>
<div class="slz-main-content padding-top-100 padding-bottom-100">
	<div class="container">
		<div class="slz-services-archive <?php echo esc_attr( $slz_container_css['sidebar_layout_class'] ); ?>">
			<div class="slz-main-title service-title-h2">
				<h2 class="title">Услуги</h2>
				<img width="285" height="40" src="/wp-content/uploads/2016/11/titleitem.png" class="attachment-full size-full" alt="">
			</div>
			<div class="row">
				<div id="page-content" class="slz-content-column <?php echo esc_attr( $slz_container_css['content_class'] ); ?>">
					<div class="service-archive-wrapper">
						<div class="sc-service-list slz-list-block <?php echo esc_attr($model->attributes['responsive-class']); ?>">
							<?php $model->render_list( $html_render ); ?>
						</div>
					</div>

				</div>
				<?php if ( $slz_container_css['show_sidebar'] ) :?>
					<div id='page-sidebar' class="slz-sidebar-column slz-widgets <?php echo esc_attr( $slz_container_css['sidebar_class'] ); ?>">
						<?php dynamic_sidebar( $slz_container_css['sidebar'] ); ?>
					</div>
				<?php endif; ?>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>