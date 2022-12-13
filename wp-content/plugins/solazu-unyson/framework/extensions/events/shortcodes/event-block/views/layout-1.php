<?php
$html_render = array();
$html_format = '
	<div class="item">
		<div class="slz-block-item-05 '. esc_attr( $model->attributes['has_image'] ) .' style-1">
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
			<a href=" %8$s " class="slz-btn btn-block-donate">'.esc_html__("Read more", "slz").'</a>
		</div>

	</div>
';
$html_render['html_format'] = $html_format;
$column = '1';
if ( isset($model->attributes['column']) ) {
    $column = $model->attributes['column'];
}
?>
<div class="slz-list-block slz-column-<?php echo esc_attr($column); ?>">
<?php $model->render_event_sc( $html_render ); ?>
</div>
