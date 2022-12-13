<div class="item">

    <?php
        $post_format = get_post_format( $module->post_id );
        $post_format = !empty( $post_format ) ? $post_format : 'standard';
    ?>
	<div class="slz-block-item-01 style-1 slz-format-<?php echo esc_attr( $post_format ) ?>">

        <?php if ( isset($module->attributes['related_display']['image']) && $module->has_post_thumbnail() ) : ?>

			<div class="block-image">

				<a href="<?php echo $module->get_url(); ?>" class="link">

					<?php echo $module->get_featured_image(); ?>

                    <?php
                        $format = '<i class="icons-%s"></i>';
                        printf( $format, $post_format );
                    ?>

				</a>

			</div>

		<?php endif; ?>

		<div class="block-content">

			<?php echo $module->get_title(true, array( 'title_class' => 'block-title' ) ); ?>

			<?php if( isset($module->attributes['related_display']['info']) ):?>
			<ul class="block-info">

				<?php echo $module->get_meta_data();?>

			</ul>
			<?php endif;?>

		</div>

	</div>
	
</div>
