<?php
$shortcode = slz_ext( 'shortcodes' )->get_shortcode('about_me');
$link_arr = $social_icon = $image = '';
if ( !empty ( $data['avatar'] ) ) {
	$image = wp_get_attachment_image_src( $data['avatar'], 'slz-thumb-100x100' );
	$image = $image[0];
}
?>
<div class="block-wrapper">
	<div class="image-wrapper">
		<img src="<?php echo esc_attr( $image ); ?>" alt="" class="img-responsive" />
	</div>
	<div class="content-wrapper"><a href="javascript:void(0)" class="name"><?php echo esc_html( $data['name'] ); ?></a>
		<div class="content-text">
			<?php echo wp_kses_post( nl2br( $data['detail'] ) ); ?>
		</div>
	</div>
	<div class="social-wrapper">
		<ul class="list-unstyled list-inline list-social-wrapper">
			<?php
				$socials = vc_param_group_parse_atts( $data['social'] );

				foreach ($socials as $social) {					
					
					$social_icon = $shortcode->get_icon_library_views( $social );
					
					if( isset( $social['link'] ) && !empty( $social['link'] ) ) {
						$link_arr = SLZ_Util::parse_vc_link( $social['link'] );
						echo '<li><a href="' . ( !empty ( $link_arr['url'] ) ? esc_url( $link_arr['url'] ) : 'javascript:void(0)') . '" '.esc_attr( $link_arr['other_atts'] ) .' class="link">
							'.wp_kses_post($social_icon).'
							</a></li>';
					}else{
						echo '<li><a href="javascript:void(0)" class="link">
								'.wp_kses_post($social_icon).'
							</a></li>';
					}
					

				}
			?>
		</ul>
	</div>
</div>