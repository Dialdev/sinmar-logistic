<div class="slz-article-not-found">
	<div class="heading">
		<h2 class="title"><?php esc_html_e('We can&rsquo;t find what you&rsquo;re looking for!', 'transera'); ?></h2>
	</div>
	<div class="page-content">
		<div class="content-none">
			<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
		
				<p><?php printf( '%1$s <a href="%2$s">%3$s</a>.', esc_html__( 'Ready to publish your first post?', 'transera' ), esc_url(admin_url( 'post-new.php' )), esc_html__( 'Get started here' , 'transera')); ?></p>
		
			<?php elseif ( is_search() ) : ?>
		
				<p><?php esc_html_e( 'Please try again with different keywords.', 'transera' ); ?></p>
				<?php get_search_form(); ?>
		
			<?php else : ?>
		
				<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'transera' ); ?></p>
				<?php get_search_form(); ?>
		
			<?php endif; ?>
			<?php transera_show_help_link();?>
		</div>
	</div>
</div>