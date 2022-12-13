<?php if ( ! defined( 'ABSPATH' ) ) {
    die('Forbidden');
}
$post_type = 'slz-event';
$limit_post = $instance['limit_post'];
$offset_post = $instance['offset_post'];
$title = $instance['title'];
$cat_id = $instance['cat_id'];

$atts = array(
    'limit_post'                => $limit_post,
    'offset_post'               => $offset_post,
	'image_size'                => $image_size,
    'image_display'             => 'show',
    'countdown_display'         => 'show',
    'slide_to_show'             => '1',
    'slide_autoplay'            => 'yes',
    'slide_dots'                => 'yes',
    'slide_arrows'              => 'yes',
    'slide_infinite'            => 'yes',
    'slide_speed'               => '600',
    'post_id'                   => '',
    'method'                    => 'cat',
    'event_time_display'        => 'show',
    'event_location_display'    => 'show',
    'description_display'       => 'show',
);

if( !empty( $cat_id ) ) {
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

$model = new SLZ_Event();
$model->init( $atts );

$unique_id = SLZ_Com::make_id();

$html_render = array();
$html_render['image_format'] = '<a href="%2$s" class="link">%1$s</a>';
$html_render['thumb_class']  = 'img-full';
$html_render['event_date']   = '<span class="date">%2$s %1$s,%3$s</span>';
$html_render['title_format'] = '<h2 class="title">%1$s</h2>';
$html_format = '
	<div class="item">
		<div class="slz-event-countdown-01 style-1">
			<div class="block-image">
				%2$s
				<div class="event-desc">
					%1$s
					%3$s
				</div>
			</div>';
if( ! empty( $atts['countdown_display'] ) && $atts['countdown_display'] == 'show' )
{
    $html_format .=	'
        <div class="coming-soon count-down" data-expire="%7$s">
            <div class="main-count-wrapper">
                <div class="main-count">
                    <div class="time days flip">
                        <span class="count curr top">00</span>
                    </div>
                    <div class="count-height"></div>
                    <div class="stat-label">'.esc_html( 'days', 'slz' ).'</div>
                </div>
            </div>
            <div class="main-count-wrapper">
                <div class="main-count">
                    <div class="time hours flip">
                        <span class="count curr top">00</span>
                    </div>
                    <div class="count-height"></div>
                    <div class="stat-label">'.esc_html( 'hours', 'slz' ).'</div>
                </div>
            </div>
            <div class="main-count-wrapper">
                <div class="main-count">
                    <div class="time minutes flip">
                        <span class="count curr top">00</span>
                    </div>
                    <div class="count-height"></div>
                    <div class="stat-label">'.esc_html( 'mins', 'slz' ).'</div>
                </div>
            </div>
            <div class="main-count-wrapper">
                <div class="main-count">
                    <div class="time seconds flip">
                        <span class="count curr top">00</span>
                    </div>
                    <div class="count-height"></div>
                    <div class="stat-label">'.esc_html( 'secs', 'slz' ).'</div>
                </div>
            </div>
        </div>
        ';
}
$html_format .= '
        </div>
	</div>
';

$html_render['html_format'] = $html_format;


echo $before_widget; ?>
    <div class="wg-events wg-events-<?php echo esc_attr( $unique_id ); ?>"
         data-block-class="wg-events-<?php echo esc_attr( $unique_id ); ?>">
        <div class="title-widget widget-title"><?php echo wp_kses_post( $title ); ?></div>
        <div class="widget-content event-slider">
            <div class="carousel-overflow">
                <div class="slz-carousel widget_carousel" data-slidestoshow="<?php echo esc_attr( $atts['slide_to_show'] ); ?>" data-autoplay="<?php echo esc_attr( $atts['slide_autoplay'] ); ?>" data-isdot="<?php echo esc_attr( $atts['slide_dots'] ); ?>" data-isarrow="<?php echo esc_attr( $atts['slide_arrows'] ); ?>" data-infinite="<?php echo esc_attr( $atts['slide_infinite'] ); ?>" data-speed="<?php echo esc_attr( $atts['slide_speed'] ); ?>">
                    <?php $model->render_event_sc( $html_render ); ?>
                </div>
            </div>
        </div>
    </div>
<?php
echo $after_widget;
?>