<?php
$post_info = slz_get_db_settings_option('post-info', array());
if( !empty( $post_info ) ) :
	echo '<ul class="block-info-main">';
	foreach ($post_info as $info) {
	
	    switch ($info) {
	
	        case 'author': ?>
	        	<?php echo '<li>'; ?>
	            <?php echo esc_html__('By ', 'transera'); ?>
	            <?php the_author( ); ?>
				<?php echo '</li>'; ?>
	            <?php break;
	        
	        case 'category': ?>
	        	<?php echo '<li>'; ?>
	            <?php the_category( ', ' ); ?>
				<?php echo '</li>'; ?>
	            <?php break;
	
	        default:
	            # code...
	            break;
	    }
	
	}
	echo '</ul>';
endif;
