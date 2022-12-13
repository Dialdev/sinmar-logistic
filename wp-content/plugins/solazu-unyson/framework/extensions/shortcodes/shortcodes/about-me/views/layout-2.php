<?php
$shortcode = slz_ext( 'shortcodes' )->get_shortcode('about_me');
$img_url = $social_icon = '';
if( !empty( $data['avatar'] ) ) {
	$img_url = wp_get_attachment_url( $data['avatar'] );
}
?>

<div class="block-wrapper">
	<div class="image-wrapper">
	<?php 
	if( !empty( $img_url ) ) :
	?>
		<img src="<?php echo esc_url( $img_url ); ?>" alt="" class="img-responsive">
	<?php 
	endif;
	?>
	
	</div>
	<div class="content-wrapper">
		<div class="heading-wrapper">
			<div class="heading-left">
				<?php
				if( !empty( $data['name'] ) ) :
				?>
					<a href="javascript:void(0)" class="name"><?php echo esc_html( $data['name'] ); ?></a>
				<?php 
				endif;
				?>
			</div>
			<div class="heading-right">
				<div class="social-wrapper">
					<?php
					if( !empty( $data['social'] ) ) {
						$socials = vc_param_group_parse_atts( $data['social'] );
						if( !empty( $socials ) ) {
							$link_arr = '';
							echo '<ul class="list-unstyled list-inline list-social-wrapper">';
							foreach ( $socials as $social ) {
								$social_icon = $shortcode->get_icon_library_views( $social );
								if( isset( $social['link'] ) && !empty( $social['link'] ) ) {
									$link_arr = SLZ_Util::parse_vc_link( $social['link'] );
									if( !empty( $link_arr['url'] ) ) {
										echo '<li><a href="'. esc_url(  $link_arr['url'] ) .'" '. esc_attr( $link_arr['other_atts'] ) .' class="link">'.wp_kses_post($social_icon).'</a></li>';
									}else{
										echo '<li><a href="javascript:void(0)" '. esc_attr( $link_arr['other_atts'] ) .' class="link">'.wp_kses_post($social_icon).'</a></li>';
									}
								}else{
									echo '<li><a href="javascript:void(0)" class="link">'.wp_kses_post($social_icon).'</a></li>';
								}
							}
							echo '</ul>';
						}
					}
						
					?>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<?php
		if( !empty( $data['detail'] ) ) :
		?>
			<div class="content-text"><?php echo wp_kses_post( nl2br( $data['detail'] ) ); ?></div>
		<?php
		endif;
		?>
	</div>
</div>
