<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Forbidden' ); }

$model = new SLZ_Recruitment();
$model->init( $data );

$uniq_id = $model->attributes['uniq_id'];
$block_cls = $model->attributes['extra_class'] . ' ' . $uniq_id;

if( ! $model->query->have_posts() ) {
    return;
}

$html_format = '
                    <div class="slz-block-item-01 style-1">
                        <div class="block-image">
                            %1$s
                        </div>
                        <div class="block-content">
                            <div class="block-content-wrapper">
                                %2$s
                                <ul class="block-info-cv">  
                                        %3$s
                                        %4$s
                                        %5$s
                                        %6$s
                                    </ul>
                                <div class="block-text">
                                    %7$s
                                </div>
                                %8$s
                            </div>
                        </div>
                    </div>';

$html_render = array(
    'html_format'         => $html_format,
    'recruit_type_format' => '<li class="time"><i class="fa fa-hourglass"></i> %1$s</li>'
);

list( $filter_tab, $output_grid ) = $model->render_filter_list( $model->attributes, $html_render, $uniq_id );

?>
<div class="slz-shortcode sc-recruitment-tab <?php echo esc_attr( $block_cls ); ?>" data-json="<?php echo esc_attr(json_encode($data));?>">
    <div class="slz-cv-wrapper">
        <div class="cv-navigation">
        	<?php if( !empty( $model->attributes['title'] ) ) : ?>
            	<div class="slz-title-shortcode"><span><?php echo esc_html($model->attributes['title']); ?></span></div>
            <?php endif;
            printf('<div class="slz-isotope-nav">
                    <ul role="tablist" class="slz-categories tab-title tab-list">%1$s</ul></div>',
                $filter_tab);
            ?>
        </div>
        <div class="tab-content cv-content">
        <?php
            echo wp_kses_post( $output_grid );
        ?>
        </div>
    </div>
</div>

