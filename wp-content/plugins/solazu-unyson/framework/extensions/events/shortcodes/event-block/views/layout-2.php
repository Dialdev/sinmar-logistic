<?php
$html_render = array();
$html_format = '
	<div class="item">
            <div class="slz-event-01">
                <div class="event-wrapper">
                    %1$s
                    <div class="event-info info">
                        <div class="info-wrapper">
                            %2$s
                            <div class="info-content">
                                %3$s
                                %5$s
                            </div>
                        </div>
                    </div>
                    %9$s
                    <div class="event-info price">
                        <div class="unit">ticket</div>
                        <div class="number">%10$s</div>
                    </div>
                    <div class="event-info button">
                        <a href="%8$s" class="slz-btn"> <span class="btn-text">'. esc_html__( 'book now', 'slz' ) .'</span><span class="btn-icon fa fa-arrow-right"></span></a>
                    </div>
                </div>
            </div>
        </div>
';
$html_render['html_format'] = $html_format;
$html_render['event_date'] = '
    <div class="event-info time">
        <div class="date">%1$s</div>
        <div class="month">%2$s</div>
        <div class="year">%3$s</div>
    </div>
';
$html_render['title_format'] = '
    <div class="title-wrapper"><a href="%2$s" class="title">%1$s</a></div>
';
$html_render['thumb_class'] = 'thumb-img';
$html_render['event_description_format'] = '
    <div class="description">%1$s</div>
';
$html_render['image_format'] = '
    <div class="info-img">%1$s</div>
';
$html_render['event_location'] = '
    <div class="event-info location">
        <div class="specific">%1$s</div>
    </div>
';
?>
<div class="slz-list-event-01">
    <?php if( isset( $model->attributes['show_searchbar'] ) && $model->attributes['show_searchbar'] == 'show' ): ?>
    <div class="search-loading"></div>
    <div class="search-event" data-json="<?php echo esc_attr( slz_events_encode_data( json_encode( $model->attributes ) ) ) ?>">
        <div class="search-item">
            <div class="search-label"><?php echo esc_html__( 'concert name', 'slz' ); ?></div><input type="search" placeholder="Search" class="search-field concert_name"></div>
        <div class="search-item search-time input-daterange">
            <div class="search-label"><?php echo esc_html__( 'when', 'slz' ); ?></div>
            <input type="search" placeholder="From" class="search-field half from input-small">
            <input type="search" placeholder="To" class="search-field half to input-small">
        </div>
        <div class="search-item">
            <div class="search-label"><?php echo esc_html__( 'artists & bands', 'slz' ); ?></div><input type="search" placeholder="Search" class="search-field artists_bands"></div>
        <div class="search-btn">
            <a href="javascript:void(0);" class="slz-btn btn-search"> <span class="btn-text"><?php echo esc_html__( 'find concert', 'slz' ); ?></span><span class="btn-icon fa fa-search"></span></a>
        </div>
    </div>
    <div class="search-result"><?php echo sprintf( 'Found %1$d Results', $model->query->found_posts ); ?></div>
    <?php endif; ?>
    <div class="list-event">
        <?php $model->render_event_sc( $html_render ); ?>
    </div>
</div>