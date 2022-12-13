<?php

$unique_id = SLZ_Com::make_id();

echo '<div class="slz-carousel-vertical-02">';
echo '<div class="slz-carousel-wrapper">';

if (!empty($block)) {

	echo '<div class="slider-for">';

	foreach ($block->query->posts as $post) {

		$module = new SLZ_Block_Module($post, $block->attributes);

		?>
		<div class="item">
			<div class="slz-block-item-01 style-3">
				<div class="block-image">
					<a href="<?php echo ( $module->permalink ); ?>" class="link">
						<?php echo ( $module->get_featured_image('large') ); ?>
					</a>
				</div>
				<div class="block-content">
					<div class="block-content-wrapper">
						<?php echo ( $module->get_title() ); ?>
						<ul class="block-info">
							<?php echo ( $module->get_meta_data() ); ?>
						</ul>
						<?php if ( $module->attributes['excerpt'] == 'show' ) : ?>
							<div class="block-text"><?php echo esc_html( $module->get_excerpt() ); ?></div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<?php

	}

	echo '</div>';

	echo '<div data-mcs-theme="dark-3" class="slider-nav mCustomScrollbar">';

	foreach ($block->query->posts as $post) {

		$module = new SLZ_Block_Module($post, $block->attributes);

		?>
		<div class="item">
			<div class="title">
				<?php echo ( get_the_title( $module->post ) ); ?>
			</div>
		</div>
		<?php

	}

	echo '</div>';

}

echo '</div>';
echo '</div>';

?>