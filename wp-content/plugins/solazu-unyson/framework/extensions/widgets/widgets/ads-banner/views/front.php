<?php

echo wp_kses_post($before_widget);
?>
<div class="slz-banner-image widget banner-<?php echo esc_attr( $unique_id ); ?>">
	<?php echo wp_kses_post( $block_title );?>
	<div class="widget-content">
		<?php echo SLZ_Com::get_advertisement( $adspot ); ?>
	</div>
</div>

<?php 
echo wp_kses_post( $after_widget );

?>