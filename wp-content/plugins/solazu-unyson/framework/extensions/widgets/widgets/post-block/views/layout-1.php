<?php
$main_layout = '';
$list_layout = '';
$post_count = 1;
if( !empty( $model->query->posts ) ) {
	foreach( $model->query->posts as $post ) {
		$module = new SLZ_Block_Module( $post, $model->attributes );
		if( $post_count == 1 ) {
			$main_layout .= slz_render_view( $view_path . '/main-layout-1.php', compact('module'));
		}else{
			$list_layout .= '<div class="element">';
			$list_layout .= slz_render_view( $view_path . '/list-layout-1.php', compact('module'));
			$list_layout .= '</div>';
		}
		$post_count++;
	}
}
?> 
<div class="slz-template-01">
	<div class="main-layout">
		<?php echo ( $main_layout ); ?>
	</div>
	<div class="list-layout column-2">
		<?php echo ( $list_layout ); ?>
	</div>
</div>