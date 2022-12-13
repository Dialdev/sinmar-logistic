<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Forbidden' ); }


$model = new SLZ_Gallery();
$model->init( $data );
$uniq_id = $model->attributes['uniq_id'];
$block_cls = $model->attributes['extra_class'] . ' ' . $uniq_id . ' ' . $model->attributes['style'];
$image_upload = wp_get_attachment_url($model->attributes['image-upload']);
if( empty($image_upload) ) {
	$block_cls .= ' no-picture-fr';
}
$html_format1 = '<div class="item">%1$s</div>';
if( $model->attributes['post_type'] == 'slz-gallery' ){
	$html_format2 =
	 '<div class="slz-sv-item" data-count="%8$s" >
        <div class="direction-line">
            <div class="point"></div>
        </div>
        <div class="slz-icon-box-1 style-vertical">
            <div class="icon-cell">
                <div class="wrapper-icon">
                	%7$s
                </div>
            </div>
            <div class="content-cell">
                <div class="wrapper-info">
                    <div class="title">%2$s</div>
                     %4$s
                </div>
            </div>
        </div>
    </div>';
}else{
	$html_format2 =
	 '<div class="slz-sv-item" data-count="%8$s" >
        <div class="direction-line">
            <div class="point"></div>
        </div>
        <div class="slz-icon-box-1 style-vertical">
            <div class="icon-cell">
                <div class="wrapper-icon">
                	%7$s
                </div>
            </div>
            <div class="content-cell">
                <div class="wrapper-info">
                    <div class="title">%2$s</div>
                    %4$s
                    %3$s
                </div>
            </div>
        </div>
    </div>';
}


$html_render1['html_format'] = $html_format1;
$html_render2['html_format'] = $html_format2;
$html_render2['read_more'] ='<a href="%1$s" class="btn read-more"> 
                            	<span class="text">%2$s</span>
                            	<span class="icons fa fa-angle-double-right"></span>
                            </a>' ;
$html_render2['icon_format']='<i class="slz-icon %1$s"></i>';
$html_render2['title_format'] = '<span class="block-title">%1$s</span>';
?>

<div class="slz-service-carousel slz-shortcode slz-gallery-feature <?php echo esc_attr( $block_cls ); ?>" data-block-class=".<?php echo esc_attr( $uniq_id ); ?>">
    <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-6 col-md-push-4">
            <div class="service-slider-wrapper">
                <div class="slide-carousel">
                   <?php $model->render_gallery_feature($html_render1);?>
                </div>
            </div>
        </div>
      
        <div class="col-md-4 col-sm-6 col-xs-6 col-md-pull-4 left-side">
        	<div class="slz-tab-list">
            <?php $model->render_gallery_feature($html_render2, 'odd');?>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-6 right-side">
            <div class="slz-tab-list">
               <?php $model->render_gallery_feature($html_render2, 'even');?>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<!-- custom css -->
<?php 
$custom_css = '';
   
     /* title color */
    if ( !empty( $image_upload ) && $model->attributes['style'] == 'style-2' ) {
        $css = '
            .%1$s .service-slider-wrapper{
                background: url(%2$s) no-repeat;
                position: relative;
                background-size: 100% 100%;
                -webkit-background-size: 100% 100%;
            }
        ';
        $custom_css .= sprintf( $css, esc_attr( $uniq_id ), esc_url( $image_upload ) );
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


    /* description color */
    if ( !empty( $model->attributes['description_color'] ) ) {
        $css = '
            .%1$s .block-text{
                color: %2$s;
            }
        ';
        $custom_css .= sprintf( $css, esc_attr( $uniq_id ), esc_attr( $model->attributes['description_color'] ) );
    }

    /*icon*/
    if ( !empty( $model->attributes['icon_color'] ) ) {
        $css = '
            .%1$s .icon-cell .wrapper-icon i{
                color: %2$s;
            }
        ';
        $custom_css .= sprintf( $css, esc_attr( $uniq_id ), esc_attr( $model->attributes['icon_color'] ) );
    }
    /*icon hover*/
    if ( !empty( $model->attributes['icon_hv_color'] ) ) {
        $css = '
            .%1$s .icon-cell:hover .wrapper-icon i{
                color: %2$s;
            }
        ';
        $custom_css .= sprintf( $css, esc_attr( $uniq_id ), esc_attr( $model->attributes['icon_hv_color'] ) );
    }
     /*icon background */
    if ( !empty( $model->attributes['icon_bg_color'] ) ) {
        $css = '
            .%1$s .slz-tab-list .icon-cell .wrapper-icon{
                background-color: %2$s;
            }
        ';
        $custom_css .= sprintf( $css, esc_attr( $uniq_id ), esc_attr( $model->attributes['icon_bg_color'] ) );
    }
    /*icon background hover*/
    if ( !empty( $model->attributes['icon_bg_hv_color'] ) ) {
        $css = '
            .%1$s .icon-cell:hover .wrapper-icon{
                background-color: %2$s;
            }
        ';
        $custom_css .= sprintf( $css, esc_attr( $uniq_id ), esc_attr( $model->attributes['icon_bg_hv_color'] ) );
    }
     /*icon border*/
    if ( !empty( $model->attributes['icon_bd_color'] ) ) {
        $css = '
            .%1$s .icon-cell .wrapper-icon{
                border-color: %2$s;
            }
        ';
        $custom_css .= sprintf( $css, esc_attr( $uniq_id ), esc_attr( $model->attributes['icon_bd_color'] ) );
    }
    /*icon border hover*/
    if ( !empty( $model->attributes['icon_bd_hv_color'] ) ) {
        $css = '
            .%1$s .icon-cell:hover .wrapper-icon{
                border-color: %2$s;
            }
        ';
        $custom_css .= sprintf( $css, esc_attr( $uniq_id ), esc_attr( $model->attributes['icon_bd_hv_color'] ) );
    }
    /* read more btn color */
    if ( !empty( $model->attributes['btn_color'] ) ) {
        $css = '
            .%1$s .wrapper-info .read-more{
                color: %2$s;
            }
        ';
        $custom_css .= sprintf( $css, esc_attr( $uniq_id ), esc_attr( $model->attributes['btn_color'] ) );
    }

    /* read more btn hover color */
    if ( !empty( $model->attributes['btn_hover_color'] ) ) {
        $css = '
             .%1$s .wrapper-info .read-more:hover{
                color: %2$s;
            }
        ';
        $custom_css .= sprintf( $css, esc_attr( $uniq_id ), esc_attr( $model->attributes['btn_hover_color'] ) );
    }
    /* read more btn background color */
    if ( !empty( $model->attributes['btn_bg_color'] ) ) {
        $css = '
            .%1$s .wrapper-info .read-more{
                background-color: %2$s;
            }
        ';
        $custom_css .= sprintf( $css, esc_attr( $uniq_id ), esc_attr( $model->attributes['btn_bg_color'] ) );
    }

    /* read more btn hover color */
    if ( !empty( $model->attributes['btn_bg_hover_color'] ) ) {
        $css = '
            .%1$s .wrapper-info .read-more:hover{
                background-color: %2$s;
            }
        ';
        $custom_css .= sprintf( $css, esc_attr( $uniq_id ), esc_attr( $model->attributes['btn_bg_hover_color'] ) );
    }

    if ( !empty( $custom_css ) ) {
        do_action('slz_add_inline_style', $custom_css);
    }
