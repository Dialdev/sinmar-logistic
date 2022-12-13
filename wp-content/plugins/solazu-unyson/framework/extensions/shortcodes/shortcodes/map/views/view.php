<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}
if ( ! is_plugin_active( 'js_composer/js_composer.php' ) ) {
	return;
}
$map_config = slz()->theme->get_config('map_config');
$key = slz_get_db_settings_option( 'map-key-api', '');
$uniq_id = 'sc-map-'.SLZ_Com::make_id();
$block_cls = $uniq_id.' '.$data['extra_class']. ' ';
$shortcode = slz_ext( 'shortcodes' )->get_shortcode('map');
$info_default  = $shortcode->get_config('default_info');
$more_info_default =  $shortcode->get_config('default_more_info');

/* ----data json-----*/

$json_data = $address  = array();
$data['array_info']  =  vc_param_group_parse_atts( $data['array_info'] );
if( $data['array_info'] ) {
	foreach( $data['array_info'] as $info) {
		if( $info ) {
			$info['address'] = !isset($info['address'])?'':$info['address'];
			$address[] = $info['address'];
		}
	}
	
}

$data['zoom'] = (empty($data['zoom'])) ? 11 :(int)$data['zoom'];
$json_data['zoom'] = $data['zoom'];
$json_data['address'] = $address;
$json_data['main_color'] = $data['bg_color'];
$json_data['marker'] = wp_get_attachment_url( $data['map_marker'] );

$json_data = json_encode($json_data);

/*----------content html----------*/

$out_put = '';
$format = '<span class="icons %1$s"></span>';
if( !empty( $data['array_info'] ) ){
	foreach ( $data['array_info']  as $info ) {

		$info = array_merge( $info_default, $info );
		$out_put .= '<div class="office">';

			if( !empty( $info['title'] ) ){
				$out_put .= '<div class="office-name">'.esc_attr( $info['title'] ).'</div>';
			}
			
		    if( !empty( $info['address'] ) || ( !empty( $info['array_info_item'] ) ) ){

		    	$out_put .= ' <div class="office-contact">';

		    		if( !empty( $info['address'] ) ){
						$address_icon = $shortcode->get_icon_library_views( $info, $format );
		    			$out_put .= sprintf('<div class="item">
							    				<p class="text">%1$s %2$s</p>
					                        </div>',
					                        wp_kses_post( $address_icon ),
					                        esc_html( $info['address'] )
					                    );

		        		$info['array_info_item'] = vc_param_group_parse_atts( $info['array_info_item'] );

		        		if(!empty($info['array_info_item'])){

		        			foreach ( $info['array_info_item'] as $item ) {
			        			$item = array_merge( $more_info_default, $item );
								$more_icon = $shortcode->get_icon_library_views( $item, $format );
			        			$out_put .= sprintf('<div class="item">
			        									<p class="text">%1$s %2$s</p>
	                                				</div>',
	                                				wp_kses_post( $more_icon ),
	                                				esc_html( $item['more_title'] )
	                                			);
					    	}

		        		}
		        		
					}

		    	$out_put .= '</div>';
		    }
		   
		$out_put .= '</div>';
	}
}
?>
<div class="slz-map-01 slz-shortcode sc_map <?php echo esc_attr( $block_cls ); ?>">
    <div id="map-01" data-json='<?php echo ( $json_data ); ?>' data-zoom="<?php echo esc_attr($data['zoom']);?>" data-key="<?php echo esc_attr($key);?>">
        <div class="theme-config" data-color='<?php echo json_encode($map_config['color']);?>'>
   		</div>
    </div>
    <?php if(!empty($data['show_block_info'])):?>
		<div class="container">
			<div class="map-block-info">
				<?php if( is_plugin_active('contact-form-7/wp-contact-form-7.php') ){ ?>
					<?php if( !empty( $data['contact_form'] ) ) : ?>
					<div class="contact-form-wrapper float-l">
						<?php echo do_shortcode( '[contact-form-7 id="'. $data['contact_form'] .'"]' ); ?>
			   		</div>
			   		<?php endif; ?>
		   		<?php } ?>
		        <div class="office-wrapper float-r">
		            <div class="office-list mCustomScrollbar">
		               <?php
		           			echo wp_kses_post($out_put);
		               ?>
		            </div>
		        </div>
		        <div class="clearfix"></div>
	    	</div>
	    </div>
	<?php endif;?>
</div>

<?php

/*------Custom Css--------*/

$css =  $custom_css = '';

if ( !empty( $data['title_color'] ) ) {
	$css = '
		.%1$s .office-name {
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $uniq_id ), esc_attr( $data['title_color'] ) );
}

if ( !empty( $data['info_color'] ) ) {
	$css = '
		.%1$s .office .office-contact .item {
			color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $uniq_id ), esc_attr( $data['info_color'] ) );
}

if ( !empty( $data['border_color'] ) ) {
	$css = '
		.%1$s .office .office-contact .item {
			color: %2$s;
		}
	';

	$custom_css .= sprintf( $css, esc_attr( $uniq_id ), esc_attr( $data['border_color'] ) );
}

if ( !empty( $data['info_color'] ) ) {     $css = '         .%1$s .office {
border-color: %2$s;         }     ';

	$custom_css .= sprintf( $css, esc_attr( $uniq_id ), esc_attr( $data['info_color'] ) );
}

if ( !empty( $data['bg_color'] ) ) {
	$css = '
		.%1$s .office-list {
			background-color: %2$s;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $uniq_id ), esc_attr( $data['bg_color'] ) );
}
if ( !empty( $data['map_height'] ) ) {
	$css = '
		.%1$s{
			height: %2$spx;
		}
	';
	$custom_css .= sprintf( $css, esc_attr( $uniq_id ), esc_attr( $data['map_height'] ) );
}

if ( !empty( $custom_css ) ) {
	do_action('slz_add_inline_style', $custom_css);
}