<?php echo $before_widget; ?>
<?php echo wp_kses_post( $title ); ?>
<div class="widget-content">
	<?php
	if(!empty($instance['attachment_id'])):
		foreach ($instance['attachment_id'] as $value):
			$file_url = wp_get_attachment_url($value);
			if( !empty($file_url)):
				$file_check = wp_check_filetype($file_url);
	?>
				<a download="<?php echo esc_url($file_url) ?>" href="<?php echo esc_url($file_url) ?>" class="slz-btn">
					<?php echo SLZ_Util::get_icon_for_extension($file_check['ext']); ?>
					<span class="btn-text"><?php echo get_the_title($value); ?></span>
					<span class="btn-icon fa fa-download"></span>
				</a>
				<?php
			endif;
		endforeach;
	endif;
	?>
</div>
<?php echo $after_widget; ?>