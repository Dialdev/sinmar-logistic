<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Forbidden' ); }
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
					<div class="block-date">
		                  %1$s
                    </div>
					%3$s
				</div>
			</div>';
if( ! empty( $data['countdown_display'] ) && $data['countdown_display'] == 'show' )
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
?>
<div class="carousel-overflow">
	<div class="slz-carousel" data-slidestoshow="<?php echo esc_attr( $data['slide_to_show'] ); ?>" data-autoplay="<?php echo esc_attr( $data['slide_autoplay'] ); ?>" data-isdot="<?php echo esc_attr( $data['slide_dots'] ); ?>" data-isarrow="<?php echo esc_attr( $data['slide_arrows'] ); ?>" data-infinite="<?php echo esc_attr( $data['slide_infinite'] ); ?>" data-speed="<?php echo esc_attr( $data['slide_speed'] ); ?>">
		<?php $model->render_event_sc( $html_render ); ?>
	</div>
</div>
