<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

$model = new SLZ_Block($instance);
$model->set_attributes($instance);

$date = $show_thumbnail = $author = $view = $comment = '';

if(!empty($instance['show_thumbnail'])){
    $show_thumbnail = '<div class="media-left"><a class="wrapper-image">%4$s</a></div>';
}
if(!empty($instance['show_date'])){
    $date ='<div class="meta-info time">%2$s</div>';
}
if(!empty($instance['show_author'])){
    $author ='<div class="meta-info">%3$s</div>';
}
if(!empty($instance['show_view'])){
    $view ='<div class="meta-info view"><i class="icon-meta fa fa-eye"></i>%5$s</div>';
}
if(!empty($instance['show_comment'])){
    $comment ='%6$s';
}

$html_format =
        '<div class="media">
              '.wp_kses_post($show_thumbnail).'
            <div class="media-right">%1$s
                <div class="meta">
                   '.wp_kses_post($author) . wp_kses_post($date).
                   wp_kses_post($view).wp_kses_post($comment).'
                </div>
            </div>
        </div>';

$html_render['html_format'] = $html_format;
$html_render['title_class'] = 'media-heading';
$html_render['view_format'] = '<a href="%1$s" class="link">%2$s</a>';
$html_render['comment_format'] = '<div class="meta-info comment"><i class="icon-meta fa fa-comments"></i><a href="%1$s" class="link">%2$s</a></div>';
echo $before_widget;?>
    <?php echo wp_kses_post($title); ?>
    <div class="widget-content">
        <?php $model->render_widget($html_render); ?>
    </div>
<?php echo $after_widget;?>