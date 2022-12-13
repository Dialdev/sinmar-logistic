<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

echo wp_kses_post( $before_widget );
$widget_cls = 'slz-widget-send-mail';
if( $style == '02' ){
	$widget_cls = 'slz-widget-send-mail2';
}
?>
<div class="slz-widget <?php echo esc_attr( $widget_cls ); ?>">
	<?php echo wp_kses_post( $title ); ?>
	<div class="widget-content">
		<?php if( !empty( $description ) ) : ?>
			<div class="description"><?php echo wp_kses_post( nl2br( $description ) ); ?></div>
		<?php endif; ?>
		<?php echo NewsletterSubscription::instance()->get_form_javascript(); ?>
		<form action="<?php echo esc_url(home_url('/')) ?>?na=s" onsubmit="return newsletter_check(this)" method="post">
		<?php if( $style == '01' ): ?>
		<?php 
			if( $show_hide == 'show' ) {
				echo '<input type="text" name="nn" required placeholder="'. esc_attr( $name_placeholder ) .'" class="form-control">';
			}
		?>
			<input type="email" required name="ne" placeholder="<?php echo esc_attr( $email_placeholder ); ?>" class="form-control">
			<button type="submit" class="slz-btn main-color"><?php echo esc_html( $button_text ); ?></button>
		<?php else: ?>
			<div class="slz-input-group">
				<?php
				if( $show_hide == 'show' ) {
					echo '<input type="text" name="nn" required placeholder="'. esc_attr( $name_placeholder ) .'" class="form-control">';
				}
				?>
				<input type="email" name="ne" placeholder="<?php echo esc_attr( $email_placeholder ); ?>" class="form-control">
				<span class="input-group-button">
					<button type="submit" class="btn">
						<span class="btn-text"><?php echo esc_html( $button_text ); ?></span>
						<span class="btn-icon fa fa-arrow-right"></span>
					</button>
				</span>
			</div>
		<?php endif; ?>
		</form>
	</div>
</div>
<?php
echo wp_kses_post( $after_widget );