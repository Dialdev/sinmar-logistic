<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Forbidden' ); }

$model = new SLZ_Service();
$model->init( $data );
$uniq_id = $model->attributes['uniq_id'];
$block_cls = $model->attributes['extra_class'] . ' ' . $uniq_id;

// 1$ - uniq_id, 2$ - active class, 3$ - gallery, 4$ - content, 5$ - title
$html_format = '
    <div id="tab-%1$s" role="tabpanel" class="tab-pane fade %2$s">
        <div class="text-content">
            %3$s
            %4$s
            %5$s
        </div>
    </div>
';

// 1$ - uniq_id, 2$ - active class, 3$ - image, 4$ - title
$tab_format = '
    <li role="presentation" class="%2$s">
        <a href="#tab-%1$s" role="tab" data-toggle="tab" class="link">
            %3$s
            %4$s
        </a>
    </li>
';

$html_render =  array(
                    'html_format'  => $html_format,
                    'tab_format'   => $tab_format,
                    'image_format' => '<img src="%1$s" alt="" class="img-full" />'
                );

printf( '<div class="slz-shortcode sc-service-tab slz-tab-vertical %1$s">', esc_attr( $block_cls ) );
    echo '<div class="tab-list-wrapper"><ul role="tablist" class="tab-list">';
         $model->render_tab_list( $html_render );
    echo '</ul></div>';
    echo '<div class="tab-content">';
         $model->render_tab_content( $html_render );
    echo '</div>';
print('</div>');