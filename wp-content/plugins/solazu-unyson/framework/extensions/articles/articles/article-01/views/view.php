<div id="post-<?php echo esc_attr($module->post_id); ?>" <?php post_class('item');?>>
	<div class="slz-block-item-01 style-1 slz-article article-01">
		<?php slz_theme_sticky_ribbon();?>

		<?php echo slz_render_view(slz_get_template_customizations_directory( '/theme/views/article.php' ), compact( 'module' )) ?>
	</div>
</div>