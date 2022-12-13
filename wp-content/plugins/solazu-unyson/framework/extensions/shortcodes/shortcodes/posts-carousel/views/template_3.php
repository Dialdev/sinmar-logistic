<?php
echo '<div class="slz-carousel-wrapper "><div class="slz-block-slider-01">';

if (!empty($block)):
	echo '<div class="block-slider-main-01">';
	$images_module = '';
	foreach ($block->query->posts as  $key => $post) :
		$module = new SLZ_Block_Module($post, $block->attributes);

		$images_module .= '<div class="slick-item">
		  	<div class="block-image">
			  	<a href="javascript:void(0)" class="link">
				 	'.$module->get_featured_image('small', array( 'thumb_class' => 'img-responsive img-full' ) ).'
		 		</a>
		  	</div>
		</div>';
		?>
		<div class="slick-item">
			<div class="block-left">
				<div class="block-image-wrapper">
					<div class="block-image">
						<a href="<?php echo ( $module->permalink ); ?>" class="link">
							<?php echo ( $module->get_featured_image('large', array( 'thumb_class' => 'img-responsive img-full' ) ) ); ?>
						</a>
					</div>
				</div>
			</div>
			<div class="block-right">
				<div class="block-slide-description">
					<?php echo ( $module->get_title() ); ?>
					<p>
						<?php echo ( $module->get_excerpt(true, true) ); ?>
					</p>
					<?php if( $module->attributes['readmore'] == 'show' ) : ?>
						<?php echo ( $module->get_read_more() ); ?>
					<?php endif; ?>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<?php
	endforeach;
	echo '</div>';
	echo '<div class="slider-nav-wrapper"><div class="block-slider-nav-01" data-slidestoshow="' . esc_attr( $block->attributes['column'] ) . '">';
	echo ( $images_module );
	echo '</div></div>';
endif;
?>
</div></div>