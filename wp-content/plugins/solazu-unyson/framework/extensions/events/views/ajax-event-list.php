<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Forbidden' ); }
$model = new SLZ_Event();
$atts = $query_args = array();
$model->get_search_atts( $atts, $query_args, $data );
$model->init( $atts, $query_args );

if( $model->post_count <= 0 ) {
	esc_html_e( 'Sorry, nothing matched your search criteria. Please try again with other criteria.', 'slz' );
	exit;
}

$html_format = '
	<div class="item">
		<div class="slz-block-item-05 style-1">
		    <div class="block-date">%1$s</div>
		    %2$s
		    <div class="block-content">
		        <div class="block-content-wrapper">
		            %3$s
		            %4$s
		            %10$s
		        </div>
		    </div>
		    <div class="clearfix"></div>
			%5$s
		</div>
	</div>
';
$html_render = array( 'html_format' => $html_format );
$model->attributes['image_display'] = 'show';
$model->attributes['event_time_display'] = 'show';
$model->attributes['description_display'] = 'show';
$model->attributes['event_location_display'] = 'show';
?>
<div class="slz-list-block slz-column-1">
<?php $model->render_event_sc( $html_render ); ?>
</div>