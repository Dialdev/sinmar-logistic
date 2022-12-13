<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * @var WP_Post $post
 * @var array $options
 */
?>
<div class="submitbox" id="submitpost">
	<div>
		<?php echo slz()->backend->render_options($options); ?>
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
			       value="<?php esc_attr_e('Update', 'slz') ?>"/>
			<input name="save" type="submit" class="button button-primary button-large" id="publish"
			       accesskey="p" value="<?php esc_attr_e('Save', 'slz') ?>"/>
		</div>
		<div class="clear"></div>
	</div>
</div>