<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Transera
 * @since 1.0
 */

$transera_args = transera_404_page();
$transera_illustration_image = $transera_args['404-illustration'];
get_header('none'); ?>
<div class="slz-main-content slz-page-404">
	<div class="content-wrapper content-wrapper-404">
		<?php 
		if ( $transera_illustration_image && !empty ( $transera_illustration_image['data']['icon'] ) && $transera_illustration_image['data']['css'] != 'none' ){
			echo '<img class="img-404" src="'.esc_url($transera_illustration_image['data']['icon']).'" alt="" />';
			
		}?>
		<h1 class="title">
			<?php 
				if( !empty( $transera_args['title'] ) ) {
					echo esc_html( $transera_args['title'] );
				} 
			?>
			
		</h1>
		<div class="subtitle"><?php echo wp_kses_post($transera_args['description']); ?>
		</div>
		<div class="slz-group-btn">
			<?php if(!empty($transera_args['home_text'])){?>
				<a href="<?php echo esc_url(site_url()); ?>" class="slz-btn btn-back-to-home"><?php echo esc_html($transera_args['home_text']); ?></a>
			<?php }
			if (!empty($transera_args['button_text'])){?>
				<a href="<?php echo esc_url($transera_args['button_link']); ?>"  class="slz-btn btn-help"><?php echo esc_html($transera_args['button_text']); ?></a>
			<?php }?>
		</div>
	</div>
</div>
<?php get_footer('none'); ?>