<?php
if( $video = $module->get_feature_video() ) {
	echo '<div class="block-image slz-block-video">';
		echo ( $module->get_ribbon_date() );
		echo ( $video );
	echo '</div>';
}