<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * @var string $the_content
 */

global $post;
$options = slz_get_db_post_option($post->ID, slz()->extensions->get( 'testimonials' )->get_testimonial_option_id());
?>
<hr class="before-hr"/>
<?php foreach($options['testimonial_children'] as $key => $row) : ?>
	<?php if (empty($row['testimonial_date_range']['from']) or empty($row['testimonial_date_range']['to'])) : ?>
		<?php continue; ?>
	<?php endif; ?>

	<div class="details-testimonial-button">
		<button data-uri="<?php echo add_query_arg( array( 'row_id' => $key, 'calendar' => 'google' ), slz_current_url() ); ?>" type="button"><?php _e('Google Calendar', 'slz') ?></button>
		<button data-uri="<?php echo add_query_arg( array( 'row_id' => $key, 'calendar' => 'ical'   ), slz_current_url() ); ?>" type="button"><?php _e('Ical Export', 'slz') ?></button>
	</div>
	<ul class="details-testimonial">
		<li><b><?php _e('Start', 'slz') ?>:</b> <?php echo $row['testimonial_date_range']['from']; ?></li>
		<li><b><?php _e('End', 'slz') ?>:</b> <?php echo $row['testimonial_date_range']['to']; ?></li>

		<?php if (empty($row['testimonial-user']) === false) : ?>
			<li>
				<b><?php _e('Speakers', 'slz') ?>:</b>
				<?php foreach($row['testimonial-user'] as $user_id ) : ?>
					<?php $user_info = get_userdata($user_id); ?>
					<?php echo esc_html( $user_info->display_name ); ?>
					<?php echo ($user_id !== end($row['testimonial-user']) ? ', ' : '' ); ?>
				<?php endforeach; ?>
			</li>
		<?php endif;?>

	</ul>
	<hr class="after-hr"/>
<?php endforeach; ?>
<!-- .additional information about testimonial -->

<!-- call map shortcode -->
<?php echo slz_ext_testimonials_render_map() ?>
<!-- .call map shortcode -->

<?php echo $the_content; ?>

<?php do_action('slz_ext_testimonials_single_after_content'); ?>