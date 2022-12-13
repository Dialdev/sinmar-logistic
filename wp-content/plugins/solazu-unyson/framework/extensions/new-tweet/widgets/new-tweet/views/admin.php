<?php 

$app_link = 'https://apps.twitter.com';

$widget_color_picker_id = SLZ_Com::make_id();

extract( $instance );
?>
<p>
	<label for="<?php echo  esc_attr( $object->get_field_id('block_title') ); ?>"><?php esc_html_e( 'Block Title', 'slz' );?></label>
	<input class="widefat" type="text" id="<?php echo esc_attr( $object->get_field_id('block_title') ); ?>" name="<?php echo esc_attr( $object->get_field_name('block_title') ); ?>" value="<?php echo esc_attr( $block_title ); ?>" />
</p>
<div>
	<label for="<?php echo esc_attr( $object->get_field_id('block_title_color') ); ?>"><?php esc_html_e( 'Title Color:', 'slz' ); ?></label>
	<input data-slz-w-color="<?php echo esc_attr( $widget_color_picker_id ); ?>" class="widefat slz-color-picker-field" id="<?php echo esc_attr( $object->get_field_id('block_title_color') ); ?>"
		   name="<?php echo esc_attr( $object->get_field_name('block_title_color') ); ?>" type="text"
		   value="<?php echo esc_attr( $block_title_color ); ?>" />
	<br><div id="<?php echo esc_attr( $widget_color_picker_id ); ?>" class="slz-color-picker-widget" rel="<?php echo esc_attr( $object->get_field_id('block_title_color') ); ?>"></div>
	<br><div class="slz-widget-description"><?php echo esc_html__('Optional - Choose a custom title text color for object block', 'slz'); ?></div>
</div>
<p>
	<label for="<?php echo  esc_attr( $object->get_field_id('limit_tweet') ); ?>"><?php esc_html_e( 'Number Tweet', 'slz' );?></label>
	<input class="widefat" type="text" id="<?php echo esc_attr( $object->get_field_id('limit_tweet') ); ?>" name="<?php echo esc_attr( $object->get_field_name('limit_tweet') ); ?>" value="<?php echo esc_attr( $limit_tweet ); ?>" />
</p>
<p>
	<label for="<?php echo  esc_attr( $object->get_field_id('screen_name') ); ?>"><?php esc_html_e( 'Account name', 'slz' );?></label>
	<input class="widefat" type="text" id="<?php echo esc_attr( $object->get_field_id('screen_name') ); ?>" name="<?php echo esc_attr( $object->get_field_name('screen_name') ); ?>" value="<?php echo esc_attr( $screen_name ); ?>" />
</p>
<div>
	<label for="<?php echo esc_attr( $object->get_field_name( 'extra_class' ) ); ?>"><?php esc_html_e( 'Extra Class:', 'slz' ); ?></label>
	<input name="<?php echo esc_attr ( $object->get_field_name( 'extra_class' ) ); ?>" id="<?php echo esc_attr ( $object->get_field_id( 'extra_class' ) ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_attr( $extra_class ); ?>" />
	<br><br><div class="slz-widget-description"><?php echo esc_html__('Optional - a extra class for this block, if you leave it blank the block will not have a extra class', 'slz'); ?></div>
</div>
<p>
	<label for="<?php echo  esc_attr( $object->get_field_id('show_media') ); ?>"><?php esc_html_e( 'Show Media', 'slz' );?></label>
	<select id="<?php echo  esc_attr( $object->get_field_id('show_media') ); ?>" name="<?php echo  esc_attr( $object->get_field_name('show_media') ); ?>">
		<?php if(isset($instance['show_media'])): ?>
			<option value="true" <?php if($instance['show_media'] == "true") echo 'selected'; ?>><?php esc_html_e( 'True', 'slz' );?></option>
			<option value="false" <?php if($instance['show_media'] == "false") echo 'selected'; ?>><?php esc_html_e( 'False', 'slz' );?></option>
		<?php else: ?>
			<option value="true"><?php esc_html_e( 'True', 'slz' );?></option>
			<option value="false"><?php esc_html_e( 'False', 'slz' );?></option>
		<?php endif; ?>
	</select>
</p>
<p>
	<label for="<?php echo  esc_attr( $object->get_field_id('re_tweet') ); ?>"><?php esc_html_e( 'Show Re-Tweet', 'slz' );?></label>
	<select id="<?php echo  esc_attr( $object->get_field_id('re_tweet') ); ?>" name="<?php echo  esc_attr( $object->get_field_name('re_tweet') ); ?>">
		<?php if(isset($instance['re_tweet'])): ?>
			<option value="true" <?php if($instance['re_tweet'] == "true") echo 'selected'; ?>><?php esc_html_e( 'True', 'slz' );?></option>
			<option value="false" <?php if($instance['re_tweet'] == "false") echo 'selected'; ?>><?php esc_html_e( 'False', 'slz' );?></option>
		<?php else: ?>
			<option value="true"><?php esc_html_e( 'True', 'slz' );?></option>
			<option value="false"><?php esc_html_e( 'False', 'slz' );?></option>
		<?php endif; ?>
	</select>
</p>

<p>
    <label for="<?php echo  esc_attr( $object->get_field_id('show_author') ); ?>"><?php esc_html_e( 'Show Author', 'slz' );?></label>
    <select id="<?php echo  esc_attr( $object->get_field_id('show_author') ); ?>" name="<?php echo  esc_attr( $object->get_field_name('show_author') ); ?>">
        <?php if(isset($instance['show_author'])): ?>
            <option value="true" <?php if($instance['show_author'] == "true") echo 'selected'; ?>><?php esc_html_e( 'True', 'slz' );?></option>
            <option value="false" <?php if($instance['show_author'] == "false") echo 'selected'; ?>><?php esc_html_e( 'False', 'slz' );?></option>
        <?php else: ?>
            <option value="true"><?php esc_html_e( 'True', 'slz' );?></option>
            <option value="false"><?php esc_html_e( 'False', 'slz' );?></option>
        <?php endif; ?>
    </select>
</p>
<p>
    <label for="<?php echo  esc_attr( $object->get_field_id('show_author_name') ); ?>"><?php esc_html_e( 'Show Author Name', 'slz' );?></label>
    <select id="<?php echo  esc_attr( $object->get_field_id('show_author_name') ); ?>" name="<?php echo  esc_attr( $object->get_field_name('show_author_name') ); ?>">
        <?php if(isset($instance['show_author'])): ?>
            <option value="true" <?php if($instance['show_author_name'] == "true") echo 'selected'; ?>><?php esc_html_e( 'True', 'slz' );?></option>
            <option value="false" <?php if($instance['show_author_name'] == "false") echo 'selected'; ?>><?php esc_html_e( 'False', 'slz' );?></option>
        <?php else: ?>
            <option value="true"><?php esc_html_e( 'True', 'slz' );?></option>
            <option value="false"><?php esc_html_e( 'False', 'slz' );?></option>
        <?php endif; ?>
    </select>
</p>
<p>
    <label for="<?php echo  esc_attr( $object->get_field_id('show_time') ); ?>"><?php esc_html_e( 'Show Time', 'slz' );?></label>
    <select id="<?php echo  esc_attr( $object->get_field_id('show_time') ); ?>" name="<?php echo  esc_attr( $object->get_field_name('show_time') ); ?>">
        <?php if(isset($instance['show_author'])): ?>
            <option value="true" <?php if($instance['show_time'] == "true") echo 'selected'; ?>><?php esc_html_e( 'True', 'slz' );?></option>
            <option value="false" <?php if($instance['show_time'] == "false") echo 'selected'; ?>><?php esc_html_e( 'False', 'slz' );?></option>
        <?php else: ?>
            <option value="true"><?php esc_html_e( 'True', 'slz' );?></option>
            <option value="false"><?php esc_html_e( 'False', 'slz' );?></option>
        <?php endif; ?>
    </select>
</p>
<script>
	slz_color_picker();
</script>