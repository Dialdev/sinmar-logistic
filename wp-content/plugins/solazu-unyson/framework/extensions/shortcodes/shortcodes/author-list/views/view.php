<?php
 if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$block_class = 'author-list-'.SLZ_Com::make_id();
$block_cls = $block_class.' '.$data['extra_class']. ' ';
$socials = SLZ_Params::params_social();
?>

<div class="slz-shortcode sc_author_list <?php echo esc_attr( $block_cls ); ?>">
	<?php
	if( $data['show_options'] == 'multiple' ) {
		echo slz_render_view( $instance->locate_path('/views/multiple-author.php'), compact( 'data', 'socials' ) );
	}else {
		echo slz_render_view( $instance->locate_path('/views/one-author.php'), compact( 'data', 'socials' ) );
	}
	?>
</div>