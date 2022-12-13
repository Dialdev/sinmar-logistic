<?php
if(!empty($args['format'])){
	$format = $args['format'];
}else{
	$format = '<div class="block-label">
			<div class="text big">%2$s</div>
			<div class="text"><span>%3$s</span><span>%4$s</span></div>
			<a href="%1$s" class="link-label"></a>
		</div>';
}
$date_type = slz_get_db_settings_option('blog-post-date-type', '');
if( $date_type == 'ribbon' ) {
	$default = array(
		'day'   => esc_html_x('d','daily posts date format', 'slz'),
		'month' => esc_html_x('M','daily posts date format', 'slz'),
		'year'  => esc_html_x('Y','daily posts date format', 'slz'),
	);
	$date_format = array_merge( $default, slz()->theme->get_config('ribbon_date_format', array()) );
	$day    = get_the_date($date_format['day']);
	$month  = get_the_date($date_format['month']);
	$year   = get_the_time($date_format['year']);

	printf( $format, $module->permalink, esc_html( $day ), esc_html( $month ), esc_html( $year ) );
}