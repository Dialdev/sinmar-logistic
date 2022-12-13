<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$atts_cls = $atts['extra_class'] . ' category-' . $unique_id;

?>

<div class="slz-shortcode sc_category widget_categorie <?php echo (( $atts['style'] == 3 ) ? 'slz-categories2' : 'slz-categories'); ?> <?php echo esc_attr($atts_cls) ?>">

<?php

if ($atts['block_title'] != '') :
	echo '<div class="' . esc_attr( $atts['block_title_class'] ) . '">' . esc_html( $atts['block_title'] ) . '</div>';
endif;

	echo '<div class="' . ( ( $atts['style'] == 2 ) ? 'two-column clearfix' : '' ) . '">';


			foreach ($categories as $item) {

				$links = get_category_link( $item->term_id );

				if ( $atts['style'] == 3 ) {

					echo '<a href="' . esc_url( $links ) . '" class="link"> <i class="icons fa fa-angle-right"></i><span class="text">' . esc_html( $item->name ) . '</span>
						<div class="label-right">' . esc_html( $item->count ) . '</div>
					</a>';

				}
				else {
					echo '<a href="' . esc_url( $links ) . '" class="link"> <i class="icons fa fa-angle-right"></i><span class="text">' . esc_html( $item->name ) . '</span>';

					if ( $atts['style'] != 2 )
					echo '<span class="badge">' . esc_html( $item->count ) . '</span>';

					echo '</a>';
				}
					
			}

	echo '</div>';
?>

</div>