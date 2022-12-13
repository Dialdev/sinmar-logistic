<?php
$html_render = array();
$html_format = '
	<div class="item">
            <div class="slz-event-03">
                <div class="event-wrapper">
                    %2$s
                    %12$s
                    %1$s
                    %3$s
                    %8$s
                </div>
            </div>
        </div>
';

$html_render['html_format'] = $html_format;

$html_render['title_format'] = '
    <div class="title-wrapper"><a href="%2$s" class="title">%1$s</a></div>
';

$html_render['thumb_class'] = 'thumb-img';

$html_render['image_format'] = '
    <div class="info-img">%1$s</div>
';
$html_render['permalink'] = ' <div class="event-info button">
                        <a href="%1$s" class="slz-btn"> <span class="btn-text">'. esc_html__( 'book now', 'slz' ) .'</span></a>
                    </div>';
?>

<div class="slz-list-event-03">
    <div class="list-event slz-list-block slz-column-3">
        <?php $model->render_event_sc( $html_render ); ?>
    </div>
</div>