<div class="item">

	<div class="slz-block-item-01 style-1">

		<?php if ( $module->has_post_thumbnail() ) : ?>

			<div class="block-image">

				<a href="<?php echo $module->get_url(); ?>" class="link">

					<?php echo $module->get_featured_image(); ?>

				</a>

			</div>

		<?php endif; ?>

		<div class="block-content">

			<?php echo $module->get_title(true, array( 'title_class' => 'block-title' ) ); ?>

			<ul class="block-info">

				<?php echo $module->get_meta_data();?>

			</ul>

			<a href="<?php echo $module->get_url(); ?>" class="block-read-more">
				<?php echo esc_html__('Read More', 'transera'); ?>
				<i class="fa fa-angle-double-right"></i>
			</a>

		</div>

	</div>
	
</div>
