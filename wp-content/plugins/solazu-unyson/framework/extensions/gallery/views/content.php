<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * @var string $the_content
 */

global $post;
$options = slz_get_db_post_option($post->ID, slz()->extensions->get( 'gallery' )->get_gallery_option_id());
?>
<hr class="before-hr"/>
<?php foreach($options['gallery_children'] as $key => $row) : ?>
	<?php if (empty($row['gallery_date_range']['from']) or empty($row['gallery_date_range']['to'])) : ?>
		<?php continue; ?>
	<?php endif; ?>

	<div class="details-gallery-button">
		<button data-uri="<?php echo add_query_arg( array( 'row_id' => $key, 'calendar' => 'google' ), slz_current_url() ); ?>" type="button"><?php _e('Google Calendar', 'slz') ?></button>
		<button data-uri="<?php echo add_query_arg( array( 'row_id' => $key, 'calendar' => 'ical'   ), slz_current_url() ); ?>" type="button"><?php _e('Ical Export', 'slz') ?></button>
	</div>
	<ul class="details-gallery">
		<li><b><?php _e('Start', 'slz') ?>:</b> <?php echo $row['gallery_date_range']['from']; ?></li>
		<li><b><?php _e('End', 'slz') ?>:</b> <?php echo $row['gallery_date_range']['to']; ?></li>

		<?php if (empty($row['gallery-user']) === false) : ?>
			<li>
				<b><?php _e('Speakers', 'slz') ?>:</b>
				<?php foreach($row['gallery-user'] as $user_id ) : ?>
					<?php $user_info = get_userdata($user_id); ?>
					<?php echo esc_html( $user_info->display_name ); ?>
					<?php echo ($user_id !== end($row['gallery-user']) ? ', ' : '' ); ?>
				<?php endforeach; ?>
			</li>
		<?php endif;?>

	</ul>
	<hr class="after-hr"/>
<?php endforeach; ?>
<!-- .additional information about gallery -->

<!-- call map shortcode -->
<?php echo slz_ext_gallery_render_map() ?>
<!-- .call map shortcode -->

<?php echo $the_content; ?>

<?php do_action('slz_ext_gallery_single_after_content'); ?>