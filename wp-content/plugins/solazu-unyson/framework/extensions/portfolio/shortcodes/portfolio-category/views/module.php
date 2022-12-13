<div class="item">
	<div class="slz-counter-item-1">
		<div class="content-cell">
			<div class="number"><?php echo esc_html( $term->count ); ?></div>
			<div class="title"><?php echo esc_html( $term->name ); ?></div>
			<a href="<?php echo esc_url(get_term_link($term->term_id));?>" ></a>
		</div>
	</div>
</div>