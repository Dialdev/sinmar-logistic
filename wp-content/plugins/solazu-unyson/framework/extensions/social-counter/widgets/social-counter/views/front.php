<?php

echo wp_kses_post($before_widget);

$block_cls = $block['extra_class'] . ' social-' . $unique_id;

?>

<div class="slz-widget widget <?php echo esc_attr($block_cls) ?>">
    <?php echo wp_kses_post( $block['block_title'] );?>

    <div class="widget-content">

<?php

	$social_api = new SLZ_Social_Api();
	$social_array = SLZ_Params::get('social-counter');

	echo '<div class="social-counter-wrapper ' . (( $block['style'] == 1 ) ? 'style-02' : '') . '">';

	foreach ($social_array as $social_id => $social_name)
	{
		if (isset($block[$social_id]) && !empty($block[$social_id])) {

			if ( $social_id == 'facebook' ) {
                $arr_fb = array(
                    'app_id'      => slz_get_db_ext_settings_option('social-counter', 'facebook-app-id'),
                    'secret_key'  => slz_get_db_ext_settings_option('social-counter', 'facebook-app-secret')
                );


				if ( !empty( $arr_fb['app_id'] ) && !empty( $arr_fb['secret_key'] ) ) {
					$social_network_meta = slz_ext_social_counter_network_meta($social_id, $block[$social_id], $social_api, $arr_fb );
				}else{
					$social_network_meta = slz_ext_social_counter_network_meta($social_id, $block[$social_id], $social_api);
				}
			}else{
				$social_network_meta = slz_ext_social_counter_network_meta($social_id, $block[$social_id], $social_api);
			}
			$link = $social_network_meta['url'];

			echo '<div class="social-counter-item">
				<div class="social-counter-title ' . esc_attr ( $social_id ) . '">
					<a target="blank" href="' . esc_url( $link ) . '" class="slz-icon">
						<i class="fa ' . esc_attr( $social_name ) . '"></i>
					</a>
					<a target="blank" href="' . esc_url( $link ) . '" class="link">
						' . esc_html( number_format( $social_network_meta['api'] ) ) . '
						<span class="sub-text">' . esc_html($social_network_meta['button']) . '</span>
					</a>
				</div>
			</div>';
		}
	}

	echo '</div>';

echo '</div>';

echo '</div>';

echo wp_kses_post($after_widget);
?>