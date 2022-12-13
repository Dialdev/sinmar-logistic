<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }
$item_array = array("");
$social_class = $title_html = $des_html = '';

if( empty( $instance['title_type'] ) ){
		$image_id =  $alt = $title = '';
		if(!empty($instance['image'])){
			$image_arr = json_decode($instance['image']);
			$image_id = $image_arr->ID;
			$alt = $image_arr->alt;
			$title = $image_arr->title;
		}
		if( !empty( $image_id ) ){
			$image_url = wp_get_attachment_url( $image_id );
			$title_html .= '<a href="'.esc_url(site_url()).'"><img src="'.esc_url($image_url).'" title="'.esc_attr( $title ).'" alt="'.esc_attr( $alt ).'" class="slz-logo img-responsive"></a>';
		}else{
			array_push( $item_array,"item" );
		}
	if( !empty($title_html)) {
		$title_html = '<div class="widget-title title-widget logo-title">' . $title_html . '</div>';
	}
}else{
	if( !empty( $instance['title'] ) ){
		$title_html .= wp_kses_post( $title );
	}else{
		array_push( $item_array,"item" );
	}
}

//get description
if(!empty($instance['description'])){
	$des_html = '<div class="widget-description">'.wp_kses_post(nl2br($instance['description'])).'</div>';
}else{
	array_push($item_array,"item");
}

//get social class
if(count($item_array) == 3){
	$social_class = "single-social";
}
$arr_social  = SLZ_Params::get('social-icons');
$social_out = '';
if( $arr_social ) {
	foreach( $arr_social  as $k => $v ){
		if( !empty( $instance[$k] ) ){
			$social_out .= sprintf('<a target="_blank" href="%1$s" class="link share-%2$s"><i class="icons fa %3$s"></i></a>',
					esc_url( $instance[$k] ),
					esc_attr($k),
					esc_attr($v)
			);
		}
	}
}
?>
<div class="slz-widget slz-widget-about-us  <?php echo esc_attr($social_class );?>">
	<?php echo wp_kses_post($title_html);?>
	<div class="widget-content">
		<!-- description -->
		<?php echo wp_kses_post($des_html);?>
		<!-- social -->
		<?php if( $social_out ) :
				echo '<div class="social">' . $social_out .'</div>';
			endif;
		?>
	</div>
</div>