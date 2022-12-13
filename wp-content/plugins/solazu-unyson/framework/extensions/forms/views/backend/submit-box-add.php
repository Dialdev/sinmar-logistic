<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * @var WP_Post $post
 */
?>
<div class="submitbox" id="submitpost">
	<div class="misc-pub-section misc-pub-post-status">
		<p class="description">
			<?php _e('Note that the type can\'t be changed later.','slz')?>
			<br/>
			<?php _e('You will need to create a new form in order to have a different form type.','slz')?>
		</p>
	</div>

	<div id="major-publishing-actions">
		<div id="delete-action">
			<?php
			if (current_user_can("delete_post", $post->ID)) {
				if (!EMPTY_TRASH_DAYS)
					$delete_text = __('Delete Permanently', 'slz');
				else
					$delete_text = __('Move to Trash', 'slz');
				?>
				<a class="submitdelete deletion"
				   href="<?php echo get_delete_post_link($post->ID); ?>"><?php echo $delete_text; ?></a><?php
			} ?>
		</div>

		<div id="publishing-action">
			<span class="spinner"></span>
			<input name="original_publish" type="hidden" id="original_publish"
			       value="<?php esc_attr_e('Publish', 'slz') ?>"/>
			<?php submit_button(__('Create', 'slz'), 'primary button-large', 'publish', false, array('accesskey' => 'p')); ?>
		</div>
		<div class="clear"></div>
	</div>
</div>