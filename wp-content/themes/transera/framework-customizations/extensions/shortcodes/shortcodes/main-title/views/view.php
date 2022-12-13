<?php if ( ! defined( 'SLZ' ) ) {
	die( 'Forbidden' );
}
$css_class = SLZ_Util::slz_shortcode_custom_css_class($data['css']);
$block_class = 'main-title-'.SLZ_Com::make_id();
$block_cls = $block_class.' '.$data['extra_class']. ' ';
$data['block_class'] = $block_class;
$align = '';
$css = $custom_css = '';
$style = '';

if ( !empty( $data['style'] ) ) {
	$block_cls .= ' ' . $data['style'];
}
/* align */
if ( !empty( $data['align'] ) ) {
	if ( $data['align'] == 'left' ) {
		$align = '';
	}elseif ( $data['align'] == 'right' ) {
		$align = 'text-r';
	}elseif ( $data['align'] == 'center' ) {
		$align = 'text-c';
	}
}
?>
<div class="slz-shortcode sc_main_title <?php echo esc_attr( $block_cls ); ?> <?php echo esc_attr( $style ); ?> <?php echo esc_attr( $align ); ?> <?php echo esc_attr($css_class)?>">
	<div class="slz-main-title">
	
		<?php
		if( !empty( $data['title'] ) || !empty( $data['extra_title'] ) ) :
		?>
			<h2 class="title"><?php echo esc_html( $data['title'] ); ?>
			<?php 
			if( !empty( $data['extra_title'] ) ) :
			?>
				<strong class="main-color"><?php echo esc_html( $data['extra_title'] ); ?></strong>
			<?php
			endif;
			?>
			</h2>
		<?php
		endif;
		?>
			<?php
			if( $data['show_icon'] == '0' && !empty($data['image']) )
				echo wp_get_attachment_image($data['image'], 'full');
			else if( $data['show_icon'] == '1' && !empty($data['icon_fontawesome']) )
				echo '<i class="'.esc_attr($data['icon_fontawesome']).'"></i>';
			else
				echo '';
		?>
		<?php
		if( !empty( $data['subtitle'] ) ):
			?>
			<div class="subtitle">
				<span class="subtitle-inner"><?php echo esc_html( $data['subtitle'] ); ?></span>
			</div>
			<?php
		endif;
		?>
	</div>
</div>

<?php

/* CUSTOM CSS */
if ( !empty( $data['subtitle_color'] ) ) {
	$css = '
		.%1$s .subtitle-inner {
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['subtitle_color'] ) );
}
if ( !empty( $data['title_color'] ) ) {
	$css = '
		.%1$s .slz-main-title .title {
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['title_color'] ) );
}
if ( !empty( $data['extra_title_color'] ) ) {
	$css = '
		.%1$s .slz-main-title .title .main-color {
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['extra_title_color'] ) );
}
//line css
if( !empty($data['subtitle_line_color']) ) {
	$css = '
		.%1$s .slz-main-title .subtitle .subtitle-inner::before,
		.%1$s .slz-main-title .subtitle .subtitle-inner::after {
			background-color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['subtitle_line_color'] ) );
}
if( !empty($data['extra_title_line_color']) ) {
	$css = '
		.%1$s .slz-main-title .title::before {
			border-color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['extra_title_line_color'] ) );
}
if( !empty($data['line_color']) ) {
	$css = '
		.%1$s .slz-main-title::before {
			border-color: %2$s;
			background-color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $block_class ), esc_attr( $data['line_color'] ) );
}
if ( !empty( $custom_css ) ) {
	do_action('slz_add_inline_style', $custom_css);
}