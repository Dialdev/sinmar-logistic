<?php

$unique_id = SLZ_Com::make_id();
echo '<div class="slz-carousel-wrapper">';
echo '<div class="slz-carousel-center">';

if (!empty($block)) {

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
					</div>
				</div>
			</div>
		</div>
		<?php

	}

}

echo '</div>';
echo '</div>';

?>