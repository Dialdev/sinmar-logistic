<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Forbidden' ); }

$block_cls = $block['extra_class'] . ' new-tweet-' . $unique_id;
$is_carousel = ( $block['is_carousel'] == 'yes' );
$tweet_per_slide = $block['tweet_per_slide'];

?>
<div class="slz-shortcode sc_new_tweet slz-new-tweet <?php echo esc_attr($block_cls) ?>">
<?php
if ($block['block_title'] != '')
	echo '<div class="' . esc_attr( $block['block_title_class'] ) . '">' . esc_html($block['block_title']) . '</div>';
	$show_media = isset($block['show_media'])?$block['show_media']:'no';
	if( ! empty( $tweet_data ) && ! isset( $tweet_data['errors'] ) ):
        if( $is_carousel ):
            $idx = 0;
?>
            <div class="list-news-tweet slz-carousel" data-slidestoshow="1" data-autoplay="yes" data-isdot="yes" data-isarrow="yes" data-infinite="yes" data-speed="600">
                <?php foreach ( $tweet_data as $data ): ?>
                    <?php if( $idx == 0 ): ?>
                    <div class="item">
                    <?php endif; ?>
                        <?php
                        $elements = slz_ext_new_tweet_get_display_elements($data, ($show_media == '1')?true:false );
                        echo slz_render_view($instance->locate_path('/views/item.php'), array( 'data' => $data, 'elements' => $elements ));
                        if($block['show_re_tweet'] === '1' && isset($data['retweeted_status'])){
                            ?>
                            <div class="re-tweeet">
                                <?php
                                $re_elements = slz_ext_new_tweet_get_display_elements($data['retweeted_status'], true);
                                echo slz_render_view($instance->locate_path('/views/item.php'), array( 'data' => $data['retweeted_status'], 'elements' => $re_elements));
                                ?>
                            </div>
                            <?php
                        } ?>
                    <?php
                    $idx++;
                    if( $idx == $tweet_per_slide ):
                    ?>
                    </div>
                    <?php
                        $idx = 0;
                        endif;
                    ?>
                <?php
                endforeach;
                if( $idx > 0 ):
                ?>
                </div>
                <?php endif; ?>
            </div>
<?php
        else:
?>
            <div class="list-news-tweet">
                <?php
                foreach ( $tweet_data as $data ) {
                    $elements = slz_ext_new_tweet_get_display_elements($data, ($show_media == '1')?true:false );
                    echo slz_render_view($instance->locate_path('/views/item.php'), array( 'data' => $data, 'elements' => $elements ));
                    if($block['show_re_tweet'] === '1' && isset($data['retweeted_status'])){
                        ?>
                        <div class="re-tweeet">
                            <?php
                            $re_elements = slz_ext_new_tweet_get_display_elements($data['retweeted_status'], true);
                            echo slz_render_view($instance->locate_path('/views/item.php'), array( 'data' => $data['retweeted_status'], 'elements' => $re_elements));
                            ?>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
<?php
        endif;
    endif;
?>
</div>
