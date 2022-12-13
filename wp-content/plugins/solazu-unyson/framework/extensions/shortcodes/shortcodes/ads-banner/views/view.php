<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$block_cls = $block['extra_class'] . ' banner-' . $unique_id;

?>

<div class="slz-shortcode sc_ads_banner slz-ads-banner slz-banner-image <?php echo esc_attr($block_cls) ?>">

<?php

if ($block['block_title'] != '')

	echo '<div class="' . esc_attr( $block['block_title_class'] ) . '">' . esc_html($block['block_title']) . '</div>';

	echo SLZ_Com::get_advertisement( $block ['adspot'] );

?>

</div>